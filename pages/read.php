<?php
session_start();
include_once "../utils/routerConfig.php";
$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
if ($slug != "login") {
    if (!isset($_SESSION["user_id"])) {
        header("Location: " . baseURL("login"));
    }
}
$name = $_GET['name'];
if (isset($name)) {
    $file = '../uploads/books/' . $name;
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo 'File không tồn tại.';
    }
} else {
    if (isset($_GET['type'])) {
        $value = $_GET['type'];
        echo $value;
    }
}