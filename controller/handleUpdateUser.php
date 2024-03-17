<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/user.php";
include "../classes/author.php";
include "../classes/wishlist.php";
include_once("../js/bootstrapConfig.php");
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
if (isset($_POST['name']) && isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST["email"];
    $id =  $_GET["id"];
    $user = User::getById($connection, $id);
    if ($_POST["password"] != "") {
        try {
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $user_update = new User(1, $user->username, $name, $password, $email);
            User::update($connection, $user_update, $user->id);
            User::updatePassword($connection, $user_update, $id);
            echo "<script>alert('Update người dùng thành công!');
                location.href = '".BASE_URL."/pages/info.php?id=" . $id . "'
            </script>";
        } catch (\Throwable $e) {
            echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '".BASE_URL."/pages/info.php?id=" . $id . "'
            </script>";
        }
    } else {
        try {
            $user_update = new User(1, $user->username, $name, "", $email);
            User::update($connection, $user_update, $user->id);
            echo "<script>alert('Update người dùng thành công!');
                location.href = '".BASE_URL."/pages/info.php?id=" . $id . "'
            </script>";
        } catch (\Throwable $e) {
            echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '".BASE_URL."/pages/info.php?id=" . $id . "'
            </script>";
        }
    }
}