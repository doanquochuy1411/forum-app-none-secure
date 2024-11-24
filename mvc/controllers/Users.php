<?php
// Thao tác với bài viết như sửa, xóa
class Users extends Controller
{
    protected $UserModel;
    // protected $CommentModel;

    private $userID;

    public function __construct()
    {
        $this->userID = $_SESSION["UserID"] ?? "";
        $this->UserModel = $this->model("User");
    }

    function Index()
    {
        header("Location: " . BASE_URL . "");
        exit();
    }

    function UpdateInfo()
    {
        if (isset($_REQUEST["btnUpdateInfo"])) {
            $file = $_FILES["user_image"];
            $user_name = $_REQUEST["user_name"];
            $email = strtolower(trim($_POST["email"]));
            $phone_number = $_REQUEST["phone_number"];
            $gender = $_REQUEST["gender"];

            $file_name = "";
            // Kiểm tra xem file có trống không
            if ($file['size'] > 0) {
                // Upload ảnh và kiểm tra kết quả
                $uploadResult = uploadImage($file);

                if ($uploadResult['status'] === 'error') {
                    $title = 'Ảnh không hợp lệ';
                    $message = $uploadResult['message'];
                    response_error($title, $message);
                    echo "<script>history.back();</script>";
                    exit();
                }

                $file_name = $uploadResult['file_name'];
            }

            $result = $this->UserModel->UpdateUser($this->userID, $user_name, $email, $phone_number, $file_name, $gender);
            $title = 'Cập nhật thông tin thành công';
            if ($file_name != "") {
                $_SESSION['Avatar'] = $file_name;
            }
            response_success($title, "");
            // if ($result) {
            // } else {
            //     if ($file['size'] > 0) {
            //         deleteImage($file_name);
            //     }
            //     $title = 'Cập nhật thông tin thất bại';
            //     $message = "Lỗi hệ thống!";
            //     response_error($title, $message);
            // }
            echo "<script>history.back();</script>";
            exit();
        }
    }
    function ChangePassword()
    {
        if (isset($_REQUEST["btnChangePassword"])) {
            $current_password = $_REQUEST["current_password"];
            $new_password = $_REQUEST["new_password"];
            $retype_password_of_change = $_REQUEST["retype_password_of_change"];

            $user_details = $this->UserModel->GetUserByID($this->userID);

            if (!password_verify($current_password, $user_details[0]['password'])) {
                $title = 'Cập nhật thất bại';
                $message = 'Mật khẩu hiện tại không chính xác!';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                exit();
                ;
            }

            if ($new_password != $retype_password_of_change) {
                $title = 'Cập nhật thất bại';
                $message = 'Mật khẩu và Nhập lại mật khẩu không khớp!';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                exit();
            }

            $hashedPassword = $new_password;

            $result = $this->UserModel->ChangePassword($this->userID, $hashedPassword);
            if ($result) {
                $title = 'Cập nhật mật khẩu thành công';
                response_success($title, "");
            } else {
                $title = 'Cập nhật mật khẩu thất bại';
                $message = "Lỗi hệ thống!";
                response_error($title, $message);
            }
            echo "<script>history.back();</script>";
            exit();
        }
    }
}