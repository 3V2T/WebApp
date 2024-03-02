<?php
include_once "./utils/routerConfig.php";
if (isset($_SESSION['success_message'])) {
    // Hiển thị thông báo
    echo "<script>alert('{$_SESSION['success_message']}');</script>";
    // Xóa biến session
    unset($_SESSION['success_message']);
}
$connection = $conn->getConn();
?>
<div class="container min-vh-100">
    <h2 class="pt-4 pb-4">Danh sách yêu thích</h2>
    <div class="row gap-3">
        <?php
        $books = Book::getAll($connection);
        foreach ($books as $b) {
            $wishlist = WishList::getWishListByUserAndBook($connection, $_SESSION['id_user'], $b->id) != null ? true : false;
            $author = Author::getById($connection, $b->author_id);
            if ($wishlist) {
                echo '
                        <div class=" col-xl-3 col-md-3 col-sm-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="./uploads/books-cover/' . $b->cover_path . '" class="card-img-top" alt="Card image cap">
                            <div class="card-body row">
                                <div class="col-10">
                                    <h5 class="card-title">' . $b->title . '</h5>
                                    <p> ' . $author->author . ' </p>
                                    <a class="btn btn-primary" href="/WebApp/pages/detail.php?id=' . $b->id . '">Detail</a>
                                    <a class="btn btn-danger" href="/WebApp/pages/read.php?name=' . $b->file_path . '">Read</a>
                                </div>
                                <div class="col-2" style="padding: 0;">
                                    ' . ($wishlist ? '<a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; padding: 0;" id="' . $b->id . '" class="fa-solid text-danger active fa-heart"></i></a>' : '<a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i style="font-size: 25px; padding: 0;" id="' . $b->id . '" class="fa-regular text-danger fa-heart"></i></a>') . '
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        }
        ?>
    </div>
</div>

<script>
    const containerSlide = document.querySelector('.container-slide');
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    const slideInterval = setInterval(nextSlide, 2000);

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        containerSlide.style.transform = `translateX(-${currentSlide * (100 / slides.length)}%)`;
    }
</script>
<script type="module" async>
    import handleEvent from './js/handleEvent.js';
    const {
        handleToggleHeartIcon
    } = handleEvent();
    console.log(handleToggleHeartIcon);
    const heartList = document.querySelectorAll(".heart");
    console.log(heartList);
    heartList.forEach(heart => {
        heart.onclick = (event) => {
            handleToggleHeartIcon(event, heart.id, heart.querySelector("i").id);
        }
    });
</script>