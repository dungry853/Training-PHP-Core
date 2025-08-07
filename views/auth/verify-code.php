<div class="container d-flex justify-content-center align-items-center">
    <div class="forgot-password-form">
        <h2>Nhập mã xác nhận</h2>
        <form method="post" action="/verify-code">
            <div class="form-group">
                <input value="<?php echo $data['verification_code'] ?? '' ?>" type="text" name="verification_code" id="verification_code" required placeholder="Mã xác nhận">
                <span class="error">
                    <?php
                    if (!empty($errors['verification_code'])) {
                        echo implode('<br>', $errors['verification_code']);
                    }
                    ?>
                </span>
            </div>

            <div class="form-group">
                <button type="submit">Xác nhận</button>
            </div>
        </form>
    </div>
</div>