<!-- Kiểm tra người dùng đăng nhập chưa -->
<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/book.php";
include "../classes/author.php";
include "../classes/category.php";
include "../classes/wishlist.php";
include "../config.php";

$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
if ($slug != "login") {
    if (!isset($_SESSION["is_login"])) {
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
            <h1 class='p-4'>Search - "<?php
                                        echo $_GET['keyword'];
                                        ?>" </h1>
            <div class="container">
                <div class="row gap-3">
                    <?php
                    $keyword = $_GET['keyword'];
                    if ($keyword) {
                        $books = [];
                        $books = Book::getByKeyWord($connection, $keyword);
                        foreach ($books as $b) {
                            $wishlist = WishList::getWishListByUserAndBook($connection, $_SESSION['id_user'], $b->id) != null ? true : false;
                            $author = Author::getById($connection, $b->author_id);
                            echo '
                            <div class=" col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="../uploads/books-cover/' . $b->cover_path . '" class="card-img-top" alt="Card image cap">
                            <div class="card-body row">
                                <div class="col-10">
                                    <h5 class="card-title">' . $b->title . '</h5>
                                    <p> ' . $author->author . ' </p>
                                    <a class="btn btn-primary" href="/WebApp/pages/detail.php?id=' . $b->id . '">Detail</a>
                                    <a class="btn btn-danger" href="/WebApp/pages/read.php?name=' . $b->file_path . '">Read</a>
                                </div>
                                <div class="col-2" style="padding: 0;">
                                ' . ($wishlist ? '<a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; padding: 0;" id="' . $b->id . '" class="fa-solid text-danger active fa-heart"></i></a>' : '<a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; padding: 0;" id="' . $b->id . '" class="fa-regular text-danger fa-heart"></i></a>') . '
                                </div>
                            </div>
                        </div>
                    </div>
                        ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        include_once("./components/footer.php");
        ?>
    </div>
    <script type="module" async>
        import handleEvent from '../js/handleEvent.js';
        const {
            handleToggleHeartIcon
        } = handleEvent();
        console.log(handleToggleHeartIcon);
        const heartList = document.querySelectorAll(".heart");
        console.log(heartList);
        heartList.forEach(heart => {
            heart.onclick = (event) => {
                handleToggleHeartIcon(event, heart.id, heart.querySelector("i").id);
            }
        });
    </script>
</body>

</html>