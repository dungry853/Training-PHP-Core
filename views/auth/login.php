<?php

use App\Models\RoleType;

$roleId = $_SESSION['user']['role_id'] ?? null;
if (isset($_SESSION['user']) && in_array($roleId, RoleType::getAdminStaff())) {
    header('Location: /admin/dashboard');
    exit;
} else if (isset($_SESSION['user']) && $roleId == RoleType::USER->value) {
    header('Location: /');
    exit;
}
?>


<div class="container d-flex justify-content-center align-items-center">
    <div class="login-form">
        <h2>Đăng nhập quản trị</h2>
        <form method="post" action="/login">
            <div class="form-group">
                <input value="<?= $data['username'] ?? '' ?>" type="text" name="username" id="username" required placeholder="Tên đăng nhập/Email">
                <span class="error">
                    <?php
                    if (!empty($errors['username'])) {
                        echo implode('<br>', $errors['username']);
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <input type="password" value="<?= $data['password'] ?? '' ?>" name="password" id="password" required placeholder="Mật khẩu">
                <span class="error">
                    <?php
                    if (!empty($errors['password'])) {
                        echo implode('<br>', $errors['password']);
                    }
                    ?>
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="remember-me-checkbox">
                    <input type="checkbox" name="remember_me" id="remember_me" value="1"
                        <?= !empty($data['remember_me']) ? 'checked' : '' ?>>
                    <label for="remember_me">Ghi nhớ đăng nhập</label>
                </div>
                <a href="/forgot-password">
                    Quên mật khẩu?
                </a>
            </div>
            <div class="form-group">
                <button type="submit">Đăng nhập</button>
            </div>

            <div class="form-group">
                <span class="or">Hoặc</span>
            </div>

            <div class="form-group">
                <div class="social-login">
                    <button type="button" class="facebook-login">
                        <i class="fa-brands fa-square-facebook"></i> Facebook
                    </button>
                    <button type="button" class="google-login">
                        <i class="fa-brands fa-google"></i>Google</button>
                </div>
            </div>

            <div class="form-group">
                <p class="register-link">Chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
            </div>

        </form>
    </div>
</div>

<div aria-live="polite" aria-atomic="true" class="bg-body-danger position-relative bd-example-toasts rounded-3">
    <div class="toast-container p-3" id="toastPlacement">
        <div class="toast" id="customToast">
            <div class="toast-body" id="toastBody">

            </div>
        </div>
    </div>
</div>


<?php if (!empty($errors['login'])): ?>
    <script>
        window.toastMessage = {
            type: "error",
            message: <?= json_encode(implode(" ", $errors['login'])) ?>
        };
    </script>
<?php elseif (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        window.toastMessage = {
            type: "success",
            message: "Đăng ký thành công! Vui lòng đăng nhập."
        };
    </script>
<?php elseif (isset($_GET['reset']) && $_GET['reset'] == 1): ?>
    <script>
        window.toastMessage = {
            type: "success",
            message: "Đặt lại mật khẩu thành công! Vui lòng đăng nhập."
        };
    </script>
<?php elseif (isset($_GET['send']) && $_GET['send'] == 1): ?>
    <script>
        window.toastMessage = {
            type: "success",
            message: "Đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra hộp thư của bạn."
        };
    </script>
<?php endif; ?>