<?php
session_start();
include_once "../utils/routerConfig.php";
include_once "../classes/database.php";
include_once "../classes/category.php";
include_once "../classes/book.php";
include_once "../classes/wishlist.php";
include_once "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    try {
        $category = Category::getById($connection, $id);
        $books = Book::getByCategory($connection, $category->category);
        if (is_array($books)) {
            foreach ($books as $book) {
                $filePath = '../uploads/books/' . $book->file_path;
                $imgPath = '../uploads/books-cover/' . $book->cover_path;
                if (file_exists($filePath) && file_exists($imgPath)) {
                    try {
                        unlink($filePath);
                        unlink($imgPath);
                        Book::delete($connection, $id);
                    } catch (\Throwable $e) {
                        echo '<script>alert("Đã xảy ra lỗi vui lòng thử lại!");
                            location.href = "/WebApp/category";
                            </script>';
                    }
                }
            }
        }
        Category::deleteById($connection, $id);
        echo '<script>alert("Xóa thể loại thành công!");
        location.href = "/WebApp/category";
    </script>';
    } catch (\Throwable $e) {
        echo '<script>alert("Đã xảy ra lỗi vui lòng thử lại!");
        location.href = "/WebApp/category";
    </script>';
    }
}
