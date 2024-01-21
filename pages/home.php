<?php
include_once "./utils/routerConfig.php";

if (isset($_SESSION['success_message'])) {
    // Hiển thị thông báo
    echo "<script>alert('{$_SESSION['success_message']}');</script>";
    // Xóa biến session
    unset($_SESSION['success_message']);
}

?>
<div class="slider h-75 overflow-hidden position-relative ">
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