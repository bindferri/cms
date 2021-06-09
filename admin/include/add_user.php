<?php
if (isset($_POST['create_user'])){
    $user_role = $_POST['user_role'];
    $user_firstname = $_POST['firstname'];
    $user_lastname = $_POST['lastname'];
    $user_email = $_POST['email'];
    $username = $_POST['username'];
    $user_password = $_POST['password'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_temp,"../images/$user_image");

    $add_user_query = "INSERT INTO users (username,user_password,user_firstname,user_lastname,user_email,
                        user_image,user_role,user_status) VALUES ('$username','$user_password','$user_firstname',
                        '$user_lastname','$user_email','$user_image','$user_role','offline')";
    $add_user_result = mysqli_query($connection,$add_user_query);
    echo "User Added Successfully";
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post-content">Role: </label>
        <select name="user_role" id="">
            <option value="Subscriber">Subscriber</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
    <div class="form-group">
        <label for="category-id">Firstname: </label>
        <input type="text" class="form-control" name="firstname">
    </div>
    <div class="form-group">
        <label for="post-author">Lastname: </label>
        <input type="text" class="form-control" name="lastname">
    </div>
    <div class="form-group">
        <label for="post-status">Email: </label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label for="post-title">Username: </label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="post-title">Password: </label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
        <label for="post-image">User Image: </label>
        <input type="file" name="user_image">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>

</form>
