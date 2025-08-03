<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Validator;
use App\Core\Session;
use App\Config\Database;
use App\Models\User;
use App\Models\RoleType;
use DateTime;


class AuthController extends Controller
{
    public function login()
    {
        $this->view('auth/login', ['title' => 'Trang đăng nhập']);
    }

    public function loginPost()
    {

        $request = new Request();
        $username = $request->getPostParam('username');
        $password = $request->getPostParam('password');

        $data = [
            'username' => $username,
            'password' => $password
        ];

        $rule = [
            'username' => 'required|UsernameOrEmail|min:3|max:20',
            'password' => 'required|min:6|max:20'
        ];

        $validator = new Validator();

        $isValid = $validator->validate($data, $rule);

        if (!$isValid) {
            $errors = $validator->getErrors();

            $this->view('auth/login', [
                'title' => 'Trang đăng nhập quản trị',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }

        $user = User::getUserByUsernameAndPassword($username, $password);
        if (!$user) {
            $errors['login'] = ['Tên đăng nhập hoặc mật khẩu không đúng.'];
            $this->view('auth/login', [
                'title' => 'Trang đăng nhập quản trị',
                'errors' => $errors,
                'data' => $data
            ]);

            return;
        }
        $session = new Session();
        $session->set('user', [
            'user_id' => $user->getUserId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'full_name' => $user->getFullName(),
            'dob' => $user->getDob(),
            'role_id' => $user->getRole()->getRoleId(),
        ]);

        if ($user->getRole()->getRoleId() == RoleType::USER->value) {
            return $this->redirect('/');
        }
        return $this->redirect('/admin/dashboard');
    }


    public function register()
    {
        $this->view('auth/register', ['title' => 'Trang đăng ký']);
    }
    public function registerPost()
    {
        $request = new Request();
        $username = $request->getPostParam('username');
        $fullName = $request->getPostParam('full_name');
        $email = $request->getPostParam('email');
        $dob = $request->getPostParam('dob');
        $password = $request->getPostParam('password');
        $rePassword = $request->getPostParam('re_password');

        $data = [
            'username' => $username,
            'full_name' => $fullName,
            'email' => $email,
            'dob' => $dob,
            'password' => $password,
            're_password' => $rePassword
        ];
        $validator = new Validator();
        $rule = [
            'username' => 'required|UsernameOrEmail|min:3|max:20',
            'full_name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'dob' => 'required|date_format:Y-m-d',
            'password' => 'required|min:6|max:20',
            're_password' => 'required|same:password'
        ];

        $isValid = $validator->validate($data, $rule);

        if (!$isValid) {
            $errors = $validator->getErrors();
            $this->view('auth/register', [
                'title' => 'Trang đăng ký',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }

        $user = User::checkUsernameOrEmailExists($username, $email);
        if ($user) {
            $errors['register'] = ['Tên đăng nhập hoặc email đã tồn tại.'];
            $this->view('auth/register', [
                'title' => 'Trang đăng ký',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }

        $user = User::createUser($username, $password, $email, $fullName, new DateTime($dob), RoleType::USER->value);
        if (!$user) {
            $errors['register'] = ['Đăng ký không thành công.'];
            $this->view('auth/register', [
                'title' => 'Trang đăng ký',
                'errors' => $errors,
                'data' => $data
            ]);
        }
        return $this->redirect('/login?success=1');
    }

    public function noAccess()
    {
        $this->view('auth/no-access');
    }

    public function logout()
    {
        $session = new Session();
        $session->destroy();
        return $this->redirect('/login');
    }
}
