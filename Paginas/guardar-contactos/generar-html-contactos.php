<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guardar-contactos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$output = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .category-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .category-button {
            margin: 10px;
            padding: 5px 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .contact-details-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .contact-details {
            display: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            background-color: #eaeaea;
            border-radius: 5px;
            margin: 10px;
            width: 160px;
            height: auto;
        }

        .contact-details h3,
        .contact-details p {
            margin: 5px;
        }

        .contact-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }

        .back-link {
            text-decoration: none; /* Quitar subrayado */
            color: red; /* Cambiar color a rojo */
            font-weight: bold; /* Hacer el texto en negrita */
        }

        .back-link:hover {
            text-decoration: underline; /* Agregar subrayado al pasar el mouse */
        }

    </style>
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
        $output .= '<h3>' . $row["nombre"] . '</h3>';
        $output .= '<p><strong>Llamada directa:</strong><br>&nbsp;<a href="tel:' . $row["numeros"] . '" style="color: red; text-decoration: none; font-weight: bold;">' . $row["numeros"] . '</a></p>';
        $output .= '<p>&nbsp;<a href="https://wa.me/506' . $row["numeros"] . '" style="color: green; text-decoration: none; font-weight: bold;">Enviar mensaje WhatsApp</a></p>';
        $output .= '<p><strong>Categoría:</strong><br>&nbsp;' . $row["categoria_nombre"] . '</p>';
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
</body>
</html>';

$conn->close();

// Guardar el contenido en un archivo HTML
file_put_contents('index.html', $output);

echo 'Archivo HTML generado con éxito.';

// Redireccionar a index.html después de 3 segundos
header("Location: index.html");
?>
