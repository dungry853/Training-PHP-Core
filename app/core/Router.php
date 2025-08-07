<?php

namespace App\Core;

use App\Middlewares\AuthMiddleware;
use App\Models\RoleType;

class Router
{

    protected static array $routes = [];

    public static function getRouter(): self
    {
        return new self();
    }
    public static function add(string $method, string $uri, array $target): void
    {
        self::$routes[] = [
            'method' => strtoupper($method),
            'uri' => rtrim($uri, '/'),
            'target' => $target,
        ];
    }


    public static function dispatch(): void
    {
        $currentUri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $currentMethod = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            if (
                $route['method'] === $currentMethod &&
                $route['uri'] === $currentUri
            ) {
                $target = $route['target'];
                $controllerName = $target['controller'] ?? null;
                $method = $target['action'] ?? null;
                $middleware = $target['middleware'] ?? [];

                // Xử lý middleware
                if (empty($middleware)) {
                    $middleware = RoleType::allCases();
                }
                $authMiddleware = new AuthMiddleware();
                $authMiddleware->handle($middleware);

                $controllerClass = 'App\\Controllers\\' . $controllerName;

                if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                    $controller = new $controllerClass();
                    call_user_func([$controller, $method]);
                    return;
                } else {
                    http_response_code(404);
                    echo "Controller hoặc method không tồn tại.";
                    return;
                }
            }
        }

        http_response_code(404);
        echo "Không tìm thấy route.";
    }
}
