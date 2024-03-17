<!-- Kiểm tra người dùng đăng nhập chưa -->
<?php

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
    include_once("./js/bootstrapConfig.php");
    ?>
    <div class="main-container">
        <?php
        include_once("./pages/components/header.php");
        ?>
        <div class="container min-vh-100 mt-4">
            <h1 class="pt-4">Tác giả: </h1>
            <div class="container">
                <div class="row gap-3">
                    <div class="col-12">
                        <table class="table mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $authorList = Author::getAll($connection);
                                $i = 0;
                                foreach ($authorList as $author) {
                                    echo '<tr>
                                    <th scope="row">' . ++$i . '</th>
                                    <td>' . $author->id . '</td>
                                    <td><input class="input-author p-2 authorId-' . $author->id . '" value="' . $author->author . '"></td>
                                    <td>
                                    <div class="d-flex justify-content-around">
                                    <a class="px-2 justify-content-between btn undoBtn btn-primary text-white">Undo</a>
                                    <button data-toggle="modal" data-target="#modalDelete' . $author->id . '" class="px-2  btn btn-danger text-white">Delete</button>
                                    <div class="modal fade" id="modalDelete' . $author->id . '" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel' . $author->id . '" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDeleteLabel' . $author->id . '">Notice</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Deleting an author will delete his/her books, do you want to continue this action?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                <a type="button" class="btn btn-danger text-white" href="'.BASE_URL.'/controller/handleDeleteAuthor.php?id=' . $author->id . '">Delete</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <form action="'.BASE_URL.'/controller/handleUpdateAuthor.php?id=' . $author->id . '" method="post" class="editform authorId-' . $author->id . '">
                                        <input class="d-none" name="author"></input>
                                        <button class="px-2  btn btn-success text-white">Save</button>
                                        </form>
                                    </div>
                                    </td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <form class="d-flex p-5" method="post"
                            action="<?php echo BASE_URL ?>/controller/handleAddAuthor.php" style="gap: 8px">
                            <input class="form-control" name="author" placeholder=" Enter author's name">
                            <button class="btn btn-danger ">
                                Clear
                            </button>
                            <button class="btn btn-success">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
        const undoBtn = document.querySelectorAll(".undoBtn");
        undoBtn.forEach((btn, index) => {
            btn.onclick = (e) => {
                location.href = "<?php echo BASE_URL ?>/author";
            }
        })
        const inputAuthor = document.querySelectorAll(".input-author");
        const inputEdit = document.querySelectorAll(".editform input");
        inputAuthor.forEach((element, index) => {
            inputEdit[index].value = element.value;
            element.onchange = (e) => {
                inputEdit[index].value = e.target.value;
                console.log(e.target.value);
            }
        })
        </script>
        <?php
        include_once("./pages/components/footer.php");
        ?>
    </div>
</body>

</html>