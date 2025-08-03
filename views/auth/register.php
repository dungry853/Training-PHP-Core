<div class="container d-flex justify-content-center align-items-center">
    <div class="login-form">
        <h2>Đăng ký tài khoản</h2>
        <form method="post" action="/register">
            <div class="form-group">
                <input value="<?= $data['username'] ?? '' ?>" type="text" name="username" id="username" required placeholder="Tên đăng nhập">
                <span class="error">
                    <?php
                    if (!empty($errors['username'])) {
                        echo implode('<br>', $errors['username']);
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <input type="text" value="<?= $data['full_name'] ?? '' ?>" name="full_name" id="full_name" required placeholder="Họ và tên">
                <span class="error">
                    <?php
                    if (!empty($errors['full_name'])) {
                        echo implode('<br>', $errors['full_name']);
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <input value="<?= $data['email'] ?? '' ?>" type="text" name="email" id="email" required placeholder="Email">
                <span class="error">
                    <?php
                    if (!empty($errors['email'])) {
                        echo implode('<br>', $errors['email']);
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <input value="<?= $data['dob'] ?? '' ?>" type="text" name="dob" id="dob" required placeholder="Ngày sinh (YYYY-MM-DD)">
                <span class="error">
                    <?php
                    if (!empty($errors['dob'])) {
                        echo implode('<br>', $errors['dob']);
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
            <div class="form-group">
                <input type="password" value="<?= $data['re_password'] ?? '' ?>" name="re_password" id="re_password" required placeholder="Nhập lại mật khẩu">
                <span class="error">
                    <?php
                    if (!empty($errors['re_password'])) {
                        echo implode('<br>', $errors['re_password']);
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <button type="submit">Đăng ký</button>
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
                <p class="register-link">Đã có tài khoản? <a href="/login">Đăng nhập ngay</a></p>
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

<?php if (!empty($errors['register'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.registerError = <?= json_encode($errors['register']) ?>;
        });
    </script>
<?php endif; ?>