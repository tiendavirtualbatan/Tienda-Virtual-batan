<!DOCTYPE html>
<html lang="es-es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tabla de Productos</title>
    <style>
        /* Estilos CSS aquí (mantener los estilos actuales) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f0f0f0;
        }

        h1 {
            background-color: #FF6600;
            color: #fff;
            padding: 10px;
            text-align: center;
            margin: 0;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            padding: 10px;
        }

        .product {
            width: 162px;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 10px;
        }

        .product-details {
            text-align: center;
        }
        .product-details a {
            text-decoration: none;
            color: green; /* Aquí puedes cambiar el color a tu preferencia */
            font-weight: bold;
        }
        /* Estilo solo para la palabra "Tienda" dentro de .product-details */
        .product-details span.tienda {
            color: #ff0080; /* Cambiar el color aquí */
            font-weight: bold;
        }

        .product-details h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .product-details p {
            margin: 5px 0;
            font-size: 16px;
            color: #FF6600;
        }

        .product-details span {
            display: block;
            font-size: 14px;
            color: #666;
        }

        /* Estilos para el contenedor principal */
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 6vh;
        }

        /* Estilos para el elemento label y el menú desplegable select */
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        /* Estilo para eliminar el subrayado en los enlaces */
        .product-details a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h1>Tabla de Productos</h1>
    <div class="container">
        <div class="form-group">
            <!-- Agregar el siguiente cuadro de búsqueda en la parte superior de la página -->
            <input type="text" id="buscador" placeholder="Buscar productos por nombre">
        </div>
    </div>

    <div class="product-container">
        <!-- Tu código PHP para obtener y mostrar los productos -->
        <?php
        // Tu código PHP para obtener y mostrar los productos
        $conexion = new mysqli('localhost', 'root', '', 'tienda');

        if ($conexion->connect_error) {
            die('Error de conexión: ' . $conexion->connect_error);
        }

        if (isset($_POST['eliminar'])) {
            // Obtener el ID del producto a eliminar
            $idProducto = $_POST['eliminar'];

            // Obtener la información del producto (incluida la ruta de la imagen)
            $sql = "SELECT * FROM productos WHERE id = '$idProducto'";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Eliminar el registro de la base de datos
                $sqlEliminar = "DELETE FROM productos WHERE id = '$idProducto'";
                $conexion->query($sqlEliminar);

                // Eliminar la imagen del servidor
                $rutaImagen = $row['imagen'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
        }

        // Consulta nuevamente los productos después de eliminar
        $sql = "SELECT * FROM productos";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product" data-categoria="' . $row['categoria'] . '">';
                echo '<img src="' . $row['imagen'] . '" alt="' . $row['nombre'] . '">';
                echo '<div class="product-details">';
                echo '<h3>' . $row['nombre'] . '</h3>';
                echo '<p>₡' . number_format($row['precio'], 2) . '</p>';
                echo '<span>Cantidad: ' . $row['cantidad'] . '</span>';
                echo '<span>Envío: ' . $row['envio'] . '</span>';
                echo '<span>Categoría: ' . $row['categoria'] . '</span>';
                
                // Modificación para el enlace de WhatsApp
                $whatsappLink = 'https://wa.me/506' . $row['telefono'];
                echo '<span>WhatsApp: <a href="' . $whatsappLink . '">' . $row['telefono'] . '</a></span>';
        
                // Aplicar estilo solo a la palabra "Tienda"
                echo '<span>Tienda: <span class="tienda">' . $row['tienda'] . '</span></span>';
        
                // Botón de eliminar
                echo '<form method="post">';
                echo '<button type="submit" name="eliminar" value="' . $row['id'] . '">Eliminar</button>';
                echo '</form>';
                
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>No hay productos registrados.</p>";
        }

        $conexion->close();
        ?>
    </div>

    <script>
        // Código JavaScript para filtrar productos por nombre en tiempo real
        document.getElementById('buscador').addEventListener('keyup', function () {
            var searchTerm = this.value.toLowerCase();
            var products = document.getElementsByClassName('product');

            for (var i = 0; i < products.length; i++) {
                var productName = products[i].getElementsByClassName('product-details')[0]
                    .getElementsByTagName('h3')[0].innerText.toLowerCase();

                if (productName.includes(searchTerm)) {
                    products[i].style.display = 'block';
                } else {
                    products[i].style.display = 'none';
                }
            }
        });

        // Código JavaScript para abrir WhatsApp con la información del producto al hacer clic en el número de teléfono
        var phoneLinks = document.querySelectorAll('.product-details a');

        phoneLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                var phoneNumber = link.textContent;
                var productName = link.closest('.product').querySelector('h3').textContent;
                var productPrice = link.closest('.product').querySelector('p').textContent;
                var productInfo = '¡Hola! Estoy interesado/a en el producto "' + productName + '" con precio de ' + productPrice + '.';
                var whatsappLink = 'https://wa.me/' + phoneNumber + '?text=' + encodeURIComponent(productInfo);
                window.open(whatsappLink);
            });
        });
    </script>
</body>

</html>
