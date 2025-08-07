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

<div aria-live="polite" aria-atomic="true" class="bg-body-danger position-relative bd-example-toasts rounded-3">
    <div class="toast-container p-3" id="toastPlacement">
        <div class="toast" id="customToast">
            <div class="toast-body" id="toastBody">

            </div>
        </div>
    </div>
</div>

<?php if (!empty($errors['reset'])): ?>
    <script>
        window.toastMessage = {
            type: "error",
            message: "<?= implode('<br>', $errors['reset']) ?>"
        };
    </script>
<?php endif; ?>