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
        $rs = Auth::login($conn, $username, $password);
        if ($rs) {
            $_SESSION['success_message'] = "Đăng nhập thành công";
            header("Location: " . baseURL("home"));
        } else {
            $_SESSION['error_message'] = "Tên đăng nhập hoặc mật khẩu không đúng";
            header("Location: " . baseURL("login"));
        }
    }
}
