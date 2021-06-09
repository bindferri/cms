<?php include "include/header.php"; include "../functions.php"?>
<?php
$post_count = countRows2("posts","post_author",$_SESSION['username']);
$comment_count = countRows2("comments","comment_author",$_SESSION['username']);
$published_posts_count = countRows3("posts","post_status","published","post_author",$_SESSION['username']);
$draft_posts_count = countRows3("posts","post_status","draft","post_author",$_SESSION['username']);
$approved_comment_count = countRows3("comments","comment_status","approved","comment_author",$_SESSION['username']);
$not_approved_comment_count = countRows3("comments","comment_status","not approved","comment_author",$_SESSION['username']);
?>
    <!-- admin index -->
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
                            Your activity
                            <small><?php echo $_SESSION['username'] ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->


                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $post_count ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $comment_count ?></div>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Data', 'Count'],

                                <?php
                                    $elements_name = ['Published Posts','Draft Posts','Approved Comments','Not Approved Comments'];
                                    $elements_count = [$published_posts_count,$draft_posts_count,$approved_comment_count,$not_approved_comment_count];

                                    for($i = 0;$i < 4;$i++){
                                        echo "['$elements_name[$i]'" . "," . "$elements_count[$i]],";
                                    }
                                ?>

                                // ['Posts', 1000],

                            ]);

                            var options = {
                                chart: {
                                    title: '',
                                    subtitle: '',
                                }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>
                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>



            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        <?php include "include/footer.php"?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>
            $(document).ready(function () {
                var pusher = new Pusher ('7f161754ea956b0d816d',{
                    cluster : 'eu',
                    encrypted: true
                });
                var notificationChannel = pusher.subscribe('notifications');
                notificationChannel.bind('new_user',function (notification) {
                    var message = notification.message;
                    toastr.success(`${message} just registered`)
                    console.log(message);
                });
            });
        </script>
