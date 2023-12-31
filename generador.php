<?php
// Establecer una conexión con la base de datos MySQL
$conexion = new mysqli('localhost', 'root', '', 'tienda');

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Consulta SQL para seleccionar todos los registros de la tabla "productos"
$sql = "SELECT * FROM productos";

// Ejecutar la consulta y almacenar el resultado en la variable $result
$result = $conexion->query($sql);

// Iniciar el buffer de salida para almacenar la salida generada por el script
ob_start();
?>
<!DOCTYPE html>
<html lang="es-es">

<head>
    <!-- Meta etiquetas para información de la página -->
    <meta property="og:title" content="Ventas Celulares Baratos Batan, Siquirres">
    <meta property="og:description" content="Desbloqueos, Ventas, Reparaciones, Computadoras, Celulares">
    <meta property="og:image" content="sistema/a.png">
    <meta property="og:url" content="https://tiendavirtualbatan.com">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Enlace al archivo de estilos CSS -->
    <link rel="stylesheet" href="sistema/css/index.css" />
    <link rel="stylesheet" href="sistema/css/btn-animate.css" />
    <link rel="stylesheet" href="sistema/css/video-container-ocultar.css" />
    <link rel="stylesheet" href="sistema/css/nav-style-index.css" />
    <title>Tienda Virtual Batan</title>
</head>

<body>
  <!-- main container -->
  <div class="container">
    <!-- navbar begin -->
    <nav class="navbar">
      <div class="navbar-brand">
        <!-- Título principal de la página -->
        <div class="logo"><button class="button btn-animate"> <span style="font-size:16px"> Tienda Virtual <span style="color:#259dff">Batán</span></span> </button></div>
      </div>
      <div class="navbar-list">
        <ul class="nav-ul">
          <li class="nav-li"><a href="index.html" class="nav-link">Inicio</a></li>
          <li class="nav-li"><a href="Paginas/formulario_productos.html" class="nav-link">Cargar Productos</a></li>
          <li class="nav-li"><a href="Paginas/Tecnico/index.html" class="nav-link">Técnico</a></li>
          <li class="nav-li"><a href="Paginas/guardar-contactos/index.html" class="nav-link">Contactos</a></li>
          <li class="nav-li"><a href="Paginas/super-useful-css-resources/super-useful-css-resources.html" class="nav-link">Recursos CSS</a></li>
        </ul>
      </div>
      <div class="menu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
    <!-- navbar end -->
  </div>

    <!-- Contenedor principal -->
    <div class="container2">
        <div class="form-group">
            <!-- Cuadro de búsqueda -->
            <input type="text" id="buscador" placeholder="Buscar productos por nombre">
        </div>
    </div>
    <!-- Aquí se mostrarán los productos dinámicamente mediante código JavaScript -->
    <div class="product-container">
        <?php
        // Verifica si hay resultados en la consulta
        if ($result->num_rows > 0) {
            // Recorre cada fila de resultados
            while ($row = $result->fetch_assoc()) {
                // Muestra un producto en un div con el atributo de data-categoria
                echo '<div class="product" data-categoria="' . $row['categoria'] . '">';

                // Muestra la imagen del producto con un enlace para la expansión
                echo '<div class="product">';
                echo '<img src="' . $row['imagen'] . '" alt="' . $row['nombre'] . '" class="expandable-image">';
                echo '</div>';

                // Agrega el enlace "Más detalles" que mostrará el contenido adicional al hacer clic en él
                echo '<a href="#" class="show-details">Más detalles</a>';

                // Muestra los detalles del producto en un div con la clase "product-details" (inicialmente oculto)
                echo '<div class="product-details" style="display:none;">';

                // Muestra el nombre del producto
                echo '<h3>' . $row['nombre'] . '</h3>';

                // Muestra el precio del producto formateado como moneda (colones, con dos decimales)
                echo '<p>₡' . number_format($row['precio'], 2) . '</p>';

                // Muestra la categoría del producto
                echo '<span>Categoría: ' . $row['categoria'] . '</span>';

                // Muestra el tipo de envío del producto
                echo '<span>Envío en: ' . $row['envio'] . ' días</span>';

                // Muestra la cantidad disponible del producto
                echo '<span>Disponibles: ' . $row['cantidad'] . ' unidades</span>';

                // Genera un enlace de WhatsApp usando el número de teléfono del vendedor
                $whatsappLink = 'https://wa.me/506' . $row['telefono'];
                echo '<span>WhatsApp: <a href="' . $whatsappLink . '">' . $row['telefono'] . '</a></span>';

                // Muestra el nombre de la tienda del producto
                echo '<span>Tienda: <span class="tienda">' . $row['tienda'] . '</span></span>';

                // Cierra el div de detalles del producto
                echo '</div>';

                // Cierra el div del producto actual
                echo '</div>';
            }
        } else {
            // Si no hay productos, muestra un mensaje indicando que no hay registros.
            echo "<p>No hay productos registrados.</p>";
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".show-details").click(function(event) {
                    event.preventDefault(); // Evita la acción predeterminada del enlace

                    var productDetails = $(this).next(".product-details");

                    // Encuentra todos los detalles del producto, excepto el que se está abriendo
                    var otherDetails = $(".product-details").not(productDetails);

                    // Si el detalle actual está visible, ocúltalo; si no, muestra y oculta los demás detalles
                    if (productDetails.is(":visible")) {
                        productDetails.hide();
                    } else {
                        otherDetails.hide();
                        productDetails.show();
                    }
                });

                // Cierra los detalles de los productos cuando se hace clic fuera de ellos
                $(document).on("click", function(event) {
                    if (!$(event.target).closest(".show-details, .product-details").length) {
                        $(".product-details").hide();
                    }
                });

            });

            // Agrega esta sección al final de tu archivo HTML, dentro de la etiqueta <body> 

            $(document).ready(function() {
                $(".expandable-image").click(function() {
                    $(this).toggleClass("expanded");
                });
            });
        </script>

    </div>
    <!-- Contenedor de íconos de redes sociales fijos -->
    <div class="sticky-container">
        <ul class="sticky">
            <li>
                <p><a href="https://wa.me/50687895592" target="_self"><img src="sistema/imagenes/whatsapp.png" width="35" height="35"></a></p>
            </li>
            <li>
                <p><a href="https://www.youtube.com/channel/UCQla-SX_xSInWU86Z4z0iYg" target="_self"><img src="sistema/imagenes/youtube.png" width="35" height="35"></a></p>
            </li>
            <li>
                <p><a href="https://www.instagram.com/yuliana.emir/" target="_self"><img src="sistema/imagenes/instagram.png" width="35" height="35"></a></p>
            </li>
            <li>
                <p><a href="https://www.facebook.com/tiendavirtualbataan/" target="_self"><img src="sistema/imagenes/facebook.png" width="35" height="35"></a></p>
            </li>
            <li>
                <p><a href="https://twitter.com/emiryuliana" target="_self"><img src="sistema/imagenes/twiter.gif" width="35" height="35"></a></p>
            </li>
            <li>
                <p><a href="emiryuliana/index.html" target="_self"><img src="sistema/imagenes/logo.png" width="35" height="35"></a></p>
            </li>
        </ul>
    </div>
    <!-- Archivo JavaScript para manipulación de la página -->

    <script src="sistema/js/index.js"></script>
    <script src="sistema/js/nav-index.js"></script>

    <iframe class="video-container-ocultar" width="560" height="315" src="https://www.youtube.com/embed/_OE4EqC5yOQ?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</body>

</html>
<?php
// Finalizar almacenamiento en buffer y guardar el contenido en una variable
$htmlContent = ob_get_clean();

// Guardar el contenido del buffer en un archivo HTML llamado index.html
file_put_contents('estatica.html', $htmlContent);

// Redirigir al usuario a index.html
header('Location: index.html');

// Asegurar que no se ejecute más código después de la redirección
exit();
?>