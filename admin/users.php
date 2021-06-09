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
                        All Users
                    </h1>
                    <?php
                    if (isset($_GET['source'])){
                        $source = $_GET['source'];
                    }else $source = '';
                    switch ($source){
                        case 'add_post':
                            include "include/add_post.php";
                            break;
                        case 'edit_post':
                            include "include/edit_post.php";
                            break;
                        case 'add_user':
                            include "include/add_user.php";
                            break;
                        case 'edit_user':
                            include "include/edit_user.php";
                            break;
                        default:
                            include "include/view_all_users.php";
                            break;
                    }
                    ?>

                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
<?php include "include/footer.php"?>