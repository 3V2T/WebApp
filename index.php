<!-- Kiểm tra người dùng đăng nhập chưa -->

<?php
session_start();
include_once "./utils/routerConfig.php";
include_once "./classes/database.php";
include_once "./classes/category.php";
include_once "./classes/book.php";
include_once "./classes/author.php";
include_once "./classes/wishlist.php";
include_once "./config.php";
$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
$_SESSION['is_admin'] = 'true';
if ($slug == "upload" || $slug == "author") {
    if (!isset($_SESSION["is_admin"])) {
        header("Location: " . baseURL("home"));
    }
}
if ($slug != "login" && $slug != "register") {
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
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php
    include_once("./js/bootstrapConfig.php");
    ?>
    <div class="main-container">
        <?php
        include_once("./pages/components/header.php");
        ?>
        <?php

        $slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
        switch ($slug) {
            case "":
                include __DIR__ . "/pages/home.php";
                break;
            case "home":
                include __DIR__ . "/pages/home.php";
                break;
            case "login":
                include __DIR__ . "/pages/login.php";
                break;
            case "register":
                include __DIR__ . "/pages/register.php";
                break;
            case "search":
                include __DIR__ . '/pages/search.php';
                break;
            case "book":
                include __DIR__ . '/pages/book.php';
                break;
            case "upload":
                include __DIR__ . '/pages/upload.php';
                break;
            case "read":
                include __DIR__ . '/pages/read.php';
                break;
            case "wishlist":
                include __DIR__ . '/pages/wishlist.php';
                break;
            case "wishlist":
                include __DIR__ . '/pages/wishlist.php';
                break;
            case "user":
                include __DIR__ . '/pages/user.php';
                break;
            case "author":
                include __DIR__ . '/pages/author.php';
                break;
            case "category":
                include __DIR__ . '/pages/category.php';
                break;
            default:
                include __DIR__ . '/pages/notfound.php';
        }
        ?>
        <?php
        include_once("./pages/components/footer.php");
        ?>
    </div>
</body>

</html>