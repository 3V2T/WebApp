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
if (!isset($_GET["id"])) {
    header("Location: " . baseURL("error"));
}

$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
?>
<?php
include_once("../js/bootstrapConfig.php");
include_once("./components/header.php");
$user;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $user = User::getById($connection, $id);
}
?>
<div class="w-100 d-flex ">
    <?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $user = User::getById($connection, $id);
        echo '<form class="p-5 form w-50 m-auto" method="post" action="'.BASE_URL.'/controller/handleUpdateUser.php?id=' . $id . '" style="gap: 8px; ">
            <div class="form-group">
                <h3>User ' . $id . ':</h3>
                </div>  
                <div class="form-group">
                    <label class="form-label ">Full Name:</label>
                    <input class="form-control" name="name" id="name" placeholder="Enter full name" required value="' . $user->name . '">
                </div>
                <div class="form-group">
                    <label class="form-label ">Username:</label>
                    <div class="p-2">' . $user->username . '
                    </div>
                    <input class="d-none" value=' . $user->username . ' name="username">
                </div>
                <div class="form-group">
                    <label class="form-label ">Email:</label>
                    <input class="form-control" name="email" id="email" placeholder="Enter email" type="email" value="' . $user->email . '" required>
                </div>
                <div class="form-group">
                    <label class="form-label ">New Password:</label>
                    <input class="form-control" name="password" id="password" placeholder="Enter new password" type="password">
                </div>
                <div class="form-group align-content-end">
                    <button class="btn btn-primary"onclick="location.reload();" >
                        Undo
                    </button>
                    <button class="btn btn-success">
                        Save
                    </button>
                </div>';
    }
    ?>
    </form>
</div>

<?php
include_once("./components/footer.php");
?>