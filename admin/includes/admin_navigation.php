<?php 
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 60;
    $timeout = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session = '$session';";
    $send_query = mysqli_query($connection,$query);
    $count = mysqli_num_rows($send_query);

    if($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session','$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time='$time' WHERE session = '$session';");
    }

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > $timeout");
    $count_user = mysqli_num_rows($users_online_query);
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
                <a class="navbar-brand" href="index.php">CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li><a href="../index.php">HOME</a></li>
                <li><a href="../index.php">Users Online <?php echo $count_user; ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                    <?php 
                        if(isset($_SESSION["username"])){
                            echo $_SESSION['username'];
                        } else {
                            echo "User";
                        }
                    ?>
                     <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>



            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="./posts.php">View All Posts</a>
                            </li>
                            <li>
                                <a href="./posts.php?source=add_post">Add Posts</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                    </li>
                    
                    <li class="">
                        <a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comments </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="./users.php">View All Users</a>
                            </li>
                            <li>
                                <a href="./users.php?source=add_user">Add User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>