<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/book.php";
include "../classes/author.php";
include "../config.php";
include "../classes/category.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo $id;
    try {
        $book = Book::getById($connection, $id);
        $filePath = '../uploads/books/' . $book->file_path;
        $imgPath = '../uploads/books-cover/' . $book->cover_path;
        if (file_exists($filePath) && file_exists($imgPath)) {
            unlink($filePath);
            unlink($imgPath);
            Book::delete($connection, $id);
            $_SESSION["error_message"] = "Delete successfully!";
        }
    } catch (\Throwable $e) {
        $_SESSION["error_message"] = $e;
    }
}
