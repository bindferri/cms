<?php
if (isset($_GET['p_id'])){
    $post_id = $_GET['p_id'];
    $get_post_query = "SELECT * FROM posts WHERE post_id = '$post_id'";
    $get_post_result = mysqli_query($connection,$get_post_query);

    while ($row_get = mysqli_fetch_assoc($get_post_result)){
        $post_title = $row_get['post_title'];
        $post_category_id = $row_get['post_category_id'];
        $post_author = $row_get['post_author'];
        $post_date = $row_get['post_date'];
        $post_image = $row_get['post_image'];
        $post_content = $row_get['post_content'];
        $post_tags = $row_get['post_tags'];
        $post_comment_count = $row_get['post_comment_count'];
        $post_status = $row_get['post_status'];
    }
}
if (isset($_POST['update_post'])) {
    $new_post_title = $_POST['post_title'];
    $new_post_category_id = $_POST['category_id'];
    $new_post_author = $_POST['post_author'];
    $new_post_image = $_FILES['post_image']['name'];
    $new_post_image_temp = $_FILES['post_image']['tmp_name'];
    $new_post_content = $_POST['post_content'];
    $new_post_tags = $_POST['post_tags'];
    $new_post_status = $_POST['post_status'];

    move_uploaded_file($new_post_image_temp, "../images/$new_post_image");
    if (empty($new_post_image)){
        $empty_image_query = "SELECT * FROM posts WHERE post_id = '$post_id'";
        $empty_image_result = mysqli_query($connection,$empty_image_query);
        while ($row_empty_image = mysqli_fetch_array($empty_image_result)){
            $new_post_image = $row_empty_image['post_image'];
        }
    }

    $update_query = "UPDATE posts SET post_category_id = '$new_post_category_id' , post_title = '$new_post_title',
                 post_author = '$new_post_author', post_image = '$new_post_image' , post_date = now() ,
                 post_content = '$new_post_content', post_tags = '$new_post_tags' , post_status = '$new_post_status'
                 WHERE post_id = '$post_id'";
    $update_result = mysqli_query($connection, $update_query);
    echo "Post Updated Successfully <a href='../post.php?p_id=$post_id'>View Post</a>";

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post-title">Post Title: </label>
        <input type="text" value="<?php echo $post_title ?>" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="category-id">Post Catergory:</label><br>
        <select name="category_id" id="">
        <?php
        $select_categories_query = "SELECT * FROM categories";
        $select_categories_result = mysqli_query($connection,$select_categories_query);
        while ($row_select_categories = mysqli_fetch_assoc($select_categories_result)){
            $categories = $row_select_categories['category_name'];
            $category_id = $row_select_categories['category_id'];
            ?>
            <option value="<?php echo $category_id ?>"><?php echo $categories ?></option>
        <?php
        }?>
        </select>
    </div>

    <div class="form-group">
        <label for="post-author">Post Author: </label>
        <br>
        <select name="post_author" id="">
    <?php
    $users_query = "SELECT * FROM users";
    $users_query_result = mysqli_query($connection,$users_query);
    while ($users_row = mysqli_fetch_assoc($users_query_result)){
        $user = $users_row['username'];
        echo "<option value='$user'>$user</option>";
    }
    ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post-status">Post Status: </label>
        <br>
        <select name="post_status" id="">
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post-image">Post Image : </label><br>
        <img width="100" src="../images/<?php echo $post_image?>">
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post-tags">Post Tags: </label>
        <input type="text" value="<?php echo $post_tags ?>" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post-content">Post Content: </label>
        <textarea class="form-control" id="body" name="post_content" cols="30" rows="10"><?php echo $post_content ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>