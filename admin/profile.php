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
                        Profile
                    </h1>
                    <?php
                    if (isset($_GET['source'])){
                        $source = $_GET['source'];
                    }else $source = '';
                    switch ($source){
                        default:
                            include "include/view_profile.php";
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