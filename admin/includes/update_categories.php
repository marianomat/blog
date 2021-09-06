<form action="" method="POST">
    <div class="form-group">
        <label for="cat_title">Edit Category Title</label>
            <?php
                if(isset($_GET["edit"])) {
                    $cat_id = mysqli_real_escape_string($connection, $_GET["edit"]);

                    $query = "SELECT * FROM categories WHERE cat_id = $cat_id;";
                    $select_cat_to_edit = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($select_cat_to_edit)) {
                        $cat_id = $row["cat_id"];
                        $cat_title = $row["cat_title"];
            ?>
            
            <input value="<?php if(isset($cat_title)) echo $cat_title; ?>" class="form-control" type="text" name="cat_title">

            <?php 
                    } 
                }
            ?>

            <?php 
                    // Editar categoria
                if(isset($_POST["update_cat"])) {
                    $cat_title_to_update = mysqli_real_escape_string($connection, $_POST["cat_title"]);
                    $query = "UPDATE categories SET cat_title = '$cat_title_to_update' WHERE cat_id = $cat_id_to_update;";
                    $update_query = mysqli_query($connection, $query);
                    header("location: categories.php"); //Refresh page
                }
            
            ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_cat" value="Edit Category">
    </div>
</form>