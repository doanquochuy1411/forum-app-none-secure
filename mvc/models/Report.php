<?php
class Report extends DB
{
    public function CreateReport($post_id, $reason, $reported_by)
    {
        $post_id = decryptData($post_id);
        $reported_by = decryptData($reported_by);
        $sql = "INSERT INTO reports(post_id, reason, reported_by) values (?,?,?)";
        $result = $this->executeQuery($sql, [$post_id, $reason, $reported_by]);

        if ($result > 0) {
            return $this->con->insert_id;
        } else {
            return 0;
        }
    }

    public function GetReportByID($report_id)
    {
        $report_id = decryptData($report_id);
        $sql = "SELECT r.*, u.user_name, u.image as avatar FROM reports r left join user u on r.reported_by = u.id where r.id = ?";
        $result = $this->executeSelectQuery($sql, [$report_id]);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($data as &$row) {
            $row['id'] = encryptData($row['id']);
            $row['reported_by'] = encryptData($row['reported_by']);
        }

        return $data;
    }
}