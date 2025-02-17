<?php
// Verifica si se ha proporcionado la placa del vehículo
if (isset($_GET['placa']) && !empty($_GET['placa'])) {
    // Obtiene la placa del vehículo desde la URL
    $placaBuscada = $_GET['placa'];

    // Aquí debes realizar una consulta a tu base de datos para obtener los detalles del vehículo según la placa
    // Reemplaza los siguientes datos de ejemplo con tu consulta real a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "parqueadero";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // $sql = "SELECT *
    // FROM parqueo
    // WHERE placa = '$placaBuscada'
    //   AND fecha_salida IS NULL
    //   AND fecha_ingreso = CURDATE()
    // ORDER BY id DESC
    // LIMIT 1";

    $sql = "SELECT parqueo.*, 
    CASE 
        WHEN parqueo.tipo_parqueo IN (9, 10, 11, 12, 13) THEN 0 
        ELSE tarifas.valorTarifa 
    END AS valorTarifa
FROM parqueo
JOIN tarifas ON parqueo.tipo_parqueo = tarifas.id
WHERE parqueo.placa = '$placaBuscada'
AND parqueo.fecha_salida IS NULL
AND parqueo.fecha_ingreso = CURDATE()
ORDER BY parqueo.id DESC
LIMIT 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Recupera los datos del vehículo
        $row = $result->fetch_assoc();
        $placa = $row["placa"];
        $fechaIngreso = date("Y-m-d", strtotime($row["fecha_ingreso"]));
        $horaIngreso = $row["hora_ingreso"];
        $valorTarifa = $row["valorTarifa"];

        // Cierra la conexión a la base de datos
        $conn->close();

        // Genera el contenido del ticket
        $ticketContent = "
        <html>
        <head>
            <title>Ticket de Parqueo</title>
            <style>
                /* Estilos CSS para el ticket (personalízalos según tus necesidades) */
                body {
                    font-family: Arial, sans-serif;
                }
                .ticket {
                    width: 300px;
                    margin: 10px auto;
                    padding: 10px;
                    border: 1px solid #000;
                }
            </style>
        </head>
        <body>
            <div class='ticket'>
                <h2>Centro Comercial de la 34</h2>
                <h4>Ticket de Parqueo</h4>
                <p><strong>Placa:</strong> $placa</p>
                <p><strong>Fecha de Ingreso:</strong> $fechaIngreso</p>
                <p><strong>Hora de Ingreso:</strong> $horaIngreso</p>
                <p><strong>Valor Tarifa:</strong> $valorTarifa</p>
                <h6> Hora o fración carros: $4000 Motos:$1000
                <!-- Agrega otros detalles del ticket aquí -->
            </div>
            <script>
                // Función para imprimir el ticket al cargar la página
                window.onload = function () {
                    window.print();
                };
            </script>
        </body>
        </html>";

        // Imprime el contenido del ticket
        echo $ticketContent;
    } else {
        echo "No se encontró un vehículo con la placa proporcionada en el parqueo.";
    }
} else {
    echo "La placa del vehículo no se ha proporcionado.";
}
