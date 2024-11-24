<?php
class Login extends Controller
{
    public $UserModel;
    protected $CategoryModel;
    public $layout = "client_layout";
    public $page = "login";
    public $title = "Đăng nhập";

    public function __construct()
    {
        $this->UserModel = $this->model("User");
        $this->CategoryModel = $this->model("Category");
    }

    function Index()
    {
        $categories = $this->CategoryModel->GetAllCategory();


        $this->view($this->layout, [
            "Page" => $this->page,
            "title" => $this->title,
            "categories" => $categories,
        ]);
    }

    function HandelLogin()
    {
        $categories = $this->CategoryModel->GetAllCategory();

        if (isset($_POST["btnLogin"])) {
            $user_name = $_POST["user_name"];
            $password = $_POST["password"];

            $userAccount = $this->UserModel->GetUserByAccountName($user_name, $password);

            if ($userAccount) {
                $_SESSION['action_status'] = "none"; // Để nhận biết request thành công hay thất bại. (none / success / error)
                $_SESSION['title_message'] = ""; // Tiêu đề lỗi hoặc thành công
                $_SESSION['message'] = ""; // Thông báo chi tiết lỗi hoặc thành công
                $_SESSION['_token'] = "";
                $_SESSION['UserID'] = $userAccount["id"];
                $_SESSION['UserName'] = $userAccount["user_name"]; // Hiển thị trên tên trên trang chủ
                $_SESSION['AccountName'] = encryptData($userAccount["account_name"]); // Tên tài khoản của user
                $_SESSION['RoleID'] = $userAccount["role_id"];
                $_SESSION['Avatar'] = $userAccount["image"];
                if ($userAccount["role_id"] == 1) {
                    header("Location: " . BASE_URL . "/admin");
                } else {
                    header("Location: " . BASE_URL);
                }
                exit();
            } else {
                $_SESSION['action_status'] = 'error';
                $_SESSION['title_message'] = "Tên tài khoản hoặc mật khẩu không chính xác";
                $this->view($this->layout, [
                    "Page" => $this->page,
                    "title" => $this->title,
                    "categories" => $categories,
                    "data" => [$user_name, $password]
                ]);
                return;
            }
        }
    }
}
?>