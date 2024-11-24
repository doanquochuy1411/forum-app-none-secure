<?php
class Notification extends DB
{
    public function GetUnreadNotificationsByUserId($receiver_id)
    {
        $receiver_id = decryptData($receiver_id);
        $sql = "select * from notifications where is_read = 0 and receiver_id = ? order by created_at desc";
        $result = $this->executeSelectQuery($sql, [$receiver_id]);
        // $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['receiver_id'] = encryptData($row['receiver_id']);
            $row['comment_id'] = $row['comment_id'] != null ? encryptData($row['comment_id']) : $row['comment_id'];
            $row['post_id'] = encryptData($row['post_id']);
            $row['report_id'] = $row['report_id'] != null ? encryptData($row['report_id']) : $row['report_id'];
        }

        // return $data;
        return $data;
    }

    public function CreateNotification($post_id, $message, $report_id = null, $comment_id = null)
    {
        $post_id = decryptData($post_id);

        $sql = "INSERT INTO notifications (receiver_id, message, comment_id, post_id, report_id)
                VALUES (
                    (SELECT user_id FROM posts WHERE id = ?), ?, ?, ?, ?
                )";
        $result = $this->executeQuery($sql, [$post_id, $message, $comment_id, $post_id, $report_id]);

        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }

    public function CreateNotificationForFollowers($post_id, $message, $follower_id)
    {
        $follower_id = decryptData($follower_id);
        $sql = "INSERT INTO notifications (receiver_id, message, post_id)
                VALUES (
                    ?, ?, ? 
                )";
        $result = $this->executeQuery($sql, [$follower_id, $message, $post_id]);

        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }

    public function CreateReportNotificationToAdmin($message, $report_id, $post_id)
    {
        $post_id = decryptData($post_id);
        // Sử dụng subquery để lấy receiver_id (tác giả của bài viết)
        $sql = "INSERT INTO notifications (receiver_id, message, post_id, report_id)
            SELECT user_id, ?, ?, ?
            FROM user u
            join user_role ur on ur.user_id = u.id 
            Where u.deleted_at is null and ur.role_id = 1";
        $result = $this->executeQuery($sql, [$message, $post_id, $report_id]);

        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }

    public function GetNotificationByID($id)
    {
        $id = decryptData($id);
        $sql = "select n.*, p.title as post_title from notifications n left join posts p on p.id = n.post_id where n.id = ?";
        $result = $this->executeSelectQuery($sql, [$id]);
        // $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $_SESSION["IndexComment"] = $row['comment_id'];
            $row['id'] = encryptData($row['id']);
            $row['receiver_id'] = encryptData($row['receiver_id']);
            $row['comment_id'] = encryptData($row['comment_id']);
            $row['post_id'] = encryptData($row['post_id']);
            $row['report_id'] = encryptData($row['report_id']);
        }

        return $data;
    }

    public function UpdateIsRead($notification_id)
    {
        $notification_id = decryptData($notification_id);
        $sql = "update notifications set is_read = ? where id = ?";
        $result = $this->executeQuery($sql, ["1", $notification_id]);
        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }
}