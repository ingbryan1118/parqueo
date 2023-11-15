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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parqueadero";

date_default_timezone_set('America/Bogota');

$conn = new mysqli($servername, $username, $password, $dbname);

session_start();
$tipoUsuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;

// echo "Tipo de usuario: " . $tipoUsuario;

//var_dump($_SESSION);
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
                        <div class="col-md-8 ">
                            <h2 class="text-center">Registro de Placas</h2>
                            <form method="POST" action="../controllers/guardar_parqueo.php">
    <!-- Formulario de Parqueo -->
    <div class="form-group">
        <label for="placa">Ingrese la Placa:</label>
        <input type="text" class="form-control" id="placa" name="placa" required>
    </div>
    <!-- <div class="form-group">
        <label for="tipo_parqueo">Tipo de Parqueo:</label>
        <select class="form-control" id="tipo_parqueo" name="tipo_parqueo" required>
            <option value="1">Vehiculo</option>
            <option value="2">Moto</option>
            <option value="3">$5,000</option>
            <option value="4">$8,000</option>
        </select>
    </div> -->

    <?php
// Hacer la consulta SQL
$sql = "SELECT id, nombreTarifa, valorTarifa FROM tarifas";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo '<div class="form-group"> <label for="tipo_parqueo">Tipo de Parqueo:</label> <select class="form-control" id="tipo_parqueo" name="tipo_parqueo" required>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["id"] . '">' . $row["nombreTarifa"] . '</option>';
    }
    echo '</select> </div>';
} else {
    echo "No hay datos en la tabla tarifas";
}

// Cerrar la conexión
$conn->close();
?>

    <!-- <div class="form-group">
        <label for="hora_ingreso">Hora de Ingreso (HH:MM):</label>
        <input type="text" class="form-control" id="hora_ingreso" name="hora_ingreso" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Ingrese la hora en formato HH:MM" required>
    </div> -->
    <button type="submit" class="btn btn-primary">Registrar Parqueo</button>
</form>

                        </div>


                    </div>

                    <?php

                    if (isset($_GET["exito"]) && $_GET["exito"] == 1) {

                        echo '<div class="alert alert-success mt-3 alert-dismissible fade show">
                Parqueo Exitoso
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