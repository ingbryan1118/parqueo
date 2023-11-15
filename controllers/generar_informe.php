<?php
require '../vendor/autoload.php'; // Incluye la biblioteca PhpSpreadsheet

// Verifica si se ha enviado el formulario
if (isset($_POST['fecha'])) {
    $selectedDate = $_POST['fecha'];

    // Conecta a la base de datos (ajusta los detalles de la conexión según tu configuración)
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'parqueadero';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Consulta para obtener los registros de estacionamiento de la fecha seleccionada
    $sql = "SELECT placa, 
    CASE tipo_parqueo 
         WHEN 1 THEN 'DIARIO'  /*DIARIO VEHICULO* */
         WHEN 2 THEN 'DIARIO'  /*DIARIO MOTO* */
         WHEN 3 THEN 'DIARIO'  /*5000 VEHICULO* */
         WHEN 4 THEN 'DIARIO'  /*8000 VEHICULO* */
         WHEN 5 THEN 'MES' /*MES 160000* */ 
         WHEN 6 THEN 'MES' /*MES 150000* */ 
         WHEN 7 THEN 'MES'     /*MES 90000* */   
         WHEN 8 THEN 'MES'     /*MES 30000* */ 
         ELSE 'GRATIS' 
    END AS tipo_parqueo, 
    costo 
FROM parqueo 
WHERE fecha_ingreso = '$selectedDate'";
    $result = $conn->query($sql);

    // Crear una instancia de una hoja de cálculo
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Definir las cabeceras de las columnas
    $sheet->setCellValue('A1', 'Placa');
    $sheet->setCellValue('B1', 'Tipo de Parqueo');
    $sheet->setCellValue('C1', 'Costo');

    // Obtener y escribir los datos en el archivo Excel
    $row = 2;
    while ($row_data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $row_data['placa']);
        $sheet->setCellValue('B' . $row, $row_data['tipo_parqueo']);
        $sheet->setCellValue('C' . $row, $row_data['costo']);
        $lastPlacaRow = $row; // Almacenar la fila de la última placa
        $row++;
    }

    // Calcular la suma de costos
        $totalCost = "=SUM(C2:C" . $lastPlacaRow . ")";
        $sheet->setCellValue('A' . ($lastPlacaRow + 1), '');
        //$sheet->setCellValue('A' . ($lastPlacaRow + 1), 'Total:'); // Coloca "Total" en la misma celda que el costo total
        // $sheet->setCellValue('C' . ($lastPlacaRow + 1), $totalCost); // Coloca la suma de costos al lado de "Total:"

        $ruta_guardado = '../reportes/';

        // Asegúrate de que la ruta tenga el separador de directorios adecuado para tu sistema operativo
        if (DIRECTORY_SEPARATOR != '/') {
            $ruta_guardado = str_replace('/', DIRECTORY_SEPARATOR, $ruta_guardado);
        }
        
        // Construye el nombre del archivo con la ruta completa
        $file_name = $ruta_guardado . 'informe_estacionamiento_' . $selectedDate . '.xlsx';
        
        // Crea el objeto Writer y guarda el archivo
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($file_name);

    // Cierra la conexión a la base de datos
    $conn->close();

    // Redirige al usuario para descargar el archivo
    header('Location: ' . $file_name);
    exit;
}


?>
