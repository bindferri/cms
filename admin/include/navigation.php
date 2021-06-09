<?php
    $users_online = "SELECT * FROM users WHERE user_status = 'online'";
    $users_online_result = mysqli_query($connection, $users_online);
    $count_users_online = mysqli_num_rows($users_online_result);
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">SB Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="">User Online: <?php echo $count_users_online ?></a> </li>
        <li><a href="../index.php">Home</a> </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="include/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php
    $active_element = '';
    $active_element2 = '';
    $active_element3 = '';
    $active_element4 = '';
    $active_element5 = '';
    $active_element6 = '';
    $active_element7 = '';
    $pagename = basename($_SERVER['PHP_SELF']);
    switch ($pagename){
        case 'posts.php' : $active_element = 'active';
        break;
        case 'categories.php' : $active_element2 = 'active';
        break;
        case 'users.php' : $active_element3 = 'active';
        break;
        case 'comments.php' : $active_element4 = 'active';
        break;
        case 'profile.php' : $active_element5 = 'active';
        break;
        case 'index.php' : $active_element6 = 'active';
        break;
        case 'dashboard.php' : $active_element7 = 'active';
        break;
    }
    ?>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="<?php echo $active_element6 ?>">
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> My Data</a>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){ ?>
            </li><li class="<?php echo $active_element7 ?>">
                <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <?php } ?>
            <li class="<?php echo $active_element ?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#posts"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts" class="collapse">
                    <li>
                        <a href="posts.php">All Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add Posts</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $active_element2 ?>">
                <a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories </a>
            </li>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){?>
            <li class="<?php echo $active_element3 ?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="users.php">All Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add Users</a>
                    </li>
                </ul>
            </li>
            <?php  } ?>
            <li class="<?php echo $active_element4 ?>">
                <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <li class="<?php echo $active_element5 ?>">
                <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>