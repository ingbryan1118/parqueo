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
        <?php include('navbar.php'); ?>

            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">


                    <div class="row">
                        <div class="col-md-8 ">
                            <h2 class="text-center">Reiniciar Parqueo</h2>
                            <form id="formEliminarCarpetas" action="../controllers/eliminar_carpetas.php" method="post">
        <?php
            $carpeta_base = 'C:/xampp/htdocs/parqueo/img/Normal/';
            // Obtener lista de carpetas dentro de $carpeta_base
            $carpetas = glob($carpeta_base . '*', GLOB_ONLYDIR);
            foreach ($carpetas as $carpeta) {
                $nombre_carpeta = basename($carpeta);
                echo "<input type='checkbox' name='carpetas[]' value='$carpeta'>$nombre_carpeta<br>";
            }
        ?>
        <button type="submit" class="btn btn-danger">Eliminar Carpetas Seleccionadas</button>
    </form>
    <div id="mensaje"></div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
    <!-- <script src="script.js"></script> -->
    <!-- Agrega los enlaces a Bootstrap JS y jQuery (debes incluir jQuery antes de Bootstrap JS) -->


    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../jquery/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#formEliminarCarpetas').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(data) {
                        $('#mensaje').html(data);
                    }
                });
            });
        });
    </script>


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>



</html>