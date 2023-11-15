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
// $horaIngreso = $_POST["hora_ingreso"];
$fechaIngreso = date("Y-m-d");
$horaIngreso = date("H:i:s");

// Validación de formato de hora (HH:MM)
// if (!preg_match("/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $horaIngreso)) {
//     echo "El formato de hora de ingreso no es válido (HH:MM).";
//     exit;
// }
    
    // Resto del código para guardar en la base de datos
    

// Resto del código para guardar en la base de datos


   
    // Inserta el registro en la base de datos
    // $horaIngresoFormateada = $horaIngreso . ":00";

    $sql = "INSERT INTO parqueo (placa, fecha_ingreso, tipo_parqueo, hora_ingreso,estado) VALUES ('$placa', '$fechaIngreso', $tipoParqueo, '$horaIngreso',0)";
    
    if ($conn->query($sql) === TRUE) {
        // echo "Parqueo registrado con éxito.";
        // echo "<a href='index.php' class='btn btn-primary'>Volver al Formulario</a>";
        // Redirige nuevamente a formulario_parqueo.php
        header("Location: ../views/index.php?exito=1");
    } else {
        echo "Error al registrar el parqueo: " . $conn->error;
    }

    $conn->close();
}
?>
