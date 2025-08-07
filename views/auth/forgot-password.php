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

<?php if (isset($_GET['send']) && $_GET['send'] == 1): ?>
    <script>
        window.toastMessage = {
            type: "success",
            message: "Đã gửi email đặt lại mật khẩu! Vui lòng kiểm tra hộp thư của bạn."
        };
    </script>
<?php endif; ?>