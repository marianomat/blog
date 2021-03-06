<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Bienvenido
                        </h1>

                        <div class="col-xs-6">
                            <?php 
                                insert_categories();
                            ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="cat_title">Añadir categoria</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Añadir">
                                </div>
                            </form>

                            <?php
                                if(isset($_GET["edit"])) {
                                    $cat_id_to_update = $_GET["edit"];
                                    include "includes/update_categories.php";
                                }
                            ?>
                            
                        </div>
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre categoria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Encontrar categorias
                                        find_all_categories();
                                    ?>

                                    <?php 
                                        // Eliminar categoria
                                        delete_categories();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
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