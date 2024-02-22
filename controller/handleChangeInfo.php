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
$name = $_POST['name'];
$password = $_POST['password'];
$email = $_POST['email'];
$is_valid = User::authen($connection, $username, $password);
if ($is_valid) {
    $updateUser = new User(1, $username, $name, $password, $email);
    try {
        User::update($connection, $updateUser, $id);
        $_SESSION["message"] = "Thay đổi thông tin thành công!";
    } catch (\Throwable $e) {
        $_SESSION["message"] = "Đã xảy ra lỗi vui lòng thử lại sau!";
    }
} else {
    $_SESSION["message"] = "Mật khẩu sai vui lòng thử lại!";
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
        if ($_SESSION['message'] != "") {
            echo '<script> alert("' . $_SESSION["message"] . '");
                location.href = "/WebApp/pages/me.php"
            </script>
            ';
            $_SESSION["message"]  = "";
        }
    } ?>
</body>

</html>