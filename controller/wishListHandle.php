<?php
include "../classes/database.php";
include "../config.php";
include "../classes/wishlist.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
$action = $_GET["action"] == "add" ? true : false;
$userId = $_GET["userId"];
$bookId = $_GET["bookId"];
echo $action;
echo $userId;
echo $bookId;
if ($action) {
    try {
        $wish = new WishList(1, $bookId, $userId);
        echo $wish->id;
        echo $wish->book_id;
        echo $wish->user_id;
        WishList::add($connection, $wish);
        return true;
    } catch (\Throwable $e) {
        return false;
    }
} else {
    try {
        $wish = new WishList(1, $bookId, $userId);
        WishList::deleteByUserAndBook($connection, $userId, $bookId);
        return true;
    } catch (\Throwable $e) {
        return false;
    }
}
