<?php
session_start();
include "../utils/routerConfig.php";
session_destroy();
header("Location: " . baseURL("login"));
