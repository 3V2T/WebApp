<!-- Kiểm tra người dùng đăng nhập chưa -->
<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0">
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
            <h1 class="pt-4">Người dùng: </h1>
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
                                $userList = User::getAll($connection);
                                $i = 0;
                                foreach ($userList as $user) {
                                    echo '<tr>
                                    <th scope="row">' . ++$i . '</th>
                                    <td>' . $user->id . '</td>
                                    <td><div class="input-author p-2 authorId-' . $user->id . '">' . $user->username . '<div></td>
                                    <td>
                                    <div class="d-flex justify-content-around">
                                    <button data-toggle="modal" data-target="#modalDelete' . $user->id . '" class="px-2  btn btn-danger text-white">Delete</button>
                                    <div class="modal fade" id="modalDelete' . $user->id . '" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel' . $user->id . '" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDeleteLabel' . $user->id . '">Notice</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Deleting this user?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                <a type="button" class="btn btn-danger text-white" href="/WebApp/controller/handleDeleteUser.php?id=' . $user->id . '">Delete</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <a href="/WebApp/pages/info.php?id=' . $user->id . '" class="px-2 btn btn-primary text-white">Edit</a>
                                        </form>
                                    </div>
                                    </td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="w-100 d-flex ">
                            <form class="p-5 form w-50 m-auto" method="post" action="/WebApp/controller/handleAddUser.php" style="gap: 8px; ">
                                <div class="form-group">
                                    <h3>Add new user: </h3>
                                </div>
                                <div class="form-group">
                                    <label class="form-label ">Full Name:</label>
                                    <input class="form-control" name="name" id="name" placeholder=" Enter full name" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label ">Username:</label>
                                    <input class="form-control" name="username" id="username" placeholder=" Enter username" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label ">Email:</label>
                                    <input class="form-control" name="email" id="email" placeholder=" Enter email" type="email required">
                                </div>
                                <div class="form-group">
                                    <label class="form-label ">Password:</label>
                                    <input class="form-control" name="password" id="password" placeholder=" Enter password" type="password" required>
                                </div>
                                <div class="form-group align-content-end">
                                    <button class="btn btn-danger ">
                                        Clear
                                    </button>
                                    <button class="btn btn-success">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const form = document.querySelector(".form");
            console.log(form)
            let isValid = false;
            const undoBtn = document.querySelectorAll(".undoBtn");
            undoBtn.forEach((btn, index) => {
                btn.onclick = (e) => {
                    location.href = "/WebApp/author";
                }
            })
        </script>
        <?php
        include_once("./pages/components/footer.php");
        ?>
    </div>
</body>

</html>