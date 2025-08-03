<?php

namespace App\Core;

class Response
{
    private int $statusCode;
    private string $message;
    private array $data;

    public function __construct(int $statusCode = 200, string $message = '', array $data = [])
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
    }

    public function sendJson(): void
    {
        http_response_code($this->statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data
        ]);
        exit;
    }

    public static function redirect(string $url)
    {
        header("Location: $url");
        exit();
    }
}
