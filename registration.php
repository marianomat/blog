<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php
//    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
//
//        $username = $_POST["username"];
//        $email = $_POST["email"];
//        $password = $_POST["password"];
//
//        $error = [
//            "username" => "",
//            "email" => "",
//            "password" => ""
//        ];
//
//        if (strlen($username) < 4) {
//            $error["username"] = "El nombre de usuario debe tener más de 4 caracteres";
//        }
//        if($username == "") {
//            $error["username"] = "El nombre de usuario debe tener más de 4 caracteres";
//        }
//        if(username_exists($username)) {
//            $error["username"] = "El nombre ya existe";
//        }
//        if(email_exists($email)) {
//            $error["email"] = "El email ya existe";
//        }
//        if($email == "") {
//            $error["email"] = "Ingrese un email válido";
//        }
//        if($password  == "") {
//            $error["password"] = "La contraseña no puede estar vacia";
//        }
//        if(strlen($password)  < 4) {
//            $error["password"] = "La contraseña debe tener más de 4 caracteres";
//        }
//
//        foreach ($error as $key => $value) {
//            if (empty($value)) {
//                unset($error[$key]); # Elimina la clave para que quede vacio.
////                login_user($username, $password);
//            }
//        }
//
//        if(empty($error)) {
//            register_user($username, $email, $password);
//            login_user($username, $password);
//        }
//    }
?>

<!-- Page Content -->
<div class="container">
    
<!--<section id="login">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-xs-6 col-xs-offset-3">-->
<!--                <div class="form-wrap">-->
<!--                <h1>Registro</h1>-->
<!--                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">-->
<!--                        <div class="form-group">-->
<!--                            <label for="username" class="sr-only">username</label>-->
<!--                            <input value="--><?php //echo $username ?? ''; ?><!--" autocomplete="on" type="text" name="username" id="username" class="form-control" placeholder="Nombre de usuario">-->
<!--                            <p class="bg-danger">--><?php //echo $error["username"] ?? ''; ?><!--</p>-->
<!--                        </div>-->
<!--                         <div class="form-group">-->
<!--                            <label for="email" class="sr-only">Email</label>-->
<!--                            <input value="--><?php //echo $email ?? ''; ?><!--" autocomplete="on" type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">-->
<!--                            <p class="bg-danger">--><?php //echo $error["email"] ?? ''; ?><!--</p>-->
<!--                        </div>-->
<!--                         <div class="form-group">-->
<!--                            <label for="password" class="sr-only">Password</label>-->
<!--                            <input type="password" name="password" id="key" class="form-control" placeholder="Contraseña">-->
<!--                            <p class="bg-danger">--><?php //echo $error["password"] ?? ''; ?><!--</p>-->
<!--                        </div>-->
<!--                -->
<!--                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Registrarme">-->
<!--                    </form>-->
<!--                 -->
<!--                </div>-->
<!--            </div> <!-- /.col-xs-12 -->-->
<!--        </div> <!-- /.row -->-->
<!--    </div> <!-- /.container -->-->
<!--</section>-->


        <hr>



<?php include "includes/footer.php";?>
