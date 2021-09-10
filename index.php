<?php ob_start(); ?>
<!-- Header -->
<?php include "includes/header.php"?>


    <!-- Navigation -->
    <?php include "includes/navigation.php"?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    <?php
                        if(isset($_GET["autor"])) {
                            echo "Posts by " . $_GET["autor"];
                        } else {
                            echo "Ultimos Posts";
                        }
                    ?>
                </h1>
                <?php
                    $stmt = mysqli_prepare($connection, "SELECT * FROM posts WHERE post_status = 'live'");
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $postcount = mysqli_stmt_num_rows($stmt);
                    mysqli_stmt_close($stmt);


                    if ($postcount == 0) {
                        echo "no post"; 
                    } else {
                        $postcount = ceil($postcount / 5);
                        $page = $_GET["page"] ?? "";

                        if($page == "" || $page == 1) {
                            $page_1 = 0;
                        } else {
                            $page_1 = ($page * 5) - 5;
                        }
                        $stmt = "123";

                        if(isset($_GET["autor"])) {
                            $post_autor = $_GET["autor"];
                            $query = "SELECT user_id, post_id, post_title, post_autor, post_date, post_img, post_status, post_content, user_first_name, user_last_name FROM posts INNER JOIN users ON user_id = post_autor WHERE post_autor = ? AND post_status = 'live' LIMIT ?,5";
                            $stmt = mysqli_prepare($connection, $query);
                            mysqli_stmt_bind_param($stmt, "ii", $post_autor, $page_1);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt,$user_id, $post_id, $post_title, $post_autor, $post_date, $post_img, $post_status,  $post_content, $user_first_name, $user_last_name);
                        } else {
                            $query = "SELECT user_id, post_id, post_title, post_autor, post_date, post_img, post_status, post_content, user_first_name, user_last_name FROM posts INNER JOIN users ON user_id = post_autor WHERE post_status = 'live' LIMIT ?,5";
                            $stmt = mysqli_prepare($connection, $query);
                            mysqli_stmt_bind_param($stmt, "i", $page_1);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $user_id, $post_id, $post_title, $post_autor, $post_date, $post_img, $post_status,  $post_content, $user_first_name, $user_last_name);
                        }

                        while (mysqli_stmt_fetch($stmt)) {
                            $post_content = substr($post_content,0,100);
                            if($post_status === "live") {
                                ?>
                                <!-- Blog Post -->
                                
                                <h2>
                                    <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="index.php?autor=<?php echo $user_id ?>"><?php echo $user_first_name . " ".$user_last_name; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                                <hr>
                                <a href="post.php?p_id=<?php echo $post_id;?>"><img class="img-responsive" src="images/<?php echo $post_img; ?>" alt=""></a>
                                <hr>
                                <p><?php echo $post_content; ?></p>
                                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Ver Post <span class="glyphicon glyphicon-chevron-right"></span></a>

                                <hr>
                            <?php
                            }
                        }
                        mysqli_stmt_close($stmt);

                        ?>
                <?php } ?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"?>
        </div>
        <!-- /.row -->

        <hr>

        <ul class="pager">
            <?php
                for($i = 1; $i <= $postcount; $i++) {
                    if($i == $page || ($i == 1 && $page == null)) {
                        echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
                    } else {
                        echo "<li><a href='index.php?page=$i'>$i</a></li>";
                    }
                    
                }
            ?>
        </ul>

<!-- footer -->       
<?php include "includes/footer.php"?>