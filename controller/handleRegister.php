<?php
session_start();
require '../config.php';
require '../classes/database.php';
require "../utils/routerConfig.php";
require "../classes/user.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $conn = require('../inc/db.php');
    if ($conn) {
        echo $username;
        echo $email;
        echo $name;
        $is_exist_user = User::getByName($conn, $username) != null ? true : false;
        if ($is_exist_user) {
            $_SESSION['register_message'] = "Người dùng đã tồn tại vui lòng đổi tên đăng nhập!";
            $data = array(
                "username" => $username,
                "email" => $email,
                "password" => $password,
                "confirmPassword" => $password,
            );
            $jsonData = json_encode($data);
            echo "<script>
            localStorage.setItem('data', '" . $jsonData . "');
          </script>";
            header("Location: " . baseURL("register"));
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $user = new User(1, $username, $name, $password, $email);
            try {
                User::add($conn, $user);
                $_SESSION['register_message'] = "Đăng kí thành công vui lòng đăng nhập!";
                header("Location: " . BASE_URL . "/login");
            } catch (\Throwable $e) {
                $_SESSION['register_message'] = "Đã xảy ra lỗi vui lòng thử lại!";
                header("Location: " . BASE_URL . "/register");
            }
        }
    }
}