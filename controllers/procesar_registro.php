<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $tipo_usuario = $_POST["tipo_usuario"];

    
    $host = "localhost"; 
    $usuario = "root"; 
    $contrasena_bd = ""; 
    $nombre_bd = "parqueadero"; 
    $conexion = mysqli_connect($host, $usuario, $contrasena_bd, $nombre_bd);

    if (!$conexion) {
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }

    // Escapar los datos para prevenir inyecciones SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $correo = mysqli_real_escape_string($conexion, $correo);
    //$contrasena = password_hash($contrasena, PASSWORD_BCRYPT); // Hash de la contraseña

    // Crear la consulta SQL para la inserción
    $sql = "INSERT INTO usuarios (nombre, correo, contrasena, tipo_usuario) VALUES ('$nombre', '$correo', '$contrasena', '$tipo_usuario')";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $sql)) {
        header("Location: ../views/creaUsuario.php?exito=1");
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conexion);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Redirigir si el formulario no se envió
    header("Location: index.html");
}
?>
