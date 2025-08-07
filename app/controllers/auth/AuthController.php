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
use DateTimeZone;
use App\Services\MailServices;


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
        $rememberMe = $request->getPostParam('remember_me') ?? '0';

        $data = [
            'username' => $username,
            'password' => $password,
            'remember_me' => $rememberMe
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
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'full_name' => $user->getFullName(),
            'dob' => $user->getDob()->format('Y-m-d'),
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s'),
            'role_id' => $user->getRole()->getRoleId()
        ]);

        if ($user->getRole()->getRoleId() == RoleType::USER->value) {
            if ($rememberMe == '1') {

                $cookieData = json_encode([
                    'user_id' => $user->getUserId(),
                    'created_at' => time(),
                ]);
                // Set a cookie for "remember me"
                setcookie('user_session', base64_encode($cookieData), time() + 300, "/"); // 5 minutes
            }
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

    public function forgotPassword()
    {
        if (isset($_SESSION['user'])) {
            return $this->redirect('/');
        }
        $this->view('auth/forgot-password', ['title' => 'Quên mật khẩu']);
    }

    public function forgotPasswordPost()
    {

        $request = new Request();
        $email = $request->getPostParam('email');

        $data = [
            'email' => $email
        ];
        $rule = [
            'email' => 'required|email'
        ];

        $validator = new Validator();
        $isValid = $validator->validate($data, $rule);
        if (!$isValid) {
            $errors = $validator->getErrors();
            $this->view('auth/forgot-password', [
                'title' => 'Quên mật khẩu',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }

        $isEmailExists = User::checkEmailExists($email);
        if (!$isEmailExists) {
            $errors['email'] = ['Email không tồn tại.'];
            $this->view('auth/forgot-password', [
                'title' => 'Quên mật khẩu',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }

        $verificationCode = bin2hex(random_bytes(3));
        $resetTokenExpiresAt = (new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')))->modify('+5 minutes');

        $isUpdated = User::updateVerificationCode($email, $verificationCode, $resetTokenExpiresAt);
        if (!$isUpdated) {
            $errors['reset'] = ['Không thể tạo liên kết đặt lại mật khẩu.'];
            $this->view('auth/forgot-password', [
                'title' => 'Quên mật khẩu',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }
        // Gửi email chứa link đặt lại mật khẩu
        $isEmailSent = MailServices::sendResetPasswordEmail($email, $verificationCode);
        if (!$isEmailSent) {
            $errors['email'] = ['Không thể gửi email đặt lại mật khẩu.'];
            $this->view('auth/forgot-password', [
                'title' => 'Quên mật khẩu',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }
        $session = new Session();
        $session->set('reset_email', $email);

        return $this->redirect('/verify-code');
    }

    public function verifyCode()
    {
        if (!Session::get('reset_email')) {
            return $this->redirect('/');
        }
        $this->view('auth/verify-code', ['title' => 'Nhập mã xác nhận']);
    }

    public function verifyCodePost()
    {
        $request = new Request();
        $verificationCode = $request->getPostParam('verification_code');
        $email = Session::get('reset_email');

        if (!isset($email)) {
            $errors['verification_code'] = ['Không tìm thấy email để xác thực.'];
            $this->view('auth/verify-code', [
                'title' => 'Nhập mã xác nhận',
                'errors' => $errors,
                'data' => []
            ]);
            return;
        }

        $data = [
            'verification_code' => $verificationCode
        ];

        $rule = [
            'verification_code' => 'required|min:6|max:6'
        ];

        $validator = new Validator();
        $isValid = $validator->validate($data, $rule);

        if (!$isValid) {
            $errors = $validator->getErrors();
            $this->view('auth/verify-code', [
                'title' => 'Nhập mã xác nhận',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }
        $isUpdated = User::verifyCode($email, $verificationCode);
        // Kiểm tra mã xác nhận và hiển thị form đặt lại mật khẩu
        if (!$isUpdated) {
            $errors['verification_code'] = ['Mã xác nhận không hợp lệ hoặc đã hết hạn.'];
            $this->view('auth/verify-code', [
                'title' => 'Nhập mã xác nhận',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }

        return $this->redirect('/reset-password');
    }

    public function resetPassword()
    {
        if (!Session::get('reset_email')) {
            return $this->redirect('/');
        }
        $this->view('auth/reset-password', ['title' => 'Đặt lại mật khẩu']);
    }

    public function resetPasswordPost()
    {
        $request = new Request();
        $password = $request->getPostParam('password');
        $rePassword = $request->getPostParam('re-password');
        $email = Session::get('reset_email');

        if (!isset($email)) {
            $errors['reset'] = ['Không tìm thấy email để đặt lại mật khẩu.'];
            $this->view('auth/reset-password', [
                'title' => 'Đặt lại mật khẩu',
                'errors' => $errors,
                'data' => []
            ]);
            return;
        }

        $data = [
            'password' => $password,
            're-password' => $rePassword
        ];
        $validator = new Validator();
        $rule = [
            'password' => 'required|min:6|max:20',
            're-password' => 'required|same:password'
        ];

        $isValid = $validator->validate($data, $rule);

        if (!$isValid) {
            $errors = $validator->getErrors();
            $this->view('auth/reset-password', [
                'title' => 'Đặt lại mật khẩu',
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }

        $isResetPassword = User::resetPassword($email, $password);
        // Kiểm tra token và cập nhật mật khẩu
        if (!$isResetPassword) {
            $errors['reset'] = ['Cập nhật mật khẩu không thành công. Vui lòng thử lại sau.'];
            $this->view('auth/reset-password', [
                'title' => 'Đặt lại mật khẩu',
                'errors' => $errors,
                'data' => $data
            ]);
        }
        Session::destroy();
        return $this->redirect('/login?reset=1');
    }


    public function noAccess()
    {
        $this->view('auth/no-access');
    }

    public function logout()
    {
        $session = new Session();
        $session->destroy();
        $cookieData = json_encode([
            'user_id' => null,
            'created_at' => null,
        ]);
        // Clear the cookie
        setcookie('user_session', base64_encode($cookieData), time() - 3600, "/"); // Expire the cookie
        return $this->redirect('/login');
    }
}
