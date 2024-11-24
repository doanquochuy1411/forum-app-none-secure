<?php
class Tag extends DB
{
    public function GetTagByName($name)
    {
        $sql = "SELECT * FROM tags Where name = ?";
        $result = $this->executeSelectQuery($sql, [$name]);
        if ($result && $result->num_rows > 0) {
            // Lấy kết quả
            $row = $result->fetch_assoc();
            return $row['id']; // Trả về ID của tag
        } else {
            return false; // Tag không tồn tại
        }
    }
    public function GetTagsOfPost($post_id)
    {
        $post_id = decryptData($post_id);
        $sql = "SELECT distinct * FROM tags t JOIN post_tags pt ON t.id = pt.tag_id Where pt.post_id = ?";
        $result = $this->executeSelectQuery($sql, [$post_id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['tag_id'] = encryptData($row['tag_id']);
            $row['post_id'] = encryptData($row['post_id']);
        }
        return $data;
    }
    public function GetPopularTags()
    {
        $sql = "SELECT distinct t.id, t.name FROM tags t JOIN post_tags pt ON t.id = pt.tag_id JOIN posts p ON pt.post_id = p.id ORDER BY p.views DESC;";
        $result = $this->executeSelectQuery($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }
        return $data;
    }
    public function CreateTag($name)
    {
        $sql = "INSERT INTO tags(name) values (?)";
        $result = $this->executeQuery($sql, [$name]);

        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }
    public function DeleteTag($name)
    {
        $sql = "DELETE FROM tags WHERE name =?";
        return $this->executeQuery($sql, [$name]);
    }
    public function AddTag($post_id, $tag_id)
    {
        $post_id = decryptData($post_id);
        $sql = "INSERT INTO post_tags (post_id, tag_id) values (?,?)";
        return $this->executeQuery($sql, [$post_id, $tag_id]);
        if ($this->con->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function DeleteTagOfPost($post_id)
    {
        $post_id = decryptData($post_id);
        $sql = "DELETE FROM post_tags WHERE post_id =?";
        $result = $this->executeQuery($sql, [$post_id]);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}