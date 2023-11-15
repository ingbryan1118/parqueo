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
$horaIngreso = date("H:i:s");
$tipo_parqueo = $_POST["tipo_parqueo"];
$fechaIngreso = date("Y-m-d");


// Validación de formato de hora (HH:MM)
// if (!preg_match("/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $horaIngreso)) {
//     echo "El formato de hora de ingreso no es válido (HH:MM).";
//     exit;
// }

$mesActual = date("n");
$añoActual = date("Y");

$costoTotal = 0;
if ($tipoParqueo == 5) {
    $costoTotal = 160000;
}else if($tipoParqueo == 6){
    $costoTotal = 150000;

}else if($tipoParqueo == 7){
    $costoTotal = 90000;

}else if($tipoParqueo == 8){
    $costoTotal = 30000;
    
}else{
    $costoTotal = 0;

}



$sqlVerificarPlaca = "SELECT COUNT(*) as count FROM parqueo WHERE placa = '$placa' AND MONTH(fecha_ingreso) = $mesActual AND YEAR(fecha_ingreso) = $añoActual AND tipo_parqueo IN (5, 6, 7, 8, 9)";

$result = $conn->query($sqlVerificarPlaca);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row["count"];
    
    if ($count > 0) {
        
        header("Location: ../views/creaVehiculo.php?error=1");
        exit();
    }
}

// Resto del código para guardar en la base de datos


    // $horaIngresoFormateada = $horaIngreso . ":00";

    $sql = "INSERT INTO parqueo (placa, fecha_ingreso, tipo_parqueo, hora_ingreso,estado,costo) VALUES ('$placa', '$fechaIngreso', $tipoParqueo, '$horaIngreso',2, $costoTotal)";
    
    if ($conn->query($sql) === TRUE) {
        // echo "Parqueo registrado con éxito.";
        // echo "<a href='index.php' class='btn btn-primary'>Volver al Formulario</a>";
        // Redirige nuevamente a formulario_parqueo.php
        header("Location: ../views/creaVehiculo.php?exito=1");
    } else {
        echo "Error al registrar el parqueo: " . $conn->error;
    }

    $conn->close();
}
?>
