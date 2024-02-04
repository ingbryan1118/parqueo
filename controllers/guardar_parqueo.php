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
    $placa = mysqli_real_escape_string($conn, $_POST["placa"]);
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

        // Insertar en la tabla 'parqueo' con la tarifa obtenida
        $stmtInsert = $conn->prepare("INSERT INTO parqueo (placa, fecha_ingreso, tipo_parqueo, hora_ingreso, estado) VALUES (?, ?, ?, ?, 0)");
        $stmtInsert->bind_param("ssss", $placa, $fechaIngreso, $parqueo, $horaIngreso);
        if ($stmtInsert->execute()) {
            header("Location: ../views/index.php?exito=1");
            exit(); // Agrega exit() después de redirigir para detener la ejecución del script.
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
            header("Location: ../views/index.php?exito=1");
            exit(); // Agrega exit() después de redirigir para detener la ejecución del script.
        } else {
            echo "Error al registrar el parqueo: " . $stmtInsert->error;
        }
        // header("Location: ../views/index.php?error=1");
        //exit(); // Agrega exit() después de redirigir para detener la ejecución del script.
    }

    $stmt->close();
    $stmtInsert->close();
    $conn->close();
}
?>
