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
        $query = "INSERT INTO users (username, password, name, email) VALUES (:username, :password, :name, :email)";
        $stmt = $conn->prepare($query);

        // Sử dụng PDO bind để tránh SQL injection
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':password', $user->password);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->execute();
    }

    public static function update($conn, $user, $id)
    {
        $query = "UPDATE users SET username = :username, name = :name, email = :email WHERE id = :id";
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
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $conn->prepare($query);
        // Sử dụng PDO bind để tránh SQL injection
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

    public static function authen($conn, $username, $password)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
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
        $query = "SELECT * FROM users WHERE id = :id";
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
}