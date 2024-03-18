<!-- Kiểm tra người dùng đăng nhập chưa -->
<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/book.php";
include "../classes/author.php";
include "../config.php";
include "../classes/category.php";
include "../classes/user.php";
include "../classes/wishlist.php";
$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
if ($slug != "login") {
    if (!isset($_SESSION["is_login"])) {
        header("Location: " . baseURL("login"));
    }
}
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
$user = User::getById($connection, $_SESSION["id_user"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    include_once("../js/bootstrapConfig.php");
    ?>
    <div class="main-container">
        <?php
        include_once("./components/header.php");
        ?>
        <div class="container min-vh-100">
            <?php
            if (isset($_GET['change'])) {
                $action = $_GET['change'];
                if ($action == "info") {
                    echo '<h2 class="pt-4 pb-4">Thay đổi thông tin</h2>
                <div class="row pt-4 pb-4 gap-4">
                    <div class="col-12 h-100 row p-5" style="box-shadow: 2px 2px 5px 2px #cccc; border-radius: 12px;">
                        <div class="col-md-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/10412/10412383.png " alt="Ảnh đại diện" class="img-fluid rounded-circle">
                        </div>
                        <form method="post" action="../controller/handleChangeInfo.php" class="col-md-10">
                            <div class="form-group">
                            <strong class="mb-4" for="name">Tên đầy đủ:</strong>
                            <input type="text" class="form-control" name="name" id="name" value="' . $user->name . '" required>
                            </div>
                            <div class="form-group">
                                <strong class="mb-4" for="email">Email:</strong>
                                <input type="email" class="form-control" name="email" id="email" value="' . $user->email . '" required>
                            </div>
                            <div class="form-group">
                                <strong class="mb-4" for="password">Nhập password để xác nhận:</strong>
                                <input type="password" class="form-control" name="password" id="password" value="" required>
                            </div>
                            <button type="reset" class="cancel btn btn-outline-danger">Cancel</button>
                            <button type="submit" class="password btn btn-outline-success">Save</button>
                        </form> 
                        <script>
                        const cancelBtn = document.querySelector(".cancel");
                        cancelBtn.onclick = (e) => {
                            location.href = "me.php";
                        }
                        </script>
                    </div>
                </div>';
                } else if ($action == "password") {
                    echo '<h2 class="pt-4 pb-4">Thay đổi mật khẩu</h2>
                <div class="row pt-4 pb-4 gap-4">
                    <div class="col-12 h-100 row p-5" style="box-shadow: 2px 2px 5px 2px #cccc; border-radius: 12px;">
                        <div class="col-md-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/10412/10412383.png " alt="Ảnh đại diện" class="img-fluid rounded-circle">
                        </div>
                        <form method="post" action="../controller/handleChangePassword.php" class="col-md-10">
                            <div class="form-group">
                                <strong class="mb-4" for="newPassword">Nhập password mới: </strong>
                                <input type="password" class="form-control" name="newPassword" id="newPassword" value="" required>
                            </div>
                            <div class="form-group">
                                <strong class="mb-4" for="newPassword">Nhập lại password mới: </strong>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" value="" required>
                            </div>
                            <div class="form-group">
                                <strong class="mb-4" for="password">Nhập password hiện tại để xác nhận:</strong>
                                <input type="password" class="form-control" name="password" id="password" value="" required>
                            </div>
                            <button type="reset" class="cancel btn btn-outline-danger">Cancel</button>
                            <button type="submit" class="password btn btn-outline-success">Save</button>
                        </form> 
                        <script>
                        const cancelBtn = document.querySelector(".cancel");
                        cancelBtn.onclick = (e) => {
                            location.href = "me.php";
                        }
                        </script>
                    </div>
                </div>';
                }
            } else {
                echo '<h2 class="pt-4 pb-4">Thông tin cá nhân</h2>
                <div class="row pt-4 pb-4 gap-4">
                    <div class="col-12 h-100 row p-5" style="box-shadow: 2px 2px 5px 2px #cccc; border-radius: 12px;">
                        <div class="col-md-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/10412/10412383.png " alt="Ảnh đại diện" class="img-fluid rounded-circle">
                        </div>
                        <div class="col-md-10">
                            <h1>' . $user->name . '</h1>
                            <p><strong>Tên người dùng: </strong>' . $user->username . '</p>
                            <p><strong>Email: </strong> ' . $user->email . '</p>
                            <button class="info btn btn-outline-primary">Change info</button>
                            <button class="password btn btn-outline-primary">Change password</button>
                        </div>
                    </div>
                    <script>
                        const infoBtn = document.querySelector(".info");
                        const passwordBtn = document.querySelector(".password");
                        infoBtn.onclick = (e) => {
                            location.href = "me.php?change=info";
                        }
                        passwordBtn.onclick = (e) => {
                            location.href = "me.php?change=password";
                        }
                    </script>
                </div>';
            }

            ?>
        </div>
        <?php
        include_once("./components/footer.php");
        ?>
    </div>
</body>

</html>