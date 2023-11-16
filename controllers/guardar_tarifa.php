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
  
$nombreTarifa = $_POST["nombreTarifa"];
$valorTarifa = $_POST["valorTarifa"];

    $sql = "INSERT INTO tarifas (nombreTarifa,valorTarifa) VALUES ('$nombreTarifa', '$valorTarifa')";
    
    if ($conn->query($sql) === TRUE) {
        // echo "Parqueo registrado con éxito.";
        // echo "<a href='index.php' class='btn btn-primary'>Volver al Formulario</a>";
        // Redirige nuevamente a formulario_parqueo.php
        header("Location: ../views/tarifas.php?exito=1");
    } else {
        echo "Error al registrar el parqueo: " . $conn->error;
    }

    $conn->close();
}
