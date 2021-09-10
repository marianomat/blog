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
                    Categorias
                </h1>

                <?php 
                    if(isset($_GET["category"])) {
                        $cat_id = $_GET["category"];
                    }
                    if(isset($_SESSION["username"]) && is_admin($_SESSION["username"])) {
                        $query1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_autor, post_date, post_img, post_content
                                                                    FROM posts WHERE post_cat = ?");
                    } else {
                        $query2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_autor, post_date, post_img, post_content
                                FROM posts WHERE post_cat = ? AND post_status = ?" );
                        $live = "live";
                    }

                    if(isset($query1)) {
                        # usamos i si es int, usamos s si es string
                        mysqli_stmt_bind_param($query1, "i", $cat_id);
                        mysqli_stmt_execute($query1);
                        mysqli_stmt_bind_result($query1, $post_id, $post_title, $post_autor, $post_date, $post_img, $post_content);
                        mysqli_stmt_store_result($query1);
                        $final_query = $query1;
                    } else {
                        mysqli_stmt_bind_param($query2, "is", $cat_id, $live);
                        mysqli_stmt_execute($query2);
                        mysqli_stmt_bind_result($query2, $post_id, $post_title, $post_autor, $post_date, $post_img, $post_content);
                        mysqli_stmt_store_result($query2);
                        $final_query = $query2;
                    }

                    if(mysqli_stmt_num_rows($final_query) === 0) {
                        echo "No posts in this category yet";
                    }
                    while(mysqli_stmt_fetch($final_query)):
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
                    <?php
                        endwhile;
                        mysqli_stmt_close($final_query);
                    ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>

<!-- footer -->       
<?php include "includes/footer.php"?>