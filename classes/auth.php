<?php
include "./user.php";
class Auth
{
    /*
            Kiểm tra đăng nhập
        */
    public static function isLoggedIn()
    {
        return isset($_SESSION['is_login']) && $_SESSION['is_login'];
    }
    /*
            Bắt buộc đăng nhập
        */
    public static function requireLogin()
    {
        if (!static::isLoggedIn()) {
            die('Please login to continue!');
        }
    }

    public static function logout()
    {
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}
