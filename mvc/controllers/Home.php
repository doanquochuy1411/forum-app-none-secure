<?php
class Home extends Controller
{
    protected $UserModel;
    protected $PostModel;
    protected $CommentModel;
    protected $CategoryModel;
    protected $TagModel;
    protected $NotificationModel;
    protected $FollowModel;
    private $userID;

    public $layout = "client_layout";
    public $page = "home";
    public $title = "Trang chủ";

    public function __construct()
    {
        $this->userID = isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : "";
        $this->UserModel = $this->model("User");
        $this->PostModel = $this->model("Post");
        $this->CommentModel = $this->model("Comment");
        $this->CategoryModel = $this->model("Category");
        $this->TagModel = $this->model("Tag");
        $this->NotificationModel = $this->model("Notification");
        $this->FollowModel = $this->model("Follow");

    }
    function Index()
    {
        $posts = $this->PostModel->GetPostWithTypeAndLimit("post");
        $questions = $this->PostModel->GetPostWithTypeAndLimit("question");
        $documents = $this->PostModel->GetPostWithTypeAndLimit("document");
        $comments = $this->CommentModel->GetAllComment();
        $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point');
        $categories = $this->CategoryModel->GetAllCategory();
        $my_posts = $this->PostModel->GetAllPostWithTypeAndUserID("post", $this->userID); // Lấy bài viết của tôi
        $tags = $this->TagModel->GetPopularTags();
        $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10);
        $_SESSION["SearchType"] = "post";


        $this->view($this->layout, [
            "Page" => $this->page,
            "title" => $this->title,
            "posts" => $posts,
            "questions" => $questions,
            "documents" => $documents,
            "comments" => $comments,
            "users" => $users,
            "categories" => $categories,
            "my_posts" => $my_posts,
            "tags" => $tags,
            "recent_posts" => $recent_posts,
        ]);
    }
    // Get post details
    function Posts($id)
    {
        $relate_posts = $this->PostModel->GetRelatePosts($id, 10);
        $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10);
        $posts = $this->PostModel->GetPostByID($id);
        $comments = $this->CommentModel->GetAllCommentOfPost($id);
        $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point');
        $this->PostModel->IncrementView(1, $id); // Tăng view lên 1
        $categories = $this->CategoryModel->GetAllCategory();
        $tags = $this->TagModel->GetPopularTags();
        $tags_of_post = $this->TagModel->GetTagsOfPost($id); // Lấy tag của bài post
        $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10);

        $title = convertTitle($posts[0]["type"]);
        $this->view($this->layout, [
            "Page" => "post_details",
            "title" => $title,
            "posts" => $posts,
            "relate_posts" => $relate_posts,
            "recent_posts" => $recent_posts,
            "comments" => $comments,
            "users" => $users,
            "categories" => $categories,
            "tags" => $tags,
            "questions" => $questions,
            "tags_of_post" => $tags_of_post,
        ]);
    }
    // Create
    function CreatePost()
    {
        if (isset($_REQUEST["btnCreatePost"])) {
            $type = $_REQUEST["contentType"];
            $category_id = $_REQUEST["contentCategory"];
            $title = $_REQUEST["title"];
            $tags = isset($_REQUEST["tags"]) ? $_REQUEST["tags"] : [];
            $content = $_REQUEST["content"];
            $user_id = $_SESSION["UserID"];

            $post_id = $this->PostModel->CreatePost($title, $content, $user_id, $category_id, $type);
            if ($post_id != 0) { // success
                $allTagsInserted = true; // Flag to check if all tags were inserted correctly

                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        $tag_id = $this->TagModel->GetTagByName($tag); // Use CheckTagByName to get ID or false
                        if ($tag_id === false) {
                            $tag_id = $this->TagModel->CreateTag($tag); // // Pass $tag to CreateTag to insert new tag
                        }

                        $result = $this->TagModel->AddTag($post_id, $tag_id);
                        if ($result === false) {
                            $allTagsInserted = false; // Set flag to false if insertion fails
                        }
                    }
                }

                // Lấy danh sách người theo dõi
                $followers = $this->FollowModel->GetAllFollower($this->userID);
                // print_r($followers);
                if (count($followers) > 0) {
                    foreach ($followers as $follower) {
                        // $follower_detail = $this->UserModel->GetUserByID($follower["follower_user_id"]);
                        // Thông báo 
                        $this->NotificationModel->CreateNotificationForFollowers($post_id, "đã đăng bài mới", $follower["follower_user_id"]);
                        // Gửi thông báo real-time qua Pusher cho người theo dõi
                        $this->sendNotification(decryptData($follower["follower_user_id"]), "Đã đăng bài mới", null, $post_id);
                    }
                }

                if ($allTagsInserted) {
                    $_SESSION['action_status'] = 'success';
                    $_SESSION['title_message'] = "Đăng bài thành công";
                } else {
                    $_SESSION['action_status'] = 'error';
                    $_SESSION['title_message'] = "Đăng bài thành công";
                    $_SESSION['message'] = "Đăng bài thành công nhưng một số tags không được chèn!";
                }
            } else {
                $_SESSION['action_status'] = 'error';
                $_SESSION['title_message'] = "Đăng bài thất bại";
                $_SESSION['message'] = "";
            }
            echo "<script>history.back();</script>";
            exit();
        }
    }
    // Policy
    function Policy()
    {
        $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10); // footer
        $categories = $this->CategoryModel->GetAllCategory(); // header
        $tags = $this->TagModel->GetPopularTags();

        $this->view($this->layout, [
            "Page" => "policy",
            "title" => "Chính sách Và Điều khoản",
            "questions" => $questions,
            "categories" => $categories,
            "tags" => $tags,
        ]);
    }

    // Trang danh mục
    function Categories($category_id, $type)
    {
        if ($type != "post" && $type != "question") {
            $posts = $this->PostModel->GetAllPostWithCategory($category_id); // body
        } else {
            $posts = $this->PostModel->GetAllPostWithCategoryAndType($category_id, $type); // body
        }
        $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10); // footer
        $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point'); // scroll 
        $categories = $this->CategoryModel->GetAllCategory(); // header
        $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10); // scroll
        $tags = $this->TagModel->GetPopularTags();
        $category_details = $this->CategoryModel->GetCategoryByID($category_id); // Lấy thông tin chi tiết của danh mục

        $sub_title = convertTitle($type); // Tiêu đề cho đường dẫn
        $this->view($this->layout, [
            "Page" => "category",
            "title" => $sub_title,
            "posts" => $posts,
            "questions" => $questions,
            "users" => $users,
            "categories" => $categories,
            "tags" => $tags,
            "recent_posts" => $recent_posts,
            "category_details" => $category_details, // chi tiết danh mục
        ]);
    }
    // Tất cả bài viết || Câu hỏi
    function AllPosts($type)
    {
        $posts = $this->PostModel->GetAllPostWithType($type); // body
        $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10); // footer
        $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point'); // scroll 
        $categories = $this->CategoryModel->GetAllCategory(); // header
        $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10); // scroll
        $tags = $this->TagModel->GetPopularTags();
        $_SESSION["SearchType"] = $type;

        $sub_title = ""; // Tiêu đề cho đường dẫn
        switch ($type) {
            case "post":
                $sub_title = "bài viết";
                break;
            case "question":
                $sub_title = "câu hỏi";
                break;
            case "document":
                $sub_title = "tài liệu";
                break;
            default:
                $sub_title = "";
                break;
        }
        $this->view($this->layout, [
            "Page" => "category",
            "title" => $sub_title,
            "posts" => $posts,
            "questions" => $questions,
            "users" => $users,
            "categories" => $categories,
            "tags" => $tags,
            "recent_posts" => $recent_posts,
        ]);
    }
    // Trang xử lý sau khi tìm kiếm dựa trên tag, nội dung và tiêu đề
    function Search()
    {

        if (isset($_REQUEST["btnSearch"]) && $_REQUEST["txtSearch"] != "") {
            $txtSearch = sanitizeInputContent($_REQUEST["txtSearch"]); // làm sạch chuỗi
            $searchType = sanitizeInputContent($_REQUEST["search-type"]); // làm sạch chuỗi
            $_SESSION["SearchType"] = $searchType;
            switch ($searchType) {
                case 'none':
                    $posts = $this->PostModel->GetPostBySearch($txtSearch, "post");
                    $label = "Bài viết";
                    break;
                case 'myPost':
                    $posts = $this->PostModel->GetAllPostWithTypeAndUserID("post", $this->userID); // Lấy bài viết của tôi
                    $label = "Bài viết của tôi";
                    break;
                default:
                    $posts = $this->PostModel->GetPostBySearch($txtSearch, $searchType);
                    if ($searchType == "post") {
                        $label = "Bài viết";
                    }

                    if ($searchType == "question") {
                        $label = "Câu hỏi";
                    }

                    if ($searchType == "document") {
                        $label = "Tài liệu";
                    }
                    break;
            }


            if (count($posts) > 0) { // success
                $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10); // footer
                $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point'); // scroll 
                $categories = $this->CategoryModel->GetAllCategory(); // header
                $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10); // scroll
                $tags = $this->TagModel->GetPopularTags();

                $this->view($this->layout, [
                    "Page" => "search",
                    "label" => $label,
                    "search" => $txtSearch, // từ khóa cần tìm kiếm
                    "posts" => $posts,
                    "questions" => $questions,
                    "users" => $users,
                    "categories" => $categories,
                    "tags" => $tags,
                    "recent_posts" => $recent_posts,
                ]);
            } else {
                $_SESSION['action_status'] = 'error';
                $_SESSION['title_message'] = "Không tìm thấy bài viết phù hợp!";
                header("Location: " . BASE_URL . "/home/allPosts/post");
                exit();
            }

        } else {
            header("Location: " . BASE_URL . "");
            exit();
        }
    }

    function tags($tag_name)
    {
        $tag = str_replace('-', ' ', $tag_name);
        $posts = $this->PostModel->GetPostByTag($tag); // body
        $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10); // footer
        $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point'); // scroll 
        $categories = $this->CategoryModel->GetAllCategory(); // header
        $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10); // scroll
        $tags = $this->TagModel->GetPopularTags();

        $this->view($this->layout, [
            "Page" => "search",
            "search" => $tag, // từ khóa cần tìm kiếm
            "posts" => $posts,
            "questions" => $questions,
            "users" => $users,
            "categories" => $categories,
            "tags" => $tags,
            "recent_posts" => $recent_posts,
        ]);
    }

    function notifications($notification_id)
    {
        $notification = $this->NotificationModel->GetNotificationByID($notification_id);
        $this->NotificationModel->UpdateIsRead($notification_id);

        if (decryptData($notification[0]["report_id"]) !== "") {
            $title = 'Bài đăng bị báo cáo: <em>\'' . $notification[0]["post_title"] . '\'</em>';
            $message = $notification[0]["message"];
            response_info($title, $message);
        }
        header("Location: " . BASE_URL . "/home/posts/" . $notification[0]["post_id"]);
        exit();
    }
    // Thông tin chi tiết của user
    function Info($account_name)
    {
        $user_details = $this->UserModel->GetUserByAccountName($account_name); // body
        if ($user_details) { // success
            $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10); // footer
            $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point'); // scroll 
            $categories = $this->CategoryModel->GetAllCategory(); // header
            $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10); // scroll
            $tags = $this->TagModel->GetPopularTags(); // scroll
            $my_posts = $this->PostModel->GetAllPostWithTypeAndUserID("post", $user_details["id"]);
            $my_questions = $this->PostModel->GetAllPostWithTypeAndUserID("question", $user_details["id"]);
            $my_trades = $this->PostModel->GetAllPostWithTypeAndUserID("document", $user_details["id"]);

            $this->view($this->layout, [
                "Page" => "user_details",
                "questions" => $questions,
                "users" => $users,
                "categories" => $categories,
                "tags" => $tags,
                "recent_posts" => $recent_posts,
                "user_details" => $user_details,
                "my_posts" => $my_posts,
                "my_questions" => $my_questions,
                "my_trades" => $my_trades
            ]);
        } else {
            $_SESSION['action_status'] = 'error';
            $_SESSION['title_message'] = "Hệ thống gặp sự cố!";
            $_SESSION['message'] = "Chân thành xin lỗi vì sự bất tiện này";
            header("Location: " . BASE_URL . "/home");
            exit();
        }
    }

    private function sendNotification($receiver_id, $message, $commentId = null, $postId = null)
    {
        global $pusher;

        $data['message'] = array(
            'receiver_id' => $receiver_id,
            'message' => $message,
            'commentId' => $commentId,
            'postId' => $postId,
        );

        $result = $pusher->trigger('post-reported', 'PostReported', $data);

        // In ra kết quả của Pusher trigger
        if ($result === true) {
            error_log("Notification sent successfully: " . json_encode($data));
        } else {
            error_log("Notification failed: " . json_encode($data));
        }
    }

    function Logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: " . BASE_URL);
        exit();
    }
}
?>