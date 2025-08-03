<?php

use App\Core\Router;

use App\Models\RoleType;

$router = Router::getRouter();

//Auth
$router->map("GET", "/login", ['controller' => 'Auth\AuthController', 'action' => 'login', 'middleware' => []], 'login');
$router->map("POST", "/login", ['controller' => 'Auth\AuthController', 'action' => 'loginPost', 'middleware' => []], 'login.post');
$router->map("GET", "/logout", ['controller' => 'Auth\AuthController', 'action' => 'logout', 'middleware' => []], 'logout');
$router->map("GET", "/no-access", ['controller' => 'Auth\AuthController', 'action' => 'noAccess', 'middleware' => []], 'no_access');
$router->map("GET", "/register", ['controller' => 'Auth\AuthController', 'action' => 'register', 'middleware' => []], 'register');
$router->map("POST", "/register", ['controller' => 'Auth\AuthController', 'action' => 'registerPost', 'middleware' => []], 'register.post');
//User
$router->map("GET", "/", ['controller' => 'User\HomeController', 'action' => 'index', 'middleware' => [RoleType::USER->value]], 'user.index');


//Admin
$router->map("GET", "/admin/dashboard", ['controller' => 'Admin\HomeController', 'action' => 'dashboard', 'middleware' => RoleType::allCases()], 'admin.dashboard');

//Admin Author
$router->map("GET", "/admin/author", ['controller' => 'Admin\HomeController', 'action' => 'author', 'middleware' => [RoleType::ADMIN->value]], 'admin.author.index');


//Admin Book
$router->map("GET", "/admin/book", ['controller' => 'Admin\HomeController', 'action' => 'book', 'middleware' => [RoleType::ADMIN->value, RoleType::ImportStaff->value]], 'admin.book.index');

//Admin Role
$router->map("GET", "/admin/role", ['controller' => 'Admin\HomeController', 'action' => 'role', 'middleware' => [RoleType::ADMIN->value]], 'admin.role.index');

//Admin Category
$router->map("GET", "/admin/category", ['controller' => 'Admin\HomeController', 'action' => 'category', 'middleware' => [RoleType::ADMIN->value]], 'admin.category.index');


//Admin User
$router->map("GET", "/admin/user", ['controller' => 'Admin\HomeController', 'action' => 'user', 'middleware' => [RoleType::ADMIN->value, RoleType::HR->value]], 'admin.user.index');
