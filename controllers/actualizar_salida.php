<!-- <?php
// Archivo "actualizar_salida.php"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $registroId = $_POST["registroId"];
    $horaSalida = $_POST["horaSalida"];
    $horaIngreso = $_POST["horaIngreso"];
    $costoo = $_POST["costoTotal"];

    // Convierte las horas de entrada y salida en objetos DateTime
    $fechaIngreso = new DateTime($horaIngreso);
    $fechaSalida = new DateTime($horaSalida);

    // Calcula la diferencia de tiempo en minutos
    $diferencia = $fechaIngreso->diff($fechaSalida);
    $minutosTranscurridos = $diferencia->days * 24 * 60 + $diferencia->h * 60 + $diferencia->i;

    // Realiza la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "parqueadero";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta el tipo de parqueo y la tarifa asociada al registroId
    $consultaTipoParqueo = "SELECT tipo_parqueo FROM parqueo WHERE id = $registroId";
    $resultTipoParqueo = $conn->query($consultaTipoParqueo);

    if ($resultTipoParqueo->num_rows > 0) {
        $rowTipoParqueo = $resultTipoParqueo->fetch_assoc();
        $tipoParqueo = $rowTipoParqueo["tipo_parqueo"];

        // Consulta la tarifa asociada al tipo de parqueo en la tabla "tarifas"
        $consultaTarifa = "SELECT valorTarifa FROM tarifas WHERE id = $tipoParqueo";
        $resultTarifa = $conn->query($consultaTarifa);

        if ($resultTarifa->num_rows > 0) {
            $rowTarifa = $resultTarifa->fetch_assoc();
            $tarifa = $rowTarifa["valorTarifa"];

            // Calcula el costo basado en la tarifa y el tiempo transcurrido
            $costo = 0;
           
           
            if ($tipoParqueo >= 3 && $tipoParqueo <= 13) {
                $costo = $tarifa;
            } elseif ($minutosTranscurridos <= 70) {
                // Si el tiempo es menor o igual a 70 minutos (1 hora y 10 minutos), cobra una hora
                $costo = $tarifa;
            } else {
                // Si ha pasado más de 70 minutos, calcula las horas completas
                $horasCompletas = floor($minutosTranscurridos / 60);
            
                // Calcula el costo de la primera hora
                $costo = $tarifa;
            
                // A partir de la segunda hora, cobra la tarifa correspondiente
                for ($i = 2; $i <= $horasCompletas; $i++) {
                    if ($i <= 9) {
                        // Si es la hora 2 a la hora 9, cobra la tarifa normal
                        $costo += $tarifa;
                    } else {
                        // A partir de la hora 10, cobra el doble de la tarifa
            
                        // Verifica si ha pasado más de 10 minutos en la fracción de la hora actual
                        $minutosFraccion = $minutosTranscurridos % 60;
                        $minutosFraccion += ($i - 1) * 60;
                        if ($minutosFraccion > 10) {
                            $costo += $tarifa * 2;
                        } else {
                            $costo += $tarifa;
                        }
                    }
                }
            }
            
            

            // Actualiza la hora de salida y el costo en la base de datos
            $sql = "UPDATE parqueo SET hora_salida = '$horaSalida', costo = $costo, estado = 1, fecha_salida = NOW()   WHERE id = $registroId";

            if ($conn->query($sql) === TRUE) {
                // La actualización fue exitosa
                echo "Actualización exitosa. El costo total es de: $" . number_format($costo, 2);
            } else {
                // Hubo un error en la actualización
                echo "Error en la actualización: " . $conn->error;
            }

        } else {
            echo "No se encontró una tarifa asociada al tipo de parqueo.";
        }

    } else {
        echo "No se encontró un registro con el ID proporcionado.";
    }

    $conn->close();
}
?> -->
