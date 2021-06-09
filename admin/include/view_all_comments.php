<?php
if (isset($_POST['checkBoxId'])){
    foreach ($_POST['checkBoxId'] as $boxId){
        $bulkOptions = $_POST['bulk_options'];
        switch ($bulkOptions){
            case 'approved': $approve_query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = '$boxId'";
                $approve_status_result = mysqli_query($connection,$approve_query);
                break;
            case 'not approved': $disapprove_query = "UPDATE comments SET comment_status = 'not approved' WHERE comment_id = '$boxId' ";
                $disapprove_status_result = mysqli_query($connection,$disapprove_query);
                break;
                case 'delete':  $delete_query = "DELETE FROM comments WHERE comment_id = '$boxId'";
                    $delete_result = mysqli_query($connection,$delete_query);
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
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){ ?>
                <option value="approved">Approve</option>
                <option value="not approved">Dissaprove</option>
                <?php } ?>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
        </div>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
       <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>ID</th>
        <th>Author</th>
        <th>E-Mail</th>
        <th>Post</th>
        <th>Comment</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){
        $read_comments_query = "SELECT * FROM comments";
    }else{
        $session_username = $_SESSION['username'];
        $read_comments_query = "SELECT * FROM comments WHERE comment_author = '$session_username'";
    }
    $read_comments_result = mysqli_query($connection,$read_comments_query);
    while ($read_comments_row = mysqli_fetch_assoc($read_comments_result)){
        $comment_id = $read_comments_row['comment_id'];
        $comment_post_id = $read_comments_row['comment_post_id'];
        $comment_author = $read_comments_row['comment_author'];
        $comment_email = $read_comments_row['comment_email'];
        $comment_content = $read_comments_row['comment_content'];
        $comment_date = $read_comments_row['comment_date'];
        $comment_status = $read_comments_row['comment_status'];

        $get_post_title = "SELECT * FROM posts WHERE post_id = '$comment_post_id'";
        $post_title_query = mysqli_query($connection,$get_post_title);
        while ($row_post_title = mysqli_fetch_assoc($post_title_query)){
            $post_title = $row_post_title['post_title'];
        }
        ?>


        <tr>
            <td><input class="checkbox" type="checkbox" name="checkBoxId[]" value="<?php echo $comment_id ?>"></td>
            <td><?php echo $comment_id ?></td>
            <td><?php echo $comment_author?></td>
            <td><?php echo $comment_email?></td>
            <td><a href="../post.php?p_id=<?php echo $comment_post_id?>"><?php echo $post_title?></a></td>
            <td><?php echo $comment_content?></td>
            <td><?php echo $comment_status?></td>
            <td><?php echo $comment_date?></td>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {?>
            <td><a href="comments.php?approve=<?php echo $comment_id ?>">Approve</a>  </td>
            <td><a href="comments.php?disapprove=<?php echo $comment_id ?>">Disapprove</a> </td>
            <?php } ?>
            <td><a href="comments.php?delete=<?php echo $comment_id ?>">Delete</a> </td>
        </tr>
    <?php  }
    ?>
    </tbody>
</table>
<?php
if (isset($_GET['delete'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $delete_id = $_GET['delete'];
            $delete_query = "DELETE FROM comments WHERE comment_id = $delete_id";
            $delete_result = mysqli_query($connection, $delete_query);

//    $count_comments_delete = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = '$comment_post_id'";
//    $count_comments_delete_result = mysqli_query($connection,$count_comments_delete);

            header("Location: comments.php");
        }
    }
}
if (isset($_GET['approve'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $approve_id = $_GET['approve'];
            $approve_query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = '$approve_id'";
            $approve_status_result = mysqli_query($connection, $approve_query);
            header("Location: comments.php");
        }
    }
}
if (isset($_GET['disapprove'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $disapprove_id = $_GET['disapprove'];
            $disapprove_query = "UPDATE comments SET comment_status = 'not approved' WHERE comment_id = '$disapprove_id' ";
            $disapprove_status_result = mysqli_query($connection, $disapprove_query);
            header("Location: comments.php");
        }
    }
}
?>