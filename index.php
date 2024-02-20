<!-- Kiểm tra người dùng đăng nhập chưa -->

<?php
session_start();
$_SESSION["user_id"] = "23232";
include_once "./utils/routerConfig.php";
include_once "./classes/database.php";
include_once "./config.php";
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
        }
        ?>
        <?php
        include_once("./pages/components/footer.php");
        ?>
    </div>
</body>

</html>