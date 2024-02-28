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
if (isset($_GET['id'])) {
    $author_id = $_GET['id'];
    $books = Book::getByAuthor($connection, $author_id);
    try {
        foreach ($books as $book) {
            $file_path = "../uploads/books/" . $book->file_path;
            $img_path = "../uploads/books-cover/" . $book->cover_path;
            if (file_exists($file_path) && file_exists($img_path)) {
                unlink($file_path);
                unlink($img_path);
                Book::delete($connection, $book->id);
            }
        }
        Author::delete($connection, $author_id);
        echo "<script>alert('Xóa thành công!');
            location.href = '/WebApp/author';
        </script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
            location.href = '/WebApp/author';
        </script>";
    }
}
