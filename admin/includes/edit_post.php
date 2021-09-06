<?php 
    if(isset($_GET["p_id"])) {
        $post_id = $_GET["p_id"];
    }

    $query = "SELECT * FROM posts WHERE post_id = $post_id;";
    $select_post_by_id = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_post_by_id)) {
        $post_id = $row["post_id"];
        $post_autor = $row["post_autor"];
        $post_title = $row["post_title"];
        $post_category = $row["post_cat"];
        $post_status = $row["post_status"];
        $post_image = $row["post_img"];
        $post_tags = $row["post_tags"];
        $post_comments_count = $row["post_comment_count"];
        $post_date = $row["post_date"];
        $post_content = $row["post_content"];
    }


    if(isset($_POST["update_post"])) {
        $post_autor = mysqli_real_escape_string($connection, $_POST["post_autor"]);
        $post_title = mysqli_real_escape_string($connection, $_POST["post_title"]);
        $post_category = mysqli_real_escape_string($connection, $_POST["post_category"]);
        $post_status = mysqli_real_escape_string($connection, $_POST["post_status"]);
        $post_tags = mysqli_real_escape_string($connection, $_POST["post_tags"]);
        $post_content = mysqli_real_escape_string($connection, $_POST["post_content"]);
        $post_image = $_FILES["post_img"]["name"];
        $post_image_temp = $_FILES["post_img"]["tmp_name"];

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if(empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = $post_id;";
            $select_image = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc ($select_image)) {
                $post_image = $row["post_img"];
            }
        }

        $query = "UPDATE posts SET 
        post_cat = $post_category,
        post_title = '$post_title',
        post_autor = '$post_autor',
        post_date = NOW(),
        post_img = '$post_image',
        post_content = '$post_content',
        post_tags = '$post_tags',
        post_status = '$post_status'
        WHERE post_id = $post_id;";

        $update_post_query = mysqli_query($connection, $query);
        confirm_query($update_post_query);


        echo "<p class='bg-success'>Post Updated, <a href='../post.php?p_id=$post_id'>View Post </a></p>";
        
    }
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title ?>">
    </div>
    <div class="form-group">
        <label for="post_category">Post category</label>
        </br>
        <select name="post_category" id="post_category">
            <?php 
                $query = "SELECT * FROM categories;";
                $select_categories = mysqli_query($connection, $query);

                confirm_query($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row["cat_id"];
                    $cat_title = $row["cat_title"];
                    if($cat_id == $post_category){
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
                    echo "<option " . $selected .   " value='$cat_id'>$cat_title</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_autor">Post Autor</label>
        <input type="text" class="form-control" name="post_autor" value="<?php echo $post_autor ?>" id="post_autor">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
 
        </br>
        <select name="post_status" id="post_status">
            <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>

            <?php 
                if($post_status === "live") {
                    echo "<option value='draft'>draft</option>";
                } else {
                    echo "<option value='live'>live</option>";
                }
            ?>
        </select>

    </div>
    <div class="form-group">
        <label for="post_img">Post Image</label>
        <input type="file" name="post_img" id="post_img">
        <img width="100" src="../images/<?php echo $post_image;?>" alt="">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags?>" id="post_tags">
    </div>
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" cols="30" rows="10" id="summernote">
            <?php echo $post_content ?>
        </textarea>
    </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Publish Post" >
    </div>

</form>