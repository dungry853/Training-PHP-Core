<?php

namespace App\Middlewares;

use App\Core\Response;
use App\Core\Session;
use App\Models\Role;
use App\Models\RoleType;

class AuthMiddleware
{
    public function handle(array $allowRoles)
    {
        $sessionUser = Session::get('user') ?? null;
        $roleId = $sessionUser['role_id'] ?? null;
        if (!$sessionUser) {
            // Người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
            Response::redirect('/login');
        }

        if ($sessionUser && !in_array($roleId, $allowRoles)) {
            // Người dùng đã đăng nhập và không có quyền truy cập
            Response::redirect('/no-access');
        }



        return;
    }
}
