<?php 
    if(isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
   
        $query = "SELECT user_password, username, user_first_name, user_last_name, user_role, user_email FROM users WHERE user_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_password, $username, $user_first_name, $user_last_name, $user_role, $user_email);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

    }

    if(isset($_POST["edit_user"])) {
        $user_password = $_POST["user_password"];
        $username = $_POST["username"];
        $user_first_name = $_POST["user_first_name"];
        $user_last_name = $_POST["user_last_name"];
        $user_role = $_POST["user_role"];
        $user_email = $_POST["user_email"];

        iF (!empty($username) && !empty($user_email) && !empty($user_password)) {
            $error = [
                "username" => "",
                "email" => "",
                "password" => ""
            ];

            if (strlen($username) < 4) {
                $error["username"] = "El nombre de usuario debe tener más de 4 caracteres";
            }
            if($username == "") {
                $error["username"] = "El nombre de usuario debe tener más de 4 caracteres";
            }
            if(username_exists($username)) {
                $error["username"] = "El nombre ya existe";
            }
            if(email_exists($user_email)) {
                $error["email"] = "El email ya existe";
            }
            if($user_email == "") {
                $error["email"] = "Ingrese un email válido";
            }
            if($user_password  == "") {
                $error["password"] = "La contraseña no puede estar vacia";
            }
            if(strlen($user_password)  < 4) {
                $error["password"] = "La contraseña debe tener más de 4 caracteres";
            }

            foreach ($error as $key => $value) {
                if (empty($value)) {
                    unset($error[$key]); # Elimina la clave para que quede vacio.
//                login_user($username, $password);
                }
            }

            if(empty($error)) {
                $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

                $query = "UPDATE users SET 
                username = ?,
                user_password = ?,
                user_first_name = ?,
                user_last_name = ?,
                user_role = ?,
                user_email = ?
                WHERE user_id = ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "ssssssi", $username, $user_password, $user_first_name, $user_last_name, $user_role, $user_email, $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $editado = "Correctamente editado";
            }
        } else {
            echo "Error: campos obligatorios username, password y email";
        }
    } 
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <p class="bg-success"><?php echo $editado ?? ''; ?></p>
        <label for="username">Nombre de usuario</label>
        <input type="text" class="form-control" name="username" id="username" value="<?php echo $username;?>">
        <p class="bg-danger"><?php echo $error["username"] ?? ''; ?></p>
    </div>
    <div class="form-group">
        <label for="user_password">Contraseña</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password" id="user_password" placeholder="change password">
        <p class="bg-danger"><?php echo $error["password"] ?? ''; ?></p>
    </div>
    <div class="form-group">
        <label for="user_first_name">Nombre</label>
        <input type="text" class="form-control" name="user_first_name" id="user_first_name" value="<?php echo $user_first_name;?>">
    </div>
    <div class="form-group">
        <label for="user_last_name">Apellido</label>
        <input type="text" class="form-control" name="user_last_name" id="user_last_name" value="<?php echo $user_last_name;?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email;?>">
        <p class="bg-danger"><?php echo $error["email"] ?? ''; ?></p>
    </div>
    <div class="form-group">
        <label for="user_role">Rol</label>
        <br>
        <select  name="user_role" id="user_role">
            <option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
            <?php
                if($user_role === "admin") {
                    echo "<option value='suscriber'>Suscriptor</option>";
                } else {
                    echo "<option value='admin'>Admin</option>";
                }
            ?>
        </select>
    </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Editar Usuario">
    </div>

</form>