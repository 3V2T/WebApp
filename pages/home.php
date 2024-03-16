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
        <div class="slide" style="height: 100%; width: calc(100%/3) ;background-image: url(https://www.ctvnews.ca/content/dam/ctvnews/en/images/2024/3/1/library-toronto-1-6790612-1709293812660.jpg); background-position: center; background-size: cover;">
        </div>
        <div class="slide" style="height: 100%; width: calc(100%/3) ;background-image: url(https://www.shutterstock.com/image-photo/elibrary-many-ebook-icons-electronic-600nw-2311535733.jpg); background-position: center; background-size: cover;">
        </div>
        <div class="slide" style="height: 100%; width: calc(100%/3);background-image: url(https://www.shutterstock.com/image-photo/elearning-education-concept-learning-online-600nw-1865958031.jpg); background-position: center; background-size: cover;">
        </div>
    </div>
    <div class="position-absolute h-100 w-100 z-3" style="top: 0; left: 0; background-color: rgba(0, 0, 0, 0.4);"></div>
    <div class="position-absolute h-100 w-100 z-3 d-flex" style="top: 0; left: 0;">
        <div class="text-white m-auto text-center">
            <h1 style="font-size: 60px">THƯ VIỆN ONLINE</h1>
            <p style="font-size: 24px">Đọc sách mọi lúc, mọi nơi!</p>
        </div>
    </div>
</div>
<div class="container min-vh-100">
    <h2 class="pt-4 pb-4">Thể loại</h2>
    <div class="row pt-4 pb-4 gap-4">
        <?php
        $categories = Category::getAll($connection);
        foreach ($categories as $category) {
            echo '<a class="p-4 col-md-3 col-sm-4 d-flex text-decoration-none" style="cursor: pointer;" href="' . BASE_URL . '/pages/book.php?type=' . $category->category . '">
                <div class="position-relative d-flex"
                    style="margin:auto; width: 150px; height: 150px;box-shadow: 2px 2px 5px 2px #cccc; border-radius: 12px">
                    <h5 class="m-auto text-center ">' . $category->name . '</h5>
                </div>
            </a>';
        }
        ?>
    </div>
    <h2 class="pt-4 pb-4">Sách</h2>
    <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script language="javascript" src="js/ajax.js"></script>
    <div id="content" class="row gap-3">
        <?php include_once('pages/loadMore.php'); ?>
    </div>

    <button id="load-more">Load More</button>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var offset = 0;
        $('#load-more').click(function() {
            offset += 4;
            loadMoreData(offset);
        });

        function loadMoreData(offset) {
            $.ajax({
                url: 'pages/loadMore.php',
                type: 'get',
                data: {
                    offset: offset
                },
                beforeSend: function() {
                    $('#load-more').show();
                },
                success: function(response) {
                    if (response != "") {
                        $("#content").append(response);
                    } else {
                        $('#load-more').hide();
                    }
                }
            });
        }
    });
</script>

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