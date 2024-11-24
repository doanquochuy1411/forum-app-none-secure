<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

class DB
{
    public $con;
    protected $servername;
    protected $username;
    protected $password;
    protected $dbname;
    protected $validOrderByColumns = ['id', 'user_name', 'created_at', 'updated_at', 'uas.point'];

    function __construct()
    {
        $this->servername = $_ENV['DB_SERVERNAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dbname = $_ENV['DB_NAME'];
        $_SESSION['Key'] = $_ENV["KEY"]; // Lấy key
        $_SESSION['SECRET_KEY'] = $_ENV["SECRET_KEY"]; // Lấy secret key -> BE
        $_SESSION['PUBLIC_KEY'] = $_ENV["PUBLIC_KEY"]; // Lấy public key => FE
        $_SESSION['SCAN_KEY'] = $_ENV["SCAN_KEY"]; // Lấy scan key => scan image

        $this->con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->con->connect_error) {
            die("fail to connect database: " . $this->con->connect_error);
        }

        $this->con->set_charset('utf8');
    }
    public function beginTransaction()
    {
        $this->con->begin_transaction();
    }

    // Cam kết transaction
    public function commit()
    {
        $this->con->commit();
    }

    // Rollback transaction
    public function rollback()
    {
        $this->con->rollback();
    }

    public function executeQuery($sql, $params = [])
    {
        // Xử lý từng tham số để thay thế `NULL` đúng cách
        if (!empty($params)) {
            foreach ($params as &$param) {
                if (is_null($param)) {
                    $param = 'NULL'; // Chuyển `NULL` PHP thành `NULL` trong SQL
                } else {
                    $param = "'$param'"; // Bao quanh các tham số khác bằng dấu nháy đơn
                }
            }
            unset($param); // Giải phóng tham chiếu

            // Thay thế các placeholder (?) bằng các tham số đã xử lý
            $sql = vsprintf(str_replace('?', '%s', $sql), $params);
        }

        // Thực thi câu truy vấn
        $result = $this->con->query($sql);
        if ($result === false) {
            throw new Exception("Query failed: " . $this->con->error);
        }

        // Trả về kết quả: true nếu có dòng bị ảnh hưởng
        return $this->con->affected_rows > 0;
    }




    // SELECT QUERY
    public function executeSelectQuery($sql, $params = [])
    {
        // Thay thế các placeholder (?) trong câu lệnh SQL bằng các tham số trực tiếp
        if (!empty($params)) {
            // Chuyển từng tham số thành chuỗi và chèn trực tiếp
            $sql = vsprintf(str_replace('?', "'%s'", $sql), $params);
        }

        // Thực thi câu truy vấn
        // echo $sql;
        // echo "<br>";
        $result = $this->con->query($sql);
        if ($result === false) {
            throw new Exception("Query failed: " . $this->con->error);
        }

        // Trả về đối tượng mysqli_result
        return $result;
    }

}

?>