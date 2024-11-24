<?php
class Register extends Controller
{
    public $UserModel;
    protected $CategoryModel;

    public $layout = "client_layout";
    public $title = "Đăng ký";

    public $ctr = "Register";

    public function __construct()
    {
        $this->UserModel = $this->model("User");
        $this->CategoryModel = $this->model("Category");

    }

    function Index()
    {
        $categories = $this->CategoryModel->GetAllCategory();

        $this->view($this->layout, [
            "Page" => "send_code",
            "title" => $this->title,
            "controller" => $this->ctr,
            "categories" => $categories,
        ]);
    }

    function SendCode()
    {
        if (isset($_POST["btnSendCode"])) {
            $email = strtolower(trim($_POST["email"]));

            $userAccount = $this->UserModel->GetUserByEmail($email);
            if ($userAccount) {
                // echo "<script>alert('Email đã được đăng ký!'); history.back();</script>";
                $title = 'Yêu cầu gửi mã xác thực thất bại!';
                $message = 'Email đã được sử dụng!';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                exit();
            }

            if (sendCode($email)) {
                $categories = $this->CategoryModel->GetAllCategory();

                $this->view($this->layout, [
                    "Page" => "verify_code",
                    "title" => $this->title,
                    "data" => $email,
                    "controller" => $this->ctr,
                    "categories" => $categories,
                ]);
            }
        }
    }
    function VerifyCode()
    {
        if (isset($_POST["btnVerifyCode"])) {
            $email = strtolower(trim($_POST["email"]));
            $code = $_POST["code"];
            $categories = $this->CategoryModel->GetAllCategory();

            if (!verifyCode($email, $code)) {
                $this->view($this->layout, [
                    "Page" => "verify_code",
                    "title" => $this->title,
                    "data" => $email,
                    "controller" => $this->ctr,
                    "categories" => $categories,
                ]);
                return;
            }

            $this->view($this->layout, [
                "Page" => "register",
                "title" => $this->title,
                "data" => $email,
                "controller" => $this->ctr,
                "categories" => $categories,
            ]);
            return;
        }
    }

    function HandelRegister()
    {
        if (isset($_POST["btnRegister"])) {
            $full_name = $_POST["full_name"];
            $account_name = strtolower(trim($_POST["account_name"]));
            $gender = $_POST["gender"];
            $email = strtolower(trim($_POST["email"]));
            $password = $_POST["password"];
            $retypePassword = $_POST["retype_password"];
            $categories = $this->CategoryModel->GetAllCategory();

            $userAccount = $this->UserModel->CheckAccountName($account_name);
            if ($userAccount) {
                $title = 'Đăng ký thất bại!';
                $message = 'Tên tài khoản đã được sử dụng!';
                response_error($title, $message);
                // echo "<script>history.back();</script>";
                $this->view($this->layout, [
                    "Page" => "register",
                    "categories" => $categories,
                    "data" => $email,
                    "full_name" => $full_name,
                    "account_name" => $account_name,
                    "password" => $password,
                    "re_type_password" => $retypePassword
                ]);
                return;
            }


            if ($password != $retypePassword) {
                // echo "<script>alert('Password and retype password do not matching');</script>";
                $title = 'Đăng ký thất bại!';
                $message = 'Mật khẩu và Nhập lại mật khẩu không trùng khớp';
                response_error($title, $message);
                $this->view($this->layout, [
                    "Page" => "register",
                    "categories" => $categories,
                    "data" => $email,
                    "full_name" => $full_name,
                    "account_name" => $account_name,
                    "password" => $password,
                    "re_type_password" => $retypePassword
                ]);
                return;
            }
            $hashedPassword = $password;
            $secret = "";

            $result = $this->UserModel->CreateUser($account_name, $full_name, $email, $gender, $hashedPassword, $secret);
            if ($result) {
                $userAccount = $this->UserModel->GetUserByEmail($email);
                $this->UserModel->SetRole($userAccount["id"], "2");
                // 1: admin
                // 2: customer
                $title = 'Đăng ký thành công!';
                $message = '';
                response_success($title, $message);
                $_SESSION["account_name_info"] = $account_name;
                $_SESSION["password_info"] = $password;
                header("Location: " . BASE_URL . "/login");
                return;
            } else {
                $title = 'Đăng ký thất bại!';
                $message = 'Lỗi hệ thống!';
                response_error($title, $message);
                $this->view($this->layout, [
                    "Page" => "register",
                    "categories" => $categories,
                    "data" => $email,
                    "full_name" => $full_name,
                    "account_name" => $account_name,
                    "password" => $password,
                    "re_type_password" => $retypePassword
                ]);
                return;
            }
        }
    }
}
?>