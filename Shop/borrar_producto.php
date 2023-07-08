<?php
// Verificar si se ha proporcionado un ID de producto válido
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Establecer la conexión a la base de datos
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "datos";

  $conn = new mysqli($servername, $username, $password, $database);

  // Verificar si la conexión fue exitosa
  if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
  }

  // Realizar la consulta para borrar el producto
  $sql = "DELETE FROM productos WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    // Mostrar un mensaje de éxito después de borrar el producto
    echo "<p>El producto con ID $id ha sido borrado exitosamente.</p>";

    // Llamar a generar_copia.php
    include("generar_copia.php");
  } else {
    // Mostrar un mensaje de error si no se pudo borrar el producto
    echo "Error al borrar el producto: " . $conn->error;
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
} else {
  // Si no se proporciona un ID de producto válido, mostrar un mensaje de error
  echo "<p>No se ha proporcionado un ID de producto válido.</p>";
}
?>
