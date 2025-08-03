<?php

namespace App\Controllers\Admin;

use App\Config\Database;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Validator;
use App\Core\Session;

use App\Models\User;

class HomeController extends Controller
{

    public function dashboard()
    {
        $session = new Session();
        $user = $session->get('user');
        $this->view('admin/dashboard', ['user' => $user, 'title' => 'Trang quản trị']);
    }

    public function author()
    {
        $this->view('admin/author/index', ['title' => 'Quản lý tác giả']);
    }

    public function book()
    {
        $this->view('admin/book/index', ['title' => 'Quản lý sách']);
    }

    public function role()
    {
        $this->view('admin/role/index', ['title' => 'Quản lý vai trò']);
    }

    public function category()
    {
        $this->view('admin/category/index', ['title' => 'Quản lý danh mục']);
    }

    public function user()
    {
        $this->view('admin/user/index', ['title' => 'Quản lý người dùng']);
    }
}
