<?php
session_start();
include "../config.php";
session_destroy();
$_SESSION['guest'] = true;
header("Location: " . BASE_URL . '/login');
