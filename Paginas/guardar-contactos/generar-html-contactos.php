<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guardar-contactos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$output = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css" />
    <title>Ver Categorías</title>
</head>
<body>
    <div class="container">
        <h1><a class="back-link" href="../../index.html">Regresar a Tienda</a></h1>
        <div class="category-buttons">';

$categoria_query = "SELECT * FROM categorias";
$categoria_result = $conn->query($categoria_query);

if ($categoria_result->num_rows > 0) {
    while ($categoria_row = $categoria_result->fetch_assoc()) {
        $output .= '<button class="category-button" data-categoria="' . $categoria_row["nombre"] . '">' . $categoria_row["nombre"] . '</button>';
    }
}

$output .= '</div>
    </div>

    <div class="container">
        <h1><a class="back-link" href="cargar-contactos.php">Detalles del Contacto</a></h1>
        <div class="contact-details-container">';

$query = "SELECT contactos.*, categorias.nombre AS categoria_nombre FROM contactos
          INNER JOIN categorias ON contactos.categoria_id = categorias.id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= '<div class="contact-details" data-categoria="' . $row["categoria_nombre"] . '">';
        $output .= '<img class="contact-img" src="uploads/' . $row["img"] . '" alt="' . $row["nombre"] . '">';
        $output .= '<h3 class="contact-name">' . $row["nombre"] . '</h3>';
        $output .= '<p class="contact-link llamada"><strong class="contact-strong">Llamada:</strong><br>&nbsp;<a href="tel:' . $row["numeros"] . '">' . $row["numeros"] . '</a></p>';
        $output .= '<p class="contact-link whatsapp"><a href="https://wa.me/506' . $row["numeros"] . '">WhatsApp</a></p>';
        $output .= '<p class="contact-category"><strong>Categoría:</strong><br>&nbsp;' . $row["categoria_nombre"] . '</p>';
        $output .= '</div>';
    }
} else {
    $output .= '<p>No se encontraron contactos.</p>';
}

$output .= '</div>
    </div>

    <script>
        const categoryButtons = document.querySelectorAll(".category-button");
        const contactDetails = document.querySelectorAll(".contact-details");

        categoryButtons.forEach(button => {
            button.addEventListener("click", () => {
                const categoria = button.getAttribute("data-categoria");
                contactDetails.forEach(detail => {
                    if (detail.getAttribute("data-categoria") === categoria) {
                        detail.style.display = detail.style.display === "flex" ? "none" : "flex";
                    } else {
                        detail.style.display = "none";
                    }
                });
            });
        });
    </script>
    <iframe
    class="video-container-ocultar"
    width="560"
    height="315"
    src="https://www.youtube.com/embed/_OE4EqC5yOQ?autoplay=1&mute=1"
    title="YouTube video player"
    frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
    allowfullscreen
  ></iframe>
</body>
</html>';

$conn->close();

// Guardar el contenido en un archivo HTML
file_put_contents('index.html', $output);

echo 'Archivo HTML generado con éxito.';

// Redireccionar a index.html después de 3 segundos
header("Location: index.html");
?>
