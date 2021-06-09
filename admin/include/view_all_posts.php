<?php
include "delete_modal.php";
if (isset($_POST['checkBoxes'])){
    foreach (($_POST['checkBoxes']) as $checkBoxId){
        $bulkoption = $_POST['bulk_options'];
        switch ($bulkoption){
            case 'published': $publish_query = "UPDATE posts SET post_status = 'published' WHERE post_id = '$checkBoxId'";
                              $publish_query_result = mysqli_query($connection,$publish_query);
                              break;
            case 'draft': $draft_query = "UPDATE posts SET post_status = 'draft' WHERE post_id = '$checkBoxId'";
                $draft_query_result = mysqli_query($connection,$draft_query);
                break;
            case 'delete': $delete_option_query = "DELETE FROM posts WHERE post_id = '$checkBoxId'";
                $delete_option_query_result = mysqli_query($connection,$delete_option_query);
                break;
            case 'clone' : $clone_query = "SELECT * FROM posts WHERE post_id = '$checkBoxId'";
                           $clone_query_result = mysqli_query($connection,$clone_query);
                           while ($clone_row = mysqli_fetch_assoc($clone_query_result)){
                               $post_title = $clone_row['post_title'];
                               $post_category_id = $clone_row['post_category_id'];
                               $post_author = $clone_row['post_author'];
                               $post_date = $clone_row['post_date'];
                               $post_image = $clone_row['post_image'];
                               $post_content = $clone_row['post_content'];
                               $post_tags = $clone_row['post_tags'];
                               $post_comment_count = $clone_row['post_comment_count'];
                               $post_status = $clone_row['post_status'];
                           }
                $clone_insert_query = "INSERT INTO posts (post_category_id,post_title,post_author,post_date,post_image,post_content,
                        post_tags,post_status) VALUES ('$post_category_id','$post_title','$post_author',
                        now(),'$post_image','$post_content','$post_tags','$post_status')";
                $clone_insert_query_result = mysqli_query($connection,$clone_insert_query);
                break;

        }
    }
}
?>
<form action="" method="post">
<table class="table table-bordered table-hover">

<div id="bulkOptionContainer" class="col-xs-4">
    <select class="form-control" name="bulk_options" id="">
        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
    </select>
</div>
<div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
</div>
    <thead>
    <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>ID</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Views</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
        $read_posts_query = "SELECT posts.post_id,posts.post_category_id,posts.post_title,posts.post_author,posts.post_date,posts.post_image,posts.post_tags
                        ,posts.post_status,posts.post_comment_count,posts.post_views_count,categories.category_id,categories.category_name FROM posts
                         LEFT JOIN categories ON posts.post_category_id = categories.category_id ORDER BY posts.post_id DESC ";
    }else{
        $session_username = $_SESSION['username'];
        $read_posts_query = "SELECT posts.post_id,posts.post_category_id,posts.post_title,posts.post_author,posts.post_date,posts.post_image,posts.post_tags
                        ,posts.post_status,posts.post_comment_count,posts.post_views_count,categories.category_id,categories.category_name FROM posts
                         LEFT JOIN categories ON posts.post_category_id = categories.category_id WHERE posts.post_author = '$session_username'  ORDER BY posts.post_id DESC ";
    }
    $read_posts_result = mysqli_query($connection,$read_posts_query);
    if (mysqli_num_rows($read_posts_result) < 1){
        echo "<h1>You have no posts</h1>";
    }
    while ($read_row = mysqli_fetch_assoc($read_posts_result)){
        $post_id = $read_row['post_id'];
        $post_category_id = $read_row['post_category_id'];
        $post_title = $read_row['post_title'];
        $post_author = $read_row['post_author'];
        $post_date = $read_row['post_date'];
        $post_image = $read_row['post_image'];
        $post_tags = $read_row['post_tags'];
        $post_status = $read_row['post_status'];
        $post_comment_count = $read_row['post_comment_count'];
        $post_views = $read_row['post_views_count'];
        $cat_id = $read_row['category_id'];
        $cat_title = $read_row['category_name'];

        $all_comment = "SELECT * FROM comments WHERE comment_post_id = '$post_id' AND comment_status = 'approved'";
        $all_comment_query = mysqli_query($connection,$all_comment);
        $comment_count = mysqli_num_rows($all_comment_query);
        ?>
        <tr>
            <td><input class="checkbox" type="checkbox" name="checkBoxes[]" value="<?php echo $post_id ?>"></td>
            <td><?php echo $post_id ?></td>
            <td><?php echo $post_author?></td>
            <td><a href="../post.php?p_id=<?php echo $post_id ?>"><?php  echo substr($post_title,0,15)?></a></td>
            <td><?php echo $cat_title?></td>
            <td><?php echo $post_status?></td>
            <td><?php echo "<img width='100' src='../images/$post_image'>"?></td>
            <td><?php echo $post_tags?></td>
            <td><a href="posts.php?source=post_comment&p_id=<?php echo $post_id ?>"><?php echo $comment_count ?></a></td>
            <td><?php echo $post_date?></td>
            <td><?php echo $post_views?></td>
            <td><a rel="<?php echo $post_id ?>" href="javascript:void(0)" class="delete_link">Delete</a> </td>
            <td><a href="posts.php?source=edit_post&p_id=<?php echo $post_id ?>">Edit</a> </td>

        </tr>
    <?php  }
    ?>
    </tbody>
</table>
</form>
<?php
if (isset($_GET['delete'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $delete_id = $_GET['delete'];
            $delete_query = "DELETE FROM posts WHERE post_id = $delete_id";
            $delete_result = mysqli_query($connection, $delete_query);
            header("Location: posts.php");
        }
    }
}
?>
<script>
    $(document).ready(function () {
        $(".delete_link").on('click',function () {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id;
            $(".modal_delete_link").attr("href",delete_url);
            $("#myModal").modal('show');
        });
    });
</script>
