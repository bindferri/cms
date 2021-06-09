<?php
if (isset($_POST['create_post'])){
    $username = $_SESSION['username'];
    $post_title = $_POST['post_title'];
    $category_id = $_POST['category_id'];
    $post_status = $_POST['post_status'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_date = date('d-m-y-h');
    move_uploaded_file($post_image_temp,"../images/$post_image");

    $add_post_query = "INSERT INTO posts (post_category_id,post_title,post_author,post_date,post_image,post_content,
                        post_tags,post_status) VALUES ('$category_id','$post_title','$username',
                        now(),'$post_image','$post_content','$post_tags','$post_status')";
    $add_post_result = mysqli_query($connection,$add_post_query);
    echo "Post Added Successfully";
}

?>

<form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="post-title">Post Title: </label>
            <input type="text" class="form-control" name="post_title">
        </div>
         <div class="form-group">
             <label for="category-id">Post Catergory ID: </label>
             <br>
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
             <label for="post-status">Post Status: </label>
             <br>
             <select name="post_status" id="">
                 <option value="published">Publish</option>
                 <option value="draft">Draft</option>
             </select>
         </div>
         <div class="form-group">
             <label for="post-image">Post Image : </label>
             <input type="file" name="post_image">
         </div>
         <div class="form-group">
             <label for="post-tags">Post Tags: </label>
             <input type="text" class="form-control" name="post_tags">
         </div>

         <div class="form-group">
             <label for="post-content">Post Content: </label>
             <textarea class="form-control" id="body" name="post_content" cols="30" rows="10"></textarea>
         </div>
         <div class="form-group">
             <input class="btn btn-primary" type="submit" name="create_post" value="Add Post">
         </div>

 </form>
