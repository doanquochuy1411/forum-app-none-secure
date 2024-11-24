<?php
class Comment extends DB
{
    public function GetAllComment()
    {
        $sql = "SELECT p.views, c.*, u.user_name AS comment_user_name, u.image AS comment_user_image, p.title AS post_title, p.user_id AS post_owner_id, owner_user.user_name AS owner_name, owner_user.image AS owner_image, pcc.comment_count 
        FROM comments c
        LEFT JOIN
            user u ON u.id = c.user_id
        LEFT JOIN
            posts p ON p.id = c.post_id
        LEFT JOIN
            user owner_user ON owner_user.id = p.user_id -- Để lấy thông tin của người sở hữu bài viết
        LEFT JOIN post_comment_counts pcc on pcc.post_id = c.post_id
        ORDER BY
            p.created_at DESC;
        ";
        $result = $this->executeSelectQuery($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            // $row['id'] = encryptData($row['id']);
            $row['post_owner_id'] = encryptData($row['post_owner_id']);
        }

        return $data;
    }

    public function GetAllCommentOfPost($post_id)
    {
        $post_id = decryptData($post_id);
        $sql = "SELECT p.views, c.*, u.user_name AS comment_user_name, u.image AS avatar, p.title AS post_title, p.user_id AS post_owner_id, owner_user.user_name AS owner_name, owner_user.image AS owner_image, pcc.comment_count 
        FROM comments c
        LEFT JOIN
            user u ON u.id = c.user_id
        LEFT JOIN
            posts p ON p.id = c.post_id
        LEFT JOIN
            user owner_user ON owner_user.id = p.user_id -- Để lấy thông tin của người sở hữu bài viết
        LEFT JOIN post_comment_counts pcc on pcc.post_id = c.post_id
        where c.post_id = ?
        ";
        $result = $this->executeSelectQuery($sql, [$post_id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['user_id'] = encryptData($row['user_id']);
        }

        return $data;
    }

    public function CreateComment($content, $user_id, $post_id, $parent_comment_id)
    {
        $user_id = decryptData($user_id);
        $post_id = decryptData($post_id);
        $parent_comment_id = empty($parent_comment_id) ? null : $parent_comment_id;
        $sql = "";
        $result = false;
        if ($parent_comment_id == "") {
            $sql = "INSERT INTO comments(content, user_id, post_id) values (?,?,?)";
            $result = $this->executeQuery($sql, [$content, $user_id, $post_id]);
        } else {
            $sql = "INSERT INTO comments(content, user_id, post_id, parent_comment_id) values (?,?,?,?)";
            $result = $this->executeQuery($sql, [$content, $user_id, $post_id, $parent_comment_id]);
        }

        if ($result) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }

    public function DeleteComment($id)
    {
        $id = decryptData($id);
        $this->beginTransaction();

        try {
            $sql = "DELETE FROM comments WHERE id = ?";
            $this->executeQuery($sql, [$id]);

            $sql2 = "DELETE FROM notifications WHERE comment_id = ?";
            $this->executeQuery($sql2, [$id]);

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    public function GetCommentByID($id)
    {
        $id = decryptData($id);
        $sql = "SELECT * FROM comments WHERE id = ?";
        $result = $this->executeSelectQuery($sql, [$id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;
    }

    public function GetAuthOfComment($cmt_id)
    {
        $cmt_id = decryptData($cmt_id);
        $sql = "SELECT u.user_name AS comment_user_name, u.image AS avatar
        FROM comments c
        LEFT JOIN
            user u ON u.id = c.user_id
        where c.id = ?";
        $result = $this->executeSelectQuery($sql, [$cmt_id]);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $data;
    }
}