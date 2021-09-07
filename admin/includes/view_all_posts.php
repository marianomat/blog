<?php
    if(isset($_POST["checkBoxArray"])) {
        foreach($_POST["checkBoxArray"] as $checkbox_post_id) {
            $bulk_options = mysqli_real_escape_string($connection, $_POST["bulk_options"]);
            $checkbox_post_id = mysqli_real_escape_string($connection, $checkbox_post_id);
            
            switch($bulk_options) {
                case "live":
                    $query = "UPDATE posts SET post_status = 'live' WHERE post_id = $checkbox_post_id";
                    $live_post_query = mysqli_query($connection, $query);
                    break;
                case "draft":
                    $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = $checkbox_post_id";
                    $draft_post_query = mysqli_query($connection, $query);
                    break;
                case "delete":
                    $query = "DELETE FROM posts WHERE post_id = $checkbox_post_id";
                    $delete_post_query = mysqli_query($connection, $query);
                    break;
                case "clone":
                    $query = "SELECT * FROM posts WHERE post_id = $checkbox_post_id";
                    $select_clone_query = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($select_clone_query)) {
                        $post_autor = $row["post_autor"];
                        $post_title = $row["post_title"];
                        $post_category = $row["post_cat"];
                        $post_status = $row["post_status"];
                        $post_image = $row["post_img"];
                        $post_tags = $row["post_tags"];
                        $post_date = $row["post_date"];
                        $post_content = $row["post_content"];
                    }
                    $query = "INSERT INTO posts(post_cat, post_title, post_autor, post_date, post_img, post_content, post_tags, post_comment_count, post_status) VALUES ($post_category, '$post_title', '$post_autor', '$post_date' , '$post_image', '$post_content', '$post_tags', 0 , '$post_status');";
                    $clone_query = mysqli_query($connection, $query);

                    if(!$clone_query) {
                        die("Query failed" . mysqli_error($connection, $clone_query));
                    }
                    break;

            }
        }
    }
?>


<form method=POST>
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="live">Live</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="apply">
            <a href="posts.php?source=add_post" class="btn btn-primary">Add new</a>
        </div>
        <thead>
            <tr>
                <th><input class='checkBoxes' type='checkbox' id='selectAllBoxes' name='selectAllBoxes' value=$post_id></th>
                <th>Id</th>
                <th>Autor</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Count</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM posts INNER JOIN categories ON cat_id = post_cat ORDER BY post_id DESC;";
                $select_posts = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row["post_id"];
                    $post_autor = $row["post_autor"];
                    $post_title = $row["post_title"];
                    $post_category = $row["post_cat"];
                    $post_status = $row["post_status"];
                    $post_image = $row["post_img"];
                    $post_tags = $row["post_tags"];
                    $post_comments_count = $row["post_comment_count"];
                    $post_date = $row["post_date"];
                    $post_viewcount = $row["post_viewcount"];
                    $cat_id = $row["cat_id"];
                    $cat_title = $row["cat_title"];

                    echo "<tr>";
                    echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value=$post_id></td>";
                    echo "<td>$post_id</td>";
                    echo "<td>$post_autor</td>";
                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                    echo "<td>$cat_title</td>";
                    echo "<td>$post_status</td>";
                    echo "<td><img width='100px' height='40px' src='../images/$post_image'/></td>";
                    echo "<td>$post_tags</td>";

                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $comment_count_query = mysqli_query($connection, $query);
                    $comment_count = mysqli_num_rows($comment_count_query);

                    echo "<td><a href='comments.php?p_id=$post_id'>$comment_count</a></td>";
                    echo "<td>$post_date</td>";
                    echo "<td><a onClick=\"return confirm('Are you sure you want to reset viewcount?');\" href='posts.php?reset_viewcount={$post_id}'>$post_viewcount</a></td>";
                    echo "<td><a class='btn btn-primary' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    ?>
                    <form method="POST">
                        <input type="hidden" value="<?php echo $post_id?>" name="post_id">
                        <td><button class="btn btn-danger" type="submit" name="delete">Delete</button></td>
                    </form>
                    <?php
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</form>


<?php 
    if(isset($_POST["delete"])) {
        $post_id_to_delete = $_POST["post_id"];
        $post_id_to_delete = mysqli_real_escape_string($connection, $post_id_to_delete);
        $query = "DELETE FROM posts WHERE post_id = $post_id_to_delete";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
    if(isset($_GET["reset_viewcount"])) {
        $post_id_to_reset = $_GET["reset_viewcount"];
        $post_id_to_reset = mysqli_real_escape_string($connection, $post_id_to_reset);
        $query = "UPDATE posts SET post_viewcount = 0 WHERE post_id = $post_id_to_reset";
        $reset_query = mysqli_query($connection, $query);
        echo $query;
        header("Location: posts.php"); 
    }
?>