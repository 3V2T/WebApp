<?php
class User
{
    public $id;
    public $username;
    public $name;
    public $password;
    public $email;

    public function __construct($id, $username, $name, $password, $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->email = $email;
    }


    public static function add($conn, $user)
    {
        // Thêm người dùng mới xuống database trả về boolean.
        // với trường password dùng thuật toán mã hóa bằng hàm password_hash và dùng thuật toán Bcrypt. Ví dụ password_hash('khacvi2003AZ', PASSWORD_BCRYPT).
    }

    public static function update($conn, $user, $id)
    {
        // Sử người dùng đã có xuống database bằng id trả về boolean.
    }

    public static function delete($conn, $id)
    {
        // Xóa người dùng database trả về boolean.
    }

    public static function authen($conn, $username, $password)
    {
        // Tìm người dùng dưới database bằng username và password và trả về boolean.
        // Dùng hàm password_verify để xác thực.
    }

    public static function getAll($conn)
    {
        // Lấy ra tất cả user có trong database và trả về 1 mảng chứa các Object User.
        // Ví dụ  
        // $usersList = [
        //     user1,
        //     user2, 
        //     ...
        // ];
    }

    public static function getById($conn, $id)
    {
        // Lấy ra user bằng id
        // Trả về 1 đối tượng user
    }
}
