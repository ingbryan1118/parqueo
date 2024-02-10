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
        <?php include('navbar.php'); ?>

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