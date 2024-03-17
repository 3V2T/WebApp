<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/user.php";
include "../classes/author.php";
include "../classes/wishlist.php";
include "../classes/admin.php";
include_once("../js/bootstrapConfig.php");
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
$password = $_POST["newPassword"];
$newPassword = $_POST["password"];

if (isset($_POST["newPassword"]) && isset($_POST["password"])) {
    $password = $_POST["password"];
    $newPassword = $_POST["newPassword"];
    try {
        $admin = new Admin(1, "admin", $password);
        $is_admin = Admin::login($connection, $admin);
        if ($is_admin) {
            $password = password_hash($newPassword, PASSWORD_BCRYPT);
            $is_admin = Admin::login($connection, $admin);
            $admin = new Admin(1, "admin", $password);
            $is_success = Admin::changePassword($connection, $admin);
            if ($is_success) {
                echo "<script>
                alert('Mật khẩu admin đã được thay đổi thành công!');
                location.href = '".BASE_URL."/login-admin';
            </script>";
            } else {
                echo "<script>
                alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '".BASE_URL."/pages/admin.php';
            </script>";
            }
        } else {
            echo "<script>
                alert('Mật khẩu admin chưa đúng, vui lòng thử lại!');
                location.href = '".BASE_URL."/pages/admin.php';
            </script>";
        }
    } catch (\Throwable $e) {
        echo "<script>
                alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '".BASE_URL."/pages/admin.php';
            </script>";
    }
}