<?php
session_start();
include_once "../utils/routerConfig.php";
include_once "../classes/database.php";
include_once "../classes/category.php";
include_once "../classes/book.php";
include_once "../classes/author.php";
include_once "../classes/wishlist.php";
include_once "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
if (isset($_GET["id"]) && $_POST['author']) {
    $id = $_GET["id"];
    $author_name = $_POST['author'];
    try {
        $author = new Author(1, $author_name, "");
        Author::update($connection, $author, $id);
        echo '<script>alert("Update tác giả thành công!");
            location.href = "'.BASE_URL.'/author";
        </script>';
    } catch (\Throwable $e) {
        echo '<script>alert("Đã xảy ra lỗi vui lòng thử lại!");
            location.href = "'.BASE_URL.'/author";
        </script>';
    }
}