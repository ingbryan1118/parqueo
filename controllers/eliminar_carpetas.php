<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parqueadero";

date_default_timezone_set('America/Bogota');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['carpetas'])) {
            $carpetas_seleccionadas = $_POST['carpetas'];
            foreach ($carpetas_seleccionadas as $carpeta) {
                if (file_exists($carpeta)) {
                    eliminarCarpeta($carpeta);
                    echo "La carpeta $carpeta y su contenido han sido eliminados.<br>";
                } else {
                    echo "La carpeta $carpeta no existe.<br>";
                }
            }
        } else {
            echo "No se han seleccionado carpetas para eliminar.<br>";
        }
    }

    function eliminarCarpeta($carpeta) {
        $archivos = glob($carpeta . '/*');
        foreach ($archivos as $archivo) {
            if (is_file($archivo)) {
                unlink($archivo);
            } elseif (is_dir($archivo)) {
                eliminarCarpeta($archivo);
            }
        }
        rmdir($carpeta);
    }
?>
