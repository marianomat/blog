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
                    Posts
                </h1>
                <?php
                    if(isset($_POST["submit"])) {
                        $search = "%{$_POST['search']}%";
                        $query = mysqli_prepare($connection, "SELECT post_title, post_autor, post_date, post_img, post_content FROM posts WHERE post_tags LIKE ?;");
                        mysqli_stmt_bind_param($query, "s", $search);
                        mysqli_stmt_execute($query);
                        mysqli_stmt_bind_result($query, $post_title, $post_autor, $post_date, $post_img, $post_content);
                        mysqli_stmt_store_result($query);

                        if(mysqli_stmt_num_rows($query) === 0) {
                            echo "<h1>NO RESULTS</h1>";
                        } else {
                            while(mysqli_stmt_fetch($query)):
                ?>
                            <!-- Blog Post -->
                            <h2>
                                <a href="#"><?php echo $post_title; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="index.php"><?php echo $post_autor; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_img; ?>" alt="">
                            <hr>
                            <p><?php echo $post_content; ?></p>
                            <a class="btn btn-primary" href="#">Leer mas <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>
                <?php
                            endwhile;
                            mysqli_stmt_close($query);
                        } 
                    }
                ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->
        <hr>

<!-- footer -->       
<?php include "includes/footer.php"?>