<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/user.php";
include "../classes/author.php";
include "../classes/wishlist.php";
include_once("../js/bootstrapConfig.php");
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $wishList = WishList::getWishListByUserId($connection, $id);
    try {
        if (is_array($wishList)) {
            foreach ($wishList as $wish) {
                WishList::delete($connection, $wish->id);
            }
        }
        User::delete($connection, $id);
        echo "<script>alert('Xóa người dùng thành công!');
            location.href = '/WebApp/user'
        </script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
            location.href = '/WebApp/user'
        </script>";
    }
}
