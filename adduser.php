<?php
    // require "config.php";
    // require "classes/database.php";
    // require "classes/user.php";
    require "inc/init.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = require "inc/db.php";

        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Tạo đối tượng User mới
        $user = new User($username, $password);
       try{ if ($user->addUser($conn)) {
        echo "Added user successfully";
    } else {
        echo "Cannot add user";
    }}
     catch(PDOException $e){
        echo $e->getMessage();}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My bookstore</title>
</head>
<body>
    <h2>Add new User</h2>
    <form name="frmADDUSER" method="POST">
        <fieldset>
            <legend>User information</legend>
            <p>
                <label for="username">User name:</label>
                <input type="text" name='username' id='username' placeholder="User name" >
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" name='password' id='password' placeholder="Password" >
            </p>
            <input type="submit" Submit>
        </fieldset>
    </form>
</body>
</html>