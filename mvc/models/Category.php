<?php
class Category extends DB
{
    public function GetAllCategory()
    {
        $sql = "SELECT * FROM categories order by id DESC";
        $result = $this->executeSelectQuery($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;

    }

    public function GetCategoryByID($category_id)
    {
        $category_id = decryptData($category_id);
        $sql = "SELECT * FROM categories WHERE id = ?";
        $result = $this->executeSelectQuery($sql, [$category_id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
        }

        return $data;
    }
    public function CheckNameCategory($category_name)
    {
        $sql = "SELECT id FROM categories WHERE name = ?";
        $result = $this->executeSelectQuery($sql, [$category_name]);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

    public function CreateCategory($category_name, $category_description, $category_type)
    {
        $sql = "Insert into categories(name, description, category_type) values (?,?, ?)";
        $result = $this->executeQuery($sql, [$category_name, $category_description, $category_type]);
        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }

    public function UpdateCategory($category_id, $category_name, $category_description = "")
    {
        $id = decryptData($category_id);
        $sql = "update categories set name = ?, description= ? where id = ?";
        $result = $this->executeQuery($sql, [$category_name, $category_description, $id]);
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function DeleteCategoryByID($category_id)
    {
        $category_id = decryptData($category_id);
        $re_sql = "select count(id) as total_posts from posts where category_id = $category_id";

        $result = $this->con->query($re_sql);
        if ($result) {
            $row = $result->fetch_assoc();
            $total_posts = $row['total_posts'];
            if ($total_posts > 0) {
                return $total_posts; // danh mục có chứa bài viết    
            }
        }
        $sql = "DELETE FROM categories WHERE id = ?";
        $r = $this->executeQuery($sql, [$category_id]);
        if ($r) {
            return true;
        } else {
            return false;
        }
    }
}