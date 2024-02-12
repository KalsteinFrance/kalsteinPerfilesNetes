<?php
$directorioDestino = '/home/he270716/public_html/plataforma.kalstein.net/wp-content/plugins/kalsteinPerfiles/src/images/ImgUpload';

if (!empty($_FILES['imagenes']['name'][0])) {
    $imagenes = $_FILES['imagenes'];

    $emailCliente = $_POST['cName'];

    // Obtener los IDs de los campos de archivos
    $idsInputs = explode(',', $_POST['ids_inputs']);

    // Inicializar un array para almacenar los números de archivo existentes
    $numerosArchivos = [];

    $archivosSubidos = 0; // Contador de archivos subidos con éxito

    foreach ($imagenes['name'] as $key => $nombre) {
        if (!empty($nombre)) {
            $nombreTemp = $imagenes['tmp_name'][$key];
            $extension = pathinfo($nombre, PATHINFO_EXTENSION);

            // Obtener el ID del input correspondiente a este archivo
            $idInput = $idsInputs[$key];

            // Crear un nombre base sin extensión
            $nombreBase = substr($idInput, 0, 7) . $emailCliente;

            // Obtener archivos existentes con el mismo nombre base
            $archivos = glob($directorioDestino . '/' . $nombreBase . '*');

            // Obtener los números de archivo existentes
            $numeros = [];
            foreach ($archivos as $archivo) {
                $nombreCompleto = pathinfo($archivo);
                preg_match('/\d+$/', $nombreCompleto['filename'], $matches);
                if (isset($matches[0])) {
                    $numeros[] = intval($matches[0]);
                }
            }

            // Obtener el número más alto de los archivos existentes
            $numeroMasAlto = max($numeros);
            $numeroNuevo = $numeroMasAlto + 1;

            // Generar el nombre de archivo único
            $nombreArchivo = $nombreBase . $numeroNuevo . '.' . $extension;
            $rutaArchivoDestino = $directorioDestino . '/' . $nombreArchivo;

            if (move_uploaded_file($nombreTemp, $rutaArchivoDestino)) {
                echo "La imagen $nombre ha sido subida correctamente a: " . $rutaArchivoDestino . ";";
                $archivosSubidos++; // Incrementar contador de archivos subidos
            } else {
                echo "Hubo un error al subir la imagen $nombre";
            }
        }
    }

    // Si todos los archivos han sido subidos con éxito, enviar un mensaje indicando que todos los archivos están listos
    if ($archivosSubidos === count(array_filter($imagenes['name']))) {
        echo "Todos los archivos han sido subidos correctamente";
    }
}else {
    echo "No se han seleccionado archivos para subir";
}
?>
