<?php

namespace App\Core;

class Request
{
    // Lấy phương thức của yêu cầu HTTP (GET, POST, PUT, DELETE, v.v.)
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    // Lấy URI của yêu cầu, loại bỏ phần truy vấn
    // Ví dụ: /users/123
    public function getUri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    // Lấy phần truy vấn của yêu cầu
    // Ví dụ: ?page=1&sort=asc
    public function getQueryParam(string $key, $default = null): ?string
    {
        return $_GET[$key] ?? $default;
    }

    // Lấy tham số từ phương thức POST
    // Ví dụ: $_POST['username']
    // Trả về giá trị của tham số hoặc giá trị mặc định nếu không tồn tại
    public function getPostParam(string $key, $default = null): ?string
    {
        return $_POST[$key] ?? $default;
    }

    // Lấy tất cả tham số từ phương thức GET
    // Trả về mảng chứa tất cả các tham số truy vấn
    public function allQueryParams(): array
    {
        return $_GET;
    }

    // Lấy tất cả tham số từ phương thức POST
    // Trả về mảng chứa tất cả các tham số POST
    public function allPostParams(): array
    {
        return $_POST;
    }
}
