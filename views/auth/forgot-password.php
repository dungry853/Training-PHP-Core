<div class="container d-flex justify-content-center align-items-center">
    <div class="forgot-password-form">
        <h2>Quên mật khẩu</h2>
        <form method="post" action="/forgot-password">
            <div class="form-group">
                <input type="email" name="email" id="email" required placeholder="Email">
                <span class="error">
                    <?php
                    if (!empty($errors['email'])) {
                        echo implode('<br>', $errors['email']);
                    }
                    ?>
                </span>
            </div>

            <div class="form-group">
                <button type="submit">Gửi liên kết đặt lại mật khẩu</button>
            </div>
        </form>
    </div>
</div>