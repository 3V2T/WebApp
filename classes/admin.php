<?php
class Admin
{
    public $id;
    public $username;
    public $password;

    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function login($conn, $admin)
    {
        $username = $admin->username;
        $password = $admin->password;
        $query = "select * from admin where admin.username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin && password_verify($password, $admin['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function logout($conn, $admin)
    {
    }

    public static function changePassword($conn, $admin)
    {
        $query = "CALL doimatkhauadmin(:username, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':password', $admin->password);
        $stmt->bindParam(':username', $admin->username);
        return $stmt->execute();
    }
}