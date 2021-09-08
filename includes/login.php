<?php include "db.php" ?>
<?php include_once "../admin/functions.php" ?>
<?php session_start(); ?>
<?php 
    if(isset($_POST["login"])) {
        $username = $_POST["username"];
        $user_password = $_POST["password"];
        login_user($username, $user_password);
    }
?>
