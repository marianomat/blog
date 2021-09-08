 <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Role</th>
            <th>Role</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT * FROM users;";
            $select_users = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row["user_id"];
                $user_password = $row["user_password"];
                $username = $row["username"];
                $user_first_name = $row["user_first_name"];
                $user_last_name = $row["user_last_name"];
                $user_role = $row["user_role"];
                $user_email = $row["user_email"];
                $user_image = $row["user_image"];
                $user_salt = $row["rand_salt"];


                echo "<tr>";
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$user_first_name</td>";
                echo "<td>$user_last_name</td>";
                echo "<td>$user_role</td>";
                echo "<td>$user_email</td>";
                echo "<td><a href='users.php?admin={$user_id}'>Admin</a></td>";
                echo "<td><a href='users.php?suscriber={$user_id}'>Suscriber</a></td>";
                echo "<td><a href='users.php?source=edit_user&user_id={$user_id}'>Edit</a></td>";
                echo "<td><a href='users.php?delete_user={$user_id}'>Delete</a></td>";
                echo "</tr>";

            }
        ?>
    </tbody>
</table>

<?php 
    if(isset($_GET["delete_user"])) {
        if(isset($_SESSION["user_role"])) {
            if($_SESSION["user_role"] == "admin") {
                $user_id_to_delete = mysqli_real_escape_string($connection, $_GET["delete_user"]);
                $query = "DELETE FROM users WHERE user_id = $user_id_to_delete";
                $delete_query = mysqli_query($connection, $query);
                header("Location: users.php"); 
            } else {
            echo "<h1>Permisos insuficientes</h1>";
            }
        } else {
            echo "<h1>Permisos insuficientes</h1>";
        }
        
    }

    if(isset($_GET["admin"])) {
        $user_id_to_admin = mysqli_real_escape_string($connection, $_GET["admin"]);
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $user_id_to_admin";
        $admin_query = mysqli_query($connection, $query);
        header("Location: users.php"); 
    }

    if(isset($_GET["suscriber"])) {
        $user_id_to_suscriber = mysqli_real_escape_string($connection, $_GET["suscriber"]);
        $query = "UPDATE users SET user_role = 'suscriber' WHERE user_id = $user_id_to_suscriber";
        $suscriber_query = mysqli_query($connection, $query);
        header("Location: users.php"); 
    }
?>