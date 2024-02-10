<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barra de Navegación Vertical</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<?php include('../conexion/db_connection.php'); ?>
<?php
//session_start();
$tipoUsuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;


if (isset($_SESSION['correo'])) {
    // El usuario está autenticado, muestra el contenido 

} else {
    header("Location: login.php");
}
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Barra de Navegación Vertical -->
            <?php include('navbar.php'); ?> 

            <!-- Contenido principal -->
            <main class="col-md-8 ms-sm-auto col-lg-10 px-md-4">
                <div class="container">
                    <h2 class="text-center">Lista de Parqueo Diario</h2>

                    <!-- Formulario de búsqueda por placa -->
                    <form method="GET" action="parqueo.php">
                        <div class="form-group">
                            <label for="placa">Buscar Placa:</label>
                            <input type="text" class="form-control" id="placa" name="placa" style="width: 30%;">
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Placa del Vehículo</th>
                                    <th>Fecha</th>
                                    <th>Hora de Ingreso</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Conexión a la base de datos (ajusta los valores según tu configuración)
                                // $servername = "localhost";
                                // $username = "root";
                                // $password = "";
                                // $dbname = "parqueadero";

                                // $conn = new mysqli($servername, $username, $password, $dbname);

                                // if ($conn->connect_error) {
                                //     die("Error de conexión: " . $conn->connect_error);
                                // }

                                // Consulta SQL para obtener los vehículos en el parqueadero
                                $sql = "SELECT id, placa, fecha_ingreso, hora_ingreso, tipo_parqueo FROM parqueo WHERE estado = 0  AND fecha_salida IS NULL AND fecha_ingreso = CURDATE() ";

                                // Si se proporcionó una placa para buscar, agregar la cláusula WHERE
                                if (isset($_GET['placa']) && !empty($_GET['placa'])) {
                                    $placaBuscada = $_GET['placa'];
                                    $sql .= " AND placa LIKE '%$placaBuscada%'";
                                }

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["placa"] . "</td>";
                                        $fechaFormateada = date("Y-m-d", strtotime($row["fecha_ingreso"]));
                                        echo "<td>" . $fechaFormateada . "</td>";
                                        echo "<td id='horaIngreso'>" . $row["hora_ingreso"] . "</td>";
                                        echo "<td><button class='btn btn-success btn-sm' onclick='abrirTicket(\"" . $row["placa"] . "\", \"" . $row["hora_ingreso"] . "\", \"" . $row["tipo_parqueo"] . "\")'>ticket</button></td>";

                                        // echo "<td><button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalSalida' data-id='" . $row["id"] . "'>X</button></td>";
                                        echo "<td><button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalSalida' data-id='" . $row["id"] . "' data-placa='" . $row["placa"] . "' data-hora-ingreso='" . $row["hora_ingreso"] . "' data-tipo-parqueo='" . $row["tipo_parqueo"] . "'>X</button></td>";
                                        echo "<td id='tiempoTranscurrido'></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2'>No hay vehículos en el parqueadero en este momento.</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal para la hora de salida -->
                <div class="modal fade" id="modalSalida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar Salida</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formSalida">
                                <div class="modal-body">
                                    <!-- Agrega estos elementos <span> para mostrar la placa y la hora de ingreso -->
                                    <p>Placa: <span id="placaSalida"></span></p>
                                    <p>Hora de Ingreso: <span id="horaIngresoSalida"></span></p>
                                    <input type="hidden" id="registroId" name="registroId">
                                    <input type="hidden" id="costoTotal" name="costoTotal"> <!-- Campo oculto para el costo -->
                                    <input type="hidden" id="tipo_parqueo" name="tipo_parqueo"> <!-- Campo oculto para el costo -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Registrar Salida</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../jquery/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script>
        // Función para abrir la ventana emergente del ticket y calcular el costo total
        function abrirTicket(placa, horaIngreso, tipo_parqueo) {
            // Define la URL de "generar_ticket.php" con la placa como parámetro
            var url = "../controllers/generar_ticket.php?placa=" + encodeURIComponent(placa) + "&horaIngreso=" + encodeURIComponent(horaIngreso);

            var costoTotal = 0;

            //console.log("por aquiiiii ver ticket de entrada" + tipo_parqueo);

            // Abre la ventana emergente con el contenido del ticket
            var ticketWindow = window.open(url, "_blank", "width=400,height=400");

            // Enfoque en la ventana emergente
            ticketWindow.focus();

            // Actualiza el campo oculto de costoTotal en el formulario del modal
            document.getElementById("costoTotal").value = costoTotal;

        }

        // Otras partes de tu código JavaScript...

        // Manejar el evento de apertura del modal
        $('#modalSalida').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var registroId = button.data('id');
            var placa = button.data('placa');
            var horaIngreso = button.data('hora-ingreso');
            var tipo_parqueo = button.data('tipo-parqueo');
            var costoTotal = 0;

            //console.log("generar el de salida")
            //console.log(costoTotal)
            //console.log(tipo_parqueo)
            // Actualizar los elementos <span> en el modal con la placa y la hora de ingreso
            document.getElementById("placaSalida").textContent = placa;
            document.getElementById("horaIngresoSalida").textContent = horaIngreso;

            // Actualizar el campo oculto de registroId y costoTotal
            document.getElementById("registroId").value = registroId;
            document.getElementById("costoTotal").value = costoTotal;
            document.getElementById("tipo_parqueo").value = tipo_parqueo;
            //console.log("actualizar salida" + costoTotal)

            

        });

        // Manejar el envío del formulario
        $('#formSalida').submit(function(e) {
            e.preventDefault();
            var fechaActual = new Date();
        // Obtener la hora actual, minutos y segundos
            var hora = fechaActual.getHours();
            var minutos = fechaActual.getMinutes();
            var segundos = fechaActual.getSeconds();

        // Formatear la hora, minutos y segundos para que tengan dos dígitos
            hora = hora < 10 ? "0" + hora : hora;
            minutos = minutos < 10 ? "0" + minutos : minutos;
            segundos = segundos < 10 ? "0" + segundos : segundos;

        // Crear una cadena con el formato deseado (por ejemplo, "12:13:42")
            var horaActualString = hora + ":" + minutos + ":" + segundos;    
            var registroId = document.getElementById("registroId").value;
            var horaSalida = horaActualString;
            var costoTotal = document.getElementById("costoTotal").value; // Obtener el costo del campo oculto

            var tipo_parqueo = document.getElementById("tipo_parqueo").value;
            // Obtener la placa y la hora de ingreso de la fila correspondiente
            var placa = document.getElementById("placaSalida").textContent;
            var horaIngreso = document.getElementById("horaIngresoSalida").textContent;

            // Actualizar la base de datos con la hora de salida y el tiempo transcurrido
            $.ajax({
                type: "POST",
                url: "../controllers/actualizar_salida.php",
                data: {
                    registroId: registroId,
                    horaIngreso: horaIngreso,
                    horaSalida: horaSalida,
                    costoTotal: costoTotal
                }, // Pasar el costo como parámetro
                success: function(response) {
                    // Actualización exitosa
                   // console.log("Base de datos actualizada correctamente");

                    // Generar el ticket de salida
                    generarTicket(placa, horaIngreso, horaSalida, tipo_parqueo);
                },
                error: function(error) {
                    // Error en la actualización
                   // console.error("Error al actualizar la base de datos: " + error.responseText);
                }
            });

            // Cerrar el modal
            $('#modalSalida').modal('hide');
        });

        function generarTicket(placa, horaIngreso, horaSalida, tipo_parqueo) {
            var costoTotal;
            // Realizar la consulta a la base de datos para obtener la tarifa
    var urlConsulta = "../controllers/obtener_tarifas.php?tipo_parqueo=" + tipo_parqueo;
    //console.log("urlConsulta: "+ urlConsulta)
    // Utiliza una función para manejar la respuesta de la consulta a la base de datos
    function handleConsultaResponse(response) {
    //console.log("Respuesta de la consulta:", response + tipo_parqueo);

    try {
        // Intentar analizar la respuesta como JSON
        var parsedResponse = JSON.parse(response);

        // Verificar si el valor parseado es un número
        if (!isNaN(parsedResponse)) {
            calcularCostoTotal(parsedResponse, tipo_parqueo);
        } else {
            console.error("El valor parseado no es un número válido.");
        }
    } catch (error) {
        console.error("Error al analizar la respuesta como JSON:", error);
    }
}


    // Hacer la solicitud AJAX para obtener la tarifa
    var xhr = new XMLHttpRequest();
    xhr.open("GET", urlConsulta, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            //console.log("Respuesta del servidor:", xhr.responseText);
            handleConsultaResponse(xhr.responseText);
        }
    };
    xhr.send();


    
    // Función para calcular el costo total con la tarifa obtenida
    function calcularCostoTotal(valorTarifa, tipo_parqueo) {
        // Resto del código para calcular el costo total
        var horaIngresoObj = new Date("1970-01-01T" + horaIngreso + "Z");
        var horaSalidaObj = new Date("1970-01-01T" + horaSalida + "Z");
        var diferencia = horaSalidaObj - horaIngresoObj;
        var minutos = Math.round(diferencia / 60000);

        var horasCompletas = Math.floor(minutos / 60);
        var costoHorasCompletas = horasCompletas * valorTarifa;
        var costoMinutosAdicionales = 0;


/* Codigo para colocar las tarifas y sus valores
        

* */
       var costoTotal;
       //console.log("tipo de parqueooo para el ticket" + tipo_parqueo)
if (tipo_parqueo >= 3 && tipo_parqueo <= 13) {
        costoTotal = valorTarifa;

} else {
    if (minutos <= 70) {
        // Si el tiempo es menor o igual a 70 minutos, se cobra el valor de la tarifa
        costoTotal = valorTarifa;

    }else{
        // Si el vehículo estuvo estacionado una hora o más,
        // se aplica la lógica original de cálculo del costo
        var horasCompletas = Math.floor(minutos / 60);
        var costoHorasCompletas = horasCompletas * valorTarifa;
        var costoMinutosAdicionales = 0;

        if (minutos % 60 > 10) {
            costoMinutosAdicionales = valorTarifa;
        }

        costoTotal = costoHorasCompletas + costoMinutosAdicionales;
    }
}
        // Generar el contenido del ticket
        var ticketContent = `
            <html>
            <head>
                <title>Ticket de Salida</title>
                <style>
                    /* Estilos CSS para el ticket */
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .ticket {
                        width: 300px;
                        padding: 10px;
                        border: 1px solid #000;
                    }
                    .info {
                        margin-bottom: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="ticket">
                    <h2>Centro Comercial de la 34</h2>
                    <h4>Ticket de Parqueo</h4>
                    <div class="info">
                        <p><strong>Placa:</strong> ${placa}</p>
                        <p><strong>Hora de Ingreso:</strong> ${horaIngreso}</p>
                        <p><strong>Hora de Salida:</strong> ${horaSalida}</p>
                        <p><strong>Costo:</strong> ${costoTotal} pesos</p>
                    </div>
                </div>
            </body>
            </html>
        `;

        // Abrir una nueva ventana para mostrar el ticket y realizar la impresión
        var url = "../controllers/actualizar_salida.php?placa=" + encodeURIComponent(placa) + "&costo=" + costoTotal;
        var ticketWindow = window.open(url, "_blank", "width=400,height=400");
        ticketWindow.document.open();
        ticketWindow.document.write(ticketContent);
        ticketWindow.document.close();
        ticketWindow.focus();
        ticketWindow.print();
    }
}

// function procesarArchivos() {
//            // Hacer una solicitud AJAX al servidor
//             var xhr = new XMLHttpRequest();
//             xhr.open('GET', '../controllers/procesador_imagenes.php', true); // Especifica el endpoint para procesar archivos
//             xhr.onreadystatechange = function() {
//                 if (xhr.readyState == 4 && xhr.status == 200) {
//                     console.log('Archivos procesados correctamente');
//                 }
//             };
//             xhr.send();
//         }

        
//         setInterval(procesarArchivos, 5000);
        
        //setInterval(procesarArchivos, 180000);

      
    </script>
</body>

</html>