<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['nombre']) && !empty($_FILES['imagen']) && isset($_POST['detalles']) && isset($_POST['precio'])) {
    $nombreImagen = $_POST['nombre']; // Nombre personalizado de la imagen
    $nombre = $_POST['nombre']; // Nombre personalizado de la imagen
    $detalles = $_POST['detalles']; // Detalles del producto
    $precio = $_POST['precio']; // Precio del producto
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp', 'tiff', 'ico', 'jfif', 'pjpeg');

    // Obtener la información del archivo cargado
    $archivoTemporal = $_FILES['imagen']['tmp_name'];
    $tamañoArchivo = $_FILES['imagen']['size'];
    $tipoArchivo = $_FILES['imagen']['type'];

    // Ruta de la carpeta principal "productos/"
    $carpetaPrincipal = 'productos/';

    // Crear la carpeta principal si no existe
    if (!is_dir($carpetaPrincipal)) {
      mkdir($carpetaPrincipal);
    }

    // Obtener la extensión del archivo cargado
    $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

    // Ruta completa de la imagen con el nombre personalizado y la extensión
    $rutaCompleta = $carpetaPrincipal . $nombreImagen . '.' . $extension;

    // Verificar si ya existe un archivo con el mismo nombre
    $contador = 1;
    while (file_exists($rutaCompleta)) {
      $nombreImagen = $_POST['nombre'] . '_' . $contador;
      $rutaCompleta = $carpetaPrincipal . $nombreImagen . '.' . $extension;
      $contador++;
    }

    // Mover el archivo cargado a la carpeta principal y cambiar el nombre
    if (move_uploaded_file($archivoTemporal, $rutaCompleta)) {
      echo 'La imagen se ha cargado y guardado con éxito.';

      // Guardar la información del producto en la base de datos
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "datos";

      // Crear una conexión a la base de datos
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Verificar la conexión
      if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
      }

      // Preparar la consulta SQL para insertar los datos en la tabla
      $sql = "INSERT INTO productos (imagen, nombre, detalles, precio) VALUES ('$rutaCompleta', '$nombre', '$detalles', $precio)";

      // Ejecutar la consulta
      if ($conn->query($sql) === TRUE) {
        echo "La información del producto se ha guardado en la base de datos.";

        // Ejecutar generar_copia.php
        require_once('generarpaypal.php');

        // Redireccionar al usuario a index.html
        header("Location: index.html");
        exit();
      } else {
        echo "Error al guardar la información del producto: " . $conn->error;
      }

      // Cerrar la conexión
      $conn->close();
    } else {
      echo 'Error al cargar y guardar la imagen.';
    }
  } else {
    echo 'No se han proporcionado todos los datos necesarios.';
  }
}
?>
