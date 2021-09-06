<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php
    if(isset($_POST["submit"])) {
        $username =  $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        iF (!empty($username) && !empty($email) && !empty($password)) {
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

           /*  $query = "SELECT rand_salt FROM users";
            $select_rand_salt_query = mysqli_query($connection,$query);

            if(!$select_rand_salt_query) {
                die("Query Failed " . mysqli_error($connection, $query));
            }
 */
           /*  $row = mysqli_fetch_array($select_rand_salt_query);
            $rand_salt = $row["rand_salt"];

            $password = crypt($password, $rand_salt); */
            

            $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('$username', '$email', '$password', 'suscriber');";
            $register_query = mysqli_query($connection, $query);

            $message = "<h6 class='bg-success text-center'>Everything looks fine</h6>";
        } else {
            $message = "<h6 class='bg-danger text-center'>Must fill all inputs</h6>"; 
        }

        
    } else {
        $message = "";
    }
?>

<!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        <?php echo "$message"?>
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
