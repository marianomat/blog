 <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID Usuario</th>
            <th>Nombre Usuario</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Rol</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Rol</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT user_id, user_password, username, user_first_name, user_last_name, user_role, user_email, user_image, rand_salt FROM users;";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $user_id, $user_password, $username, $user_first_name, $user_last_name, $user_role,$user_email,$user_image, $user_salt);

            while(mysqli_stmt_fetch($stmt)) {
                echo "<tr>";
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$user_first_name</td>";
                echo "<td>$user_last_name</td>";
                echo "<td>$user_role</td>";
                echo "<td>$user_email</td>";
                echo "<td><a href='users.php?admin={$user_id}'>Administrador</a></td>";
                echo "<td><a href='users.php?suscriber={$user_id}'>Suscriptor</a></td>";
                echo "<td><a class='btn btn-sm btn-info' href='users.php?source=edit_user&user_id={$user_id}'>Editar</a></td>";
                echo "<td><a class='btn btn-sm btn-danger' href='users.php?delete_user={$user_id}'>Eliminar</a></td>";
                echo "</tr>";

            }
            mysqli_stmt_close($stmt);
        ?>
    </tbody>
</table>

<?php 
    if(isset($_GET["delete_user"])) {
        if(isset($_SESSION["user_role"])) {
            if($_SESSION["user_role"] == "admin") {
                $user_id_to_delete = $_GET["delete_user"];
                $query = "DELETE FROM users WHERE user_id = ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt,"i", $user_id_to_delete);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: users.php");
            } else {
            echo "<h1>Permisos insuficientes</h1>";
            }
        } else {
            echo "<h1>Permisos insuficientes</h1>";
        }
        
    }

    if(isset($_GET["admin"])) {
        $user_id_to_admin = $_GET["admin"];
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id_to_admin);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: users.php");
    }

    if(isset($_GET["suscriber"])) {
        $user_id_to_suscriber = $_GET["suscriber"];
        $query = "UPDATE users SET user_role = 'suscriber' WHERE user_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id_to_suscriber);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: users.php"); 
    }
?>