<?php
class Admin extends Controller
{
    protected $UserModel;
    protected $PostModel;
    protected $CommentModel;
    protected $CategoryModel;

    private $userID;

    public $layout = "admin_layout";
    public $page = "dashboard";
    public $title = "Admin";


    public function __construct()
    {
        $this->userID = $_SESSION["UserID"] ?? "";
        $this->UserModel = $this->model("User");
        $this->PostModel = $this->model("Post");
        $this->CommentModel = $this->model("Comment");
        $this->CategoryModel = $this->model("Category");
    }

    function Index()
    {
        $user = $this->UserModel->GetUserByID($this->userID); // get user details
        $all_users = $this->UserModel->GetAllUserDescWithOrderBy("created_at"); // get all user
        $posts = $this->PostModel->GetAllPostWithType("post"); // get all post
        $questions = $this->PostModel->GetAllPostWithType("question"); // get all question
        $documents = $this->PostModel->GetAllPostWithType("document"); // get all documents
        $comments = $this->CommentModel->GetAllComment(); // get all comment
        $years = $this->getCurrentAndPreviousYears(); // lấy 5 năm gần nhất

        $this->view($this->layout, [
            "Page" => $this->page,
            "title" => $this->title,
            "user" => $user,
            "all_users" => $all_users,
            "posts" => $posts,
            "questions" => $questions,
            "comments" => $comments,
            "documents" => $documents,
            "years" => $years,
        ]);
    }

    function Users()
    {
        $user = $this->UserModel->GetUserByID($this->userID); // get user details
        $all_users = $this->UserModel->GetAllUserDescWithOrderBy("created_at"); // get all user
        $this->view($this->layout, [
            "Page" => 'user',
            "title" => $this->title,
            "user" => $user,
            "all_users" => $all_users,
        ]);
    }

    function Posts()
    {
        $users = $this->UserModel->GetUserByID($this->userID); // get user details
        $posts = $this->PostModel->GetAllPostWithType("post"); // get all post

        $this->view($this->layout, [
            "Page" => 'post',
            "title" => $this->title,
            "user" => $users,
            "posts" => $posts,
        ]);
    }

    function Questions()
    {
        $user = $this->UserModel->GetUserByID($this->userID); // get user details
        $questions = $this->PostModel->GetAllPostWithType("question"); // get all questions

        $this->view($this->layout, [
            "Page" => 'question',
            "title" => $this->title,
            "user" => $user,
            "questions" => $questions,
        ]);

    }

    function Documents()
    {
        $user = $this->UserModel->GetUserByID($this->userID); // get user details
        $documents = $this->PostModel->GetAllPostWithType("document");

        $this->view($this->layout, [
            "Page" => 'document',
            "title" => $this->title,
            "user" => $user,
            "documents" => $documents,
        ]);
    }

    function Categories()
    {
        $user = $this->UserModel->GetUserByID($this->userID); // get user details
        $categories = $this->CategoryModel->GetAllCategory(); // get all category

        $this->view($this->layout, [
            "Page" => 'category_admin',
            "title" => $this->title,
            "user" => $user,
            "categories" => $categories,
        ]);
    }

    function AddUser()
    {
        if (isset($_REQUEST["btnAddUser"])) {
            $full_name = $_POST["full_name"];
            $account_name = strtolower(trim($_POST["account_name"]));
            $email = strtolower(trim($_POST["email"]));
            $password = $_POST["password"];

            $userAccount = $this->UserModel->GetUserByEmail($email);
            if ($userAccount) {
                $title = 'Thêm thành viên thất bại!';
                $message = 'Email đã được sử dụng!';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                exit();
            }

            $userAccount = $this->UserModel->CheckAccountName($account_name);
            if ($userAccount) {
                $title = 'Thêm thành viên thất bại!';
                $message = 'Tên tài khoản đã được sử dụng!';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                exit();
            }

            $hashedPassword = $password;
            $secret = GenerateSecret();
            $gender = 'Nam';
            $result = $this->UserModel->CreateUser($account_name, $full_name, $email, $gender, $hashedPassword, $secret);
            if ($result) {
                $userAccount = $this->UserModel->GetUserByEmail($email);
                $this->UserModel->SetRole($userAccount["id"], "2");
                // 1: admin
                // 2: customer
                $title = 'Thêm thành viên thành công!';
                $message = '';
                response_success($title, $message);
                echo "<script>history.back();</script>";
                exit();
            } else {
                // echo "<script>alert('Fail to register');</script>";
                $title = 'Thêm thành viên thất bại!';
                $message = 'Lỗi hệ thống!';
                response_error($title, $message);
                echo "<script>history.back();</script>";
                exit();
            }
        }
    }

    function DeleteCategory($id)
    {
        $result = $this->CategoryModel->DeleteCategoryByID($id);
        switch ($result) {
            case $result === false:
                $title = 'Xóa thất bại';
                $mes = "Lỗi hệ thống!";
                response_error($title, $mes);
                break;
            case $result === true:
                $title = 'Xóa thành công';
                response_success($title);
                break;
            default:
                $title = 'Xóa danh mục thất bại';
                $mes = "Không thể xóa. Có $result bài viết thuộc danh mục này!";
                response_error($title, $mes);
                break;
        }
        echo "<script>history.back();</script>";
        exit();
    }

    function UpdateCategory($category_id)
    {
        $user = $this->UserModel->GetUserByID($this->userID); // get user details
        $category = $this->CategoryModel->GetCategoryByID($category_id); // get category by id

        $this->view($this->layout, [
            "Page" => 'edit_category',
            "title" => $this->title,
            "user" => $user,
            "category" => $category,
        ]);
    }

    function HandelUpdateCategory($category_id)
    {

        if (isset($_REQUEST["btnUpdateCategory"])) {
            $current_name = $_POST["current_name"];
            $category_name = $_POST["category_name_update"];
            $category_description = $_POST["category_description_update"];

            if ($current_name != $category_name) {
                $checkCategoryName = $this->CategoryModel->CheckNameCategory($category_name);
                if ($checkCategoryName) {
                    $title = 'Cập nhật thất bại';
                    $mes = "Tên danh mục đã tồn tại!";
                    response_error($title, $mes);
                    echo "<script>history.back();</script>";
                    exit();
                }
            }

            $result = $this->CategoryModel->UpdateCategory($category_id, $category_name, $category_description);
            if (!$result) {
                $title = 'Cập nhật thất bại';
                $mes = "Lỗi hệ thống!";
                response_error($title, $mes);
            } else {
                $title = 'Cập nhật thành công';
                response_success($title);
            }
            echo "<script>history.back();</script>";
            exit();
        } else {
            header("Location: " . BASE_URL . "/errors/unauthorized");
        }
    }

    function AddCategory()
    {
        if (isset($_REQUEST["btnAddCategory"])) {
            $category_name = $_POST["category_name"];
            $category_description = $_POST["category_description"];
            $category_type = $_POST["category_type"];

            $checkCategoryName = $this->CategoryModel->CheckNameCategory($category_name);
            if ($checkCategoryName) {
                $title = 'Thêm danh mục thất bại';
                $mes = "Tên danh mục đã tồn tại!";
                response_error($title, $mes);
                echo "<script>history.back();</script>";
                exit();
            }

            $result = $this->CategoryModel->CreateCategory($category_name, $category_description, $category_type);
            if ($result) {
                $title = 'Thêm danh mục thành công';
                response_success($title);
            } else {
                $title = 'Thêm danh mục thất bại';
                $mes = "Lỗi hệ thống!";
                response_error($title, $mes);
            }
            echo "<script>history.back();</script>";
            exit();
        } else {
            header("Location: " . BASE_URL . "/errors/unauthorized");
        }
    }

    function DeleteUser($user_id)
    {
        $result = $this->UserModel->DeleteUser($user_id);
        switch ($result) {
            case $result === false:
                $title = 'Xóa thành viên thất bại';
                $mes = "Lỗi hệ thống!";
                response_error($title, $mes);
                break;
            case $result === true:
                $title = 'Xóa thành viên thành công';
                response_success($title);
                break;
            default:
                $title = 'Xóa thành viên thất bại';
                $mes = "Không thể xóa. Có $result bài viết thuộc tác giả này!";
                response_error($title, $mes);
                break;
        }
        echo "<script>history.back();</script>";
        exit();
    }

    function getCurrentAndPreviousYears()
    {
        $currentYear = date("Y");
        $previousYears = [];

        for ($i = 0; $i < 5; $i++) {
            $previousYears[] = $currentYear - $i;
        }

        return $previousYears;
    }

}

?>