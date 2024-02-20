<!-- Kiểm tra người dùng đăng nhập chưa -->
<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/book.php";
include "../classes/author.php";
include "../config.php";
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
            <?php
            if (isset($_GET["type"])) {
                $list = [
                    (object) [
                        "name" => "Tất cả",
                        "slug" => "all",
                    ],
                    (object) [
                        "name" => "Thiếu nhi",
                        "slug" => "thieu-nhi",
                    ],
                    (object) [
                        "name" => "Khoa học",
                        "slug" => "khoa-hoc",
                    ],
                    (object) [
                        "name" => "Tâm lý",
                        "slug" => "tam-ly",
                    ],
                    (object) [
                        "name" => "Lịch sử",
                        "slug" => "lich-su",
                    ],

                    (object) [
                        "name" => "Văn học",
                        "slug" => "van-hoc",
                    ],
                ];
                foreach ($list as $item) {
                    if ($item->slug == $_GET['type']) {
                        echo "<h1 class='p-4'>{$item->name}</h1>";
                    }
                }
            }
            ?>
            <div class="container">
                <div class="row gap-3">
                    <?php
                    $category = $_GET['type'] != null ? $_GET['type'] : null;
                    if ($category) {
                        $books = $category == "all" ? Book::getAll($connection) : Book::getByCategory($connection, $category);
                        foreach ($books as $b) {
                            $author = Author::getById($connection, $b->author_id);
                            echo '
                        <div class=" col-xl-3 col-md-3 col-sm-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="../uploads/books-cover/' . $b->cover_path . '" class="card-img-top" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">' . $b->title . '</h5>
                                <p> ' . $author->author . ' </p>
                                <a href="#" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                        ';
                        }
                    }

                    ?>

                    <!-- <div class=" col-xl-3 col-md-3 col-sm-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="../uploads/books-cover/thanh-cat-tu-han-va-su-hinh-thanh-the-gioi-hien-dai.jpg" class="card-img-top" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <a href="#" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <?php
        include_once("./components/footer.php");
        ?>
    </div>
</body>

</html>