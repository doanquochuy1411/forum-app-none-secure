<?php
class Follow extends DB
{
    public function CheckFollowByUser($auth_id, $user_id)
    {
        $user_id = decryptData($user_id);
        $auth_id = decryptData($auth_id);
        $sql = "SELECT id FROM followers WHERE follower_user_id = ? AND followed_user_id = ?";
        $result = $this->executeSelectQuery($sql, [$user_id, $auth_id]);
        if ($result->num_rows > 0) {
            return true; // followed
        }
        return false;
    }

    public function CreateFollowPostByUser($auth_id, $user_id)
    {
        $user_id = decryptData($user_id);
        $auth_id = decryptData($auth_id);
        $sql = "INSERT INTO followers (follower_user_id, followed_user_id ) values (?,?)";
        return $this->executeQuery($sql, [$user_id, $auth_id]);
    }

    public function CancelLikedPostByUser($auth_id, $user_id)
    {
        $user_id = decryptData($user_id);
        $auth_id = decryptData($auth_id);
        $sql = "DELETE FROM followers WHERE follower_user_id = ? AND followed_user_id = ?";
        return $this->executeQuery($sql, [$user_id, $auth_id]);
    }

    public function GetAllFollower($authID)
    {
        $authID = decryptData($authID);
        $sql = "SELECT * FROM followers WHERE followed_user_id = ?";
        $result = $this->executeSelectQuery($sql, [$authID]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['follower_user_id'] = encryptData($row['follower_user_id']);
            $row['followed_user_id'] = encryptData($row['followed_user_id']);
        }
        return $data;
    }
}

// Đếm số lượng người dùng mà user đó đang theo dõi
// SELECT 
//     COUNT(*) AS `following_count`
// FROM 
//     `followers`
// WHERE 
//     `follower_user_id` = 1;


// Đếm số lượng người theo dõi một user
// SELECT 
//     COUNT(*) AS `follower_count`
// FROM 
//     `followers`
// WHERE 
//     `followed_user_id` = 1;