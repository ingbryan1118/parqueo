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

<?php
session_start();
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
            <nav id="sidebar" class="col-md-4 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">

                        <?php
                        // Lógica condicional para ocultar elementos según el tipo de usuario
                        if ($tipoUsuario != 2) {
                            //             echo '<li class="nav-item">
                            //     <a class="nav-link" href="reporte.php">
                            //         <i class="fa fa-sign-out"></i> Reporte
                            //     </a>
                            //   </li>';

                            echo '';
            }
                echo '';
                      
                        ?>

<li class="nav-item">
                  <a class="nav-link" href="creaplaca.php">
                      <i class="fa fa-sign-out"></i> Crear Placa
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="verplacas.php">
                      <i class="fa fa-sign-out"></i> Ver Placas
                  </a>
                </li>  <li>
                            <a class="nav-link active" href="index.php">
                                <i class="fa fa-home"></i> Registrar Parqueo
                            </a>
                        </li>

                        

                        <li class="nav-item">
                            <a class="nav-link" href="parqueo.php">
                                <i class="fa fa-list"></i> Lista de parqueo
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="parqueoMensual.php">
                                <i class="fa fa-list"></i> Listado Parqueo Mensual
                            </a>
                        </li>

                        <!-- <li class="nav-item">
                            <a class="nav-link" href="reporte.php">
                                <i class="fa fa-sign-out"></i> Reporte
                            </a>
                        </li> -->

                        <?php
                        // Lógica condicional para ocultar elementos según el tipo de usuario
                        if ($tipoUsuario != 2) {
                                        echo '<li class="nav-item">
                                <a class="nav-link" href="reporte.php">
                                    <i class="fa fa-sign-out"></i> Reporte
                                </a>
                              </li>';

                            echo '<li class="nav-item">
                  <a class="nav-link" href="creaUsuario.php">
                      <i class="fa fa-sign-out"></i> Crear Usuario
                  </a>
                </li>';

                            echo '<li class="nav-item">
                  <a class="nav-link" href="tarifas.php">
                      <i class="fa fa-sign-out"></i> Tarifas
                  </a>
                </li>';
                        }



                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fa fa-sign-out"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-8 ms-sm-auto col-lg-10 px-md-4">
                <div class="container">
                    <h2 class="text-center">Lista de Parqueo Mensual</h2>

                    <!-- Formulario de búsqueda por placa -->
                    <form method="GET" action="parqueoMensual.php">
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
                                    <th>Tarifa</th>
                                    <!-- <th>Actualizar</th>
                                    <th>Eliminar</th> -->
                                    <!-- <th>Hora de Ingreso</th>
                                    <th>Entrada</th>
                                    <th>costo</th> -->


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Conexión a la base de datos (ajusta los valores según tu configuración)
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "parqueadero";

                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Error de conexión: " . $conn->connect_error);
                                }

                                $sql = "SELECT p.id, p.placa, p.tipo_parqueo, t.id, t.nombreTarifa, t.valorTarifa
                                FROM placa AS p
                                JOIN tarifas AS t ON p.tipo_parqueo = t.id
                                WHERE tipo_parqueo in (6,8,9,10)";

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
                                        echo "<td>" . $row["nombreTarifa"] . "</td>";
                                        echo "<td><button class='btn btn-success btn-sm' onclick='abrirTicket(\"" . $row["placa"] . "\", \"" . $row["tipo_parqueo"] . "\")'>ticket</button></td>";
                                        //echo "<td id='horaIngreso'>" . $row["costo"] . "</td>";
                                       // echo "<td><input type='number' class='form-control' id='costoInput_" . $row["id"] . "' value='" . $row["costo"] . "'></td>";
                                        if ($tipoUsuario != 2) {
                                            //echo "<td><button class='btn btn-success btn-sm' onclick='abrirTicket(\"" . $row["placa"] . "\", \"" . $row["hora_ingreso"] . "\", \"" . $row["tipo_parqueo"] . "\")'>ticket</button></td>";
                                            //echo "<td><button class='btn btn-success btn-sm' onclick='actualizarCosto(" . $row["id"] . ")'>Actualizar</button></td>";
                                            echo "<td><button class='btn btn-danger btn-sm' onclick='eliminarRegistro(\"" . $row["placa"] . "\")'>Eliminar</button></td>";

                                        }
                                        // // echo "<td><button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalSalida' data-id='" . $row["id"] . "'>X</button></td>";
                                        //echo "<td><button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalSalida' data-id='" . $row["id"] . "' data-placa='" . $row["placa"] . "' data-hora-ingreso='" . $row["hora_ingreso"] . "' data-tipo-parqueo='" . $row["tipo_parqueo"] . "'>X</button></td>";
                                        // echo "<td id='tiempoTranscurrido'></td>";
                                        // echo "</tr>";
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

                                    <label for="horaSalida">Hora de Salida:</label>
                                    <input type="time" class="form-control" id="horaSalida" name="horaSalida" required>
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

    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../jquery/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
        // Función para abrir la ventana emergente del ticket y calcular el costo total
        function abrirTicket(placa, horaIngreso, tipo_parqueo) {
            // Define la URL de "generar_ticket.php" con la placa como parámetro
            var url = "../controllers/generar_ticketMensual.php?placa=" + encodeURIComponent(placa) + "&horaIngreso=" + encodeURIComponent(horaIngreso);

            var costoTotal = 0;

            console.log("por aquiiiii ver ticket de entrada" + tipo_parqueo);

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

            console.log("generar el de salida")
            console.log(costoTotal)
            console.log(tipo_parqueo)
            // Actualizar los elementos <span> en el modal con la placa y la hora de ingreso
            document.getElementById("placaSalida").textContent = placa;
            document.getElementById("horaIngresoSalida").textContent = horaIngreso;

            // Actualizar el campo oculto de registroId y costoTotal
            document.getElementById("registroId").value = registroId;
            document.getElementById("costoTotal").value = costoTotal;
            document.getElementById("tipo_parqueo").value = tipo_parqueo;
            //console.log("actualizar salida" + costoTotal)

            // Limpiar el campo de hora de salida
            document.getElementById("horaSalida").value = "";

        });

        // Manejar el envío del formulario
        $('#formSalida').submit(function(e) {
            e.preventDefault();
            var registroId = document.getElementById("registroId").value;
            var horaSalida = document.getElementById("horaSalida").value;
            var costoTotal = document.getElementById("costoTotal").value; // Obtener el costo del campo oculto

            var tipo_parqueo = document.getElementById("tipo_parqueo").value;
            console.log("form salida");
            console.log("costo total " + costoTotal);
            console.log("Tipo de parqueo" + tipo_parqueo);

            // Obtener la placa y la hora de ingreso de la fila correspondiente
            var placa = document.getElementById("placaSalida").textContent;
            var horaIngreso = document.getElementById("horaIngresoSalida").textContent;

            //console.log(horaIngreso);
            // console.log(horaSalida);

            // Actualizar la base de datos con la hora de salida y el tiempo transcurrido
            $.ajax({
                type: "POST",
                url: "actualizar_salida.php",
                data: {
                    registroId: registroId,
                    horaIngreso: horaIngreso,
                    horaSalida: horaSalida,
                    costoTotal: costoTotal
                }, // Pasar el costo como parámetro
                success: function(response) {
                    // Actualización exitosa
                    console.log("Base de datos actualizada correctamente");

                    // Generar el ticket de salida
                    generarTicket(placa, horaIngreso, horaSalida, tipo_parqueo);
                },
                error: function(error) {
                    // Error en la actualización
                    console.error("Error al actualizar la base de datos: " + error.responseText);
                }
            });

            // Cerrar el modal
            $('#modalSalida').modal('hide');
        });


        function generarTicket(placa, horaIngreso, horaSalida, tipo_parqueo) {
            // El contenido de la función generarTicket aquí...
            var horaIngresoObj = new Date("1970-01-01T" + horaIngreso + "Z");
            var horaSalidaObj = new Date("1970-01-01T" + horaSalida + "Z");
            var diferencia = horaSalidaObj - horaIngresoObj;
            var minutos = Math.round(diferencia / 60000);



            console.log("TIPO DE PARQUEO:" + tipo_parqueo);
            if (tipo_parqueo == 1) {
                var tarifaPorHora = 3000;
                console.log("TARIFA POR HORA:" + tarifaPorHora);
                var horasCompletas = Math.floor(minutos / 60);
                var costoHorasCompletas = horasCompletas * tarifaPorHora;
                var costoMinutosAdicionales = 0;

                if (minutos % 60 > 19) {
                    costoMinutosAdicionales = tarifaPorHora;
                }

                costoTotal = costoHorasCompletas + costoMinutosAdicionales;
            } else if (tipo_parqueo == 2) {
                var tarifaPorHora = 1000;
                console.log("TARIFA POR HORA:" + tarifaPorHora);
                var horasCompletas = Math.floor(minutos / 60);
                var costoHorasCompletas = horasCompletas * tarifaPorHora;
                var costoMinutosAdicionales = 0;

                if (minutos % 60 > 19) {
                    costoMinutosAdicionales = tarifaPorHora;
                }

                costoTotal = costoHorasCompletas + costoMinutosAdicionales;
            } else if (tipo_parqueo == 3) {
                costoTotal = 5000;
            } else if (tipo_parqueo == 4) {
                costoTotal = 8000;
            }







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

            var url = "actualizar_salida.php?placa=" + encodeURIComponent(placa) + "&costo=" + costoTotal;
            var ticketWindow = window.open(url, "_blank", "width=400,height=400");
            ticketWindow.document.open();
            ticketWindow.document.write(ticketContent);
            ticketWindow.document.close();
            ticketWindow.focus();
            ticketWindow.print();
        }


        function eliminarRegistro(placa) {
            
            //console.log("id a eliminar: " + placa)
            if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
                $.ajax({
                    type: "POST",
                    url: "../controllers/eliminar_registro.php",
                    data: {
                        placa: placa
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    },
                    error: function(error) {
                        console.error("Error al eliminar el registro: " + error.responseText);
                    }
                });
            }
        }

        function actualizarCosto(id) {
            var nuevoCosto = document.getElementById("costoInput_" + id).value;

            $.ajax({
                type: "POST",
                url: "../controllers/actualizar_costo.php",
                data: {
                    id: id,
                    nuevoCosto: nuevoCosto
                },
                success: function(response) {
                    alert(response);
                    // Puedes recargar la página o actualizar solo la fila de la tabla con JavaScript.
                },
                error: function(error) {
                    console.error("Error al actualizar el costo: " + error.responseText);
                }
            });
        }
    </script>
</body>

</html>