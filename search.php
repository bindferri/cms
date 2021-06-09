<?php include "include/header.php"; include "include/db.php"?>

    <!-- Navigation -->
<?php include "include/navigation.php";?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                    <?php


                    if (isset($_POST['submit'])) {
                        $search = $_POST['search'];
                        $search_query = "SELECT * FROM posts WHERE post_tags LIKE '$search%' OR post_author LIKE '$search%'";
                        $search_result = mysqli_query($connection, $search_query);

                    $count = mysqli_num_rows($search_result);
                    if ($count == 0){
                        echo "Nothing found.";
                    }else{
                    while ($row = mysqli_fetch_assoc($search_result)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                    ?>
                <h2><a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a> </h2>
                <p class="lead">
                    by <a href="post_author.php?p_author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

              <?php
                }
              }
            }
                ?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "include/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>
        <?php include "include/footer.php";?>

