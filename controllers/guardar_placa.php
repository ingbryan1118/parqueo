<?php
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
    $fechaIngreso = date('Y-m-d H:i:s');

    $sqlVerificarPlaca = "SELECT * FROM placa WHERE placa = '$placa'";
    $resultadoVerificacion = $conn->query($sqlVerificarPlaca);

    if ($resultadoVerificacion->num_rows > 0) {
        // La placa ya existe, mostrar mensaje al usuario
        header("Location: ../views/creaplaca.php?exito=0");
        exit(); // Detener la ejecución del script
    } else {
        // La placa no existe, realizar la inserción en la base de datos
        $sql = "INSERT INTO placa (placa, tipo_parqueo, fecha_ingreso) VALUES ('$placa', $tipoParqueo, '$fechaIngreso')";
        if ($conn->query($sql) === TRUE) {
            // Redirigir al usuario con un mensaje de éxito
            header("Location: ../views/creaplaca.php?exito=1");
            exit(); // Detener la ejecución del script
        } else {
            echo "Error al ejecutar la inserción: " . $conn->error;
        }
    }

    $conn->close();
}
?>
