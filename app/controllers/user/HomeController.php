<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Config\Database;
use App\Core\Request;
use App\Core\Validator;
use App\Core\Session;

use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('user/index', ['title' => 'Trang người dùng']);
    }

    
}
