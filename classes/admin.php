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
        $query = "CALL getadminbyusername (:username,:password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin) {
            return new Admin($admin['id'], $admin['username'], $admin['password']);
        } else {
            return null;
        }
    }

    public static function changePassword($conn, $admin)
    {
        $query = "call doimatkhauadmin(:username, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':password', $admin->password);
        $stmt->bindParam(':username', $admin->username);
        return $stmt->execute();
    }
}
