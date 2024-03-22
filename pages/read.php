<?php
session_start();
include_once "../utils/routerConfig.php";
$slug = getSlugFromUrl($_SERVER['REQUEST_URI']);
if (!isset($_GET['name'])) {
    header("Location: " . BASE_URL . "/error");
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
