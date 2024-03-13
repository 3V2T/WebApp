<?php
session_start();
include "../classes/database.php";
include "../classes/author.php";
include "../classes/book.php";
include "../classes/category.php";
include "../config.php";
include_once "../utils/routerConfig.php";

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
            $new_filename = uniqid() . '_' . rand(1000, 9999) .'.'. pathinfo($file_name, PATHINFO_EXTENSION);
            // Move the uploaded file to the uploads directory
            try {
                move_uploaded_file($file_tmp, $upload_dir_pdf . $new_filename);
                // File uploaded successfully
                $path->pdf_path = $new_filename;
                // You can now store the file path in your database or process it further
            } catch (\Throwable $e) {
                $path->pdf_path = "";
            }
        } else {
            $path->pdf_path = "";
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
            $new_filename = uniqid() . '_' . rand(1000, 9999) .'.'. pathinfo($file_name, PATHINFO_EXTENSION);
            try {
                move_uploaded_file($file_tmp, $upload_dir_img . $new_filename);
                $path->img_path = $new_filename;
            } catch (\Throwable $e) {
                $path->img_path = "";
            }
        }
        else {
            $path->img_path = "";
        }
    } else {
        return $path;
    }
    return $path;
}

function updateAll ($connection, $book, $uploadPath) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $category_id = $_POST["category_id"];
            $description = $_POST["description"];
            $author_name = $_POST["author"];
            $published = $_POST["published"];
            try {
                unlink("../uploads/books/". $book->file_path);
                unlink("../uploads/books-cover/". $book->cover_path);
                $author = Author::getByName($connection, $author_name);
                if ($author) {
                    $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $uploadPath->pdf_path);
                    Book::update($connection, $book_update, $book->id);
                    $_SESSION['title'] = $book->title;
                    echo "<script>alert('Cập nhật sách thành công!');
                        location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                    </script>";
                } else {
                    $author =  new Author(1, $author_name, " ");
                    Author::add($connection, $author);
                    $author = Author::getByName($connection, $author_name);
                    if ($author) {
                        $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $uploadPath->pdf_path);
                        Book::update($connection, $book_update, $book->id);
                        $_SESSION['title'] = $book->title;
                        echo "<script>alert('Cập nhật sách thành công!');
                            location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                        </script>";
                    }
                }
            } catch (\Throwable $e) {
                echo "<script>alert('Cập nhật sách thất bại vui lòng thử lại!');
                            location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                        </script>";
            }
        }
}

function updateInfoAndPdf ($connection, $book, $uploadPath) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $category_id = $_POST["category_id"];
        $description = $_POST["description"];
        $author_name = $_POST["author"];
        $published = $_POST["published"];
        try {
            unlink("../uploads/books/". $book->file_path);
            $author = Author::getByName($connection, $author_name);
            if ($author) {
                $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $book->cover_path, $uploadPath->pdf_path);
                Book::update($connection, $book_update, $book->id);
                $_SESSION['title'] = $book->title;
                echo "<script>alert('Cập nhật sách thành công!');
                    location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                </script>";
            } else {
                $author =  new Author(1, $author_name, " ");
                Author::add($connection, $author);
                $author = Author::getByName($connection, $author_name);
                if ($author) {
                    $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $book->cover_path, $uploadPath->pdf_path);
                    Book::update($connection, $book_update, $book->id);
                    $_SESSION['title'] = $book->title;
                    echo "<script>alert('Cập nhật sách thành công!');
                        location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                    </script>";
                }
            }
        } catch (\Throwable $e) {
            echo "<script>alert('Cập nhật sách thất bại vui lòng thử lại!');
                        location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                    </script>";
        }
    }
}

function updateInfoAndImg ($connection, $book, $uploadPath) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $category_id = $_POST["category_id"];
        $description = $_POST["description"];
        $author_name = $_POST["author"];
        $published = $_POST["published"];
        try {
            unlink("../uploads/books-cover/". $book->cover_path);
            $author = Author::getByName($connection, $author_name);
            if ($author) {
                $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $book->file_path);
                Book::update($connection, $book_update, $book->id);
                $_SESSION['title'] = $book->title;
                echo "<script>alert('Cập nhật sách thành công!');
                    location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                </script>";
            } else {
                $author =  new Author(1, $author_name, " ");
                Author::add($connection, $author);
                $author = Author::getByName($connection, $author_name);
                if ($author) {
                    $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $uploadPath->img_path, $book->file_path);
                    Book::update($connection, $book_update, $book->id);
                    $_SESSION['title'] = $book->title;
                    echo "<script>alert('Cập nhật sách thành công!');
                        location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                    </script>";
                }
            }
        } catch (\Throwable $e) {
            echo "<script>alert('Cập nhật sách thất bại vui lòng thử lại!');
                        location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                    </script>";
        }
    }
}

function updateInfoOnly ($connection, $book) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $category_id = $_POST["category_id"];
        $description = $_POST["description"];
        $author_name = $_POST["author"];
        $published = $_POST["published"];
        try {
            $author = Author::getByName($connection, $author_name);
            if ($author) {
                $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $book->cover_path, $book->file_path);
                Book::update($connection, $book_update, $book->id);
                $_SESSION['title'] = $book->title;
                echo "<script>alert('Cập nhật sách thành công!');
                    location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                </script>";
            } else {
                $author =  new Author(1, $author_name, " ");
                Author::add($connection, $author);
                $author = Author::getByName($connection, $author_name);
                if ($author) {
                    $book_update = new Book(1, $title, $author->id, $category_id, $description, $published, $book->cover_path, $book->file_path);
                    Book::update($connection, $book_update, $book->id);
                    $_SESSION['title'] = $book->title;
                    echo "<script>alert('Cập nhật sách thành công!');
                        location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                    </script>";
                }
            }
        } catch (\Throwable $e) {
            echo "<script>alert('Cập nhật sách thất bại vui lòng thử lại!');
                        location.href = '".BASE_URL."/pages/detail.php?id=".$book->id."';
                    </script>";
        }
    }
}

function updateData () {
    $id = $_SESSION["current_id"];
    $conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $connection = $conn->getConn();
    $book = Book::getById($connection, $id);
    $path = uploadFile();
    if ($path->pdf_path != "" && $path->img_path != "") {
        updateAll($connection, $book, $path);
    }
    else if ($path->pdf_path != "" && $path->img_path == "") {
        updateInfoAndPdf($connection, $book, $path);
    }
    else if ($path->pdf_path == "" && $path-> img_path != "") {
        updateInfoAndImg($connection, $book, $path);
    }
    else if ($path->pdf_path == "" && $path->img_path == "") {
        updateInfoOnly($connection, $book);
    }
}

updateData();