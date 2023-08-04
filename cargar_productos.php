<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'tienda');

// Verificar si hay errores de conexión
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];
$envio = $_POST['envio'];
$categoria = $_POST['categoria'];
$telefono = $_POST['telefono'];
$cedula = $_POST['cedula'];
$tienda = $_POST['tienda'];

// Procesar la imagen
$imagen_nombre = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];

// Obtener la extensión del archivo
$imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);

// Generar un nombre único para la imagen usando el timestamp actual
$nombre_imagen_unico = 'Diseños_' . uniqid() . '.' . $imagen_extension;

$imagen_ruta = 'imagenes/' . $nombre_imagen_unico;

// Verificar si el directorio "imagenes" existe o no
if (!file_exists('imagenes')) {
    // Si no existe, lo creamos con permisos 0755 (es posible que debas ajustar los permisos según tu servidor)
    mkdir('imagenes', 0755);
}

// Mover la imagen al directorio de imágenes en el servidor
move_uploaded_file($imagen_temp, $imagen_ruta);

// Insertar los datos en la tabla de productos
$sql = "INSERT INTO productos (imagen, nombre, precio, cantidad, envio, categoria, telefono, cedula, tienda) 
        VALUES ('$imagen_ruta', '$nombre', '$precio', $cantidad, '$envio', '$categoria', '$telefono', '$cedula', '$tienda')";

if ($conexion->query($sql) === TRUE) {
    // Redireccionar a mostrar_productos.php
    header("Location: generador.php");
    exit(); // Asegurarse de que el script se detenga después de la redirección
} else {
    echo "Error al cargar el producto: " . $conexion->error;
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>