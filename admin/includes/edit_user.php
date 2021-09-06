<?php 
    if(isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
   
        $query = "SELECT * FROM users WHERE user_id = $user_id;";
        $select_user_by_id = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_user_by_id)) {
            $user_password = $row["user_password"];
            $username = $row["username"];
            $user_first_name = $row["user_first_name"];
            $user_last_name = $row["user_last_name"];
            $user_role = $row["user_role"];
            $user_email = $row["user_email"];
            /* $rand_salt = $row["rand_salt"]; */
        }
       
        /* $user_password = crypt($user_password, $rand_salt); */

    }

    if(isset($_POST["edit_user"])) {
        
        $user_password = $_POST["user_password"];
        $username = $_POST["username"];
        $user_first_name = $_POST["user_first_name"];
        $user_last_name = $_POST["user_last_name"];
        $user_role = $_POST["user_role"];
        $user_email = $_POST["user_email"];

        iF (!empty($username) && !empty($user_email) && !empty($user_password)) {
            /* $query = "SELECT rand_salt FROM users";
            $select_rand_salt_query = mysqli_query($connection,$query);

            if(!$select_rand_salt_query) {
                die("Query Failed " . mysqli_error($connection, $query));
            }

            $row = mysqli_fetch_array($select_rand_salt_query);
            $rand_salt = $row["rand_salt"];

            $hashed_password = crypt($user_password, $rand_salt); */
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10)); 

            $query = "UPDATE users SET 
            username = '$username',
            user_password = '$user_password',
            user_first_name = '$user_first_name',
            user_last_name = '$user_last_name',
            user_role = '$user_role',
            user_email = '$user_email'
            WHERE user_id = $user_id;";

            $update_user_query = mysqli_query($connection, $query);
            confirm_query($update_user_query);
        } else {
            echo "Error: campos obligatorios username, password y email";
        }
    } 
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username" value="<?php echo $username;?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password" id="user_password" placeholder="change password">
    </div>
    <div class="form-group">
        <label for="user_first_name">First Name</label>
        <input type="text" class="form-control" name="user_first_name" id="user_first_name" value="<?php echo $user_first_name;?>">
    </div>
    <div class="form-group">
        <label for="user_last_name">Last Name</label>
        <input type="text" class="form-control" name="user_last_name" id="user_last_name" value="<?php echo $user_last_name;?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email;?>">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <br>
        <select  name="user_role" id="user_role">
            <option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
            <?php
                if($user_role === "admin") {
                    echo "<option value='suscriber'>Suscriber</option>";
                } else {
                    echo "<option value='admin'>Admin</option>";
                }
            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" name="user_image" id="user_image">
    </div> -->
     <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
    </div>

</form>