<?php 
    if(isset($_POST["create_post"])) {
        $post_title = $_POST["post_title"];
        $post_cat = $_POST["post_cat"];
        $post_status = $_POST["post_status"];
        $post_tags = $_POST["post_tags"];
        $post_content = $_POST["post_content"];
        $post_image = $_FILES["post_img"]["name"];
        $post_image_temp = $_FILES["post_img"]["tmp_name"];
        $post_comments_count = 0;
        $post_autor = $_SESSION['id'];

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO posts(post_cat, post_title, post_autor, post_date, post_img, post_content, post_tags, post_comment_count, post_status) VALUES ($post_cat, '$post_title', '$post_autor', NOW() , '$post_image', '$post_content', '$post_tags', '$post_comments_count', '$post_status');";

        $create_post_query = mysqli_query($connection, $query);
        confirm_query($create_post_query);

        $post_id = mysqli_insert_id($connection); #saca la ultima id creada

        echo "<p class='bg-success'>Post Created, <a href='../post.php?p_id=$post_id'>View Post </a></p>";

    }
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title" id="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <br/>
        <select name="post_cat" id="post_category">
            <?php 
                $query = "SELECT * FROM categories;";
                $select_categories = mysqli_query($connection, $query);

                confirm_query($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row["cat_id"];
                    $cat_title = $row["cat_title"];

                    echo "<option value='$cat_id'>$cat_title</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        </br>
        <select name="post_status" id="post_status">
            <option value="draft">draft</option>
            <option value="live">live</option>  
        </select>
        
    </div>
    <div class="form-group">
        <label for="post_img">Post Image</label>
        <input type="file" name="post_img" id="post_img">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" id="post_tags">
    </div>
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>

</form>