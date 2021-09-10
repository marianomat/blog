<?php 
    if(isset($_POST["create_user"])) {
        $user_password = $_POST["user_password"];
        $username = $_POST["username"];
        $user_first_name = $_POST["user_first_name"];
        $user_last_name = $_POST["user_last_name"];
        $user_role = $_POST["user_role"];
        $user_email = $_POST["user_email"];
        #$user_image = $_FILES["user_image"]["name"];
        #$user_image_temp = $_FILES["user_image"]["tmp_name"];

        #move_uploaded_file($user_image_temp, "../images/$user_image");
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

                $query = "INSERT INTO users(username, user_password, user_first_name, user_last_name, user_role, user_email) VALUES 
                           (?,?,?,?,?,?)";

                $stmt = mysqli_prepare($connection,$query);
                mysqli_stmt_bind_param($stmt,"ssssss", $username, $user_password,$user_first_name, $user_last_name, $user_role, $user_email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "<p class='bg-success'>Usuario creado: " . "<a href='users.php'> View Users </a></p>";
            }

         } else {
            echo "Error: campos obligatorios username, password y email";
        }

    }
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Nombre usuario</label>
        <input type="text" class="form-control" name="username" id="username" value="<?php echo $username ?? '';?>">
        <p class="bg-danger"><?php echo $error["username"] ?? ''; ?></p>
    </div>
    <div class="form-group">
        <label for="user_password">Contraseña</label>
        <input type="password" class="form-control" name="user_password" id="user_password">
        <p class="bg-danger"><?php echo $error["password"] ?? ''; ?></p>
    </div>
    <div class="form-group">
        <label for="user_first_name">Nombre</label>
        <input type="text" class="form-control" name="user_first_name" id="user_first_name" value="<?php echo $user_first_name ?? '';?>">
    </div>
    <div class="form-group">
        <label for="user_last_name">Apellido</label>
        <input type="text" class="form-control" name="user_last_name" id="user_last_name" value="<?php echo $user_last_name ?? '';?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email ?? ''  ;?>">
        <p class="bg-danger"><?php echo $error["email"] ?? ''; ?></p>
    </div>
    <div class="form-group">
        <label for="user_role">Rol</label>
        <br>
        <select value="suscriber" name="user_role" id="user_role">
            <option value="">Select Option</option>
            <option value="admin">Admin</option>
            <option value="suscriber">Suscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="user_image">Imagen</label>
        <input type="file" name="user_image" id="user_image">
    </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Crear usuario">
    </div>

</form>