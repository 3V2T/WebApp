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
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $admin = new Admin(1, $username, $password);
        $isAdmin = Admin::login($connection, $admin);
        if ($isAdmin) {
            $_SESSION['is_admin'] = true;
            $_SESSION['is_login'] = true;
            echo '<script>
            alert ("Đăng nhập thành công, chào mừng admin!");
            location.href = "' . BASE_URL . '/home";
        </script>';
        } else {
            echo '<script>
                    alert ("Tên đăng nhập hoặc mật khẩu không đúng!");
                    location.href = "' . BASE_URL . '/login-admin";
                </script>';
        }
    } catch (\Throwable $e) {
        echo '<script>
            alert ("Đã xảy ra lỗi vui lòng thử lại!");
            location.href = "' . BASE_URL . '/login-admin";
        </script>';
    }
}
