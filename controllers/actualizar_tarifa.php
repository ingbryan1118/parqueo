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

if (isset($_POST['id']) && isset($_POST['nuevoCosto'])) {
    $id = $_POST['id'];
    $nuevoCosto = $_POST['nuevoCosto'];
    $nuevoNombre = $_POST['nuevoNombre'];
    

    $sql = "UPDATE tarifas SET valorTarifa = $nuevoCosto, nombreTarifa = '$nuevoNombre' WHERE id = $id";

    if ($conn->query($sql) === true) {
        echo "Tarifa actualizada correctamente.";
    } else {
        echo "Error al actualizar el costo: " . $conn->error;
        echo $sql;
    }
}

$conn->close();
