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
    if (!isset($_SESSION["user_id"])) {
        header("Location: " . baseURL("login"));
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
                        <h6>Tác giả:</h6> <span class="pl-4">' . $author->author . '</span>
                        <h6>Thể loại:</h6><span class="pl-4">' . $category->name . '</span>
                        <h6>Ngày phát hành:</h6><span class="pl-4">' . $book->published . '</span>
                        <h6 >Mô tả:</h6>
                        <p class="pl-4">' . $book->description . '</p>
                        <div>
                            <a class="btn btn-success text-white">Download</a>
                            <a class="btn btn-danger"
                                href="/WebApp/pages/read.php?name=' . $book->file_path . '">Read</a>
                        </div>
                    </div>';
                    } ?>
                </div>
            </div>
        </div>
        <?php
        include_once("./components/footer.php");
        ?>
</body>

</html>