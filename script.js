document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("parqueoForm");
    const registrarParqueoButton = document.getElementById("registrarParqueo");

    registrarParqueoButton.addEventListener("click", async function () {
        // Obtener los datos del formulario
        const placa = document.getElementById("placa").value;
        const tipoParqueo = document.getElementById("tipo_parqueo").value;
        const horaIngreso = document.getElementById("hora_ingreso").value;

        // Crear un objeto de datos para enviar al servidor
        const data = {
            placa,
            tipoParqueo,
            hora_ingreso: horaIngreso,
        };

        try {
            // Realizar la solicitud AJAX al servidor para guardar los datos
            const response = await fetch("guardar_parqueo.php", {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json",
                },
            });

            if (response.ok) {
                const result = await response.json();

                // Verificar si el registro fue exitoso en el servidor
                if (result.exito === 1) {
                    const ticketURL = `generar_ticket.php?placa=${placa}&tipo_parqueo=${tipoParqueo}&hora_ingreso=${horaIngreso}`;
                    window.location.href = ticketURL;
                } else {
                    console.error("Error en el servidor al guardar el parqueo");
                }
            } else {
                console.error("Error en la solicitud AJAX: " + response.statusText);
            }
        } catch (error) {
            console.error("Error en la solicitud AJAX: " + error);
        }
    });
});
