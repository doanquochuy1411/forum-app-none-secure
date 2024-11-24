<?php
class User extends DB
{
    public function GetAllUser()
    {
        $sql = "SELECT * FROM user Where deleted_at is null";
        $result = $this->executeSelectQuery($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }
        return $data;
    }
    public function GetAllUserDescWithOrderBy($orderBy = "created_at", $sort = "DESC")
    {
        $sort = strtoupper($sort);  // Chuyển thành chữ hoa để đồng nhất
        if (!in_array($sort, ['ASC', 'DESC'])) {
            $sort = 'DESC';  // Mặc định là DESC nếu giá trị không hợp lệ
        }

        if (!in_array($orderBy, $this->validOrderByColumns)) {
            $orderBy = 'created_at';  // Mặc định là sắp xếp theo 'id' nếu $orderBy không hợp lệ
        }

        $sql = "SELECT u.*, uas.total_posts, uas.total_questions, uas.total_comments, uas.total_likes, uas.point FROM user u join user_activity_summary uas on uas.user_id = u.id WHERE u.deleted_at IS NULL order by $orderBy $sort";
        $result = $this->executeSelectQuery($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['account_name'] = encryptData($row['account_name']);
        }
        return $data;
    }
    public function GetUserByID($userID)
    {
        $userID = decryptData($userID);
        $sql = "SELECT * FROM user Where deleted_at is null and id = ?";
        $result = $this->executeSelectQuery($sql, [$userID]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }
        return $data;
    }

    public function GetUserByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE deleted_at IS NULL AND email = ?";
        $result = $this->executeSelectQuery($sql, [$email]);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

    public function GetUserByAccountName($account_name, $password = "")
    {
        $account_name = decryptData($account_name);
        if ($password != "") {
            $sql = "SELECT u.*, ur.role_id, uas.total_posts, uas.total_questions, uas.total_comments, uas.total_likes, uas.point, uas.total_document FROM user u Join user_role ur on ur.user_id = u.id join user_activity_summary uas on uas.user_id = u.id WHERE u.deleted_at IS NULL AND u.account_name = ? and password = ?";
            $result = $this->executeSelectQuery($sql, [$account_name, $password]);
        } else {
            $sql = "SELECT u.*, ur.role_id, uas.total_posts, uas.total_questions, uas.total_comments, uas.total_likes, uas.point, uas.total_document FROM user u Join user_role ur on ur.user_id = u.id join user_activity_summary uas on uas.user_id = u.id WHERE u.deleted_at IS NULL AND u.account_name = ?";
            $result = $this->executeSelectQuery($sql, [$account_name]);
        }
        $data = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($data)) {
            $data[0]["id"] = encryptData($data[0]["id"]);
            return $data[0];
        }

        return null;
    }
    public function UpdateLoginAttempts($account_name)
    {
        $sql = "UPDATE user SET login_attempts = login_attempts + 1 WHERE account_name = ?";
        return $this->executeQuery($sql, [$account_name]);
    }
    public function ResetLoginAttempts($account_name)
    {
        $sql = "UPDATE user SET login_attempts = 0 WHERE account_name = ?";
        return $this->executeQuery($sql, [$account_name]);
    }
    public function ResetLoginAttemptsWithEmail($email)
    {
        $sql = "UPDATE user SET login_attempts = 0 WHERE email = ?";
        return $this->executeQuery($sql, [$email]);
    }
    public function UpdateLocked($account_name)
    {
        $sql = "UPDATE user SET locked = 1 WHERE account_name = ?";
        return $this->executeQuery($sql, [$account_name]);
    }
    public function ResetLocked($account_name)
    {
        $sql = "UPDATE user SET locked = 0 WHERE account_name = ?";
        return $this->executeQuery($sql, [$account_name]);
    }
    public function ResetLockedWithEmail($email)
    {
        $sql = "UPDATE user SET locked = 0 WHERE email = ?";
        return $this->executeQuery($sql, [$email]);
    }
    public function UpdatePassword($email, $password)
    {
        $sql = "UPDATE user SET password = ? WHERE email = ?";
        return $this->executeQuery($sql, [$password, $email]);
    }

    public function CheckAccountName($account_name)
    {
        $sql = "SELECT id FROM user WHERE deleted_at IS NULL AND account_name = ?";
        $result = $this->executeSelectQuery($sql, [$account_name]);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

    public function CreateUser($account_name, $user_name, $email, $gender, $password, $secret)
    {
        if ($gender == "Nam") {
            $image = "image_671cacd73d296_1729932503.jpg"; // Male
        } else {
            $image = "image_671caccc4f269_1729932492.jpg"; // FeMale
        }
        $sql = "INSERT INTO user(account_name, user_name, email, password, image, gender, google_auth_secret) values (?,?,?,?,?,?,?)";
        return $this->executeQuery($sql, [$account_name, $user_name, $email, $password, $image, $gender, $secret]);
    }

    public function GetAllRole()
    {
        $sql = "SELECT * FROM role";
        return $this->executeQuery($sql);
    }

    public function SetRole($userID, $roleID)
    {
        $sql = "INSERT INTO user_role(user_id, role_id) values (?,?)";
        return $this->executeQuery($sql, [$userID, $roleID]);
    }

    public function UpdateUser($id, $user_name, $email, $phone_number, $file_name, $gender)
    {
        $sql = "";
        $result = false;
        $id = decryptData($id);
        if ($file_name != "") {
            $sql = "UPDATE user set user_name = ?, email=?, phone_number=?, image=?, gender=? where id = ?";
            $result = $this->executeQuery($sql, [$user_name, $email, $phone_number, $file_name, $gender, $id]);
        } else {
            $sql = "UPDATE user set user_name = ?, email=?, phone_number=?, gender=? where id = ?";
            $result = $this->executeQuery($sql, [$user_name, $email, $phone_number, $gender, $id]);
        }

        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }
    public function ChangePassword($id, $password)
    {
        $id = decryptData($id);
        $sql = "UPDATE user set password=? where id = ?";
        $result = $this->executeQuery($sql, [$password, $id]);

        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    public function GetAllAdmin()
    {
        $sql = "SELECT * FROM user u join user_role ur on ur.user_id = u.id Where u.deleted_at is null and ur.role_id = 1";
        $result = $this->executeSelectQuery($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['user_id'] = encryptData($row['user_id']);
            $row['role_id'] = encryptData($row['role_id']);
        }
        return $data;
    }

    public function DeleteUser($user_id)
    {
        $id = decryptData($user_id);

        $re_sql = "select count(id) as total_posts from posts where user_id = $id";

        $result = $this->con->query($re_sql);
        if ($result) {
            $row = $result->fetch_assoc();
            $total_posts = $row['total_posts'];
            if ($total_posts > 0) {
                return $total_posts; // danh mục có chứa bài viết    
            }
        }

        $sql = "UPDATE user set deleted_at = NOW() where id = ?";
        $result = $this->executeQuery($sql, [$id]);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function GetUserAmountPerMonthByYear($year)
    {
        $sql = "SELECT 
            MONTH(created_at) AS month, 
            COUNT(*) AS user_count
        FROM 
            user
        WHERE 
            YEAR(created_at) = ?
        GROUP BY 
            MONTH(created_at)
        ORDER BY 
            month ASC;
        ";
        return $this->executeSelectQuery($sql, [$year]);
    }
}
?>