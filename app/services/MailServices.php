<?php



namespace App\Services;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

class MailServices
{
    public static function sendResetPasswordEmail($toEmail, $verificationCode)
    {
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'];
            $mail->Password   = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $mail->Port       = $_ENV['MAIL_PORT'];

            // Người gửi và người nhận
            $mail->setFrom($_ENV['MAIL_USERNAME'], 'Training-PHP');
            $mail->addAddress($toEmail);

            // Nội dung
            $mail->isHTML(true);
            $mail->Subject = "Reset mật khẩu";
            $mail->Body    = "Mã xác nhận để đặt lại mật khẩu: $verificationCode. Mã chỉ tồn tại trong 5 phút.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Lỗi gửi email: " . $e->getMessage());

            return false;
        }
    }
}
