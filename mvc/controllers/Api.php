<?php
class Api extends Controller
{
    protected $UserModel;
    protected $PostModel;
    protected $ReportModel;
    protected $NotificationModel;
    protected $FollowModel;
    protected $CommentModel;

    private $userID;

    public function __construct()
    {
        $this->userID = $_SESSION["UserID"] ?? "";
        $this->PostModel = $this->model("Post");
        $this->UserModel = $this->model("User");
        $this->ReportModel = $this->model("Report");
        $this->NotificationModel = $this->model("Notification");
        $this->CommentModel = $this->model("Comment");
        $this->FollowModel = $this->model("Follow");
    }
    // Gửi báo cáo
    function Index()
    {
        echo json_encode([
            'code' => "401",
            'status' => "error",
            'message' => "permission denied"
        ]);
    }

    public function getNotifications()
    {
        // Lấy danh sách thông báo từ database
        $notifications = $this->NotificationModel->GetUnreadNotificationsByUserId($this->userID);

        if (empty($notifications)) {
            // Trả về lỗi 400 nếu không tìm thấy dữ liệu
            http_response_code(400); // Đặt mã phản hồi là 400
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy thông báo cho người dùng này.",
            ]);
            return; // Dừng lại nếu dữ liệu trống
        }

        // Trả về JSON
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'count' => count($notifications),
            'notifications' => $notifications
        ]);
    }

    public function getUserDetailsViaCmtID($cmt_id)
    {
        // Lấy danh sách thông báo từ database
        $userDetails = $this->CommentModel->GetAuthOfComment($cmt_id);
        // print_r($userDetails);
        if (empty($userDetails)) {
            // Trả về lỗi 400 nếu không tìm thấy dữ liệu
            http_response_code(400); // Đặt mã phản hồi là 400
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy dữ liệu người dùng cho bình luận này.",
            ]);
            return; // Dừng lại nếu dữ liệu trống
        }

        // Trả về JSON
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'user_details' => $userDetails,
        ]);
    }

    public function getPostToStatistics($year)
    {
        // Lấy danh sách thông báo từ database
        $result = $this->PostModel->GetPostAmountPerMonthByYear($year);
        if (mysqli_num_rows($result) > 0) {
            $posts = array_fill(0, 12, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                $posts[$row['month'] - 1] = $row['post_count'];
            }
            http_response_code(200);
            echo json_encode([
                'code' => 200,
                'status' => "success",
                'posts' => $posts,
                'message' => "Lấy dữ liệu thành công",
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy dữ liệu thống kê.",
            ]);
            return;
        }
    }

    public function getUserToStatistics($year)
    {
        // Lấy danh sách thông báo từ database
        $result = $this->UserModel->GetUserAmountPerMonthByYear($year);
        if (mysqli_num_rows($result) > 0) {
            $userData = array_fill(0, 12, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                $userData[$row['month'] - 1] = $row['user_count'];
            }
            http_response_code(200);
            echo json_encode([
                'code' => 200,
                'status' => "success",
                'users' => $userData,
                'message' => "Lấy dữ liệu thành công",
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy dữ liệu thống kê.",
            ]);
            return;
        }
    }

    public function HandelLikePost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = $_POST['post_id'];
            $userId = $_POST['user_id'];
            $status = "";

            $checkLiked = $this->PostModel->CheckLikedPostByUser($userId, $postId);
            if ($checkLiked) {
                $this->PostModel->CancelLikedPostByUser($userId, $postId);
                $status = 'unliked';
            } else {
                $this->PostModel->CreateLikedPostByUser($userId, $postId);
                $status = 'liked';
            }
        }

        $likeCount = $this->PostModel->CountLikedOfPost($postId);
        http_response_code(200);
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'like_status' => $status,
            'like_count' => $likeCount,
            'message' => "Dữ liệu đã được xử lý",
        ]);
    }

    public function CheckLikedPost($postId, $userId)
    {
        $checkLiked = $this->PostModel->CheckLikedPostByUser($userId, $postId);
        if ($checkLiked) {
            http_response_code(200);
            echo json_encode([
                'code' => 200,
                'status' => "success",
                'like_status' => "liked",
                'message' => "Kiểm tra trạng thái thích thành công",
            ]);
        } else {
            http_response_code(200);
            echo json_encode([
                'code' => 200,
                'status' => "success",
                'like_status' => "unliked",
                'message' => "Kiểm tra trạng thái thích thành công",
            ]);
        }
    }

    public function GetTopPostsByViews($limit)
    {
        $topPosts = $this->PostModel->GetTopPostsByViews($limit);
        if (empty($topPosts)) {
            http_response_code(400);
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy dữ liệu bài viết.",
            ]);
            return;
        }

        // Trả về JSON
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'top_posts_by_views' => $topPosts,
        ]);
    }

    public function GetTopPostsByLikes($limit)
    {
        $topPosts = $this->PostModel->GetTopPostsByLikes($limit);
        if (empty($topPosts)) {
            http_response_code(400);
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy dữ liệu bài viết.",
            ]);
            return;
        }

        // Trả về JSON
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'top_posts_by_likes' => $topPosts,
        ]);
    }

    public function CheckFollowUser($authId, $userId)
    {
        if ($authId == "none" || $userId == "none") {
            http_response_code(400);
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'follow_status' => "followed",
                'message' => "Không tìm thấy dữ liệu người dùng.",
            ]);
            return;
        }

        $checkFollowed = $this->FollowModel->CheckFollowByUser($authId, $userId);
        if ($checkFollowed) {
            http_response_code(200);
            echo json_encode([
                'code' => 200,
                'status' => "success",
                'follow_status' => "followed",
                'message' => "Kiểm tra trạng thái theo dõi thành công",
            ]);
        } else {
            http_response_code(200);
            echo json_encode([
                'code' => 200,
                'status' => "success",
                'follow_status' => "unFollowed",
                'message' => "Kiểm tra trạng thái theo dõi thành công",
            ]);
        }
    }

    public function HandelFollow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authId = $_POST['auth_id'];
            $userId = $_POST['user_id'];
            $status = "";

            $checkLiked = $this->FollowModel->CheckFollowByUser($authId, $userId);
            if ($checkLiked) {
                $this->FollowModel->CancelLikedPostByUser($authId, $userId);
                $status = 'unFollow';
            } else {
                $this->FollowModel->CreateFollowPostByUser($authId, $userId);
                $status = 'follow';
            }
        }

        http_response_code(200);
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'follow_status' => $status,
            'message' => "Dữ liệu đã được xử lý",
        ]);
    }

    public function getAuthOfPost($post_id)
    {
        $postDetail = $this->PostModel->GetPostByID($post_id);
        if (empty($postDetail)) {
            http_response_code(400); // Đặt mã phản hồi là 400
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy bài viết cho thông báo này.",
            ]);
            return; // Dừng lại nếu dữ liệu trống
        }

        // Trả về JSON
        http_response_code(200);
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'post_details' => $postDetail,
        ]);
    }

    public function getAuthOfReport($report_id)
    {
        // Lấy danh sách thông báo từ database
        $reportDetails = $this->ReportModel->GetReportByID($report_id);
        if (empty($reportDetails)) {
            // Trả về lỗi 400 nếu không tìm thấy dữ liệu
            http_response_code(400); // Đặt mã phản hồi là 400
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy dữ liệu người dùng cho báo cáo này.",
            ]);
            return; // Dừng lại nếu dữ liệu trống
        }

        // Trả về JSON
        echo json_encode([
            'code' => 200,
            'status' => "success",
            'report_details' => $reportDetails,
        ]);
    }

    public function getQuestionAndDocumentToStatistics($year)
    {
        // Lấy danh sách thông báo từ database
        $questions = $this->PostModel->GetPostAmountPerMonthByYear($year, "question");
        $documents = $this->PostModel->GetPostAmountPerMonthByYear($year, "document");
        $posts = $this->PostModel->GetPostAmountPerMonthByYear($year, "post");
        $questionCounts = array_fill(0, 12, 0);
        $documentCounts = array_fill(0, 12, 0);
        $postCounts = array_fill(0, 12, 0);
        $labels = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];

        if (mysqli_num_rows($questions) > 0) {
            while ($row = mysqli_fetch_assoc($questions)) {
                $monthIndex = $row['month'] - 1; // Trừ 1 để chỉ số mảng bắt đầu từ 0
                $questionCounts[$monthIndex] = (int) $row['post_count'];
            }
        }

        if (mysqli_num_rows($documents) > 0) {
            while ($row = mysqli_fetch_assoc($documents)) {
                $monthIndex = $row['month'] - 1; // Trừ 1 để chỉ số mảng bắt đầu từ 0
                $documentCounts[$monthIndex] = (int) $row['post_count'];
            }
        }

        if (mysqli_num_rows($posts) > 0) {
            while ($row = mysqli_fetch_assoc($posts)) {
                $monthIndex = $row['month'] - 1; // Trừ 1 để chỉ số mảng bắt đầu từ 0
                $postCounts[$monthIndex] = (int) $row['post_count'];
            }
        }

        $data = [
            'labels' => $labels,
            'dataset1' => $questionCounts,
            'dataset2' => $documentCounts,
            'dataset3' => $postCounts,
        ];

        if (!empty($data['dataset1']) || !empty($data['dataset2']) || !empty($data['dataset3'])) {
            http_response_code(200);
            echo json_encode([
                'code' => 200,
                'status' => "success",
                'data' => $data,
                'message' => "Lấy dữ liệu thành công",
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'code' => 400,
                'status' => "error",
                'message' => "Không tìm thấy dữ liệu thống kê.",
            ]);
        }

    }
}

?>