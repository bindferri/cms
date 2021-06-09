<?php include "db.php"; include "functions.php";?>

<div class="col-md-4">

    <!-- Blog Search Well -->
    <form action="search.php" method="post">
    <div class="well">
        <h4>Blog Search</h4>
        <div class="input-group">
            <input type="text" class="form-control" name="search">
            <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
        </div>
    </form>
</div>
        <!-- /.input-group -->


                <?php if (isset($_GET['signup'])){
                    require "./vendor/autoload.php";
                    $options = array('cluster' => 'eu', 'useTLS' => true);
                    $pusher = new Pusher\Pusher("7f161754ea956b0d816d","9a4f98d349713bf067dc",1083370,$options);
                    $singup = $_GET['signup'];
                    if (isset($_POST['sign_up'])){
                        $username = trim($_POST['signup_username']);
                        $password = trim($_POST['signup_password']);
                        $firstname = trim($_POST['signup_firstname']);
                        $lastname = trim($_POST['signup_lastname']);
                        $email = trim($_POST['signup_email']);

                        $error = ['signup_username'=>'','signup_password'=>'','signup_firstname'=>'','signup_lastname'=>'','signup_email'=>''];

                        if (strlen($username) < 4){
                            $error['signup_username'] = "Username need to be longer than 4 characters";
                        }
                        if ($username == ''){
                            $error['signup_username'] = "Username cannot be empty";
                        }
                        if (usernameCheck($username)){
                            $error['signup_username'] = "Username already exists";
                        }
                        if (strlen($password) < 8){
                            $error['signup_password'] = "Password need to be longer than 8 characters";
                        }
                        if ($password == ''){
                            $error['signup_password'] = "Password cannot be empty";
                        }
                        if ($email == ''){
                            $error['signup_email'] = "Email cannot be empty";
                        }
                        if (emailCheck($email)){
                            $error['signup_email'] = "Email already exists";
                        }
                        if ($firstname == ''){
                            $error['signup_firstname'] = "Firstname cannot be empty";
                        }
                        if ($lastname == ''){
                            $error['signup_lastname'] = "Lastname cannot be empty";
                        }

                        foreach ($error as $key => $value){
                            if (empty($value)){
                                unset($error[$key]);
                            }
                        }
                        if (empty($error)){
                            signup($username,$password,$firstname,$lastname,$email);
                            $data['message'] = $username;
                            $pusher->trigger('notifications','new_user',$data);
                        }

                    }
                if ($singup == 'true') {?>
                    <div class="well">
                    <div class="row">
        <form action="" method="post">
            <div class="col-lg-12">
                    <div class="form-group">
                        <h4 class="text-center"></h4>
                        <label for="post-author">Username: </label>
                        <input type="text" class="form-control" name="signup_username" autocomplete="on"
                                value="<?php echo isset($username) ? $username : '' ?>">
                        <p><?php echo isset($error['signup_username']) ? $error['signup_username'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="post-author">Password: </label>
                        <input type="password" class="form-control" name="signup_password">
                        <p><?php echo isset($error['signup_password']) ? $error['signup_password'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="post-author">Firstname: </label>
                        <input type="text" class="form-control" name="signup_firstname">
                        <p><?php echo isset($error['signup_firstname']) ? $error['signup_firstname'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="post-author">Lastname: </label>
                        <input type="text" class="form-control" name="signup_lastname">
                        <p><?php echo isset($error['signup_lastname']) ? $error['signup_lastname'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="post-author">Email: </label>
                        <input type="email" class="form-control" name="signup_email">
                        <p class="alert-danger"><?php echo isset($error['signup_email']) ? $error['signup_email'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="sign_up" value="Sign Up">
                    </div>
                    <a href="index.php">Log In</a>
        </form>
    </div>
                    </div>
                    </div>
<?php
                }
                }
                elseif (isset($_GET['forgot']) && $_GET['forgot'] === 'true'){
                    require './vendor/autoload.php';
                    require './classes/Config.php';
                    $reset_message = "Forgot your password?";
                    if (isset($_POST['reset_password'])) {
                        $reset_password_email = $_POST['reset_email'];


                        $error = ['reset_email' => ''];
                        if (!checkEmail($reset_password_email)) {
                            $error['reset_email'] = "Email doesn't exist";
                        }
                        if ($reset_password_email == '') {
                            $error['reset_email'] = "Email cannot be empty";
                        }

                        foreach ($error as $key => $value) {
                            if (empty($value)) {
                                unset($error[$key]);
                            }
                        }
                        if (empty($error)){
                            $token = bin2hex(openssl_random_pseudo_bytes(50));
                            $statment = mysqli_prepare($connection,"UPDATE users SET user_token = '$token' WHERE user_email = ?");
                            mysqli_stmt_bind_param($statment,"s",$reset_password_email);
                            mysqli_stmt_execute($statment);
                            $mail = new PHPMailer\PHPMailer\PHPMailer();

                            $mail->isSMTP();
                            $mail->Host       = Config::SMTP_HOST;
                            $mail->SMTPAuth   = true;
                            $mail->Username   = Config::SMTP_USER;
                            $mail->Password   = Config::SMTP_PASSWORD;
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = Config::SMTP_PORT;
                            $mail->isHTML(true);
                            $mail->setFrom('bindferri@gmail.com','Bind Ferri');
                            $mail->addAddress($reset_password_email);
                            $mail->Subject = 'Hello from Brindowllo';
                            $mail->Body = '<p>Please confirm that you want to reset your password by clicking in this link: 
                                                <a href="http://localhost/cms/index.php?email='.$reset_password_email.'&token='.$token.'">Click Here</a></p>';
                            $mail->CharSet = 'UTF-8';

                            if ($mail->send()){
                                $reset_message = "Mail was sent successfully";
                            }else{
                                $reset_message = "Mail failed to sent";
                            }
                        }

                    }
?>
<div class="well">
    <div class="row">
        <form action="" method="post">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="form-group">
                        <h2><?php echo $reset_message ?></h2>
                        <label for="post-author">Email: </label>
                        <input type="email" class="form-control" name="reset_email">
                        <p class="alert-danger"><?php echo isset($error['reset_email']) ? $error['reset_email'] : '' ?></p>
                        <button class="btn btn-primary" name="reset_password">Reset Password</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
                    <?php }elseif (isset($_GET['email']) && $_GET['token']){
                            $new_password_message = "Reset your password";
                            $reset_token = $_GET['token'];
                            $reset_email = $_GET['email'];
                            $count = 0;
                            $query = "SELECT * FROM users";
                            $select_query = mysqli_query($connection,$query);
                            while ($select_row = mysqli_fetch_assoc($select_query)){
                                $db_token = $select_row['user_token'];
                                $db_email = $select_row['user_email'];

                                if ($reset_token == $db_token && $reset_email == $db_email){
                                    $count++;
                                }
                            }
                            if ($count < 1){
                                echo '<script type="text/javascript">
           window.location = "index.php"
      </script>';
                            }

                            if (isset($_POST['new_password'])) {
                                $new_password = $_POST['new_password1'];
                                $confirm_new_password = $_POST['confirm_new_password'];

                                if ($new_password == $confirm_new_password) {
                                    $reset_password_statment = mysqli_prepare($connection, "UPDATE users SET user_token = '',user_password = ? WHERE user_email = ?");
                                    mysqli_stmt_bind_param($reset_password_statment, "ss", $confirm_new_password, $reset_email);
                                    mysqli_stmt_execute($reset_password_statment);
                                    $new_password_message = "Your password has successfully reseted";
                                }else{
                                    $new_password_message = "Password doesn't match";
                                }
                            }
                                    
                    ?>
                    <div class="well">
                        <div class="row">
                            <form action="" method="post">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <h2><?php echo $new_password_message; ?></h2>
                                            <label for="new-password">New Password: </label>
                                            <input type="password" class="form-control" name="new_password1">
                                            <p class="alert-danger"><?php echo isset($error['reset_email']) ? $error['reset_email'] : '' ?></p>
                                            <label for="confirm-new-password">Confirm New Password: </label>
                                            <input type="password" class="form-control" name="confirm_new_password">
                                            <p class="alert-danger"><?php echo isset($error['reset_email']) ? $error['reset_email'] : '' ?></p>
                                            <button class="btn btn-primary" name="new_password" value="reset password">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
               <?php }
                else{?>
                    <?php
                    if (isset($_SESSION['user_role'])){

                    }
                    else{
                    if (isset($_POST['sign_in'])) {
                        $login_username = trim($_POST['login_username']);
                        $login_password = trim($_POST['login_password']);

                        $error = ['login_username'=>'', 'login_password'=>''];

                        if ($login_username == '') {
                            $error['login_username'] = "Username cannot be empty";
                        }
                        if ($login_password == '') {
                            $error['login_password'] = "Password cannot be empty";
                        }
                        if (checkLogin($login_username,$login_password)){
                            $error['login_password'] = "Password doesn't match with username";
                        }
                        if (checkUser($login_username)){
                            $error['login_username'] = "Username doesn't exist";
                        }
                        foreach ($error as $key => $value){
                            if (empty($value)){
                                unset($error[$key]);
                            }
                        }


                    }
                    ?>
<div class="well">
    <div class="row">
        <form action="/cms/admin/include/login.php" method="post">
            <div class="col-lg-12">
                    <div class="form-group">
                        <label for="post-author">Username: </label>
                        <input type="text" class="form-control" name="login_username">
                        <p><?php echo isset($error['login_username']) ? $error['login_username'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="post-author">Password: </label>
                        <input type="password" class="form-control" name="login_password">
                        <p><?php echo isset($error['login_password']) ? $error['login_password'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="sign_in" value="Sign In">
                    </div>
                <div class="col-lg-6">
                    <a href="index.php?signup=true">Sign Up</a>
                </div>
                <div class="col-lg-6">
                    <a href="index.php?forgot=true">Forgot Password?</a>
                </div>
            </div>
    </div>
        </form>
</div>

               <?php }}?>


        <!-- /.col-lg-6 -->
        <!-- /.col-lg-6 -->
    <!-- /.row -->


    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php
                    $query = "SELECT * FROM categories";
                    $categories_result = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($categories_result)){
                        $category = $row['category_name'];
                        $category_id = $row['category_id'];
                        echo "<li><a href='/cms/category/$category_id'> $category</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
    </div>

</div>