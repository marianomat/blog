<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome To Admin
                            <small><?php echo $_SESSION['username'];?></small>
                        </h1>
                        
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                       
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                <?php
                                    $query = "SELECT * FROM posts;";
                                    $post_count_query = mysqli_query($connection, $query);

                                    $post_count = mysqli_num_rows($post_count_query);
                                ?>

                                <div class='huge'><?php echo $post_count; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php 
                                        $query = "SELECT * FROM comments;";
                                        $comment_count_query = mysqli_query($connection, $query);

                                        $comment_count = mysqli_num_rows($comment_count_query);
                                    ?>
                                    <div class='huge'><?php echo $comment_count; ?></div>
                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php 
                                        $query = "SELECT * FROM users;";
                                        $user_count_query = mysqli_query($connection, $query);

                                        $user_count = mysqli_num_rows($user_count_query);
                                    ?>
                                    <div class='huge'><?php echo $user_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                         <?php 
                                            $query = "SELECT * FROM categories;";
                                            $category_count_query = mysqli_query($connection, $query);

                                            $category_count = mysqli_num_rows($category_count_query);
                                        ?>
                                        <div class='huge'><?php echo $category_count; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./categories.php">
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

                <?php

                    $query = "SELECT * FROM posts WHERE post_status = 'draft';";
                    $select_draft_posts = mysqli_query($connection, $query);
                    $draft_count = mysqli_num_rows($select_draft_posts);

                    $query = "SELECT * FROM posts WHERE post_status = 'live';";
                    $select_live_posts = mysqli_query($connection, $query);
                    $live_count = mysqli_num_rows($select_live_posts);

                    $query = "SELECT * FROM comments WHERE comment_status = 'unapproved';";
                    $select_unapproved_comments = mysqli_query($connection, $query);
                    $unapproved_count = mysqli_num_rows($select_unapproved_comments);

                    $query = "SELECT * FROM users WHERE user_role = 'suscriber';";
                    $select_suscribers = mysqli_query($connection, $query);
                    $suscriber_count = mysqli_num_rows($select_suscribers);

                ?>

                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            let data = google.visualization.arrayToDataTable([
                                ['Data', 'Count'],

                                <?php
                                $elements_text = ["All Posts", "Active Posts", "Draft Posts", "Categories", "Users", "Suscriber", "Comments", "Unapproved Comments"];
                                $elements_count = [$post_count, $live_count, $draft_count, $category_count, $user_count, $suscriber_count, $comment_count, $unapproved_count];

                                for ($i = 0; $i < 7; $i++) {
                                    echo "['$elements_text[$i]', $elements_count[$i]] ,";
                                }

                                ?>
                                /* ['Post', 1000], */
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

    </div>
    <!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?>