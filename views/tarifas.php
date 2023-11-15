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
                            <a class="nav-link active" href="index.php">
                                <i class="fa fa-home"></i> Registrar Parqueo
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="creaVehiculo.php">
                                <i class="fa fa-home"></i> Registrar Parqueo Mensual
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


                    <div class="row">
                        <div class="col-md-4 ">
                            <h2 class="text-center">Registro de Tarifas</h2>
                            <form method="POST" action="../controllers/guardar_tarifa.php">
                                <!-- <form id="parqueoForm"> -->
                                <div class="form-group">
                                    <label for="nombreTarifa">Nombre Tarifa:</label>
                                    <input type="text" class="form-control" id="nombreTarifa" name="nombreTarifa" required>
                                </div>
                                <div class="form-group">
                                    <label for="valorTarifa">Valor Tarifa:</label>
                                    <input type="number" class="form-control" id="valorTarifa" name="valorTarifa" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="hora_ingreso">Hora de Ingreso (HH:MM):</label>
                                    <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso" required>
                                    <input type="text" class="form-control" id="hora_ingreso" name="hora_ingreso" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Ingrese la hora en formato HH:MM" required>
                                </div> -->
                                <button type="submit" class="btn btn-primary">Registrar Tarifa</button>
                                <!-- <button type="button" id="registrarParqueo">Registrar Parqueo</button> -->
                            </form>
                        </div>

                        <div class="col-md-8 ">
                            <h2 class="text-center">Listado de Tarifas</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre de la tarifa</th>
                                            <th>Valor Tarifa</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Conexión a la base de datos (ajusta los valores según tu configuración)
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $dbname = "parqueadero";

                                        $conn = new mysqli($servername, $username, $password, $dbname);

                                        if ($conn->connect_error) {
                                            die("Error de conexión: " . $conn->connect_error);
                                        }

                                        $sql = "SELECT id, nombreTarifa, valorTarifa 
                                        FROM tarifas ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["nombreTarifa"] . "</td>";
                                                echo "<td><input type='number' class='form-control' id='costoInput_" . $row["id"] . "' value='" . $row["valorTarifa"] . "'></td>";
                                                if ($tipoUsuario != 2) {

                                                    echo "<td><button class='btn btn-success btn-sm' onclick='actualizarCosto(" . $row["id"] . ")'>Actualizar</button></td>";
                                                    echo "<td><button class='btn btn-danger btn-sm' onclick='eliminarRegistro(" . $row["id"] . ")'>Eliminar</button></td>";
                                                }
                                                // // echo "<td><button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalSalida' data-id='" . $row["id"] . "'>X</button></td>";
                                                //echo "<td><button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalSalida' data-id='" . $row["id"] . "' data-placa='" . $row["placa"] . "' data-hora-ingreso='" . $row["hora_ingreso"] . "' data-tipo-parqueo='" . $row["tipo_parqueo"] . "'>X</button></td>";
                                                // echo "<td id='tiempoTranscurrido'></td>";
                                                // echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2'>No hay vehículos en el parqueadero en este momento.</td></tr>";
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                    <?php

                    if (isset($_GET["exito"]) && $_GET["exito"] == 1) {

                        echo '<div class="alert alert-success mt-3 alert-dismissible fade show">
                Tarifa Guardada
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
    <!-- Agrega los enlaces a Bootstrap JS y jQuery (debes incluir jQuery antes de Bootstrap JS) -->


    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../jquery/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>



    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>



</html>