<?php
class Post extends DB
{
    public function GetAllPostWithType($type)
    {
        $sql = "SELECT p.* , u.account_name, u.user_name, u.image as avatar, pcc.comment_count, pcc.report_count, pcc.like_count FROM posts p left join user u on u.id = p.user_id left join post_comment_counts pcc on pcc.post_id = p.id Where p.deleted_at is null and p.type = ? order by p.created_at DESC";
        $result = $this->executeSelectQuery($sql, [$type]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['account_name'] = encryptData($row['account_name']);
        }

        return $data;
    }

    // Lấy tất cả bài viết || câu hỏi
    public function GetAllPostWithCategoryAndType($category_id, $type)
    {
        $category_id = decryptData($category_id);
        $sql = "SELECT p.* , u.account_name, u.user_name, u.image as avatar, pcc.comment_count, pcc.like_count FROM posts p left join user u on u.id = p.user_id left join post_comment_counts pcc on pcc.post_id = p.id Where p.deleted_at is null and p.category_id = ? and p.type = ? order by p.created_at DESC";
        $result = $this->executeSelectQuery($sql, [$category_id, $type]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['account_name'] = encryptData($row['account_name']);
        }

        return $data;
    }

    public function GetPostBySearch($txt, $type)
    {
        // Tách từ khóa tìm kiếm thành các từ riêng lẻ
        $keywords = explode(' ', $txt);
        $placeholders = [];
        $searchTerms = [];
        $keywordMatches = [];

        // Tạo các placeholder và các từ tìm kiếm cho từng từ khóa
        foreach ($keywords as $keyword) {
            if (!empty($keyword)) {
                $placeholders[] = "(t.name LIKE ? OR p.content LIKE ? OR p.title LIKE ?)";
                $searchTerms[] = '%' . $keyword . '%';
                $searchTerms[] = '%' . $keyword . '%';
                $searchTerms[] = '%' . $keyword . '%';

                // Đếm số lần match với mỗi từ khóa
                $keywordMatches[] = "(CASE WHEN t.name LIKE ? THEN 1 ELSE 0 END 
                                 + CASE WHEN p.content LIKE ? THEN 1 ELSE 0 END 
                                 + CASE WHEN p.title LIKE ? THEN 1 ELSE 0 END)";
                $searchTerms[] = '%' . $keyword . '%';
                $searchTerms[] = '%' . $keyword . '%';
                $searchTerms[] = '%' . $keyword . '%';
            }
        }

        // Kết hợp các placeholder với toán tử OR
        $placeholders = implode(' OR ', $placeholders);

        // Tính tổng số lần match từ khóa cho mỗi bài viết
        $keywordMatchScore = implode(' + ', $keywordMatches);

        $sql = "SELECT DISTINCT p.*, u.user_name, u.image as avatar, pcc.comment_count,
                   ($keywordMatchScore) AS match_score, pcc.like_count
            FROM posts p 
            JOIN user u ON u.id = p.user_id 
            JOIN post_comment_counts pcc ON pcc.post_id = p.id 
            LEFT JOIN post_tags pt ON pt.post_id = p.id 
            LEFT JOIN tags t ON t.id = pt.tag_id
            WHERE p.deleted_at IS NULL
            AND ($placeholders) AND p.type = ?
            ORDER BY match_score DESC, p.created_at DESC;";

        $params = array_merge($searchTerms, [$type]);

        $result = $this->executeSelectQuery($sql, $params);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;
    }

    // Lấy tất cả bài viết || câu hỏi với tags
    public function GetPostByTag($txt)
    {
        $sql = "SELECT DISTINCT p.*, u.user_name, u.image as avatar, pcc.comment_count, u.account_name, pcc.like_count
                FROM posts p 
                JOIN user u ON u.id = p.user_id 
                JOIN post_comment_counts pcc ON pcc.post_id = p.id 
                LEFT JOIN post_tags pt ON pt.post_id = p.id 
                LEFT JOIN tags t ON t.id = pt.tag_id
                WHERE p.deleted_at IS NULL AND LOWER(t.name) LIKE LOWER(?) 
                ORDER BY p.created_at DESC;";
        // Sử dụng ký tự đại diện `%` để tìm kiếm các chuỗi chứa từ khóa
        $searchTerm = '%' . $txt . '%';
        $result = $this->executeSelectQuery($sql, [$searchTerm]);
        // $result = $this->executeSelectQuery($sql, [$type, $limit]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;
    }
    // Lấy tất cả bài viết và câu hỏi của danh mục
    public function GetAllPostWithCategory($category_id)
    {
        $category_id = decryptData($category_id);
        $sql = "SELECT p.* , u.user_name, u.image as avatar, pcc.comment_count, u.account_name, pcc.like_count FROM posts p left join user u on u.id = p.user_id left join post_comment_counts pcc on pcc.post_id = p.id Where p.deleted_at is null and p.category_id = ? order by p.created_at DESC";
        $result = $this->executeSelectQuery($sql, [$category_id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;
    }
    public function GetAllPostWithTypeAndUserID($type, $userID)
    {
        if ($userID != "") {
            $userID = decryptData($userID);
        }
        $sql = "SELECT p.* , u.user_name, u.image as avatar, pcc.comment_count, u.account_name, pcc.like_count FROM posts p left join user u on u.id = p.user_id left join post_comment_counts pcc on pcc.post_id = p.id Where p.deleted_at is null and p.type = ? and p.user_id = ? order by p.created_at DESC";
        $result = $this->executeSelectQuery($sql, [$type, $userID]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;
    }
    public function GetPostWithTypeAndLimit($type, $limit = 0)
    {
        if ($limit != 0) {
            $sql = "SELECT p.* , u.user_name, u.image as avatar, pcc.comment_count, u.account_name, pcc.like_count FROM posts p left join user u on u.id = p.user_id left join post_comment_counts pcc on pcc.post_id = p.id Where p.deleted_at is null and p.type = ? order by p.created_at DESC limit ?";
            $result = $this->executeSelectQuery($sql, [$type, $limit]);
        } else {
            $sql = "SELECT p.* , u.user_name, u.image as avatar, pcc.comment_count, u.account_name, pcc.like_count FROM posts p left join user u on u.id = p.user_id left join post_comment_counts pcc on pcc.post_id = p.id Where p.deleted_at is null and p.type = ? order by p.created_at DESC";
            $result = $this->executeSelectQuery($sql, [$type]);
        }
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['account_name'] = encryptData($row['account_name']);
        }

        return $data;
    }

    public function GetPostByID($id)
    {
        $id = decryptData($id);
        $sql = "SELECT p.* , u.user_name, u.image as avatar, pcc.comment_count, u.account_name, u.id as user_id, pcc.like_count FROM posts p left join user u on u.id = p.user_id left join post_comment_counts pcc on pcc.post_id = p.id Where p.deleted_at is null and p.id = ?";
        $result = $this->executeSelectQuery($sql, [$id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['user_id'] = encryptData($row['user_id']);
        }

        return $data;
    }

    public function CreatePost($title, $content, $user_id, $category_id, $type)
    {
        $user_id = decryptData($user_id);
        $category_id = decryptData($category_id);
        $sql = "INSERT INTO posts(title, content, user_id, category_id, type) values (?,?,?,?,?)";
        $result = $this->executeQuery($sql, [$title, $content, $user_id, $category_id, $type]);

        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }

    public function IncrementView($number, $id)
    {
        $id = decryptData($id);
        $sql = "UPDATE posts set views = views + ? where id = ?";
        return $this->executeQuery($sql, [$number, $id]);
    }

    public function GetRelatePosts($post_id, $limit)
    {
        $post_id = decryptData($post_id);
        $sql = "SELECT DISTINCT p2.* FROM posts p1 
            JOIN post_tags pt1 ON p1.id = pt1.post_id 
            JOIN post_tags pt2 ON pt1.tag_id = pt2.tag_id 
            JOIN posts p2 ON pt2.post_id = p2.id WHERE p1.id = ? and p2.deleted_at is null
            AND p2.id != ? order by p2.views DESC LIMIT ?";
        $result = $this->executeSelectQuery($sql, [$post_id, $post_id, $limit]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;
    }

    public function UpdatePost($id, $title, $content, $category_id, $type)
    {
        $id = decryptData($id);
        $category_id = decryptData($category_id);
        $sql = "UPDATE posts set title = ?, content=?, category_id=?, type= ? where id = ?";
        $result = $this->executeQuery($sql, [$title, $content, $category_id, $type, $id]);

        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    // Soft delete
    public function DeletePost($id)
    {
        $id = decryptData($id);
        $this->beginTransaction();

        try {
            $sql = "UPDATE posts set deleted_at = NOW() Where id = ?";
            $this->executeQuery($sql, [$id]);

            $sql2 = "DELETE FROM notifications WHERE post_id = ?";
            $this->executeQuery($sql2, [$id]);

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    public function GetAuthOfPost($post_id)
    {
        $id = decryptData($post_id);
        $sql = "select user_id from posts where id = ?";
        $result = $this->executeSelectQuery($sql, [$id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function GetPostAmountPerMonthByYear($year, $type = "post")
    {
        $sql = "SELECT 
            MONTH(created_at) AS month, 
            COUNT(*) AS post_count
        FROM 
            posts
        WHERE 
            YEAR(created_at) = ? and type = ?
        GROUP BY 
            MONTH(created_at)
        ORDER BY 
            month ASC;
        ";
        return $this->executeSelectQuery($sql, [$year, $type]);
    }



    public function CheckLikedPostByUser($user_id, $post_id)
    {
        $user_id = decryptData($user_id);
        $post_id = decryptData($post_id);
        $sql = "SELECT id FROM likes WHERE post_id = ? AND user_id = ?";
        $result = $this->executeSelectQuery($sql, [$post_id, $user_id]);
        if ($result->num_rows > 0) {
            return true; // liked
        }
        return false;
    }

    public function CancelLikedPostByUser($user_id, $post_id)
    {
        $user_id = decryptData($user_id);
        $post_id = decryptData($post_id);
        $sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        return $this->executeQuery($sql, [$post_id, $user_id]);
    }

    public function CreateLikedPostByUser($user_id, $post_id)
    {
        $user_id = decryptData($user_id);
        $post_id = decryptData($post_id);
        $sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        return $this->executeQuery($sql, [$post_id, $user_id]);
    }

    public function CountLikedOfPost($post_id)
    {
        $post_id = decryptData($post_id);
        $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?";
        $result = $this->executeSelectQuery($sql, [$post_id]);
        return $result->fetch_assoc()['like_count'];
    }

    public function GetTopPostsByViews($limit)
    {
        $sql = "SELECT title, views FROM posts Where posts.type = 'post' ORDER BY views DESC LIMIT ?";
        $result = $this->executeSelectQuery($sql, [$limit]);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function GetTopPostsByLikes($limit)
    {
        $sql = "SELECT 
            posts.title,
            COUNT(likes.id) as likes
        FROM 
            posts
        LEFT JOIN likes on likes.post_id = posts.id
        Where posts.type = 'post'
        GROUP BY 
            posts.id, posts.title
        ORDER BY 
            likes DESC
        LIMIT ?
        ";
        $result = $this->executeSelectQuery($sql, [$limit]);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function CheckAuthPostByUser($user_id, $post_id)
    {
        $user_id = decryptData($user_id);
        $post_id = decryptData($post_id);
        $sql = "SELECT 1 FROM posts WHERE id = ? AND user_id = ?";
        $result = $this->executeSelectQuery($sql, [$post_id, $user_id]);
        if ($result->num_rows > 0) {
            return true; // is auth
        }
        return false;
    }

    public function generate_fake_likes()
    {
        // Hàm để tạo số lượng like ngẫu nhiên từ 20 đến 50
        function generate_likes($post_id)
        {
            $likes = rand(10, 30);
            $user_ids = array_rand(range(23, 77), $likes); // Giả sử có 100 user_id từ 1 đến 100
            $likes_data = [];
            foreach ($user_ids as $user_id) {
                $likes_data[] = [$user_id, $post_id];
            }
            return $likes_data;
        }

        // Tạo dữ liệu cho các bài viết từ 167 đến 238
        $post_ids = range(220, 238);
        $all_likes = [];

        foreach ($post_ids as $post_id) {
            $all_likes = array_merge($all_likes, generate_likes($post_id));
        }

        // Thực hiện các câu lệnh SQL
        foreach ($all_likes as $like) {
            $sql = "INSERT INTO likes(user_id, post_id) VALUES (?, ?)";
            $this->executeQuery($sql, $like);
        }
    }

}