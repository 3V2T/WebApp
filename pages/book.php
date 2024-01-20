<!-- Kiểm tra người dùng đăng nhập chưa -->
<?php
session_start();
include_once "../utils/routerConfig.php";
$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
if ($slug != "login") {
    if (!isset($_SESSION["user_id"])) {
        header("Location: " . baseURL("login"));
    }
}

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
        <div class="main" style="flex: 1">
            <div class="container h-100 mt-4">
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
                            echo "<h1>{$item->name}</h1>";
                        }
                    }
                }
                ?>
                <div class="container">
                    <div class="row gap-3">
                        <div class=" col-xl-3 col-md-3 col-sm-4 col-sm-6 mb-4">
                            <div class="card">
                                <img src="../uploads/books-cover/thanh-cat-tu-han-va-su-hinh-thanh-the-gioi-hien-dai.jpg"
                                    class="card-img-top" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class=" col-xl-3 col-md-3 col-sm-4 col-sm-6 mb-4">
                            <div class="card">
                                <img src="../uploads/books-cover/thanh-cat-tu-han-va-su-hinh-thanh-the-gioi-hien-dai.jpg"
                                    class="card-img-top" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-4 col-sm-6 mb-4">
                            <div class="card">
                                <img src="../uploads/books-cover/thanh-cat-tu-han-va-su-hinh-thanh-the-gioi-hien-dai.jpg"
                                    class="card-img-top" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-4 col-sm-6 mb-4">
                            <div class="card">
                                <img src="../uploads/books-cover/thanh-cat-tu-han-va-su-hinh-thanh-the-gioi-hien-dai.jpg"
                                    class="card-img-top" alt="Card image cap">
                                <div class="card-body">
                                    <div class="w-100" style="overflow: hidden; text-overflow: ellipsis;">
                                        <h5 class="card-title">
                                            Thành Cát Tư Hãn và lịch sử thế giới hiện đại</h5>
                                    </div>
                                    <a href=" #" class="btn btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
            include_once("./components/footer.php");
            ?>
    </div>
</body>

</html>