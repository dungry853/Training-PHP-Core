<?php

namespace App\Core;

class Controller
{
    public function view(string $view, array $data = [])
    {

        extract($data);
        $baseViewPath = dirname(__DIR__, 2) . '/views';
        $viewPath = "$baseViewPath/$view.php";
        $layoutPath = "$baseViewPath/layouts/layout.php";

        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            // fallback nếu không dùng layout
            require $viewPath;
        }
    }

    function renderPartial(string $view, array $data = [])
    {
        $baseViewPath = dirname(__DIR__, 2) . '/views';
        $viewPath = "$baseViewPath/$view.php";
        extract($data);
        require $viewPath;
    }

    public function redirect(string $url)
    {
        header("Location: $url");
        exit();
    }
}
