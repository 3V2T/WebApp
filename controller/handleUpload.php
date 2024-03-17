<?php
include "../classes/database.php";
include "../classes/author.php";
include "../classes/book.php";
include "../classes/category.php";
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
                echo '<script>
                    alert("Only PDF files are allowed!");
                    location.href="'.BASE_URL .'/upload" ;
                    </script>';
                    return false;
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
                echo '<script>
                    alert("Only image files are allowed!");
                    location.href="'.BASE_URL .'/upload" ;
                </script>';
                return false;   
            }

            $new_filename = uniqid() . '_' . rand(1000, 9999) .'.'. pathinfo($file_name, PATHINFO_EXTENSION);

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
    $conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $connection = $conn->getConn();
    $uploadPath = uploadFile();
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
                    Book::add($connection, $book);
                    $_SESSION['title'] = $book->title;
                }
            } catch (\Throwable $e) {
                echo $_SESSION['error_message'] = $e;
            }
        }
    } else {
        $_SESSION['error_message'] = "Upload file gặp lỗi vui lòng thử lại!";
    }
}

addData();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
include "../js/bootstrapConfig.php";
?>

<body>
    <div class="min-vh-100 min-vw-100 ">
        <div class="modal d-flex " tabindex="-1" role="dialog">
            <div class="modal-dialog d-flex w-75" role="document">
                <div class="modal-content m-auto">
                    <div class="modal-header">
                        <h2 class="modal-title">Notice</h2>
                    </div>
                    <div>
                        <?php
                        $conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
                        $connection = $conn->getConn();
                        if (isset($_SESSION['title'])) {
                            $title = $_SESSION['title'];
                            if ($title != "") {
                                $book = Book::getByTitle($connection, $title);
                                $author = Author::getById($connection, $book->author_id);
                                $category = Category::getById($connection, $book->category_id);
                                echo "
                            <div class='modal-body'>
                            <h3>Upload successfully!</h3>
                            </div>
                            <div class='row px-4 pb-4'>
                                <div class='col-md-8'>
                                <div>
                                    <strong>Title: </strong>
                                    <span>" . $book->title . "</span>
                                </div>
                                <div>
                                    <strong>Category: </strong>
                                    <span>" . $category->name . "</span>
                                </div>
                                <div>
                                    <strong>Author: </strong>
                                    <span>" . $author->author . "</span>
                                </div>
                                </div>
                                <div class='col-md-4'>
                                    <img class='w-100' src='../uploads/books-cover/" . $book->cover_path . "' >
                                </div>
                            </div>
                            ";
                                unset($_SESSION['title']);
                            }
                        }
                        if (isset($_SESSION['error_message'])) {
                            echo "<div class='position-fixed bg-white d-flex' style='top: 0; left: 0; right: 0; bottom: 0;'>
                                    <div class='modal-body m-auto shadow'>
                                    <h3>" . $_SESSION['error_message'] . "</h3>
                                    </div>
                                </div>";
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="goBack()" class="btn btn-outline-primary">New upload</button>
                        <button type="button" onclick="goHome()" class="btn btn-outline-success" data-dismiss="modal">Go
                            home</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
const goHome = () => {
    location.href = "<?php echo BASE_URL?> /home";
}
const goBack = () => {
    location.href = "<?php echo BASE_URL?> /upload";
}
</script>

</html>