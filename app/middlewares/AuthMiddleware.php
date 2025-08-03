<?php

namespace App\Middlewares;

use App\Core\Response;
use App\Core\Session;
use App\Models\User;

class AuthMiddleware
{
    public function handle(array $allowRoles)
    {
        $sessionUser = Session::get('user') ?? null;
        if (!$sessionUser) {
            // Người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
            Response::redirect('/login');
        }
        if ($sessionUser && !in_array($sessionUser['role_id'], $allowRoles)) {
            // Người dùng đã đăng nhập và không có quyền truy cập
            Response::redirect('/no-access');
        }

        return;
    }
}
