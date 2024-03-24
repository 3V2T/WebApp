<?php
session_start();
require '../config.php';
require '../classes/database.php';
require '../classes/auth.php';
require "../utils/routerConfig.php";
require "../classes/user.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $conn = require('../inc/db.php');
    if ($conn) {
        $user = User::login($conn, $username, $password);
        if ($user) {
            $_SESSION['is_login'] = true;
            $_SESSION['name_user'] = $user->username;
            $_SESSION['id_user'] = $user->id;
            $_SESSION['success_message'] = "Đăng nhập thành công";
            header("Location: " . BASE_URL . '/home');
        } else {
            $_SESSION['error_message'] = "Tên đăng nhập hoặc mật khẩu không đúng";
            header("Location: " . BASE_URL . '/login');
        }
    }
}
