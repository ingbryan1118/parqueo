<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>



<?php
session_start();
$tipoUsuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;


if (isset($_SESSION['correo'])) {
    // El usuario está autenticado, muestra el contenido 

} else {
    header("Location: login.php");
}
?>


<body>
    <div class="container-fluid">
        <div class="row">
        <?php include('navbar.php'); ?>

            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">


                    <div class="row">
                        <div class="col-md-8 ">
                            <h2 class="text-center">Registrar Usuario</h2>
                            <form action="../controllers/procesar_registro.php" method="POST">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>

                                <div class="form-group">
                                    <label for="correo">Correo:</label>
                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                </div>

                                <div class="form-group">
                                    <label for="contrasena">Contraseña:</label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                                </div>

                                <div class="form-group">
                                    <label for="tipo_usuario">Tipo de Usuario:</label>
                                    <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                                        <option value="1">ADMINISTRADOR</option>
                                        <option value="2">DIGITADOR</option>


                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </form>
                        </div>


                    </div>

                    <?php

                    if (isset($_GET["exito"]) && $_GET["exito"] == 1) {

                        echo '<div class="alert alert-success mt-3 alert-dismissible fade show">
                Usuario Creado Exitosamente
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
                    }


                    ?>
                </div>
            </main>
        </div>
    </div>
    <!-- <script src="script.js"></script> -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../jquery/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Agrega los enlaces a Bootstrap JS y jQuery (debes incluir jQuery antes de Bootstrap JS) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>

</html>