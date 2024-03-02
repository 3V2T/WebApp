<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/user.php";
include "../classes/author.php";
include_once("../js/bootstrapConfig.php");
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();
if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $isExist = User::getByName($connection, $username);
        if ($isExist) {
            echo "<script>alert('Người dùng đã tồn tại vui lòng thử lại!');
                location.href = '/WebApp/user'
            </script>";
        } else {
            try {
                $user = new User(1, $username, $name, $password_hash, $email);
                User::add($connection, $user);
                echo "<script>alert('Thêm người dùng thành công!');
                    </script>
                    ";
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
                                <h4 class="text-success">Add user successfully!</h4>
                                <div class="d-flex">
                                    <div class="p-2 font-weight-bold">Username: </div>
                                    <div class="p-2 font-italic">' . $username . '</div>
                                </div>
                                <div class="d-flex">
                                    <div class="p-2 font-weight-bold">Password: </div>
                                    <div class="p-2 font-italic">' . $password . '</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-danger text-white" href="/WebApp/home">Go Home</a>
                                <a type="button" class="btn btn-primary text-white" data-dismiss="modal" href="/WebApp/user">Add
                                    New</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            } catch (\Throwable $e) {
                echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
                        location.href = '/WebApp/user'
                    </script>";
            }
        }
    } catch (\Throwable $e) {
        echo "<script>alert('Đã xảy ra lỗi vui lòng thử lại!');
                location.href = '/WebApp/user'
            </script>";
    }
}
