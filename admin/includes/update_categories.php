<form action="" method="POST">
    <div class="form-group">
        <label for="cat_title">Editar nombre categoria</label>
            <?php
                if(isset($_GET["edit"])) {
                    $cat_id = $_GET["edit"];

                    $query = "SELECT cat_id, cat_title FROM categories WHERE cat_id = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $cat_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                ?>
                        <input value="<?php if(isset($cat_title)) echo $cat_title; ?>" class="form-control" type="text" name="cat_title">
                <?php
                }
                ?>

            <?php 
                    // Editar categoria
                if(isset($_POST["update_cat"])) {
                    $cat_title = $_POST["cat_title"];
                    $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?;");
                    mysqli_stmt_bind_param($stmt, "si", $cat_title, $cat_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    redirect("categories.php");
                }
            
            ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_cat" value="Editar">
    </div>
</form>