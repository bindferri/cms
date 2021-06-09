<?php
function countRows($table){
    global $connection;
    $query = "SELECT * FROM " . $table;
    $query_result = mysqli_query($connection,$query);
    $post_count = mysqli_num_rows($query_result);
    return $post_count;
}
function countRows2($table,$row,$command){
    global $connection;
    $query2 = "SELECT * FROM $table WHERE $row = '$command' ";
    $query_results2 = mysqli_query($connection,$query2);
    $count2 = mysqli_num_rows($query_results2);
    return $count2;
}
function countRows3($table,$row,$command,$row2,$command2){
    global $connection;
    $query2 = "SELECT * FROM $table WHERE $row = '$command' AND $row2 = '$command2'";
    $query_results2 = mysqli_query($connection,$query2);
    $count2 = mysqli_num_rows($query_results2);
    return $count2;
}
function usernameCheck($username){
    global $connection;
    $query = "SELECT username FROM users";
    $query_result = mysqli_query($connection, $query);
    $count = 0;

    while ($row = mysqli_fetch_assoc($query_result)) {
        $username2 = $row['username'];
        if ($username == $username2) {
            $count++;
        }
    }
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}
function emailCheck($email){
    global $connection;
    $query = "SELECT user_email FROM users";
    $query_result = mysqli_query($connection,$query);
    $count = 0;

    while ($row = mysqli_fetch_assoc($query_result)){
        $email2 = $row['user_email'];
        if ($email == $email2){
            $count++;
        }
    }
    if ($count > 0){
        return true;
    }else{
        return false;
    }
}
function signup($username,$password,$firstname,$lastname,$email)
{
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname = mysqli_real_escape_string($connection, $lastname);
    $email = mysqli_real_escape_string($connection, $email);

    if (!empty($username) && !empty($password) && !empty($firstname) && !empty($lastname) && !empty($email)) {
        if (!usernameCheck($username)) {
            if (!emailCheck($email)) {
                $signup_query = "INSERT INTO users (username,user_password,user_firstname,user_lastname,user_email,user_role)
                                            VALUES ('$username','$password','$firstname','$lastname','$email','Subscriber')";
                $signup_query_result = mysqli_query($connection, $signup_query);
            }
        }
    }
}
function login_user($login_username,$login_password){
    global $connection;

    $login_username = trim(mysqli_real_escape_string($connection,$login_username));
    $login_password = trim(mysqli_real_escape_string($connection,$login_password));

    $validation_query = "SELECT * FROM users WHERE username = '$login_username'";
    $validation_result = mysqli_query($connection,$validation_query);
    while ($row = mysqli_fetch_assoc($validation_result)){
        $username = $row['username'];
        $password = $row['user_password'];
        $role = $row['user_role'];
        $user_id = $row['user_id'];
        $user_email = $row['user_email'];
    }
    if (($login_username == $username) && ($login_password == $password) ){
        $_SESSION['username'] = $login_username;
        $_SESSION['user_role'] = $role;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $user_email;
        $online_query = "UPDATE users SET user_status = 'online' WHERE user_id = '$user_id'";
        $online_query_result = mysqli_query($connection,$online_query);
        header("Location: ../index.php");
    }
    else {
        header("Location: ../../index.php");
    }
}
function checkLogin($username,$password){
    global $connection;
    $query = "SELECT * FROM users WHERE username = '$username'";
    $query_result = mysqli_query($connection,$query);

    while ($row = mysqli_fetch_assoc($query_result)){
        $db_password = $row['user_password'];
        $db_username = $row['username'];

        if ($username == $db_username && $password != $db_password){
            return true;
        }
    }
}
function checkUser($username){
global $connection;
$query = "SELECT * FROM users";
$query_result = mysqli_query($connection,$query);

while ($row = mysqli_fetch_assoc($query_result)){
    $db_username = $row['username'];

    if ($username != $db_username){
        return true;
    }
    else {
        return false;
    }
}
}
function checkEmail($email){
    global $connection;
    $count = 0;
    $query = "SELECT * FROM users";
    $query_result = mysqli_query($connection,$query);

    while ($row = mysqli_fetch_assoc($query_result)){
        $db_email = $row['user_email'];

        if ($email == $db_email){
            $count++;
        }
    }
    if ($count > 0){
        return true;
    }else{
        return false;
    }
}
?>

