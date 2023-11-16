<?php
session_start();
$tipoUsuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Conectar a la base de datos (reemplaza 'nombre_base_de_datos', 'nombre_usuario' y 'contrasena' con tus propias credenciales)
    $conn = new mysqli("localhost", "root", "", "parqueadero");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $query = "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Obtén el tipo de usuario de la fila obtenida
        $row = $result->fetch_assoc();
        $tipoUsuario = $row['tipo_usuario'];

        // Almacena el correo y tipo de usuario en la sesión
        $_SESSION['correo'] = $correo;
        $_SESSION['tipo_usuario'] = $tipoUsuario;

        header("Location: index.php");
    } else {
        echo "Error: Correo o contraseña incorrectos. <a href='login.php'>Intenta de nuevo</a>";
    }

    $conn->close();
}
