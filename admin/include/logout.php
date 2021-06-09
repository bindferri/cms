<?php include "../../include/db.php"?>
<?php session_start(); ?>
<?php
$username = $_SESSION['user_id'];
session_destroy();
$offline_query = "UPDATE users SET user_status = 'offline' WHERE user_id = '$username'";
$offline_query_status = mysqli_query($connection,$offline_query);
unset($_SESSION['username']);
unset($_SESSION['user_role']);
unset($_SESSION['user_id']);

header("Location: ../../index.php");
?>