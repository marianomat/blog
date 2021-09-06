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
                            echo "Page Heading";
                        }
                    ?>
                    
                    
                </h1>

                <?php
                    $post_query_count = "SELECT * FROM posts WHERE post_status = 'live';";
                    $find_count = mysqli_query($connection, $post_query_count);
                    $postcount = mysqli_num_rows($find_count);

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



                        if(isset($_GET["autor"])) {
                            $post_autor = $_GET["autor"];
                            $query = "SELECT * FROM posts WHERE post_autor = $post_autor AND post_status = 'live' LIMIT $page_1,5;";
                        } else {
                            $query = "SELECT * FROM posts WHERE post_status = 'live' LIMIT $page_1,5";
                        }
                        

                        $select_all_posts_query = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                            $post_id = $row["post_id"];
                            $post_title = $row["post_title"];
                            $post_autor = $row["post_autor"];
                            $post_date = $row["post_date"];
                            $post_img = $row["post_img"];
                            $post_status = $row["post_status"];
                            $post_content = substr($row["post_content"],0,100);

                            if($post_status === "live") {
                                ?>
                                <!-- Blog Post -->
                                
                                <h2>
                                    <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="index.php?autor=<?php echo $post_autor; ?>"><?php echo $post_autor; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                                <hr>
                                <a href="post.php?p_id=<?php echo $post_id;?>"><img class="img-responsive" src="images/<?php echo $post_img; ?>" alt=""></a>
                                <hr>
                                <p><?php echo $post_content; ?></p>
                                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                                <hr>
                            <?php
                            }
                        }
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