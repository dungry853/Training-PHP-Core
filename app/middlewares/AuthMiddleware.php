<?php

namespace App\Middlewares;

use App\Core\Response;
use App\Core\Session;
use App\Models\Role;
use App\Models\RoleType;
use App\Models\User;

class AuthMiddleware
{
    protected static $publicRoutes = [
        '/login',
        '/register',
        '/forgot-password',
        '/reset-password',
        '/verify-code',
        '/no-access',
    ];
    public function handle(array $allowRoles)
    {
        $sessionUser = Session::get('user');
        $currentUri = $_SERVER['REQUEST_URI'] ?? '';



        if (!$sessionUser && isset($_COOKIE['user_session'])) {
            $this->restoreSessionFromCookie();
            $sessionUser = Session::get('user');
        }
        $roleId = $sessionUser['role_id'] ?? null;

        if (!$sessionUser && !$this->isPublicRoute($currentUri)) {
            Response::redirect('/login');
            exit;
        }

        if ($sessionUser && !in_array($roleId, $allowRoles) && $currentUri !== '/no-access') {
            Response::redirect('/no-access');
            exit;
        }

        return;
    }

    protected function isPublicRoute(string $uri): bool
    {
        foreach (self::$publicRoutes as $route) {
            if (str_starts_with($uri, $route)) {
                return true;
            }
        }
        return false;
    }

    protected function restoreSessionFromCookie(): void
    {
        $cookieData = json_decode(base64_decode($_COOKIE['user_session']), true); // giải mã cookie 2 lớp
        $userId = $cookieData['user_id'] ?? null;
        $createdAt = $cookieData['created_at'] ?? null;
        $expiredTime = time() - 300; // 5 phút

        if (!isset($userId) || !isset($createdAt) || isset($createdAt) && $createdAt < $expiredTime) {
            // Cookie đã hết hạn, xóa cookie
            setcookie('user_session', '', time() - 3600, '/');
            exit;
        }

        $user = User::getUserById($userId);
        if ($user) {
            Session::set('user', [
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'full_name' => $user->getFullName(),
                'dob' => $user->getDob()->format('Y-m-d'),
                'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s'),
                'role_id' => $user->getRole()->getRoleId()
            ]);
        }
    }
}
