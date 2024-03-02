<!-- Kiểm tra người dùng đăng nhập chưa -->

<?php
session_start();
include_once "../utils/routerConfig.php";
include_once "../classes/database.php";
include_once "../classes/category.php";
include_once "../classes/book.php";
include_once "../classes/author.php";
include_once "../classes/wishlist.php";
include_once "../config.php";
$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);

if ($slug == "upload") {
    if (!isset($_SESSION["is_admin"])) {
        header("Location: " . baseURL("home"));
    }
}
if ($slug != "login" && $slug != "register") {
    if (!isset($_SESSION["is_login"])) {
        header("Location: " . baseURL("login"));
    }
}

$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
$id = isset($_GET['id']) ? $_GET["id"] : null;
$_SESSION['current_id'] = $id;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php
    include_once("../js/bootstrapConfig.php");
    ?>
    <div class="main-container">
        <?php
        include_once("./components/header.php");
        ?>
        <?php

        ?>
        <div class="container p-5">
            <form action="/WebApp/controller/handleUpdateBook.php?type=info" method="post"
                enctype="multipart/form-data">
                <?php
                $book = Book::getById($connection, $id);
                $category_book = Category::getById($connection, $book->category_id);
                $author = Author::getById($connection, $book->author_id);
                echo '<h1>Form upload sách</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ten-sach">Tên sách</label>
                                <input type="text" class="form-control" id="ten-sach" name="title" placeholder="Tên sách" value="' . $book->title . '">
                            </div>
                            <div class="form-group"> <label for="tac-gia">Thể loại</label>
                                <select class="form-control" name="category_id" id="the-loai" placeholder="Thể loại">
                                    <option value="" selected> -- Chọn thể loại -- </option>';
                ?>
                <?php
                $categoriesList = [];
                $categoriesList = Category::getAll($connection);
                foreach ($categoriesList as $category) {
                    if ($category->name == $category_book->name) {
                        echo "<option value='$category->id' selected>$category->name</option>";
                    } else {
                        echo "<option value='$category->id'>$category->name</option>";
                    }
                }
                ?>
                </select>
        </div>
        <?php
        echo '<div class="form-group"> <label for="mo-ta-sach">Mô tả sách</label>
        <div class="form-control h-auto text" style="cursor:pointer">
            ' . $book->description . '
        </div> 
        <textarea class="d-none form-control" name="description" id="mo-ta-sach" rows="10"></textarea>
    </div>
    <div class="form-group"> <label for="tac-gia">Tác giả</label>
        <input type="text" class="form-control" name="author" id="tac-gia" placeholder="Tên tác giả"
            value="' . $author->author . '">
    </div>
    <div class="form-group">
        <label for="ngay-phat-hanh">Ngày phát hành</label>
        <input type="date" name="published" class="form-control" id="ngay-phat-hanh" value="' . $book->published . '">
    </div>';
        ?>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="file-pdf">File PDF</label>
            <input type="file" class="form-control" id="file-pdf" name="file-pdf">
        </div>
        <div class="form-group">
            <label for="file-anh">File ảnh</label>
            <input type="file" class="form-control" id="file-anh" name="file-anh" accept="image/*">
            <?php
            echo '<img src="../uploads/books-cover/' . $book->cover_path . '" class="img-fluid" id="anh-sach" style="display: block;">';
            ?>
        </div>
    </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-danger" id="clear-all">Clear all</button>
    </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script>
    const textArea = document.querySelector("textarea");
    const textDiv = document.querySelector(".text");
    textArea.value = textDiv.innerText;
    textDiv.onclick = (e) => {
        textDiv.classList.add("d-none");
        textArea.classList.remove("d-none");
    };
    $(document).ready(function() {
        $("form").submit(function(event) {
            // Prevent form submission
            event.preventDefault();

            // Perform form validation
            var tenSach = $("#ten-sach").val();
            var tacGia = $("#tac-gia").val();
            var moTaSach = $("#mo-ta-sach").val();
            var theLoai = $("#the-loai").val();
            var ngayPhatHanh = $("#ngay-phat-hanh").val();
            var filePDF = $("#file-pdf").val();
            var fileAnh = $("#file-anh").val();

            var isValid = true;

            // Validate required fields
            if (tenSach === "") {
                isValid = false;
                $("#ten-sach").addClass("is-invalid");
            } else {
                $("#ten-sach").removeClass("is-invalid");
            }

            if (tacGia === "") {
                isValid = false;
                $("#tac-gia").addClass("is-invalid");
            } else {
                $("#tac-gia").removeClass("is-invalid");
            }
            if (theLoai === "") {
                isValid = false;
                $("#the-loai").addClass("is-invalid");
            } else {
                $("#the-loai").removeClass("is-invalid");
            }
            if (moTaSach === "") {
                isValid = false;
                $("#mo-ta-sach").addClass("is-invalid");
            } else {
                $("#mo-ta-sach").removeClass("is-invalid");
            }

            if (ngayPhatHanh === "") {
                isValid = false;
                $("#ngay-phat-hanh").addClass("is-invalid");
            } else {
                $("#ngay-phat-hanh").removeClass("is-invalid");
            }

            // If the form is valid, submit it
            if (isValid) {
                this.submit();
            }
        });

        // Clear all form fields
        $("#clear-all").click(function() {
            $("form")[0].reset();
        });
    });
    // Hiển thị hình ảnh khi tải lên
    $(document).on("change", "#file-anh", function() {
        var file = this.files[0];
        var reader = new FileReader();

        reader.onload = function() {
            var image = reader.result;
            $('#anh-sach').attr('src', image);
            $('#anh-sach').show();
        };
        reader.readAsDataURL(file);
    });

    // Clear all data in form
    $(document).on("click", "#clear-all", function() {
        // Clear all input fields
        $("input").val("");
        // Clear all textarea fields
        $("textarea").val("");
    });
    </script>
    <?php
    include_once("./components/footer.php");
    ?>
    </div>
</body>

</html>