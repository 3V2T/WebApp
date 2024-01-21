<div class="container p-5">
    <form action="controller/handleUpload.php" method="post" enctype="multipart/form-data">
        <h1>Form upload sách</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ten-sach">Tên sách</label>
                    <input type="text" class="form-control" id="ten-sach" placeholder="Tên sách">
                </div>
                <div class="form-group">
                    <label for="tac-gia">Tác giả</label>
                    <input type="text" class="form-control" id="tac-gia" placeholder="Tác giả">
                </div>
                <div class="form-group">
                    <label for="mo-ta-tac-gia">Mô tả tác giả</label>
                    <textarea class="form-control" id="mo-ta-tac-gia" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="mo-ta-sach">Mô tả sách</label>
                    <textarea class="form-control" id="mo-ta-sach" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="ngay-phat-hanh">Ngày phát hành</label>
                    <input type="date" class="form-control" id="ngay-phat-hanh">
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