<?php
class Reset extends Controller
{
    public $UserModel;
    protected $CategoryModel;

    public $layout = "client_layout";
    public $title = "Quên mật khẩu";
    public $ctr = "Reset";



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

            if (!validateEmail($email)) {
                $title = 'Email không hợp lệ';
                $message = '';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                return;
            }

            $userAccount = $this->UserModel->GetUserByEmail($email);
            if ($userAccount == null) {
                $title = 'Email chưa được đăng ký';
                $message = '';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                return;
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
                "Page" => "reset",
                "title" => $this->title,
                "data" => $email,
                "categories" => $categories,
            ]);
            return;
        }
    }

    function HandelReset()
    {
        if (isset($_POST["btnReset"])) {
            $email = strtolower(trim($_POST["email"]));
            $password = $_POST["password"];
            $retypePassword = $_POST["retype_password"];
            $categories = $this->CategoryModel->GetAllCategory();

            if ($password != $retypePassword) {
                $title = 'Mật khẩu và Nhập lại mật khẩu không trùng khớp!';
                $message = '';
                response_error($title, $message);
                $this->view($this->layout, [
                    "Page" => "reset",
                    "categories" => $categories,
                ]);
                return;
            }
            $hashedPassword = $password;

            $result = $this->UserModel->UpdatePassword($email, $hashedPassword);
            if ($result) {
                $this->UserModel->ResetLoginAttemptsWithEmail($email);
                $this->UserModel->ResetLockedWithEmail($email);
                $title = 'Khôi phục mật khẩu thành công';
                response_success($title);
                $_SESSION["password_info"] = $password;
                header("Location: " . BASE_URL . "/login");
            } else {
                $title = 'Khôi phục mật khẩu thất bại. Vui lòng thử lại sau!';
                response_error($title);
                header("Location: " . BASE_URL . "/reset");
                return;
            }
        }
    }
}
?>