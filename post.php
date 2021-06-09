<?php include "include/header.php"; include "include/db.php"?>
<?php include "include/db.php"; ?>
<!-- Navigation -->
<?php include "include/navigation.php";?>
<?php
if (isset($_POST['liked'])){
    echo "<h1>ITS WORKING</h1>";
}
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <!-- First Blog Post -->
            <?php
            if (isset($_GET['p_id'])) {
                $p_id = $_GET['p_id'];
                $view_count_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '$p_id'";
                $view_count_query_result = mysqli_query($connection,$view_count_query);
            }
            $query_posts = "SELECT * FROM posts WHERE post_id = $p_id";
            $result_posts = mysqli_query($connection,$query_posts);
            while ($row = mysqli_fetch_assoc($result_posts)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                ?>
                <h2><a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a> </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="/cms/images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
                <div class="row">
                    <p class="text-center"><a class="like" href="#"><span class="glyphicon glyphicon-thumbs-up">Like</span></a></p>
                </div>
                <div class="row">
                    <p class="text-center">Like: 10</p>
                </div>
                <hr>
            <?php  }
            ?>

            <!-- Blog Comments -->
            <?php
            if (isset($_POST['comment_submit'])) {
                $comment = $_POST['comment'];
                $comment_email = isset($_POST['comment_email']);
                $comment_author = isset($_POST['comment_author']);

                    if (isset($_SESSION['user_role'])){
                        $session_username = $_SESSION['username'];
                        $session_email = $_SESSION['user_email'];
                        $comment = $_POST['comment'];
                        $insert_comment = "INSERT INTO comments (comment_post_id , comment_author , comment_email , comment_content , comment_status,comment_date) 
                                   VALUES ('$p_id' ,'$session_username','$session_email','$comment','not approved',now())";
                    $insert_comment_result = mysqli_query($connection, $insert_comment);
                    }elseif (!empty($comment_email) && !empty($comment) && !empty($comment_author)){
                    $insert_comment = "INSERT INTO comments (comment_post_id , comment_author , comment_email , comment_content , comment_status,comment_date) 
                                   VALUES ('$p_id' , '$comment_author','$comment_email','$comment','not approved',now())";
                    $insert_comment_result = mysqli_query($connection, $insert_comment);
                    } else {
                    echo "<script>alert('Fields cannot be empty') </script>";
            }
            }
            ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <br>
                <form role="form" action="" method="post">
                    <?php if (!isset($_SESSION['user_role'])) { ?>
                    <div class="form-group">
                        <label for="comment-author">Author: </label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="comment-email">Email: </label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="comment">Comment: </label>
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="comment_submit">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->
            <?php
            $show_comments = "SELECT * FROM comments WHERE comment_post_id = '$p_id' AND comment_status = 'approved' ORDER BY comment_id DESC ";
            $show_comments_result = mysqli_query($connection,$show_comments);
            while ($row_show_comments = mysqli_fetch_assoc($show_comments_result)){
                $comment_author = $row_show_comments['comment_author'];
                $comment_date = $row_show_comments['comment_date'];
                $comment_content = $row_show_comments['comment_content'];
                ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author ?>
                        <small><?php echo $comment_date ?></small>
                    </h4>
                    <?php echo $comment_content ?>
                </div>
            </div>


           <?php }
            ?>


            <!-- Comment -->
<!--            <div class="media">-->
<!--                <a class="pull-left" href="#">-->
<!--                    <img class="media-object" src="http://placehold.it/64x64" alt="">-->
<!--                </a>-->
<!--                <div class="media-body">-->
<!--                    <h4 class="media-heading">Start Bootstrap-->
<!--                        <small>August 25, 2014 at 9:30 PM</small>-->
<!--                    </h4>-->
<!--                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.-->
<!--                    <-- Nested Comment -->
<!--                    <div class="media">-->
<!--                        <a class="pull-left" href="#">-->
<!--                            <img class="media-object" src="http://placehold.it/64x64" alt="">-->
<!--                        </a>-->
<!--                        <div class="media-body">-->
<!--                            <h4 class="media-heading">Nested Start Bootstrap-->
<!--                                <small>August 25, 2014 at 9:30 PM</small>-->
<!--                            </h4>-->
<!--                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <-- End Nested Comment -->
<!--                </div>-->
<!--            </div>-->

        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "include/sidebar.php";?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include "include/footer.php";?>
    <script>
        $(document).ready(function () {
            var post_id = <?php echo $post_id ?>
            var user_id = 2;

        $('.like').click(function () {
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $post_id ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });
        });
    </script>

