<?php
// Số lượng item hiển thị trên mỗi trang
session_start();
include_once "../utils/routerConfig.php";
include_once "../classes/database.php";
include_once "../classes/category.php";
include_once "../classes/book.php";
include_once "../classes/user.php";
include_once "../classes/author.php";
include_once "../classes/wishlist.php";
include_once "../config.php";
$conn = include "../inc/db.php";
$offset = 0;
$response = "";
// Offset, mặc định là 0
$limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
// Truy vấn dữ liệu từ cơ sở dữ liệu
$bookArray = Book::getAll($conn);
$books = Book::getPagingBooks($conn, $limit, $offset);
foreach ($books as $b) {
    $wishlist;
    if (isset($_SESSION["id_user"])) {

        $wishlist = WishList::getWishListByUserAndBook($conn, $_SESSION['id_user'], $b->id) != null ? true : false;
    }
    $author = Author::getById($conn, $b->author_id);
    $response = $response .  '
    <div class=" col-xl-3 col-md-4 col-sm-6 mb-4">
<div class="card">
    <img src="./uploads/books-cover/' . $b->cover_path . '" class="card-img-top" alt="Card image cap">
    <div class="card-body row">
        <div class="col-10 d-flex flex-column" style="gap: 8px">
        <a href="' . BASE_URL . '/pages/detail.php?id=' . $b->id . '" style="font-size: 24px; color: black" class="fw-bold">' . $b->title . '</a>
        <a href="' . BASE_URL . '/pages/bookbyauthor.php?authorId=' . $author->id . '"> ' . $author->author . ' </a>
            <div>
<a class="btn btn-primary" href="' . BASE_URL . '/pages/detail.php?id=' . $b->id . '">Detail</a>
<a class="btn btn-danger" href="' . BASE_URL . '/pages/read.php?name=' . $b->file_path . '">Read</a>
</div>
</div>
<div class="col-2" style="padding: 0;">
' . (isset($_SESSION["id_user"]) ? ($wishlist ? '<a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; padding: 0;" id="' . $b->id . '"
class="fa-solid text-danger active fa-heart"></i></a>' : '<a style="cursor: pointer"
id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; " id="' . $b->id . '"
class="fa-regular text-danger fa-heart"></i></a>') : null) . '
</div>
</div>
</div>
</div>
';;
}
echo $response;
return $response;
