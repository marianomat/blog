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
                    Page Heading
                </h1>

                <?php 
                    if(isset($_GET["category"])) {
                        $cat_id = mysqli_real_escape_string($connection, $_GET["category"]);
                    }

                    $query = "SELECT * FROM posts WHERE post_cat = $cat_id AND post_status = 'live'";

                    $select_all_posts_query = mysqli_query($connection, $query);

                    if(mysqli_num_rows($select_all_posts_query) == 0) {
                        echo "No posts in this category yet";
                    } else {
                        while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row["post_id"];
                        $post_title = $row["post_title"];
                        $post_autor = $row["post_autor"];
                        $post_date = $row["post_date"];
                        $post_img = $row["post_img"];
                        $post_content = $row["post_content"];
                    
                        ?>
                    
                        <!-- Blog Post -->
                        
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_autor; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_img; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                        
                        <?php }
                    } ?>

                    
                    
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>

<!-- footer -->       
<?php include "includes/footer.php"?>