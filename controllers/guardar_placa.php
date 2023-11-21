<?php
// Conexión a la base de datos (ajusta los valores según tu configuración)


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parqueadero";

date_default_timezone_set('America/Bogota');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
$placa = $_POST["placa"];
$tipoParqueo = $_POST["tipo_parqueo"];


    $sql = "INSERT INTO placa (placa, tipo_parqueo) VALUES ('$placa', $tipoParqueo)";
    
    if ($conn->query($sql) === TRUE) {
        // echo "Parqueo registrado con éxito.";
        // echo "<a href='index.php' class='btn btn-primary'>Volver al Formulario</a>";
        // Redirige nuevamente a formulario_parqueo.php
        header("Location: ../views/creaplaca.php?exito=1");
    } else {
        echo "Error al registrar el parqueo: " . $conn->error;
    }

    $conn->close();
}
