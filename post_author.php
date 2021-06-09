<?php include "include/header.php"; include "include/db.php"?>

    <!-- Navigation -->
<?php include "include/navigation.php";?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                <?php if (isset($_GET['p_author'])){
                    $p_author = $_GET['p_author'];
                    echo $p_author; } ?>
                <small>Gazetar Sporti</small>
            </h1>
            <!-- First Blog Post -->
            <?php
            if (isset($_GET['p_author'])){
                $p_author = $_GET['p_author'];
            }
            $query_posts = "SELECT * FROM posts WHERE post_author = '$p_author'";
            $result_posts = mysqli_query($connection,$query_posts);
            while ($row_author = mysqli_fetch_assoc($result_posts)){
                $post_id = $row_author['post_id'];
                $post_title = $row_author['post_title'];
                $post_author = $row_author['post_author'];
                $post_date = $row_author['post_date'];
                $post_image = $row_author['post_image'];
                $post_content = $row_author['post_content'];
                ?>

                <h2><a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a> </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            <?php  }
            ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "include/sidebar.php";?>

    </div>
    <!-- /.row -->

    <hr>
<?php include "include/footer.php";?>