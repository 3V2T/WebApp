<?php
session_start();
include "../classes/database.php";
include "../classes/author.php";
include "../classes/book.php";
include "../classes/category.php";
include "../config.php";
include_once "../utils/routerConfig.php";

// Error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define upload path
function uploadFile()
{
    $path = (object) [
        "pdf_path" => "",
        "img_path" => ""
    ];
    $upload_dir_pdf = '../uploads/books/';
    $upload_dir_img = '../uploads/books-cover/';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if a PDF file has been uploaded
        if (isset($_FILES['file-pdf']) && $_FILES['file-pdf']['error'] == 0) {
            $file_name = $_FILES['file-pdf']['name'];
            $file_tmp = $_FILES['file-pdf']['tmp_name'];

            // Validate file type
            $allowed_types = ['application/pdf'];
            if (!in_array($_FILES['file-pdf']['type'], $allowed_types)) {
                die('Only PDF files are allowed!');
            }

            // Generate a unique filename to prevent overwrites
            $new_filename = $file_name;
            // Move the uploaded file to the uploads directory
            try {
                move_uploaded_file($file_tmp, $upload_dir_pdf . $new_filename);
                // File uploaded successfully
                $path->pdf_path = $new_filename;
                // You can now store the file path in your database or process it further
            } catch (\Throwable $e) {
                return false;
            }
        } else {
            return false;
        }

        // Check if an image file has been uploaded
        if (isset($_FILES['file-anh']) && $_FILES['file-anh']['error'] == 0) {
            $file_name = $_FILES['file-anh']['name'];
            $file_tmp = $_FILES['file-anh']['tmp_name'];

            // Validate image type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['file-anh']['type'], $allowed_types)) {
                die('Only image files are allowed!');
            }

            $new_filename = $file_name;

            try {
                move_uploaded_file($file_tmp, $upload_dir_img . $new_filename);
                $path->img_path = $new_filename;
            } catch (\Throwable $e) {
                return false;
            }
        }
        return $path;
    } else {
        return false;
    }
}

function addData()
{
    $id = $_SESSION["current_id"];
    $conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $connection = $conn->getConn();
    $uploadPath = uploadFile();
    $id = $_SESSION["current_id"];
    if (is_object($uploadPath)) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $category_id = $_POST["category_id"];
            $description = $_POST["description"];
            $author_name = $_POST["author"];
            $published = $_POST["published"];
            try {
                $author = Author::getByName($connection, $author_name);
                if ($author) {
                    $book = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $uploadPath->pdf_path);
                    Book::update($connection, $book, $id);
                    $_SESSION['title'] = $book->title;
                    $_SESSION['error_message'] = "Sửa thông tin thành công!";
                } else {
                    $author =  new Author(1, $author_name, " ");
                    Author::add($connection, $author);
                    $author = Author::getByName($connection, $author_name);
                    if ($author) {
                        $book = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $uploadPath->pdf_path);
                        Book::update($connection, $book, $id);
                        $_SESSION['title'] = $book->title;
                        $_SESSION['error_message'] = "Sửa thông tin thành công!";
                    }
                }
            } catch (\Throwable $e) {
                echo $_SESSION['error_message'] = "Đã xảy ra lỗi vui lòng thử lại!";
            }
        }
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $book = Book::getById($connection, $id);
            $title = $_POST["title"];
            $category_id = $_POST["category_id"];
            $description = $_POST["description"];
            $author_name = $_POST["author"];
            $published = $_POST["published"];
            try {
                $author = Author::getByName($connection, $author_name);
                if ($author) {
                    $book = new Book(1, $title, $author->id, $category_id, $description, $published, $book->cover_path, $book->file_path);
                    Book::updateInfo($connection, $book, $id);
                    $_SESSION['title'] = $book->title;
                } else {
                    $author =  new Author(1, $author_name, " ");
                    Author::add($connection, $author);
                    $author = Author::getByName($connection, $author_name);
                    if ($author) {
                        $book = new Book(1, $title, $author->id, $category_id, $description, $published, $book->cover_path, $book->file_path);
                        Book::updateInfo($connection, $book, $id);
                        $_SESSION['title'] = $book->title;
                    }
                }
            } catch (\Throwable $e) {
                echo $_SESSION['error_message'] = "Đã xảy ra lỗi vui lòng thử lại!";
            }
        }
    }
}

addData();

echo '<script>alert("' . $_SESSION['error_message']  . '")
    location.href = "/WebApp/home";
</script>';
