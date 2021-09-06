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
                    <small>Secondary Text</small>
                </h1>

                <?php 
                    if(isset($_GET["p_id"])) {
                        $post_id = $_GET["p_id"];
                        
                        $query = "SELECT * FROM posts WHERE post_id = $post_id";
                        echo $query;

                        $select_all_posts_query = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                            $post_title = $row["post_title"];
                            $post_autor = $row["post_autor"];
                            $post_date = $row["post_date"];
                            $post_img = $row["post_img"];
                            $post_content = $row["post_content"];
                            $post_viewcount = $row["post_viewcount"];
                        }

                 /*        $query = "UPDATE posts SET post_viewcount = $post_viewcount + 1 WHERE post_id = $post_id;";
                        $update_count_query = mysqli_query($connection, $query); */




                        /* if(!$update_count_query) {
                            die("query failed" . mysqli_error($connection, $update_count_query));
                        } */

                   
                    
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

                        if(!empty($comment_autor) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_autor, comment_email, comment_content, comment_status, comment_date) VALUES ($post_id, '$comment_autor', '$comment_email', '$comment_content', 'unapproved', NOW());"; 

                            $create_comment_query = mysqli_query($connection, $query);
                            if(!$create_comment_query) {
                                die("query failed" . mysqli_error($connection));
                            }

                            $query = "UPDATE posts SET post_comment_count = (SELECT COUNT(*) FROM comments WHERE comment_post_id = $post_id) WHERE post_id = $post_id;";
                            $update_commends_count = mysqli_query($connection, $query);
                            if(!$update_commends_count) {
                                die("query failed" . mysqli_error($connection));
                            }
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
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC;";
                    $get_comments = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_array($get_comments)) {
                        $comment_autor = $row["comment_autor"];
                        $comment_date = $row["comment_date"];
                        $commend_content = $row["comment_content"];
                        $commend_email = $row["comment_email"];
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
                        <?php echo $commend_content ?>
                    </div>
                </div>  
                <?php
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