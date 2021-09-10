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

        $query = "INSERT INTO posts(post_cat, post_title, post_autor, post_date, post_img, post_content, post_tags, post_comment_count, post_status) 
    VALUES (?,?, ?, NOW() , ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection,$query);
        mysqli_stmt_bind_param($stmt, "isssssss", $post_cat, $post_title, $post_autor, $post_image, $post_content, $post_autor, $post_comments_count, $post_status);
        mysqli_stmt_execute($stmt);
        $post_id = mysqli_stmt_insert_id($stmt); #saca la ultima id creada
        mysqli_stmt_close($stmt);
        echo "<p class='bg-success'>Post creado, <a href='../post.php?p_id=$post_id'>Ver post</a></p>";
    }
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Titulo</label>
        <input type="text" class="form-control" name="post_title" id="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Categoria</label>
        <br/>
        <select name="post_cat" id="post_category">
            <?php 
                $query = "SELECT cat_id, cat_title FROM categories;";
                $stmt = mysqli_prepare($connection,$query);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
                while(mysqli_stmt_fetch($stmt)) :
                    echo "<option value='$cat_id'>$cat_title</option>";
                endwhile;
                mysqli_stmt_close($stmt);
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Estado</label>
        </br>
        <select name="post_status" id="post_status">
            <option value="draft">Borrador</option>
            <option value="live">Activo</option>
        </select>
        
    </div>
    <div class="form-group">
        <label for="post_img">Imagen</label>
        <input type="file" name="post_img" id="post_img">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" id="post_tags">
    </div>
    <div class="form-group">
        <label for="summernote">Contenido</label>
        <textarea type="text" class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publicar Post">
    </div>

</form>