<?php 
include_once "./utils/routerConfig.php";
include_once "classes/book.php";
$connection = $conn->getConn();



// Số lượng item hiển thị trên mỗi trang
$limit = 4;

// Offset, mặc định là 0
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

// Truy vấn dữ liệu từ cơ sở dữ liệu

$books = Book::getPagingBooks($connection, $limit, $offset);
foreach ($books as $b) {
    $wishlist;
    if (isset($_SESSION["id_user"])) {
        $wishlist = WishList::getWishListByUserAndBook($connection, $_SESSION['id_user'], $b->id) != null ? true : false;
    }
    $author = Author::getById($connection, $b->author_id);
    echo '
                        <div class=" col-xl-3 col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="./uploads/books-cover/' . $b->cover_path . '" class="card-img-top" alt="Card image cap">
                            <div class="card-body row">
                                <div class="col-10">
                                    <h5 class="card-title">' . $b->title . '</h5>
                                    <p> ' . $author->author . ' </p>
                                    <a class="btn btn-primary" href="' . BASE_URL . '/pages/detail.php?id=' . $b->id . '">Detail</a>
                                    <a class="btn btn-danger" href="' . BASE_URL . '/pages/read.php?name=' . $b->file_path . '">Read</a>
                                </div>
                                <div class="col-2" style="padding: 0;">
                                    ' . (isset($_SESSION["id_user"]) ? ($wishlist ? '<a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; padding: 0;" id="' . $b->id . '" class="fa-solid text-danger active fa-heart"></i></a>' : '<a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; " id="' . $b->id . '" class="fa-regular text-danger fa-heart"></i></a>') : null) . '
                                </div>
                            </div>
                        </div>
                    </div>';
}

/* code test

$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "library";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
// Số lượng item hiển thị trên mỗi lần load more
$limit = 1;

// Offset, mặc định là 0
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

// Truy vấn dữ liệu từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM books LIMIT $offset, $limit");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hiển thị dữ liệu
if ($results) {
    foreach ($results as $row) {
        echo '<div class="item">' . $row['title'] . '</div>';
    }
} else {
    echo "No more data available";
}
*/
?>