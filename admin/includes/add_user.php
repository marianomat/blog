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

        $username = mysqli_real_escape_string($connection, $username);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $user_password = mysqli_real_escape_string($connection, $user_password);

        iF (!empty($username) && !empty($user_email) && !empty($user_password)) {

           /*  $query = "SELECT rand_salt FROM users";
            $select_rand_salt_query = mysqli_query($connection,$query);

            if(!$select_rand_salt_query) {
                die("Query Failed " . mysqli_error($connection, $query));
            }

            $row = mysqli_fetch_array($select_rand_salt_query);
            $rand_salt = $row["rand_salt"];

            $user_password = crypt($user_password, $rand_salt); */
                
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10)); 

            $query = "INSERT INTO users(username, user_password, user_first_name, user_last_name, user_role, user_email) VALUES ('$username', '$user_password', '$user_first_name', '$user_last_name' , '$user_role', '$user_email');";

            $create_user_query = mysqli_query($connection, $query);
            confirm_query($create_user_query);

            echo "User Created: " . "<a href='users.php'> View Users </a>";

         } else {
            echo "Error: campos obligatorios username, password y email";
        }

    }
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" id="user_password">
    </div>
    <div class="form-group">
        <label for="user_first_name">First Name</label>
        <input type="text" class="form-control" name="user_first_name" id="user_first_name">
    </div>
    <div class="form-group">
        <label for="user_last_name">Last Name</label>
        <input type="text" class="form-control" name="user_last_name" id="user_last_name">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" id="user_email">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <br>
        <select value="suscriber" name="user_role" id="user_role">
            <option value="">Select Option</option>
            <option value="admin">Admin</option>
            <option value="suscriber">Suscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" name="user_image" id="user_image">
    </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>

</form>