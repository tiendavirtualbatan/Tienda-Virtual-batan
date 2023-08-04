<?php
$host = 'localhost';
$username = 'root'; // Reemplaza esto con el nombre de usuario de tu base de datos
$password = ''; // Reemplaza esto con la contraseña de tu base de datos
$database = 'tienda';

// Crear la conexión
$conn = mysqli_connect($host, $username, $password, $database);

// Verificar la conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Definir la cantidad de productos por página
$productosPorPagina = 5;

// Obtener el número de página actual desde la URL, si no se proporciona, asumimos la página 1
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;

// Calcular el índice de inicio para la consulta SQL
$indiceInicio = ($paginaActual - 1) * $productosPorPagina;

// Obtener el término de búsqueda del cuadro de búsqueda
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Consulta a la base de datos utilizando la cláusula LIKE para buscar coincidencias
$sql = "SELECT * FROM productos WHERE nombre LIKE '%$searchTerm%' LIMIT $indiceInicio, $productosPorPagina";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Mostrar los resultados de la búsqueda
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product" data-categoria="' . $row['categoria'] . '">';
        echo '<img src="' . $row['imagen'] . '" alt="' . $row['nombre'] . '">';
        echo '<a href="#" class="show-details">Más detalles</a>';
        echo '<div class="product-details" style="display:none;">';
        echo '<h3>' . $row['nombre'] . '</h3>';
        echo '<p>₡' . number_format($row['precio'], 2) . '</p>';
        echo '<span>Categoría: ' . $row['categoria'] . '</span>';
        echo '<span>Envío: ' . $row['envio'] . '</span>';
        echo '<span>Cantidad: ' . $row['cantidad'] . '</span>';
        $whatsappLink = 'https://wa.me/506' . $row['telefono'];
        echo '<span>WhatsApp: <a href="' . $whatsappLink . '">' . $row['telefono'] . '</a></span>';
        echo '<span>Tienda: <span class="tienda">' . $row['tienda'] . '</span></span>';
        echo '</div>';
        echo '</div>';
    }

    // Obtener el total de productos en la base de datos para calcular la paginación
    $totalProductos = mysqli_query($conn, "SELECT COUNT(*) as total FROM productos WHERE nombre LIKE '%$searchTerm%'")->fetch_assoc()['total'];
    $totalPaginas = ceil($totalProductos / $productosPorPagina);

    // Muestra la paginación
    echo '<div class="pagination">';
    for ($i = 1; $i <= $totalPaginas; $i++) {
        echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
    }
    echo '</div>';
} else {
    // Mostrar mensaje si no se encontraron productos
    echo "<p>No se encontraron productos.</p>";
}

// Cerrar la conexión
mysqli_close($conn);
?>
