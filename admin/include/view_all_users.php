<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Image</th>
        <th>Role</th>
    </tr>
    </thead>
    <tbody>
    <?php


    $read_users_query = "SELECT * FROM users";
    $read_users_result = mysqli_query($connection,$read_users_query);
    while ($read_users_row = mysqli_fetch_assoc($read_users_result)){
        $user_id = $read_users_row['user_id'];
        $username = $read_users_row['username'];
        $user_password = $read_users_row['user_password'];
        $user_firstname = $read_users_row['user_firstname'];
        $user_lastname = $read_users_row['user_lastname'];
        $user_email = $read_users_row['user_email'];
        $user_image = $read_users_row['user_image'];
        $user_role = $read_users_row['user_role'];
        ?>


        <tr>
            <td><?php echo $user_id ?></td>
            <td><?php echo $username?></td>
            <td><?php echo $user_password?></td>
            <td><?php echo $user_firstname?></a></td>
            <td><?php echo $user_lastname?></td>
            <td><?php echo $user_email?></td>
            <td><?php echo "<img width='100' src='../images/$user_image'>"?></td>
            <td><?php echo $user_role?></td>
            <td><a href="users.php?admin=<?php echo $user_id ?>">Admin</a> </td>
            <td><a href="users.php?subscriber=<?php echo $user_id ?>">Subscriber</a> </td>
            <td><a href="users.php?source=edit_user&u_id=<?php echo $user_id ?>">Edit</a> </td>
            <td><a href="users.php?delete=<?php echo $user_id ?>">Delete</a> </td>
        </tr>
    <?php  }
    ?>
    </tbody>
</table>
<?php
if (isset($_GET['delete'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $delete_id = $_GET['delete'];
            $delete_query = "DELETE FROM users WHERE user_id = $delete_id";
            $delete_result = mysqli_query($connection, $delete_query);
            header("Location: users.php");
        }
    }
}
if (isset($_GET['admin'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $admin_id = $_GET['admin'];
            $admin_query = "UPDATE users SET user_role = 'Admin' WHERE user_id = '$admin_id'";
            $admin_role_result = mysqli_query($connection, $admin_query);
            header("Location: users.php");
        }
    }
}
if (isset($_GET['subscriber'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $subscriber_id = $_GET['subscriber'];
            $subscriber_query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = '$subscriber_id' ";
            $subscriber_role_result = mysqli_query($connection, $subscriber_query);
            header("Location: users.php");
        }
    }
}
?>