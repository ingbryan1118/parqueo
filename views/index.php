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

<?php include('../conexion/db_connection.php'); ?>
<?php

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "parqueadero";

// date_default_timezone_set('America/Bogota');

// $conn = new mysqli($servername, $username, $password, $dbname);


//session_start();
//$tipoUsuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;

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
        <?php include('navbar.php'); ?>
            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">


                    <div class="row">
                        <div class="col-md-8 ">
                            <h2 class="text-center">Registro de ingreso al parqueadero</h2>
                            <form method="POST" action="../controllers/guardar_parqueo.php">
                                <!-- Formulario de Parqueo -->
                                <div class="form-group">
                                    <label for="placa">Ingrese la Placa:</label>
                                    <input type="text" class="form-control" id="placa" name="placa" required>
                                </div>


                                <!-- <?php
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
                                        ?> -->
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

                    if (isset($_GET["error"]) && $_GET["error"] == 1) {

                        echo '<div class="alert alert-danger mt-3 alert-dismissible fade show">
                No esta creada la placa por favor agregarla  
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