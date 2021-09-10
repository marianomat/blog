<?php 
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 60;
    $timeout = $time - $time_out_in_seconds;

    $query = "SELECT id FROM users_online WHERE session = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $session);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if($count == NULL) {
        $query = "INSERT INTO users_online(session, time) VALUES (?, ?)";
        $stmt= mysqli_prepare($connection,$query);
        mysqli_stmt_bind_param($stmt, "ss", $session, $time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $query = "UPDATE users_online SET time='$time' WHERE session = ?";
        $stmt= mysqli_prepare($connection,$query);
        mysqli_stmt_bind_param($stmt, "s", $session);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $query = "SELECT id FROM users_online WHERE time > ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $timeout);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count_user = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
?>


<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Panel del usuario</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../index.php">Usuarios Online <?php echo $count_user; ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                    <?php 
                        if(isset($_SESSION["username"])){
                            echo $_SESSION['username'];
                        } else {
                            echo "Usuario";
                        }
                    ?>
                     <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i>Perfil</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Desloguear</a>
                        </li>
                    </ul>
                </li>
            </ul>



            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i>Tablero</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="./posts.php">Ver todos los posts</a>
                            </li>
                            <li>
                                <a href="./posts.php?source=add_post">Añadir post</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categorias</a>
                    </li>
                    
                    <li class="">
                        <a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comentarios </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Usuarios <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="./users.php">Ver todos</a>
                            </li>
                            <li>
                                <a href="./users.php?source=add_user">Añadir usuario</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./profile.php"><i class="fa fa-fw fa-dashboard"></i> Perfil </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>