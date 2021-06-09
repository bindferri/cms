<?php  include "include/db.php"; ?>
<?php  include "include/header.php"; ?>
<?php
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'> location.reload(); </script>";
    }
}
    if (isset($_SESSION['lang'])){
        include "include/languages/".$_SESSION['lang'].".php";
    }else{
        include "include/languages/en.php";
    }

?>

<!-- Navigation -->

<?php  include "include/navigation.php"; ?>
<?php

if (isset($_POST['submit'])){
    $to = "leagueoflegendstv0@gmail.com";
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $header = $_POST['email'];

    mail($to,$subject,$body,$header);
}
?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">


                        <form method="get" class="navbar-form navbar-right" action="" id="language_form">
                        <div class="form-group">
                            <label for="language">Language: </label>
                            <select name="lang" class="form-control" onchange="changeLanguage()">
                                <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){echo "selected";} ?>>English</option>
                                <option value="al" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'al'){echo "selected";} ?>>Albanian</option>
                            </select>
                        </div>
                        </form>
                        <h1><?php echo _CONTACT ?></h1>
                        <form role="form" action="" method="post">


                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL ?>">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="<?php echo _SUBJECT ?>">
                            </div>
                            <div class="form-group">
                                <textarea placeholder="<?php echo _TEXT ?>" name="body" id="body" cols="50" rows="10" class="form-control"></textarea>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>

    <script>
        function changeLanguage(){
            document.getElementById('language_form').submit();
        }
    </script>

<?php include "include/footer.php";?>