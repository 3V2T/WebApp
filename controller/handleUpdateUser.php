<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/user.php";
include "../classes/author.php";
include "../classes/wishlist.php";
include_once("../js/bootstrapConfig.php");
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
if (isset($_POST['name']) && isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST["email"];
    $id =  $_GET["id"];
    $user = User::getById($connection, $id);
    if ($_POST["password"] != "") {
        try {
            $password = $_POST["password"];
            $user_update = new User(1, $user->username, $name, $password, $email);
            User::update($connection, $user_update, $user->id);
            User::updatePassword($connection, $user_update, $id);
            echo "<script>alert('Update người dùng thành công!');
            </script>";
            echo '<div class="min-vw-100 min-vh-100 d-flex">
                <div class="modal m-auto position-relative" tabindex="-1" role="dialog" style="display:block">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Notice</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4 class="text-success">Update user successfully!</h4>
                                <div class="d-flex">
                                    <div class="p-2 font-weight-bold">Username: </div>
                                    <div class="p-2 font-italic">' . $user->username . '</div>
                                </div>
                                <div class="d-flex">
                                    <div class="p-2 font-weight-bold">Password: </div>
                                    <div class="p-2 font-italic">' . $password . '</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-danger text-white" href="' . BASE_URL . '/home">Go Home</a>
                                <a type="button" class="btn btn-primary text-white" data-dismiss="modal" href="' . BASE_URL . '/user">Add
                                    New</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        } catch (\Throwable $e) {
            echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '" . BASE_URL . "/pages/info.php?id=" . $id . "'
            </script>";
        }
    } else {
        try {
            $user_update = new User(1, $user->username, $name, "", $email);
            User::update($connection, $user_update, $user->id);
            echo "<script>alert('Update người dùng thành công!');
                location.href = '" . BASE_URL . "/pages/info.php?id=" . $id . "'
            </script>";
        } catch (\Throwable $e) {
            echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '" . BASE_URL . "/pages/info.php?id=" . $id . "'
            </script>";
        }
    }
}
