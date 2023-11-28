<?php
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
    $sql = "SELECT costo FROM parqueo WHERE tipo_parqueo IN (1,2,3,4,5,6,7) AND
    fecha_ingreso = '$selectedDate'";
    $result = $conn->query($sql);

    // Calcular la suma de costos
    $totalCost = 0;
    while ($row_data = $result->fetch_assoc()) {
        $totalCost += $row_data['costo'];
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Mostrar el ticket en formato HTML
    echo '<html>
            <head>
                <title>Reporte a</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .ticket {
                        width: 200px;
                        margin: 20px auto;
                        padding: 10px;
                        border: 1px solid #000;
                    }
                </style>
            </head>
            <body>
                <div class="ticket">
                    <h2>Ticket de Estacionamiento</h2>
                    <p>Fecha: ' . $selectedDate . '</p>
                    <p>Total Costo: ' . $totalCost . '</p>
                </div>
                <script>
                    // Impresión automática al cargar la página
                    window.onload = function() {
                        window.print();
                    };
                </script>
            </body>
          </html>';
}
?>
