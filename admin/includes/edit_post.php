<?php 
    if(isset($_GET["p_id"])) {
        $post_id = $_GET["p_id"];
    }

    $query = "SELECT post_id, post_autor, post_title, post_cat, post_status, post_img, post_tags, post_comment_count, post_date, post_content 
FROM posts WHERE post_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $post_id, $post_autor, $post_title, $post_category,
        $post_status, $post_image, $post_tags, $post_comments_count, $post_date, $post_content);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if(isset($_POST["update_post"])) {
        $post_autor = $_POST["post_autor"];
        $post_title = $_POST["post_title"];
        $post_category = $_POST["post_category"];
        $post_status = $_POST["post_status"];
        $post_tags = $_POST["post_tags"];
        $post_content = $_POST["post_content"];
        $post_image = $_FILES["post_img"]["name"];
        $post_image_temp = $_FILES["post_img"]["tmp_name"];

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if(empty($post_image)) {
            $query = "SELECT post_img FROM posts WHERE post_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $post_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $post_image);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }

        $query = "UPDATE posts SET 
        post_cat = ?,
        post_title = ?,
        post_autor = ?,
        post_date = NOW(),
        post_img = ?,
        post_content = ?,
        post_tags = ?,
        post_status = ?
        WHERE post_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt,"issssssi", $post_category, $post_title, $post_autor, $post_image, $post_content, $post_tags,
        $post_status, $post_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<p class='bg-success'>Post editado <a href='../post.php?p_id=$post_id'>Ver Post </a></p>";
        
    }
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Titulo</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title ?>">
    </div>
    <div class="form-group">
        <label for="post_category">Categoria</label>
        </br>
        <select name="post_category" id="post_category">
            <?php 
                $query = "SELECT cat_id, cat_title FROM categories";
                $stmt = mysqli_prepare($connection,$query);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);

                while(mysqli_stmt_fetch($stmt)) {
                    if($cat_id == $post_category){
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
                    echo "<option " . $selected .   " value='$cat_id'>$cat_title</option>";
                }
                mysqli_stmt_close($stmt);
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_autor">Autor</label>
        <input type="text" class="form-control" name="post_autor" value="<?php echo $post_autor ?>" id="post_autor">
    </div>
    <div class="form-group">
        <label for="post_status">Estado</label>
 
        </br>
        <select name="post_status" id="post_status">
            <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>

            <?php 
                if($post_status === "live") {
                    echo "<option value='draft'>Borrador</option>";
                } else {
                    echo "<option value='live'>Activo</option>";
                }
            ?>
        </select>

    </div>
    <div class="form-group">
        <label for="post_img">Imagen</label>
        <input type="file" name="post_img" id="post_img">
        <img width="100" src="../images/<?php echo $post_image;?>" alt="">
    </div>
    <div class="form-group">
        <label for="post_tags">Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags?>" id="post_tags">
    </div>
    <div class="form-group">
        <label for="summernote">Contenido</label>
        <textarea type="text" class="form-control" name="post_content" cols="30" rows="10" id="summernote">
            <?php echo $post_content ?>
        </textarea>
    </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Publicar Post" >
    </div>

</form>