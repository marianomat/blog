<div class="col-md-4">

                <!-- Blog Search Well -->
             
                <div class="well">
                    <h4>Buscar Posts</h4>
                    <form action="search.php" method="POST">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button name="submit" class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>


                 <!-- Login -->
                <?php 
                    if(isset($_SESSION['username'])) {
                   
                ?>
                        <div class="well">
                            <h4><?php echo "Bienvenido " . $_SESSION['username'] ?></h4>
                            <form action="includes/logout.php" method="POST">
                               <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit" name="login">
                                            Desloguear
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <!-- /.input-group -->
                        </div>


                  <?php  } else {
                 ?>
             
                <div class="well">
                    <h4>Ingresar</h4>
                    <form action="includes/login.php" method="POST">
                        <div class="form-group">
                            <input name="username" type="text" class="form-control" placeholder="Enter Username">
                        </div>
                         <div class="input-group">
                            <input name="password" type="password" class="form-control" placeholder="Enter Password">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" name="login">
                                    Login 
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                <?php } ?>



                <!-- Blog Categories Well -->
                <?php
                    $query = "SELECT cat_title, cat_id FROM categories";
                    $select_categories_sidebar_query = mysqli_query($connection, $query);
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $cat_title, $cat_id);
                ?>

                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                    while(mysqli_stmt_fetch($stmt)):
                                        echo "<li> 
                                                    <a href='category.php?category=$cat_id'> {$cat_title} </a>
                                             </li>";
                                    endwhile;
                                    mysqli_stmt_close($stmt);
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php"?>

            </div>