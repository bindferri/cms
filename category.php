<?php include "include/header.php"; include "include/db.php"?>
    <!-- Navigation -->
<?php include "include/navigation.php";?>
<?php
$number_pages = 3;
if (isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 0;
}
if ($page == 0){
    $page_number = 0;
}else{
    $page_number = ($page * $number_pages) - $number_pages;

}
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">



                <!-- First Blog Post -->
                    <?php
                    if (isset($_GET['cat_id'])){
                        $category_id = $_GET['cat_id'];
                    }

                        $category_title_query = "SELECT * FROM categories WHERE category_id = '$category_id'";
                        $category_title_result = mysqli_query($connection, $category_title_query);
                        while ($row_category_title = mysqli_fetch_assoc($category_title_result)) {
                            $cat_id = $row_category_title['category_id'];
                            $cat_title = $row_category_title['category_name'];
                        }

                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
                          $statement1 = mysqli_prepare($connection,"SELECT post_id , post_title , post_author , post_date , post_image , post_content
                                                        FROM posts WHERE post_category_id = ? LIMIT $page_number,$number_pages");
//                        $query_posts = "SELECT * FROM posts WHERE post_category_id = $category_id";
//                        $result_posts = mysqli_query($connection,$query_posts);
                    }else{
                        $statement2 = mysqli_prepare($connection,"SELECT post_id , post_title , post_author , post_date , post_image , post_content
                                    FROM posts WHERE post_category_id = ? AND post_status = ? LIMIT $page_number,$number_pages");
                        $published = 'published';
//                        $query_posts = "SELECT * FROM posts WHERE post_category_id = $category_id AND post_status = 'published'";
//                        $result_posts = mysqli_query($connection,$query_posts);
                    }
                    if (isset($statement1)){
                        mysqli_stmt_bind_param($statement1,"i",$category_id);
                        mysqli_stmt_execute($statement1);
                        mysqli_stmt_bind_result($statement1,$post_id , $post_title , $post_author , $post_date , $post_image , $post_content);
                        mysqli_stmt_store_result($statement1);
                        $count_query = "SELECT * FROM posts WHERE post_category_id = '$category_id'";
                        $count_result = mysqli_query($connection,$count_query);
                        $count = mysqli_num_rows($count_result);
                        $statement = $statement1;
                    }else{
                        mysqli_stmt_bind_param($statement2,"is",$category_id,$published);
                        $count = mysqli_stmt_num_rows($statement2);
                        $count = ($count / $number_pages);
                        mysqli_stmt_execute($statement2);
                        mysqli_stmt_bind_result($statement2,$post_id , $post_title , $post_author , $post_date , $post_image , $post_content);
                        mysqli_stmt_store_result($statement2);
                        $count_query = "SELECT * FROM posts WHERE post_category_id = '$category_id' AND post_status = 'published'";
                        $count_result = mysqli_query($connection,$count_query);
                        $count = mysqli_num_rows($count_result);
                        $statement = $statement2;
                    }
                    if (mysqli_stmt_num_rows($statement) < 1){
                        echo "<h1 class='text-center'>No posts available</h1>";
                    }
                    $count = ceil($count / $number_pages);
                    while (mysqli_stmt_fetch($statement)){
                    ?>
                        <h1 class="page-header">
                            <?php echo $cat_title?>
                        </h1>
                <h2><a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a> </h2>
                <p class="lead">
                    by <a href="post_author.php?p_author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="/cms/images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <?php  }
                ?>
                <hr>
                <ul class="pager">
                    <?php
                    for ($i = 1;$i <= $count;$i++) {
                        if ($i == $page) {
                            echo "<li><a class='active_link' href='/cms/category.php?cat_id=$cat_id&page=$i'>$i</a></li>";
                        } else {
                            echo "<li><a href='/cms/category.php?cat_id=$cat_id&page=$i'>$i</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "include/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>
        <?php include "include/footer.php";?>

