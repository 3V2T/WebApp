<!-- Kiểm tra người dùng đăng nhập chưa -->
<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/book.php";
include "../classes/author.php";
include "../config.php";
include "../classes/category.php";
$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
if ($slug != "login") {
    if (!isset($_SESSION["is_login"])) {
        header("Location: " . baseURL("login"));
    }
}
if (!isset($_GET["id"])) {
    header("Location: " . baseURL("error"));
}

$isEdit = false;
if (isset($_GET['edit'])) {
    if ($_GET['edit'] == "true") {
        $isEdit = true;
    } else {
        header("Location: " . baseURL('pages/detail.php?id=' . $_GET["id"]));
    }
}
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    include_once("../js/bootstrapConfig.php");
    ?>
    <div class="main-container">
        <?php
        include_once("./components/header.php");
        ?>
        <div class="container min-vh-100 mt-4">
            <div>
                <div class="row py-5 d-flex">
                    <?php
                    if (isset($_GET["id"])) {
                        $id = $_GET["id"];
                        $book = Book::getById($connection, $id);
                        $category = Category::getById($connection, $book->category_id);
                        $author = Author::getById($connection, $book->author_id);
                        echo '<div class="col-md-5">
        <div class="col-md-1"></div>
        <div class="col-md-10"><img src="../uploads/books-cover/' . $book->cover_path . '"
                style="width: 100%;box-shadow: 2px 2px 5px 2px #cccc; border-radius: 12px;"></div>
        <div class="col-md-1"></div>
    </div>
    <div class="col-md-7 p-4" style="box-shadow: 2px 2px 5px 2px #cccc; border-radius: 12px">
        <h1>' . $book->title . '</h1>
        <h6>Tác giả:</h6> <p class="pl-4">' . $author->author . '</p>
        <h6>Thể loại:</h6><p><a href="'.BASE_URL.'/pages/book.php?type=' . $category->category . '" class="pl-4">' . $category->name . '</a></p>
        <h6>Ngày phát hành:</h6><p class="pl-4">' . $book->published . '</p>
        <h6 >Mô tả:</h6>
        <p class="pl-4">' . $book->description . '</p>
        <div>
            <a class="btn btn-success text-white" href="'.BASE_URL.'/controller/handleDownload.php?file=' . $book->file_path . '">Download</a>
            <a class="btn btn-primary text-white"
                href="'.BASE_URL.'/pages/read.php?name=' . $book->file_path . '">Read</a>
                ';

                        if (isset($_SESSION["is_admin"])) {
                            echo '<button data-toggle="modal" data-target="#modalDelete" class="btn btn-danger text-white">Delete</button>
                                    <a  class="btn btn-info text-white" href="'.BASE_URL.'/pages/editBook.php?id=' . $book->id . '">Edit</a>
                                    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDeleteLabel">Notice</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Delete this book?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                <a type="button" class="btn btn-danger text-white"href="'.BASE_URL.'/controller/handleDelete.php?id=' . $book->id . '">Delete</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    ';
                        }

                        echo '</div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        include_once("./components/footer.php");
        ?>
</body>

</html>