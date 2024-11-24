<?php
require BASE_URL . '/phpmailer/src/PHPMailer.php';
require BASE_URL . '/phpmailer/src/Exception.php';
require BASE_URL . '/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendCode($email)
{
    $otp = rand(100000, 999999);
    $expiryTime = time() + 90;

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = "let942217@gmail.com";
    $mail->Password = "yhcb hqcv hwgd fbmf";

    $mail->SMTPSecure = 'tls';

    $mail->Port = 587;

    $mail->setFrom("let942217@gmail.com");
    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = "Email verification Code ($otp)";
    $mail->Body = "Chào bạn,\n\nMã xác nhận của bạn là:\n\n$otp\n\nMã này có hiệu lực trong vòng 90 giây. Vui lòng sử dụng mã này để xác nhận địa chỉ email của bạn.\n\nCảm ơn bạn!\n\nNếu bạn không yêu cầu mã này, vui lòng bỏ qua email này.";
    try {
        $mail->send();
        // $_SESSION["verify-code"] = $otp;
        // $_SESSION["otp-timestamp"] = time();
        $_SESSION['otp_map'][$email] = [
            'otp_code' => $otp,
            'otp_expiry' => $expiryTime
        ];
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function verifyCode($email, $inputOtp)
{
    // $otp = $_SESSION["verify-code"];
    // return $otp == $code;
    if (!isset($_SESSION['otp_map'][$email])) {
        $title = 'Xác thực thất bại';
        $message = 'OTP không tồn tại hoặc đã hết hạn.';
        response_error($title, $message);
        return false;
    }

    $otpData = $_SESSION['otp_map'][$email];
    $currentTime = time();

    // Kiểm tra thời gian hết hạn
    if ($currentTime > $otpData['otp_expiry']) {
        $title = 'Xác thực thất bại';
        $message = 'OTP đã hết hạn. Vui lòng yêu cầu mã mới.';
        response_error($title, $message);
        return false;
    }

    // Kiểm tra mã OTP
    if ($inputOtp == $otpData['otp_code']) {
        return true;
    } else {
        $title = 'Xác thực thất bại';
        $message = 'Mã OTP không đúng!';
        response_error($title, $message);
        return false;
    }
}
?>