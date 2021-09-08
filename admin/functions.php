<?php
    function confirm_query($query_result) {
        global $connection;
        if(!$query_result) {
            die("Query Failed". mysqli_error($connection));
        } 
    }

    # Es para el grafico del index admin
    function row_count_one_condition($entity, $condition, $condition_value) {
        global $connection;
        $query = "SELECT * FROM $entity WHERE $condition = '$condition_value';";
        $selected_rows = mysqli_query($connection, $query);
        return mysqli_num_rows($selected_rows);
    }

    # Es para los totales que muestran en el index admin
    function rows_count($entity) {
        global $connection;
        $query = "SELECT * FROM $entity;";
        $count_query = mysqli_query($connection, $query);
        return mysqli_num_rows($count_query);
    }
    function insert_categories() {
        global $connection;
        if(isset($_POST["submit"])) {
            $cat_title = $_POST["cat_title"];
            if($cat_title == "" || empty($cat_title)) {
                echo "This field should not by empty.";
            } else {
                $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES (?);");
                mysqli_stmt_bind_param($stmt, "s", $cat_title);
                mysqli_stmt_execute($stmt);

                if(!$stmt) {
                    die("Query Failed" . mysqli_error($connection));
                }
                mysqli_stmt_close($stmt);

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

    function is_admin($username): bool
    {
        global $connection;
        $query = "SELECT user_role FROM users WHERE username = '$username';";
        $result = mysqli_query($connection, $query);
        confirm_query($result);

        $row = mysqli_fetch_array($result);
        iF($row["user_role"] == "admin") {
            return true;
        } else {
            return false;
        }
    }

    function username_exists($username): bool
    {
        global $connection;
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        confirm_query($result);

        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function email_exists($email): bool
    {
        global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = mysqli_query($connection, $query);
        confirm_query($result);

        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function redirect($location) {
        return Header("Location: $location");
        die();
    }

    function register_user($username, $email, $password) {
        global $connection;

        $username = trim(mysqli_real_escape_string($connection, $username));
        $email = trim(mysqli_real_escape_string($connection, $email));
        $password = trim(mysqli_real_escape_string($connection, $password));

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('$username', '$email', '$password', 'suscriber');";
        $register_query = mysqli_query($connection, $query);
    }

    function login_user($username, $user_password) {
        global $connection;

        ## mysqli_real_escape_string para sanitizar los inputs del front
        $username = trim(mysqli_real_escape_string($connection, $username));
        $user_password = trim(mysqli_real_escape_string($connection, $user_password));

        $query = "SELECT * FROM users WHERE username = '{$username}';";
        $select_user_query = mysqli_query($connection, $query);

        if (!$select_user_query) {
            die("QUERY FAILED" . mysqli_error($connection));
        }

        while ($row = mysqli_fetch_array($select_user_query)) {
            $db_user_id = $row["user_id"];
            $db_user_password = $row["user_password"];
            $db_username = $row["username"];
            $db_user_first_name = $row["user_first_name"];
            $db_user_last_name = $row["user_last_name"];
            $db_user_role = $row["user_role"];
            $db_user_email = $row["user_email"];
        }
        if (password_verify($user_password, $db_user_password)) {

            $_SESSION["username"] = $db_username;
            $_SESSION["id"] = $db_user_id;
            $_SESSION["user_first_name"] = $db_user_first_name;
            $_SESSION["user_last_name"] = $db_user_last_name;
            $_SESSION["user_role"] = $db_user_role;
            redirect("/cms/admin");
        }   else {
            redirect("/cms/index.php");
        }
    }
?>