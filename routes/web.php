<?php

use App\Core\Router;

use App\Models\RoleType;

$router = Router::getRouter();


//Auth
$router::add("GET", "/login", ['controller' => 'Auth\AuthController', 'action' => 'login', 'middleware' => []], 'login');
$router::add("POST", "/login", ['controller' => 'Auth\AuthController', 'action' => 'loginPost', 'middleware' => []], 'login.post');
$router::add("GET", "/logout", ['controller' => 'Auth\AuthController', 'action' => 'logout', 'middleware' => []], 'logout');
$router::add("GET", "/no-access", ['controller' => 'Auth\AuthController', 'action' => 'noAccess', 'middleware' => []], 'no_access');
$router::add("GET", "/register", ['controller' => 'Auth\AuthController', 'action' => 'register', 'middleware' => []], 'register');
$router::add("POST", "/register", ['controller' => 'Auth\AuthController', 'action' => 'registerPost', 'middleware' => []], 'register.post');
$router::add("GET", "/forgot-password", ['controller' => 'Auth\AuthController', 'action' => 'forgotPassword', 'middleware' => []], 'forgot_password');
$router::add("POST", "/forgot-password", ['controller' => 'Auth\AuthController', 'action' => 'forgotPasswordPost', 'middleware' => []], 'forgot_password.post');
$router::add("GET", "/reset-password", ['controller' => 'Auth\AuthController', 'action' => 'resetPassword', 'middleware' => []], 'reset_password');
$router::add("POST", "/reset-password", ['controller' => 'Auth\AuthController', 'action' => 'resetPasswordPost', 'middleware' => []], 'reset_password.post');
$router::add("GET", "/verify-code", ['controller' => 'Auth\AuthController', 'action' => 'verifyCode', 'middleware' => []], 'verify_code');
$router::add("POST", "/verify-code", ['controller' => 'Auth\AuthController', 'action' => 'verifyCodePost', 'middleware' => []], 'verify_code.post');
//User
$router::add("GET", "/", ['controller' => 'User\HomeController', 'action' => 'index', 'middleware' => [RoleType::USER->value]], 'user.index');


//Admin
$router::add("GET", "/admin/dashboard", ['controller' => 'Admin\HomeController', 'action' => 'dashboard', 'middleware' => RoleType::getAdminStaff()], 'admin.dashboard');

//Admin Author
$router::add("GET", "/admin/author", ['controller' => 'Admin\HomeController', 'action' => 'author', 'middleware' => [RoleType::ADMIN->value]], 'admin.author.index');


//Admin Book
$router::add("GET", "/admin/book", ['controller' => 'Admin\HomeController', 'action' => 'book', 'middleware' => [RoleType::ADMIN->value, RoleType::ImportStaff->value]], 'admin.book.index');

//Admin Role
$router::add("GET", "/admin/role", ['controller' => 'Admin\HomeController', 'action' => 'role', 'middleware' => [RoleType::ADMIN->value]], 'admin.role.index');

//Admin Category
$router::add("GET", "/admin/category", ['controller' => 'Admin\HomeController', 'action' => 'category', 'middleware' => [RoleType::ADMIN->value]], 'admin.category.index');


//Admin User
$router::add("GET", "/admin/user", ['controller' => 'Admin\HomeController', 'action' => 'user', 'middleware' => [RoleType::ADMIN->value, RoleType::HR->value]], 'admin.user.index');
