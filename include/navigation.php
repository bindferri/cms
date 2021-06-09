<?php include "db.php"?>
<?php session_start(); ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=/cms/index>Universal Sport</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $query = "SELECT * FROM categories";
                $categories_result = mysqli_query($connection,$query);
                while ($row = mysqli_fetch_assoc($categories_result)){
                    $category = $row['category_name'];
                    $category_id = $row['category_id'];
                    $category_class = '';
                    $registration_class = '';

                    $pagename = basename($_SERVER['PHP_SELF']);
                    if (isset($_GET['cat_id']) && $_GET['cat_id'] == $category_id){
                        $category_class = 'active';
                    }elseif ($pagename == 'contact.php'){
                        $registration_class = 'active';
                    }
                    echo "<li class='$category_class'><a href='/cms/category/$category_id'> $category</a></li>";
                }
                ?>
                <li class="<?php echo $registration_class ?>"><a href="/cms/contact">Contact</a></li>
                <li><a href="/cms/admin">Admin</a></li>
                <?php
                if (isset($_GET['p_id'])){
                    $post_id = $_GET['p_id'];
                    if (isset($_SESSION['user_role'])){
                        if ($_SESSION['user_role'] == 'Admin'){
                            echo "<li><a href='admin/posts.php?source=edit_post&p_id=$post_id'>Edit Post</a></li>";
                        }
                    }
                }
                    ?>
                <?php if (isset($_SESSION['user_role'])){?>
                    <li class="dropdown account-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/cms/admin/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="/cms/admin/include/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>