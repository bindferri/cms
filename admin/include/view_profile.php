<?php
if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $get_profile_query = "SELECT * FROM users WHERE user_id = '$user_id'";
    $get_profile_result = mysqli_query($connection,$get_profile_query);

    while ($read_user_row = mysqli_fetch_assoc($get_profile_result)){
        $username = $read_user_row['username'];
        $user_password = $read_user_row['user_password'];
        $user_firstname = $read_user_row['user_firstname'];
        $user_lastname = $read_user_row['user_lastname'];
        $user_email = $read_user_row['user_email'];
        $user_image = $read_user_row['user_image'];
        $user_role = $read_user_row['user_role'];
    }
}
if (isset($_POST['update_user'])) {
    $new_username = $_POST['username'];
    $new_user_password = $_POST['password'];
    $new_user_firstname = $_POST['firstname'];
    $new_user_lastname = $_POST['lastname'];
    $new_user_email = $_POST['email'];
    $new_user_image = $_FILES['user_image']['name'];
    $new_user_image_temp= $_FILES['user_image']['tmp_name'];
    $new_user_role = $_POST['user_role'];

    move_uploaded_file($new_user_image_temp, "../images/$new_user_image");
    if (empty($new_user_image)){
        $empty_image_query = "SELECT * FROM users WHERE user_id = '$user_id'";
        $empty_image_result = mysqli_query($connection,$empty_image_query);
        while ($row_empty_image = mysqli_fetch_array($empty_image_result)){
            $new_user_image = $row_empty_image['user_image'];
        }
    }

    $update_query = "UPDATE users SET username = '$new_username' , user_password = '$new_user_password',
                 user_firstname = '$new_user_firstname', user_lastname = '$new_user_lastname' , user_email = '$new_user_email' ,
                 user_image = '$new_user_image' , user_role = '$new_user_role'
                 WHERE user_id = '$user_id'";
    $update_result = mysqli_query($connection, $update_query);

    header("Location: profile.php");

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <h3>Role: <?php echo $user_role ?></h3>
    </div>

    <div class="form-group">
        <label for="category-id">Firstname: </label>
        <input type="text" value="<?php echo $user_firstname?>" class="form-control" name="firstname">
    </div>
    <div class="form-group">
        <label for="post-author">Lastname: </label>
        <input type="text" value="<?php echo $user_lastname?>" class="form-control" name="lastname">
    </div>
    <div class="form-group">
        <label for="post-status">Email: </label>
        <input type="email" value="<?php echo $user_email?>" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label for="post-title">Username: </label>
        <input type="text" value="<?php echo $username?>" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="post-title">Password: </label>
        <input type="password" value="<?php echo $user_password?>"class="form-control" name="password">
    </div>
    <div class="form-group">
        <label for="post-image">User Image: </label><br>
        <img width="100" src="../images/<?php echo $user_image?>">
        <input type="file" name="user_image">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
    </div>

</form>