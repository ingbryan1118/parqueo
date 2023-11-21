<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parqueadero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$tipo_parqueo = $_GET['tipo_parqueo'];

// Realiza la consulta a la base de datos para obtener la tarifa
$sql = "SELECT valorTarifa FROM tarifas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $tipo_parqueo); // 'i' representa el tipo de dato integer
$stmt->execute();
$stmt->bind_result($valorTarifa);

// Obtén el resultado
if ($stmt->fetch()) {
    // Devuelve el valor de la tarifa como respuesta
    echo floatval($valorTarifa);
} else {
    // Maneja el caso en que no se encuentre la tarifa
    echo "No se encontró la tarifa para el tipo de parqueo: $tipo_parqueo";
}

$stmt->close();
$conn->close();
?>
