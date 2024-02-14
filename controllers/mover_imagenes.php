<?php
// Obtener la ruta de origen y destino del formulario
$rutaOrigen = $_POST['rutaOrigen'];
$rutaDestino = $_POST['rutaDestino'];
$placa = $_POST['placa'];

// Comprobar si la carpeta de destino existe, si no, crearla
if (!file_exists($rutaDestino)) {
    mkdir($rutaDestino, 0777, true); // Se crean los directorios recursivamente
}

// Obtener todos los archivos en la carpeta de origen
$archivos = glob($rutaOrigen . "*.jpg"); // Cambiar la extensión si las imágenes tienen otra extensión

// Expresión regular para extraer la placa del nombre del archivo
$regex = '/(?<=_)[A-Z\d]+(?=_)/';

// Mover cada archivo a la carpeta de destino si coincide con la placa
foreach ($archivos as $archivo) {
    // Obtener solo el nombre del archivo sin la ruta
    $nombreArchivo = basename($archivo);

    // Extraer la placa del nombre del archivo usando la expresión regular
    preg_match($regex, $nombreArchivo, $matches);
    $placaArchivo = $matches[0]; // La placa estará en el primer grupo coincidente

    // Verificar si la placa extraída coincide con la placa actual
    if ($placaArchivo === $placa) {
        // Construir la ruta de destino completa
        $rutaArchivoDestino = $rutaDestino . $placa . "/";

        // Comprobar si la carpeta de destino para esta placa existe, si no, crearla
        if (!file_exists($rutaArchivoDestino)) {
            mkdir($rutaArchivoDestino, 0777, true); // Se crean los directorios recursivamente
        }

        // Mover el archivo
        if (rename($archivo, $rutaArchivoDestino . $nombreArchivo)) {
            // Archivo movido con éxito
            echo "Imagen " . $nombreArchivo . " movida correctamente a " . $placa . "<br>";
        } else {
            // Error al mover el archivo
            echo "Error al mover la imagen " . $nombreArchivo . "<br>";
        }
    }
}
?>
