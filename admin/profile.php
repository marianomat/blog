<?php include "includes/admin_header.php" ?>

<?php
    if(isset($_SESSION["username"])) {
        $username = $_SESSION["username"];

        $query = "SELECT * FROM users WHERE username = '{$username}';";
        $select_user_profile_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($select_user_profile_query)) {
            $user_id = $row["user_id"];
            $user_password = $row["user_password"];
            $username = $row["username"];
            $user_first_name = $row["user_first_name"];
            $user_last_name = $row["user_last_name"];
            $user_role = $row["user_role"];
            $user_email = $row["user_email"];
            #$user_image = $row["user_image"];
        }
    }

    if(isset($_POST["edit_user_profile"])) {

        $user_password = $_POST["user_password"];
        $username = $_POST["username"];
        $user_first_name = $_POST["user_first_name"];
        $user_last_name = $_POST["user_last_name"];
        $user_role = $_POST["user_role"];
        $user_email = $_POST["user_email"];

        iF (!empty($username) && !empty($user_email) && !empty($user_password)) {
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

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <h1 class="page-header">
                        Users
                    </h1>


                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $username;?>">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" class="form-control" name="user_password" id="user_password" autocomplete="off">
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
                        <!-- <div class="form-group">
                            <label for="user_image">Image</label>
                            <input type="file" name="user_image" id="user_image">
                        </div> -->
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="edit_user_profile" value="Edit User">
                        </div>

                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?>