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
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">

                        <?php
                        // Lógica condicional para ocultar elementos según el tipo de usuario
                        if ($tipoUsuario != 2) {
                            //             echo '<li class="nav-item">
                            //     <a class="nav-link" href="reporte.php">
                            //         <i class="fa fa-sign-out"></i> Reporte
                            //     </a>
                            //   </li>';

                            echo '<li class="nav-item">
                  <a class="nav-link" href="creaplaca.php">
                      <i class="fa fa-sign-out"></i> Crear Placa
                  </a>
                </li>';

                echo '<li class="nav-item">
                  <a class="nav-link" href="verplacas.php">
                      <i class="fa fa-sign-out"></i> Ver Placas
                  </a>
                </li>';
                        }
                        ?>
                            <a class="nav-link active" href="index.php">
                                <i class="fa fa-home"></i> Registrar Parqueo
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="parqueo.php">
                                <i class="fa fa-list"></i> Lista de parqueo
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="parqueoMensual.php">
                                <i class="fa fa-list"></i> Listado Parqueo Mensual
                            </a>
                        </li>

                        <?php
                        // Lógica condicional para ocultar elementos según el tipo de usuario
                        if ($tipoUsuario != 2) {
                            echo '<li class="nav-item">
                    <a class="nav-link" href="reporte.php">
                        <i class="fa fa-sign-out"></i> Reporte
                    </a>
                  </li>';

                            echo '<li class="nav-item">
                  <a class="nav-link" href="creaUsuario.php">
                      <i class="fa fa-sign-out"></i> Crear Usuario
                  </a>
                </li>';

                            echo '<li class="nav-item">
                            <a class="nav-link" href="tarifas.php">
                                <i class="fa fa-sign-out"></i> Tarifas
                            </a>
                            </li>';
                        }



                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fa fa-sign-out"></i> Login
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

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