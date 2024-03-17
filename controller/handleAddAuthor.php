<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/user.php";
include "../classes/author.php";
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
if (isset($_POST['author'])) {
    $author_name = $_POST['author'];
    $author = new Author(1, $author_name, "");
    try {
        Author::add($connection, $author);
        echo "<script>alert('Thêm tác giả mới thành công!');
                location.href = '".BASE_URL."/author'
            </script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '".BASE_URL."/author'
            </script>";
    }
}