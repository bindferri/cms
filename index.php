<?php include "include/header.php"; include "include/db.php"?>

    <!-- Navigation -->
<?php include "include/navigation.php";?>
<?php
$number_posts = 5;
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if (isset($_GET['page'])){
                    $page = $_GET['page'];
                }else {
                    $page = 0;
                }

                if ($page == 0){
                    $page_1 = 0;
                }
                else{
                    $page_1 = ($page * $number_posts) - $number_posts;
                }




                ?>

                <h1 class="page-header">
                    Sport
                </h1>

                <!-- First Blog Post -->
                    <?php
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
                            $admin_query_posts = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1 , $number_posts";
                            $result_posts = mysqli_query($connection, $admin_query_posts);
                            $count_post = "SELECT * FROM posts";
                            $count_post_result = mysqli_query($connection,$count_post);
                            $count = mysqli_num_rows($count_post_result);
                            $count = ceil($count / $number_posts);
                    }
                    else {
                        $query_posts = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1 , $number_posts";
                        $result_posts = mysqli_query($connection, $query_posts);
                        $count_post = "SELECT * FROM posts WHERE post_status = 'published'";
                        $count_post_result = mysqli_query($connection,$count_post);
                        $count = mysqli_num_rows($count_post_result);
                        $count = ceil($count / $number_posts);
                        $post_count = mysqli_num_rows($result_posts);
                        if ($post_count == 0){
                            echo "<h3>There is no post available</h3>";
                        }
                    }
                    while ($row = mysqli_fetch_assoc($result_posts)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                    ?>
                <h2><a href="post/<?php echo $post_id ?>"><?php echo $post_title ?></a> </h2>
                <p class="lead">
                    by <a href="post_author.php?p_author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                        <a href="post.php?p_id=<?php echo $post_id ?>">
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                        </a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

              <?php  }
                ?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "include/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>
        <ul class="pager">
            <?php
            for ($i = 1;$i <= $count;$i++){
                if ($i == $page){
                    echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
                }else{
                    echo "<li><a href='index.php?page=$i'>$i</a></li>";
                }
            }?>
        </ul>
        <?php include "include/footer.php";?>

