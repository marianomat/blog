<?php ob_start(); ?>
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
        $query = "SELECT * FROM $entity WHERE $condition = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $condition_value);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $selected_rows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        return $selected_rows;
    }

    # Es para los totales que muestran en el index admin
    function rows_count($entity) {
        global $connection;
        $query = "SELECT * FROM $entity;";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $count_query = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        return $count_query;
    }
    function insert_categories() {
        global $connection;
        if(isset($_POST["submit"])) {
            $cat_title = $_POST["cat_title"];
            if($cat_title == "" || empty($cat_title)) {
                echo "This field should not by empty.";
            } else {
                $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES (?)");
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
        $query = "SELECT cat_id, cat_title FROM categories";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
        while(mysqli_stmt_fetch($stmt)) {
            echo    "<tr>
                        <td>$cat_id</td>
                        <td>$cat_title</td>
                        <td><a class='btn btn-sm btn-danger' href='categories.php?delete=$cat_id'>Eliminar</a></td>
                        <td><a class='btn btn-sm btn-info' href='categories.php?edit=$cat_id'>Editar</a></td>
                    </tr>";
        }
        mysqli_stmt_close($stmt);
    }

    function delete_categories() {
        global $connection;
        if(isset($_GET["delete"])) {
            $cat_id_to_delete = $_GET["delete"];
            $query = "DELETE FROM categories WHERE cat_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $cat_id_to_delete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: categories.php"); //Refresh page
        }
    }

    function is_admin($username): bool
    {
        global $connection;
        $query = "SELECT user_role FROM users WHERE username = ?"; #BUG
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_role);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        iF($user_role == "admin") {
            return true;
        } else {
            return false;
        }
    }

    function username_exists($username): bool
    {
        global $connection;
        $query = "SELECT username FROM users WHERE username = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username);
        mysqli_stmt_store_result($stmt);


        if(mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            mysqli_stmt_close($stmt);
            return false;
        }
    }

    function email_exists($email): bool
    {
        global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $email);
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            mysqli_stmt_close($stmt);
            return false;
        }
    }

    function redirect($location) {
        Header("Location: $location");
    }

    function register_user($username, $email, $password) {
        global $connection;

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES (?, ?, ?, 'suscriber')";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email,$password);
        mysqli_stmt_execute($stmt);
        if(!$stmt) {
            echo mysqli_error($connection);
        mysqli_stmt_close($stmt);
        }
    }
    function login_user($username, $user_password) {
        global $connection;

        $stmt = mysqli_prepare($connection, "SELECT user_id, user_password, username, user_first_name, user_last_name, user_role, user_email FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $db_user_id, $db_user_password, $db_username, $db_user_first_name, $db_user_last_name, $db_user_role, $db_user_email);
        mysqli_stmt_fetch($stmt);
        if (password_verify($user_password, $db_user_password)) {
            $_SESSION["username"] = $db_username;
            $_SESSION["id"] = $db_user_id;
            $_SESSION["user_first_name"] = $db_user_first_name;
            $_SESSION["user_last_name"] = $db_user_last_name;
            $_SESSION["user_role"] = $db_user_role;
            redirect("/cms/admin");
            # redirect("https://marianopereyra.com/blog/admin");
        }   else {
            redirect("/cms/index.php");
            # redirect("https://marianopereyra.com/blog/admin");
        }
        mysqli_stmt_close($stmt);
    }
?>