<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class MailServices
{
    public static function sendResetPasswordEmail($toEmail, $token)
    {
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tungbeobede@gmail.com'; // Đổi thành email của bạn
            $mail->Password   = '123456'; // App Password (không phải mật khẩu gmail)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Người gửi và người nhận
            $mail->setFrom('tungbeobede@gmail.com', 'Training-PHP');
            $mail->addAddress($toEmail);

            // Nội dung
            $mail->isHTML(true);
            $mail->Subject = 'Reset mật khẩu';
            $resetLink = "http://training-php.test/reset-password?token=$token";
            $mail->Body    = "Click vào liên kết sau để đặt lại mật khẩu: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
