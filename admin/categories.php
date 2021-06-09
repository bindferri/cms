<?php ob_start(); ?>
<?php include "include/header.php"; ?>
    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "include/navigation.php"; ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Categories
                    </h1>
                     <div class="col-xs-6">
                         <?php
                         if (isset($_POST['submit'])){
                             $add_category_title = $_POST['category_title'];
                             if ($add_category_title == "" || empty($add_category_title)){
                                 echo "The Category Title cannot be empty";
                             }
                             else {
                                   $statement = mysqli_prepare($connection,"INSERT INTO categories (category_name) VALUES (?)");
                                   mysqli_stmt_bind_param($statement,"s",$add_category_title);
                                   mysqli_stmt_execute($statement);
//                                 $add_category_query = "INSERT INTO categories (category_name) VALUES ('$add_category_title')";
//                                 $add_category_result = mysqli_query($connection, $add_category_query);
                             }
                         }
                         ?>
                    <form action="" method="post">
                    <div class="form-group">
                        <label for="category-title">Catergory Title: </label>
                        <input type="text" class="form-control" name="category_title">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                    </div>
                    </form>
                     </div>

                    <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Title</th>
                            </tr>
                            </thead>
                        <tbody>
                        <?php
                        $category_select_query = "SELECT * FROM categories";
                        $category_select_result = mysqli_query($connection,$category_select_query);
                        while ($row_category_select = mysqli_fetch_assoc($category_select_result)){
                            $category_title = $row_category_select['category_name'];
                            $category_id = $row_category_select['category_id'];
                            ?>

                            <tr>
                                <td><?php echo $category_id ?></td>
                                <td><?php echo $category_title ?></td>
                                <td><?php echo "<a href='categories.php?delete={$category_id}'>Delete</a>"?></td>
                                <td><?php echo "<a href='categories.php?edit={$category_id}'>Edit</a>"?></td>
                            </tr>


                      <?php  }
                        ?>

                        <?php
                        if (isset($_GET['delete'])){
                            if (isset($_SESSION['user_role'])) {
                                if ($_SESSION['user_role'] == 'Admin') {
                                    $get_category_id = $_GET['delete'];
                                    $delete_category_query = "DELETE FROM categories WHERE category_id = $get_category_id";
                                    $delete_category_result = mysqli_query($connection, $delete_category_query);
                                    header("Location:categories.php");
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <div class="col-xs-6">
                    <form action="" method="post">
                        <?php
                        if (isset($_GET['edit'])){
                            $get_editcategory_id = $_GET['edit'];
                            $edit_category_query = "SELECT * FROM categories WHERE category_id = $get_editcategory_id";
                            $edit_category_result = mysqli_query($connection,$edit_category_query);
                            while ($row_edit_category = mysqli_fetch_assoc($edit_category_result)){
                                $edit_title = $row_edit_category['category_name'];
                                $edit_id = $row_edit_category['category_id'];
                            }
                        ?>
                            <div class="form-group">
                            <label for="category-title">Edit Title: </label>
                            <input value="<?php echo $edit_title ?>" type="text" class="form-control" name="update_category_title">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="update" value="Edit Category">
                        </div>
                    </form>
                </div>

                      <?php  }
                        ?>

                    <?php
                    if (isset($_GET['edit'])) {
                        $update_category_id = $_GET['edit'];
                        if (isset($_POST['update'])) {
                            $update_title = $_POST['update_category_title'];
                            $update_statement = mysqli_prepare($connection,"UPDATE categories SET category_name = ? WHERE category_id = ?");
                            mysqli_stmt_bind_param($update_statement,"si",$update_title,$update_category_id);
                            mysqli_stmt_execute($update_statement);
//                            $update_title_query = "UPDATE categories SET category_name = '$update_title' WHERE category_id = '$update_category_id'";
//                            $update_title_result = mysqli_query($connection, $update_title_query);
                            header("Location: categories.php");
                        }
                    }
                    ?>



            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
<?php include "include/footer.php"?>