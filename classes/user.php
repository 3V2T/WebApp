<?php
class User
{
    public $id;
    public $username;
    public $password;
    /*
                phương thức khởi tạo constructor
            */
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }


    public static function login($conn, $username, $password)
    {
        try {
            $stmt = $conn->prepare("SELECT * FROM user Where username =:username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Lấy ra user
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["username"];
                return true;
            } else {
                // Đăng thất bại
                return false;
            }
        } catch (PDOException $e) {
            // Đăng nhập lỗi
            echo "Error: " . $e->getMessage();
            return false;
        }
        // Default trả về false
        return false;
    }

    public static function addUser($conn, $user)
    {
        if ($user) {
            try { // Câu truy vấn INSERT INTO
                $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";

                // Chuẩn bị câu truy vấn
                $stmt = $conn->prepare($sql);

                // Bind các giá trị vào câu truy vấn
                $stmt->bindParam(':username', $user->username);
                $hashPassword = password_hash($user->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $hashPassword);
                // Thực thi câu truy vấn
                $stmt->execute();
                echo "Thêm người dùng mới thành công";
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    public function addInformation($conn, $user)
    {
    }
}
