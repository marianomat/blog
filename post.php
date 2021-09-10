<!-- Header -->
<?php include "includes/header.php"?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                    if(isset($_GET["p_id"])) {
                        $post_id = $_GET["p_id"];
                        $query = mysqli_prepare($connection, "SELECT post_title, post_autor, post_date, post_img, post_content, post_viewcount, user_first_name, user_last_name FROM posts INNER JOIN users ON user_id = post_autor WHERE post_id = ?");
                        mysqli_stmt_bind_param($query, "i", $post_id);
                        mysqli_stmt_execute($query);
                        mysqli_stmt_bind_result($query, $post_title, $post_autor, $post_date, $post_img, $post_content, $post_viewcount, $user_first_name, $user_last_name);
                        mysqli_stmt_fetch($query);
                        mysqli_stmt_close($query);
                ?>
                <!-- Blog Post -->
                
                <h2>
                   <?php echo $post_title; ?>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $user_first_name . " ".$user_last_name; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_img; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

                <?php
                    } else {
                        header("Location: index.php");
                    }
                ?>

                <!-- Blog Comments -->

                <?php 
                    if(isset($_POST["create_comment"])) {
                        $post_id = $_GET["p_id"];
                        $comment_autor = $_POST["comment_autor"];
                        $comment_email = $_POST["comment_email"];
                        $comment_content = $_POST["comment_content"];
                        $unapproved = "unapproved";

                        if(!empty($comment_autor) && !empty($comment_email) && !empty($comment_content)) {

                            $stmt = mysqli_prepare($connection,"INSERT INTO comments(comment_post_id, comment_autor, comment_email, comment_content, comment_status, comment_date) 
                                                                        VALUES (?,?,?,?,?, NOW())");
                            mysqli_stmt_bind_param($stmt, "issss", $post_id, $comment_autor, $comment_email, $comment_content, $unapproved) or die( mysqli_stmt_error($stmt) );
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);

                            $stmt = mysqli_prepare($connection, "UPDATE posts SET post_comment_count = (SELECT COUNT(*) FROM comments WHERE comment_post_id = ?) WHERE post_id = ?");
                            mysqli_stmt_bind_param($stmt, "ii", $post_id, $post_id);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "<script>alert('Fields cannot be empty');</script>";
                        }
                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">
                        <div class="form-group">
                            <label for="comment_autor">Autor</label>
                            <input type="text" id="comment_autor" name="comment_autor" class="form-control" required></input>
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" id="comment_email" name="comment_email" class="form-control" required ></input>
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Comment</label>
                            <textarea name="comment_content" id="comment_content" class="form-control"  rows="3" required></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                
                <?php
                    $post_id = $_GET["p_id"];
                    $stmt = mysqli_prepare($connection, "SELECT comment_autor, comment_date, comment_content, comment_email FROM comments WHERE comment_post_id = ? AND comment_status = 'approved' ORDER BY comment_id DESC;");
                    mysqli_stmt_bind_param($stmt, "i", $post_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $comment_autor, $comment_date, $comment_content, $comment_email);
                    while(mysqli_stmt_fetch($stmt)) :

                ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_autor ?>
                            <small><?php echo $comment_date ?></small>
                        </h4>
                        <?php echo $comment_content ?>
                    </div>
                </div>  
                <?php
                     endwhile;
                     mysqli_stmt_close($stmt);
                ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>

<!-- footer -->       
<?php include "includes/footer.php"?>