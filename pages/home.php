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
<div class="slider h-75 overflow-hidden position-relative">
    <div class="d-flex container-slide" style="width: 300%; height: 100%; transition: all 0.5s;">
        <div class="slide" style="height: 100%; width: calc(100%/3) ;background-image: url(https://www.korea.net/upload/content/editImage/20210513171333520_VIZHLNM9.jpg); background-position: center; background-size: cover;">
        </div>
        <div class="slide" style="height: 100%; width: calc(100%/3) ;background-image: url(https://www.shutterstock.com/image-photo/elibrary-many-ebook-icons-electronic-600nw-2311535733.jpg); background-position: center; background-size: cover;">
        </div>
        <div class="slide" style="height: 100%; width: calc(100%/3);background-image: url(https://www.shutterstock.com/image-photo/elearning-education-concept-learning-online-600nw-1865958031.jpg); background-position: center; background-size: cover;">
        </div>
    </div>
    <div class="position-absolute top-0 left-0 h-100 w-100 bg-black z-3"></div>

</div>
<div class="container min-vh-100">
    <h2 class="pt-4 pb-4">Thể loại</h2>
    <div class="row pt-4 pb-4 gap-4">
        <?php
        $categories = Category::getAll($connection);
        foreach ($categories as $category) {
            echo '<a class="p-4 col-md-3 col-sm-4 d-flex text-decoration-none" style="cursor: pointer;" href="/WebApp/pages/book.php?type=' . $category->category . '">
                <div class="position-relative d-flex"
                    style="margin:auto; width: 150px; height: 150px;box-shadow: 2px 2px 5px 2px #cccc; border-radius: 12px">
                    <h5 class="m-auto">' . $category->name . '</h5>
                </div>
            </a>';
        }
        ?>
    </div>
    <h2 class="pt-4 pb-4">Sách</h2>
    <div class="row gap-3">
        <?php
        $books = Book::getAll($connection);
        foreach ($books as $b) {
            $author = Author::getById($connection, $b->author_id);
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
                                <div class="col-2">
                                    <a style="cursor: pointer" id="' . $_SESSION["id_user"] . '" class="heart"><i id="' . $b->id . '" class="fa-regular text-danger fa-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>';
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