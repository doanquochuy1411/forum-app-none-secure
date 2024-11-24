<?php

class Posts extends Controller
{
    protected $PostModel;
    protected $CommentModel;
    protected $UserModel;
    protected $CategoryModel;
    protected $TagModel;
    protected $NotificationModel;
    private $userID;

    public $layout = "client_layout";

    public $title = "Bài viết";

    public function __construct()
    {
        $this->userID = $_SESSION["UserID"] ?? "";
        $this->PostModel = $this->model("Post");
        $this->UserModel = $this->model("User");
        $this->CommentModel = $this->model("Comment");
        $this->CategoryModel = $this->model("Category");
        $this->TagModel = $this->model("Tag");
        $this->NotificationModel = $this->model("Notification");
    }

    function Index()
    {
        header("Location: " . BASE_URL . "");
        exit();
    }

    function CreateComment()
    {
        if (isset($_REQUEST["btnComment"])) {
            $content = $_REQUEST["content"];
            $parent_comment_id = (int) ($_REQUEST["parent_comment_id"]);
            $post_id = $_REQUEST["post_id"];

            $cmt_id = $this->CommentModel->CreateComment($content, $this->userID, $post_id, $parent_comment_id);
            if ($cmt_id == 0) {
                $_SESSION['action_status'] = 'error';
                $_SESSION['title_message'] = "Bình luận thất bại";
                $_SESSION['message'] = "Không thể bình luận!";
            } else {
                $this->NotificationModel->CreateNotification($post_id, "đã bình luận: " . stripImages($content), null, $cmt_id);
                $auth = $this->PostModel->GetAuthOfPost($post_id);
                // Gửi thông báo real-time qua Pusher cho tác giả
                $this->sendNotification($auth[0]["user_id"], "đã bình luận: " . stripImages($content), $cmt_id, $post_id);

                $_SESSION['action_status'] = 'success';
                $_SESSION['title_message'] = "Bình luận thành công";
            }
            echo "<script>history.back();</script>";
            exit();
        } else {
            header("Location: " . BASE_URL . "/errors/Unauthorized");
        }
    }

    function DeleteComment($id)
    {
        $comment = $this->CommentModel->GetCommentByID($id);
        if ($comment[0]['user_id'] != decryptData($_SESSION['UserID'])) {
            $_SESSION['action_status'] = 'error';
            $_SESSION['title_message'] = "Không có quyền truy cập!";
            header("Location: " . BASE_URL);
            exit();
        }

        // // Trả về true nếu xóa thành công và ngược lại
        $result = $this->CommentModel->DeleteComment($id);
        if (!$result) {
            $_SESSION['action_status'] = 'error';
            $_SESSION['title_message'] = "Xóa bình luận thất bại";
            $_SESSION['message'] = "Truy vấn gặp sự cố!";
        } else {
            $_SESSION['action_status'] = 'success';
            $_SESSION['title_message'] = "Xóa bình luận thành công";
        }
        echo "<script>history.back();</script>";
        exit();
    }
    // To view edit
    function Edit($id)
    {
        $posts = $this->PostModel->GetPostByID($id);
        $authID = decryptData($posts[0]['user_id']);
        $loginID = decryptData($_SESSION['UserID']);

        if ($authID != $loginID) {
            $_SESSION['action_status'] = 'error';
            $_SESSION['title_message'] = "Không có quyền truy cập!";
            header("Location: " . BASE_URL);
            exit();
        }

        $relate_posts = $this->PostModel->GetRelatePosts($id, 10);
        $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10);
        $comments = $this->CommentModel->GetAllCommentOfPost($id);
        $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point');
        $categories = $this->CategoryModel->GetAllCategory();
        $tags = $this->TagModel->GetPopularTags();
        $tags_of_post = $this->TagModel->GetTagsOfPost($id); // Lấy tag của bài post
        $questions = $this->PostModel->GetPostWithTypeAndLimit("question", 10);

        $title = convertTitle($posts[0]["type"]);
        $this->view($this->layout, [
            "Page" => "edit_post",
            "title" => $title,
            "post_to_edit" => $posts, // Post details
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

    function HandleEdit($id)
    {
        if (isset($_REQUEST["btnEditPost"])) {
            $type = $_REQUEST["contentType"];
            $category_id = $_REQUEST["contentCategory"];
            $title = $_REQUEST["title"];
            $tags = isset($_REQUEST["tags"]) ? $_REQUEST["tags"] : [];
            $content = $_REQUEST["content"];

            // print_r($tags);
            $result = $this->PostModel->UpdatePost($id, $title, $content, $category_id, $type);

            // if ($result != 0) { // success
            $allTagsInserted = true; // Flag to check if all tags were inserted correctly

            $this->TagModel->DeleteTagOfPost($id);
            // if ($tag_delete_result == 0) { // fail
            //     $allTagsInserted = false; // Set flag to false if insertion fails

            // }

            if (count($tags) > 0) {
                foreach ($tags as $tag) {
                    $tag_id = $this->TagModel->GetTagByName($tag); // Use CheckTagByName to get ID or false
                    if ($tag_id === false) {
                        $tag_id = $this->TagModel->CreateTag($tag); // // Pass $tag to CreateTag to insert new tag
                    }

                    $result = $this->TagModel->AddTag($id, $tag_id);
                    if ($result === false) {

                        $allTagsInserted = false; // Set flag to false if insertion fails
                    }
                }
            }

            if ($allTagsInserted) {
                $_SESSION['action_status'] = 'success';
                $_SESSION['title_message'] = "Cập nhật thành công";
            } else {
                $_SESSION['action_status'] = 'error';
                $_SESSION['title_message'] = "Cập nhật thành công";
                $_SESSION['message'] = "Cập nhật thành công nhưng một số tags không được cập nhật!";
            }

            echo "<script>history.back();</script>";
            exit();
        }
    }
    // Delete post
    function Delete($id)
    {
        $post = $this->PostModel->GetPostByID($id);

        if (decryptData($post[0]['user_id']) != decryptData($_SESSION['UserID']) && $_SESSION['RoleID'] != 1) {
            $_SESSION['action_status'] = 'error';
            $_SESSION['title_message'] = "Không có quyền truy cập!";
            header("Location: " . BASE_URL);
            exit();
        }

        // Trả về true nếu xóa thành công và ngược lại
        $result = $this->PostModel->DeletePost($id);
        if (!$result) {

            $_SESSION['action_status'] = 'error';
            $_SESSION['title_message'] = "Xóa thất bại";
            $_SESSION['message'] = "Truy vấn gặp sự cố!";
        } else {
            $_SESSION['action_status'] = 'success';
            $_SESSION['title_message'] = "Xóa thành công";
        }
        echo "<script>history.back();</script>";
        exit();
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


    // View post, document, question details
    function User($id)
    {
        $my_posts = $this->PostModel->GetAllPostWithTypeAndUserID("post", $id);
        $my_questions = $this->PostModel->GetAllPostWithTypeAndUserID("question", $id);
        $my_trades = $this->PostModel->GetAllPostWithTypeAndUserID("document", $id);
        $users = $this->UserModel->GetAllUserDescWithOrderBy('uas.point'); // scroll 
        $categories = $this->CategoryModel->GetAllCategory(); // header
        $recent_posts = $this->PostModel->GetPostWithTypeAndLimit("post", 10); // scroll
        $tags = $this->TagModel->GetPopularTags(); // scroll

        $this->view($this->layout, [
            "categories" => $categories,
            "Page" => "post_by_user",
            "recent_posts" => $recent_posts,
            "users" => $users,
            "tags" => $tags,
            "my_posts" => $my_posts,
            "my_questions" => $my_questions,
            "my_trades" => $my_trades
        ]);
    }
}