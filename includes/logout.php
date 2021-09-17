<?php include "db.php" ?>

<?php session_start(); ?>

<?php
    $_SESSION["username"] = null;
    $_SESSION["user_first_name"] = null;
    $_SESSION["user_last_name"] = null;
    $_SESSION["user_role"] = null;
    $_SESSION["id"] = null;
    $_SESSION["user_email"] = null;

    header("Location: ../index.php");
?>
