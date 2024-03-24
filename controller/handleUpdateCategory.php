<?php
session_start();
include_once "../utils/routerConfig.php";
include_once "../classes/database.php";
include_once "../classes/category.php";
include_once "../classes/book.php";
include_once "../classes/author.php";
include_once "../classes/wishlist.php";
include_once "../config.php";
include "./handleSlug.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();

if (isset($_GET["id"]) && $_POST['category_name']) {
    $id = $_GET["id"];
    $category_name = $_POST['category_name'];
    $string = strtolower($category_name);
    $category = create_slug($string);
    echo $category;
    echo $category_name;
    try {
        $category = new Category(1, $category, $category_name);
        Category::updateById($connection, $category, $id);
        echo '<script>alert("Update thể loại thành công!");
            location.href = "' . BASE_URL . '/category";
        </script>';
    } catch (\Throwable $e) {
        echo '<script>alert("Đã xảy ra lỗi vui lòng thử lại!");
            location.href = "' . BASE_URL . '/category";
        </script>';
    }
}
