<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/user.php";
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
$id = $_SESSION["id_user"];
$username = $_SESSION['name_user'];
$newPassword = $_POST['newPassword'];
$password = $_POST['password'];
$is_valid = User::authen($connection, $username, $password);
if ($is_valid) {
    try {
        $password = password_hash($newPassword, PASSWORD_BCRYPT);
        $updateUser = new User(1, "", "", $password, "");
        User::updatePassword($connection, $updateUser, $id);
        $_SESSION["message"] = true;
    } catch (\Throwable $e) {
        $_SESSION["message"] = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_SESSION["message"])) {
        if ($_SESSION['message']) {
            echo '<script> alert("Đổi mật khẩu thành công vui lòng đăng nhập lại!");
                location.href = "'.BASE_URL.'/login"
            </script>
            ';
            session_destroy();
        } else {
            echo '<script> alert("Đã xảy ra lỗi vui lòng thử lại!");
                location.href = "'.BASE_URL.'/pages/me.php"
            </script>
            ';
        }
    } ?>
</body>

</html>