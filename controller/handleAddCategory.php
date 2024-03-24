<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/category.php";
include "../config.php";
include "./handleSlug.php";

$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();

if (isset($_POST['category_name'])) {
    $category_name = $_POST['category_name'];
    try {
        $category = new Category(1, create_slug($category_name), $category_name);
        Category::add($connection, $category);
        echo '<script>alert("Thêm thể loại thành công!");
            location.href = "' . BASE_URL . '/category";
        </script>';
    } catch (\Throwable $e) {
        echo '<script>alert("Đã xảy ra lỗi vui lòng thử lại!");
            location.href = "' . BASE_URL . '/category";
        </script>';
    }
}
