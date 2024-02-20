<div class="container p-5">
    <form action="controller/handleUpload.php" method="post" enctype="multipart/form-data">
        <h1>Form upload sách</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ten-sach">Tên sách</label>
                    <input type="text" class="form-control" id="ten-sach" name="title" placeholder="Tên sách">
                </div>
                <div class="form-group"> <label for="tac-gia">Thể loại</label>
                    <select class="form-control" name="category_id" id="the-loai" placeholder="Thể loại">
                        <option value="" selected> -- Chọn thể loại -- </option>
                        <?php
                        $categoriesList = [];
                        $categoriesList = Category::getAll($connection);
                        foreach ($categoriesList as $category) {
                            echo "<option value='$category->id'>$category->name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group"> <label for="mo-ta-sach">Mô tả sách</label>
                    <textarea class="form-control" name="description" id="mo-ta-sach" rows="5"></textarea>
                </div>
                <div class="form-group"> <label for="tac-gia">Tác giả</label>
                    <input type="text" class="form-control" name="author" id="tac-gia" placeholder="Tên tác giả">
                </div>
                <div class="form-group">
                    <label for="ngay-phat-hanh">Ngày phát hành</label>
                    <input type="date" name="published" class="form-control" id="ngay-phat-hanh">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="file-pdf">File PDF</label>
                    <input type="file" class="form-control" id="file-pdf" name="file-pdf">
                </div>
                <div class="form-group">
                    <label for="file-anh">File ảnh</label>
                    <input type="file" class="form-control" id="file-anh" name="file-anh" accept="image/*">
                    <img src="" class="img-fluid" id="anh-sach" style="display: none;">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Tải lên</button>
        <button type="button" class="btn btn-danger" id="clear-all">Clear all</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script>
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

            // Validate file inputs
            if (filePDF === "") {
                isValid = false;
                $("#file-pdf").addClass("is-invalid");
            } else {
                $("#file-pdf").removeClass("is-invalid");
            }

            if (fileAnh === "") {
                isValid = false;
                $("#file-anh").addClass("is-invalid");
            } else {
                $("#file-anh").removeClass("is-invalid");
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