<?php

use function PHPSTORM_META\elementType;

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
        $is_exist = Category::getByCategory($connection, $category);
        if (!is_object($is_exist)) {
            Category::add($connection, $category);
            echo '<script>alert("Thêm thể loại thành công!");
                location.href = "' . BASE_URL . '/category";
            </script>';
        } else {
            echo '<script>alert("Tên thể loại đã tồn tại vui lòng thử lại!");
                location.href = "' . BASE_URL . '/category";
            </script>';
        }
    } catch (\Throwable $e) {
        echo '<script>alert("Đã xảy ra lỗi vui lòng thử lại!");
            
        </script>';
    }
}
