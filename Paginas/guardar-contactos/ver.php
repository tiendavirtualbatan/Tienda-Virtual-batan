<!DOCTYPE html>
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
            flex-wrap: wrap; /* Acomodar en varias líneas */
            justify-content: center; /* Centrar horizontalmente */
        }

        .contact-details {
            display: none;
            display: flex; /* Mostrar en línea */
            flex-direction: column; /* Acomodar apilados */
            align-items: center; /* Centrar verticalmente */
            padding: 10px;
            background-color: #eaeaea;
            border-radius: 5px;
            margin: 10px;
            width: 160px; /* Ancho fijo */
            height: auto; /* Alto fijo */
        }

        .contact-details h3,
        .contact-details p {
            margin: 5px; /* Agregar espacio entre los elementos */
        }

        .contact-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
    <title>Ver Categorías</title>
</head>
<body>
    <div class="container">
        <h1>Categorías</h1>
        <div class="category-buttons">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "guardar-contactos";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $categoria_query = "SELECT * FROM categorias";
            $categoria_result = $conn->query($categoria_query);

            if ($categoria_result->num_rows > 0) {
                while ($categoria_row = $categoria_result->fetch_assoc()) {
                    echo '<button class="category-button" data-categoria="' . $categoria_row["nombre"] . '">' . $categoria_row["nombre"] . '</button>';
                }
            }

            $conn->close();
            ?>
        </div>
    </div>

    <div class="container">
        <h1>Detalles del Contacto</h1>
        <div class="contact-details-container">
            <?php
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $query = "SELECT contactos.*, categorias.nombre AS categoria_nombre FROM contactos
                      INNER JOIN categorias ON contactos.categoria_id = categorias.id";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="contact-details" data-categoria="' . $row["categoria_nombre"] . '">';
                    echo '<img class="contact-img" src="uploads/' . $row["img"] . '" alt="' . $row["nombre"] . '">';
                    echo '<h3>' . $row["nombre"] . '</h3>';
                    echo '<p><strong>Números:</strong><br>&nbsp;<a href="tel:' . $row["numeros"] . '" style="color: red; text-decoration: none; font-weight: bold;">' . $row["numeros"] . '</a></p>';
                    echo '<p><strong>Categoría:</strong><br>&nbsp;' . $row["categoria_nombre"] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No se encontraron contactos.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script>
        const categoryButtons = document.querySelectorAll('.category-button');
        const contactDetails = document.querySelectorAll('.contact-details');

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                const categoria = button.getAttribute('data-categoria');
                contactDetails.forEach(detail => {
                    if (detail.getAttribute('data-categoria') === categoria) {
                        detail.style.display = detail.style.display === 'flex' ? 'none' : 'flex';
                    } else {
                        detail.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
