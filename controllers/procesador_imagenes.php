<?php

date_default_timezone_set('America/Bogota');
// Obtener la fecha actual
$fecha_actual = date("Ymd");

// Construir la ruta de la carpeta basada en la fecha actual
$carpeta = 'C:/xampp/htdocs/parqueo/img/Normal/' . $fecha_actual;
//echo $carpeta;



// // Ruta de la carpeta
//$carpeta = 'C:/xampp/htdocs/parqueo/img/Normal/20240205';

// // Obtener la lista de archivos en la carpeta
$files = glob($carpeta . '/*.*'); // Busca todos los archivos en la carpeta

// Patrón de expresión regular para encontrar el texto después de un guion bajo seguido de números
//$pattern = '/_(\w{6})_/'; // Modificado para capturar solo los primeros 6 caracteres después del guion bajo
//$pattern = '/_(\w{6}\d{1,2})_/'; // Modificado para capturar solo los primeros 6 caracteres seguidos de 1 o 2 dígitos después del guion bajo
$pattern = '/_(\w{5}\d)_/';




// Array para almacenar valores únicos encontrados
$found_texts = array();

// Iterar sobre cada archivo
foreach ($files as $file) {
    // Obtener solo el nombre del archivo sin la ruta
    $filename = basename($file);
    
    //echo "Nombre de archivo: $filename\n"; // Imprimir el nombre de archivo para depurar
    
    // Buscar el patrón en el nombre del archivo
    if (preg_match($pattern, $filename, $matches)) {
        // El texto que coincide con el patrón estará en $matches[1]
        $found_text = $matches[1];
        
        // Almacenar el texto encontrado en el array si no existe ya
        if (!in_array($found_text, $found_texts)) {
            $found_texts[] = $found_text;
        }
    }
}

//echo "Placas encontradas: ";
 // Imprimir el array de placas encontradas

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parqueadero";

date_default_timezone_set('America/Bogota');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
//print_r($found_texts);


foreach ($found_texts as $placa_actual) {
    echo "Placa actual: $placa_actual\n"; // Imprimir la placa actual para depurar
    $fecha_ingreso = date("Y-m-d"); // Formato datetime
    $hora_ingreso = date("H:i:s"); // Formato time
    
    // Consulta para verificar si ya existe un registro con la misma placa, fecha de ingreso y estado 0
    $sql_check = "SELECT placa FROM parqueo WHERE placa = '$placa_actual' AND fecha_ingreso = '$fecha_ingreso' AND estado = 0";
    $result_check = $conn->query($sql_check);
    
    // Verificar si la consulta se ejecutó correctamente
    if ($result_check === false) {
        echo "Error al ejecutar la consulta: " . $conn->error;
    } else {
        // Verificar si hay filas devueltas por la consulta
        if ($result_check->num_rows > 0) {
            // Si hay filas, la placa ya ha sido ingresada hoy con estado 0
            echo "La placa $placa_actual ya ha sido ingresada hoy con estado 0, no se insertará nuevamente.\n";
        } else {
            // Si no hay filas, la placa no ha sido ingresada hoy con estado 0
            // Consulta para obtener el tipo de parqueo y la tarifa asociada a la placa
            $sql = "SELECT p.placa, p.tipo_parqueo, t.valorTarifa
                    FROM placa p
                    INNER JOIN tarifas t ON p.tipo_parqueo = t.id
                    WHERE p.placa = '$placa_actual'";
            echo "$sql\n";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $placa = $row["placa"];
                $tipo_parqueo = $row["tipo_parqueo"];
                $valor_tarifa = $row["valorTarifa"];
        
                // Insertar los datos en la tabla "parqueo"
                $sql_insert = "INSERT INTO parqueo (placa, tipo_parqueo, fecha_ingreso, hora_ingreso) 
                VALUES ('$placa', $tipo_parqueo, '$fecha_ingreso', '$hora_ingreso')";
            } else {
                // Si no se encuentra la tarifa, se utiliza la tarifa con ID 1
                $tipo_parqueo = 1; // Suponiendo que el ID de la tarifa por defecto es 1
                
                // Insertar los datos en la tabla "parqueo"
                $sql_insert = "INSERT INTO parqueo (placa, tipo_parqueo, fecha_ingreso, hora_ingreso) 
                VALUES ('$placa_actual', $tipo_parqueo, '$fecha_ingreso', '$hora_ingreso')";
            }

            // Ejecutar la consulta de inserción
            if ($conn->query($sql_insert) === TRUE) {
                echo "Registro insertado correctamente: Placa = $placa, Tarifa = $valor_tarifa\n";
            } else {
                echo "Error al insertar registro: " . $conn->error;
            }
        }
    }
}



// foreach ($found_texts as $placa_actual) {
//     echo "Placa actual: $placa_actual\n"; // Imprimir la placa actual para depurar
//     $fecha_ingreso = date("Y-m-d"); // Formato datetime
//     $hora_ingreso = date("H:i:s"); // Formato time
//     // Consulta para obtener el tipo de parqueo y la tarifa asociada a la placa
    
//     $sql_check = "SELECT placa FROM parqueo WHERE placa = '$placa_actual' AND fecha_ingreso = '$fecha_ingreso' AND estado = 1";
//     $result_check = $conn->query($sql_check);
    
//     // Verificar si la consulta se ejecutó correctamente
//     if ($result_check === false) {
//         echo "Error al ejecutar la consulta: " . $conn->error;
//     } else {
//         // Verificar si hay filas devueltas por la consulta
//         if ($result_check->num_rows > 0) {
//             // Si hay filas, la placa ya ha sido ingresada hoy con estado 1
            
//             //echo "La placa $placa_actual ya ha sido ingresada hoy con estado 1.\n";
            
//             $sql = "SELECT p.placa, p.tipo_parqueo, t.valorTarifa
//             FROM placa p
//             INNER JOIN tarifas t ON p.tipo_parqueo = t.id
//             WHERE p.placa = '$placa_actual'";
//             echo "$sql\n";
//             $result = $conn->query($sql);
//             if ($result->num_rows > 0) {
//                 $row = $result->fetch_assoc();
//                 $placa = $row["placa"];
//                 $tipo_parqueo = $row["tipo_parqueo"];
//                 $valor_tarifa = $row["valorTarifa"];
        
//                 // Insertar los datos en la tabla "parqueo"
//                 $sql_insert = "INSERT INTO parqueo (placa, tipo_parqueo, fecha_ingreso, hora_ingreso) 
//                 VALUES ('$placa', $tipo_parqueo, '$fecha_ingreso', '$hora_ingreso')";
//             } else{

//                 $tipo_parqueo = 1; // Suponiendo que el ID de la tarifa por defecto es 1
//                 // Insertar los datos en la tabla "parqueo"
//                 $sql_insert = "INSERT INTO parqueo (placa, tipo_parqueo, fecha_ingreso, hora_ingreso) 
//                 VALUES ('$placa_actual', $tipo_parqueo, '$fecha_ingreso', '$hora_ingreso')";

//             }
            

//         } else {
//             // Si no hay filas, la placa no ha sido ingresada hoy con estado 1
//             echo "La placa $placa_actual no ha sido ingresada hoy con estado 1.\n";
//             $sql = "SELECT p.placa, p.tipo_parqueo, t.valorTarifa
//             FROM placa p
//             INNER JOIN tarifas t ON p.tipo_parqueo = t.id
//             WHERE p.placa = '$placa_actual'";
//             echo "vamos a hacer estooooo";
//             echo "$sql\n";

//             $result = $conn->query($sql);
//             if ($result->num_rows > 0) {
//                 $row = $result->fetch_assoc();
//                 $placa = $row["placa"];
//                 $tipo_parqueo = $row["tipo_parqueo"];
//                 $valor_tarifa = $row["valorTarifa"];
        
//                 // Insertar los datos en la tabla "parqueo"
//                 $sql_insert = "INSERT INTO parqueo (placa, tipo_parqueo, fecha_ingreso, hora_ingreso) 
//                 VALUES ('$placa', $tipo_parqueo, '$fecha_ingreso', '$hora_ingreso')";
//                echo "esto es lo que se debe hacer"; 
//                //echo "$sql_insert\n";
//             } else{

//                 $tipo_parqueo = 1; // Suponiendo que el ID de la tarifa por defecto es 1
//                 // Insertar los datos en la tabla "parqueo"
//                 $sql_insert = "INSERT INTO parqueo (placa, tipo_parqueo, fecha_ingreso, hora_ingreso) 
//                 VALUES ('$placa_actual', $tipo_parqueo, '$fecha_ingreso', '$hora_ingreso')";

//             }
//         }
//     }
    

//     // if ($result_check->num_rows > 0) {
    
//     // $sql = "SELECT p.placa, p.tipo_parqueo, t.valorTarifa
//     //         FROM placa p
//     //         INNER JOIN tarifas t ON p.tipo_parqueo = t.id
//     //         WHERE p.placa = '$placa_actual'";

//     // echo "$sql\n";

//     // // Ejecutar la consulta
//     // $result = $conn->query($sql);

//     // if ($result->num_rows > 0) {
//     //     //         // Obtener los valores de la fila
//     //             $row = $result->fetch_assoc();
//     //             $placa = $row["placa"];
//     //             $tipo_parqueo = $row["tipo_parqueo"];
//     //             $valor_tarifa = $row["valorTarifa"];
        
//     //             // Insertar los datos en la tabla "parqueo"
//     //             $sql_insert = "INSERT INTO parqueo (placa, tipo_parqueo, fecha_ingreso, hora_ingreso) 
//     //             VALUES ('$placa', $tipo_parqueo, '$fecha_ingreso', '$hora_ingreso')";
        
//     //             if ($conn->query($sql_insert) === TRUE) {
//     //                 echo "Registro insertado correctamente: Placa = $placa, Tarifa = $valor_tarifa\n";
//     //             } else {
//     //                 echo "Error al insertar registro: " . $conn->error;
//     //             }
//     //         } else {
//     //             echo "No se encontraron resultados para la placa: $placa_actual\n";
//     //         }
//     //     } else {
//     //         // La placa ya ha sido ingresada con estado 0, no la insertamos nuevamente
//     //         echo "La placa $placa_actual ya ha sido ingresada hoy con estado 0, no se insertará nuevamente.\n";
//     //     }

// }



// Cerrar conexión
$conn->close();
?>
