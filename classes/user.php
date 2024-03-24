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
        $query = 'CALL themuser(:username, :password, :name, :email)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $user->username);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":email", $user->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User($user['id'], $user['username'], $user['name'], $user['password'], $user['email']);
        } else {
            return null;
        }
    }

    public static function update($conn, $user, $id)
    {
        $query = "CALL suauser(:id, :username, :name, :email)";
        $stmt = $conn->prepare($query);
        // Sử dụng PDO bind để tránh SQL injection
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);

        return $stmt->execute();
    }
    public static function updatePassword($conn, $user, $id)
    {
        $query = "CALL suamatkhauuser(:id, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':password', $user->password);
        return $stmt->execute();
    }



    public static function delete($conn, $id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public static function login($conn, $username, $password)
    {
        $query = 'CALL getuserbyusername(:username, :password)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User($user['id'], $user['username'], $user['name'], $user['password'], $user['email']);
        } else {
            return null;
        }
    }
    public static function register($conn, $user)
    {
        $query = 'CALL themuser(:username, :password, :name, :email)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $user->username);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":email", $user->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User($user['id'], $user['username'], $user['name'], $user['password'], $user['email']);
        } else {
            return null;
        }
    }

    public static function getAll($conn)
    {
        $query = "SELECT * FROM users";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $usersList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['id'], $row['username'], $row['name'], $row['password'], $row['email']);
            $usersList[] = $user;
        }
        return $usersList;
    }

    public static function getById($conn, $id)
    {
        $query = "CALL getUsersbyid(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User($user['id'], $user['username'], $user['name'], $user['password'], $user['email']);
        } else {
            return null;
        }
    }

    public static function getByName($conn, $username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User($user['id'], $user['username'], $user['name'], $user['password'], $user['email']);
        } else {
            return null;
        }
    }

    public static function isExist($conn, $username)
    {
        $query = 'SELECT kiemtratontaiuser(:username)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }
}
