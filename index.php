<?php
  require 'config.php';
  require 'classes/database.php';
  require 'classes/user.php';
  $conn = require('inc/db.php');
  
  if (!$conn) {
    return;
  }
  $rs = User::authenticate($conn, 'abc', 'abcd12');
  if ($rs) {
    echo 'Login successfully';
    return;
  }
  echo 'Login failed';
?>