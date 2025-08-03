<?php

namespace App\Core;

use App\Middlewares\AuthMiddleware;
use AltoRouter;

class Router
{

    protected static $router;

    public static function init()
    {
        self::$router = new AltoRouter();

        // Optional: base path nếu cần (ví dụ /myapp)
        // self::$router->setBasePath('/myapp');
        self::$router;
    }

    public static function getRouter()
    {
        return self::$router;
    }

    public static function dispatch()
    {

        $match = self::$router->match();
        //$match['target'] thường chứa mảng dạng ['TênController', 'method'] (ví dụ: ['UserController', 'login']).
        if ($match) {
            $target = $match['target'];

            if (is_array($target)) {
                $controllerName = $target['controller'] ?? null;
                $method = $target['action'] ?? null;
                $middleware = $target['middleware'] ?? [];
            } else {
                // Nếu target chỉ là mảng index, ví dụ ['UserController', 'login']
                list($controllerName, $method) = $target;
                $middleware = [];
            }

            if (!empty($middleware)) {
                // Xử lý middleware nếu có
                $authMiddleware = new AuthMiddleware();
                $authMiddleware->handle($middleware);
            }

            $controllerClass = 'App\\Controllers\\' . $controllerName;

            if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                $controller = new $controllerClass();
                call_user_func_array([$controller, $method], $match['params']);
            } else {
                // 404 not found
                echo "Controller or method not found.";
            }
        } else {
            // 404 route not matched
            echo "Route not matched.";
        }
    }
}
