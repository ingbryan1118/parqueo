<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barra de Navegación Vertical</title>
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
                        }

                        echo '<li class="nav-item">
                  <a class="nav-link" href="verplacas.php">
                      <i class="fa fa-sign-out"></i> Ver Placas
                  </a>
                </li>';
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

                        <li class="nav-item">
                            <a class="nav-link" href="reporte.php">
                                <i class="fa fa-sign-out"></i> Reporte
                            </a>
                        </li>

                        <?php
                        // Lógica condicional para ocultar elementos según el tipo de usuario
                        if ($tipoUsuario != 2) {
                            //             echo '<li class="nav-item">
                            //     <a class="nav-link" href="reporte.php">
                            //         <i class="fa fa-sign-out"></i> Reporte
                            //     </a>
                            //   </li>';

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
                    <h2 class="text-center">Reportes</h2>

                    <div class="row">

                        <div class="col-md-4">
                        <h3 class="text-center">Reportes con placas</h3>
                            <form id="fechaForm" method="POST" action="../controllers/generar_informe.php">
                                <div class="form-group">
                                    <label for="fecha">Selecciona una fecha:</label>
                                    <input type="date" id="fecha" name="fecha">
                                </div>
                                <button type="submit" class="btn btn-primary">Generar Informe</button>
                            </form>



                        </div>
                        <div class="col-md-4">
                        <h3 class="text-center">Reporte caja</h3>
                        <form id="fechaForm" method="POST" action="../controllers/generarInformeTotal.php">
                                <div class="form-group">
                                    <label for="fecha">Selecciona una fecha:</label>
                                    <input type="date" id="fecha" name="fecha">
                                </div>
                                <button type="submit" class="btn btn-primary">Informe Diario</button>
                            </form>

                        </div>

                    </div>

                </div>
            </main>
        </div>
    </div>
    <!-- <script src="script.js"></script> -->
    <!-- Agrega los enlaces a Bootstrap JS y jQuery (debes incluir jQuery antes de Bootstrap JS)
 -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../jquery/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>



</html>