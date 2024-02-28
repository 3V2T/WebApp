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
    <?php
    include_once("./js/bootstrapConfig.php");
    ?>
    <div class="main-container">
        <?php
        include_once("./pages/components/header.php");
        ?>
        <div class="container min-vh-100 mt-4">
            <div class="container">
                <div class="row gap-3">
                    <div class="col-12 d-flex">
                        <table class="table mt-5 ">
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
                                    <td><input class="p-2" value="' . $author->author . '"></td>
                                    <td><a class="btn undoBtn btn-primary text-white">Undo</a>
                                    <button data-toggle="modal" data-target="#modalDelete' . $author->id . '" class="btn btn-danger text-white">Delete</button>
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
                                                <a type="button" class="btn btn-danger text-white" href="/WebApp/controller/handleDeleteAuthor.php?id=' . $author->id . '">Delete</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <a class="btn btn-success text-white">Save</a>
                                    </td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
        const undoBtn = document.querySelectorAll(".undoBtn");
        undoBtn.forEach((btn, index) => {
            btn.onclick = (e) => {
                location.href = "/WebApp/author";
            }
        })
        const deleteBtn = document.querySelectorAll(".deleteBtn");
        </script>
        <?php
        include_once("./pages/components/footer.php");
        ?>
    </div>
</body>

</html>