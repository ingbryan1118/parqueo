<?php
// Archivo "actualizar_salida.php"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $registroId = $_POST["registroId"];
    $horaSalida = $_POST["horaSalida"];
    $horaIngreso = $_POST["horaIngreso"]; // Asegúrate de recibir la hora de entrada desde tu formulario

    // Convierte las horas de entrada y salida en objetos DateTime
    $fechaIngreso = new DateTime($horaIngreso);
    $fechaSalida = new DateTime($horaSalida);

    // Calcula la diferencia de tiempo en minutos
    $diferencia = $fechaIngreso->diff($fechaSalida);
    $minutosTranscurridos = $diferencia->days * 24 * 60 + $diferencia->h * 60 + $diferencia->i;

    // Define las tarifas por tipo de parqueo
    $tarifas = [
        1 => 3000,   // Tipo 1: $3000 por hora
        2 => 1000,   // Tipo 2: Tarifa fija de $5000
        3 => 5000,   // Tipo 3: Tarifa fija de $8000
        4 => 8000, // Tipo 4: Tarifa fija de $150000
    ];

    // Realiza la consulta para obtener el tipo de parqueo asociado al registroId
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "parqueadero";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta el tipo de parqueo asociado al registroId
    $consultaTipoParqueo = "SELECT tipo_parqueo FROM parqueo WHERE id = $registroId";
    $result = $conn->query($consultaTipoParqueo);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tipoParqueo = $row["tipo_parqueo"];

        // Calcula el costo basado en el tipo de parqueo
        $costo = 0;

        if ($tipoParqueo == 1) {
            if ($minutosTranscurridos <= 19) {
                $costo = $tarifas[$tipoParqueo] + 1900; // 19 minutos o menos
            } else {
                $horasCompletas = ceil($minutosTranscurridos / 60) - 1; // Resta una hora para no contar la primera hora completa
                $costo = ($horasCompletas * $tarifas[$tipoParqueo]) + $tarifas[$tipoParqueo];
            }
        } else if ($tipoParqueo == 2)  {
                    if ($minutosTranscurridos <= 19) {
                        $costo = $tarifas[$tipoParqueo] + 1900; // 19 minutos o menos
                    } else {
                        $horasCompletas = ceil($minutosTranscurridos / 60) - 1; // Resta una hora para no contar la primera hora completa
                        $costo = ($horasCompletas * $tarifas[$tipoParqueo]) + $tarifas[$tipoParqueo];
                    }
         }else {
            // Tipo de parqueo  3 o 4: Tarifa fija
            $costo = $tarifas[$tipoParqueo];
        }

        // Actualiza la hora de salida y el costo en la base de datos
        $sql = "UPDATE parqueo SET hora_salida = '$horaSalida', costo = $costo, estado = 1 WHERE id = $registroId";

        if ($conn->query($sql) === TRUE) {
            // La actualización fue exitosa
            echo "Actualización exitosa. El costo total es de: $" . number_format($costo, 2);
        } else {
            // Hubo un error en la actualización
            echo "Error en la actualización: " . $conn->error;
        }
    } else {
        echo "No se encontró un registro con el ID proporcionado.";
    }

    $conn->close();
}
?>
