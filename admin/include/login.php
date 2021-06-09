<?php include "../../include/db.php";?>
<?php include "../../functions.php"?>
<?php session_start(); ?>
<?php

if (isset($_POST['sign_in'])){
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];

    login_user($login_username,$login_password);

}
?>