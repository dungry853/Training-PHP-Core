<div class="container d-flex justify-content-center align-items-center">
    <div class="forgot-password-form">
        <h2>Đặt lại mật khẩu</h2>
        <form method="post" action="/reset-password">
            <div class="form-group">
                <input type="password" name="password" id="password" required placeholder="Mật khẩu mới">
                <span class="error">
                    <?php
                    if (!empty($errors['password'])) {
                        echo implode('<br>', $errors['password']);
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <input type="password" name="re-password" id="re-password" required placeholder="Nhập lại mật khẩu mới">
                <span class="error">
                    <?php
                    if (!empty($errors['re-password'])) {
                        echo implode('<br>', $errors['re-password']);
                    }
                    ?>
                </span>
            </div>

            <div class="form-group">
                <button type="submit">Cập nhật mật khẩu</button>
            </div>
        </form>
    </div>
</div>