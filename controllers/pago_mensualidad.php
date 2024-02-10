<?php
// Inicia la sesión si no está iniciada
if (!isset($_SESSION)) {
    session_start();
}

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
    $tarifa = $_POST['tarifa'];
    $placa = $_POST['placa'];
    $fechaIngreso = date("Y-m-d");
    $horaIngreso = date("H:i:s");

    // Verificar si la placa ya existe en la tabla 'placa'
    $stmt = $conn->prepare("SELECT tipo_parqueo FROM placa WHERE placa = ?");
    $stmt->bind_param("s", $placa);
    $stmt->execute();
    $resultadoPlaca = $stmt->get_result();

    if ($resultadoPlaca !== false && $resultadoPlaca->num_rows > 0) {
        // La placa ya existe, obtener la tipo de parqueo
        $tipo_parqueo = $resultadoPlaca->fetch_assoc();
        $parqueo = $tipo_parqueo['tipo_parqueo'];


        $stmtInsert = $conn->prepare("INSERT INTO parqueo (placa, fecha_ingreso, tipo_parqueo, hora_ingreso, fecha_salida, estado, costo) VALUES (?, ?, ?, ?, ?, 1, ?)");
        $stmtInsert->bind_param("sssssd", $placa, $fechaIngreso, $parqueo, $horaIngreso, $fechaIngreso, $tarifa);


        if ($stmtInsert->execute()) {
            // Establece una variable de sesión indicando que el pago ha sido realizado
            $_SESSION['pago_realizado'] = true;
            echo "Pago realizado con éxito.";
        } else {
            echo "Error al registrar el parqueo: " . $stmtInsert->error;
        }
    } else {

        $ultimoCaracter = substr($placa, -1);

        if (is_numeric($ultimoCaracter)) {
            // Placa de tipo vehículo
            $parqueo = 1;
        } else {
            // Placa de tipo moto
            $parqueo = 2;
        }

        // Insertar en la tabla 'parqueo' con el tipo de parqueo determinado
        $stmtInsert = $conn->prepare("INSERT INTO parqueo (placa, fecha_ingreso, tipo_parqueo, hora_ingreso, estado) VALUES (?, ?, ?, ?, 0)");
        $stmtInsert->bind_param("ssss", $placa, $fechaIngreso, $parqueo, $horaIngreso);

        if ($stmtInsert->execute()) {
            // Establece una variable de sesión indicando que el pago ha sido realizado
            $_SESSION['pago_realizado'] = true;
            echo "Pago realizado con éxito.";
        } else {
            echo "Error al registrar el parqueo: " . $stmtInsert->error;
        }
    }

    $stmt->close();
    $stmtInsert->close();
    $conn->close();
}
