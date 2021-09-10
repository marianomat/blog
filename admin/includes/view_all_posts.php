<?php
    if(isset($_POST["checkBoxArray"])) {
        foreach($_POST["checkBoxArray"] as $checkbox_post_id) {
            $bulk_options = $_POST["bulk_options"];
            
            switch($bulk_options) {
                case "live":
                    $query = "UPDATE posts SET post_status = 'live' WHERE post_id = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $checkbox_post_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    break;
                case "draft":
                    $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $checkbox_post_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    break;
                case "delete":
                    $query = "DELETE FROM posts WHERE post_id = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $checkbox_post_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    break;
                case "clone":
                    $query = "SELECT posT_autor, post_title, post_cat, post_status, post_img, post_tags, post_date, post_content FROM posts WHERE post_id = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $checkbox_post_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $post_autor, $post_title, $post_category, $post_status, $post_image, $post_tags, $post_date, $post_content);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                    $query = "INSERT INTO posts(post_cat, post_title, post_autor, post_date, post_img, post_content, post_tags, post_comment_count, post_status) VALUES (?, ?, ?, ?, ?, ?, ?, 0 , ?)";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "isssssss", $post_category, $post_title, $post_autor, $post_date, $post_image, $post_content, $post_tags, $post_status);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    break;

            }
        }
    }
?>


<form method=POST>
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Opcioness</option>
                <option value="live">Activo</option>
                <option value="draft">Borrador</option>
                <option value="delete">Eliminar</option>
                <option value="clone">Clonar</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Aplicar">
            <a href="posts.php?source=add_post" class="btn btn-primary">Agregar</a>
        </div>
        <thead>
            <tr>
                <th><input class='checkBoxes' type='checkbox' id='selectAllBoxes' name='selectAllBoxes' value=$post_id></th>
                <th>Id</th>
                <th>Autor</th>
                <th>Titulo</th>
                <th>Categoria</th>
                <th>Estado</th>
                <th>Imagen</th>
                <th>Tags</th>
                <th>Comentarios</th>
                <th>Fecha</th>
                <th>Visitas</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT post_id, post_autor, post_title, post_cat, post_status, post_img, post_tags, post_comment_count, post_date, post_viewcount, cat_id, cat_title FROM posts INNER JOIN categories ON cat_id = post_cat ORDER BY post_id DESC";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $post_id, $post_autor, $post_title, $post_category, $post_status, $post_image, $post_tags, $post_comments_count, $post_date, $post_viewcount, $cat_id, $cat_title);

                while(mysqli_stmt_fetch($stmt)) {

                    echo "<tr>";
                    echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value=$post_id></td>";
                    echo "<td>$post_id</td>";
                    echo "<td>$post_autor</td>";
                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                    echo "<td>$cat_title</td>";
                    echo "<td>$post_status</td>";
                    echo "<td><img width='100px' height='40px' src='../images/$post_image'/></td>";
                    echo "<td>$post_tags</td>";
                    echo "<td><a href='comments.php?p_id=$post_id'>$post_comments_count</a></td>";
                    echo "<td>$post_date</td>";
                    echo "<td><a onClick=\"return confirm('Resetar visitas del post?');\" href='posts.php?reset_viewcount={$post_id}'>$post_viewcount</a></td>";
                    echo "<td><a class='btn btn-primary' href='posts.php?source=edit_post&p_id={$post_id}'>Editar</a></td>";
                    ?>
                    <form method="POST">
                        <input type="hidden" value="<?php echo $post_id?>" name="post_id">
                        <td><button class="btn btn-danger" type="submit" name="delete">Eliminar</button></td>
                    </form>
                    <?php
                    echo "</tr>";
                }
                mysqli_stmt_close($stmt);
            ?>
        </tbody>
    </table>
</form>


<?php 
    if(isset($_POST["delete"])) {
        $post_id_to_delete = $_POST["post_id"];
        $query = "DELETE FROM posts WHERE post_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $post_id_to_delete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: posts.php");
    }
    if(isset($_GET["reset_viewcount"])) {
        $post_id_to_reset = $_GET["reset_viewcount"];
        $query = "UPDATE posts SET post_viewcount = 0 WHERE post_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $post_id_to_reset);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: posts.php");
    }
?>