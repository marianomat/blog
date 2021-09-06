<?php
    function confirm_query($query_result) {
        global $connection;
        if(!$query_result) {
            die("Query Failed". mysqli_error($connection));
        } 
    }
    
    
    function insert_categories() {
        global $connection;
        if(isset($_POST["submit"])) {
            $cat_title = $_POST["cat_title"];
            if($cat_title == "" || empty($cat_title)) {
            echo "This field should not by empty.";
            } else {
                $query = "INSERT INTO categories (cat_title) VALUES ('{$cat_title}');";

                $create_category_query = mysqli_query($connection, $query);
                
                if(!$create_category_query) {
                    die("Query Failed" . mysqli_error($connection));
                }
            }
        }   
    }

    function find_all_categories() {
        global $connection;
        $query = "SELECT * FROM categories";
        $select_categories_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_categories_query)) {
            $cat_id = $row["cat_id"];
            $cat_title = $row["cat_title"];
            echo    "<tr>
                        <td>$cat_id</td>
                        <td>$cat_title</td>
                        <td><a href='categories.php?delete=$cat_id'>Delete</a></td>
                        <td><a href='categories.php?edit=$cat_id'>Edit</a></td>
                    </tr>";
        }
    }

    function delete_categories() {
        global $connection;
        if(isset($_GET["delete"])) {
            $cat_id_to_delete = $_GET["delete"];
            $query = "DELETE FROM categories WHERE cat_id = $cat_id_to_delete;";
            $delete_query = mysqli_query($connection, $query);
            header("location: categories.php"); //Refresh page
        }
    }
?>