<?php
include "../classes/database.php";
include "../classes/author.php";
include "../classes/book.php";
include "../config.php";
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
            if (move_uploaded_file($file_tmp, $upload_dir_pdf . $new_filename)) {
                // File uploaded successfully
                $path->pdf_path = $new_filename;
                // You can now store the file path in your database or process it further
            } else {
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

            if (move_uploaded_file($file_tmp, $upload_dir_img . $new_filename)) {
                $path->img_path = $new_filename;
            } else {
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
    $conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $connection = $conn->getConn();
    $uploadPath = uploadFile();
    echo $uploadPath->pdf_path;
    echo $uploadPath->img_path;
    if (is_object($uploadPath)) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $category_id = $_POST["category_id"];
            $description = $_POST["description"];
            $author_name = $_POST["author"];
            $published = $_POST["published"];
            echo "Tên sách: " . $title . "<br>";
            echo "Thể loại ID: " . $category_id . "<br>";
            echo "Mô tả sách: " . $description . "<br>";
            echo "Tác giả: " . $author_name . "<br>";
            echo "Ngày phát hành: " . $published . "<br>";
            try {
                $author = Author::getByName($connection, $author_name);
                if ($author) {
                    echo "isvalid";
                    $book = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $uploadPath->pdf_path);
                    Book::add($connection, $book);
                    echo "success add book";
                } else {
                    echo "isntvalid";
                    $author =  new Author(1, $author_name, " ");
                    Author::add($connection, $author);
                    $author = Author::getByName($connection, $author_name);
                    if ($author) {
                        echo "isvalid";
                        $book = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $uploadPath->pdf_path);
                        Book::add($connection, $book);
                        echo "success add book";
                    }
                    echo "true";
                }
            } catch (\Throwable $e) {
                echo $e;
                echo "error";
            }
        }
    } else {
        echo "false";
    }
}

addData();
