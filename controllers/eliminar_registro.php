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

// Verifica si se recibió un ID válido para eliminar
if (isset($_POST['placa'])) {
    $placa = $_POST['placa'];

    // Consulta SQL para eliminar el registro
    $sql = "DELETE FROM placa WHERE placa = '$placa'";
    echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "Registro eliminado con éxito.";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
} else {
    echo "ID de registro no válido.";
}

$conn->close();
