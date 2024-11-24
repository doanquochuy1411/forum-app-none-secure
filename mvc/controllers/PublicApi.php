<?php
class PublicApi extends Controller
{
    function Index()
    {
        echo json_encode([
            'code' => "200",
            'status' => "success",
            'message' => "Access to public api"
        ]);
    }

    public function reSendCode($email)
    {
        if ($email == "" || !sendCode($email)) {
            $_SESSION['otp_map'][$email]['otp_expiry'] = time() + 90;
            http_response_code(400); // Đặt mã phản hồi là 400
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Gửi mã xác nhận thất bại.",
            ]);
            return;
        }

        // Trả về JSON
        http_response_code(200);
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'message' => "Mã xác nhận đã được gửi lại.",
        ]);
    }
}

?>