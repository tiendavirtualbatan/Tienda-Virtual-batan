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
      <title>Tienda Virtual Batan</title>
   </head>
   <body>
      <div class="container1">
         <!-- Encabezado y menú de navegación -->
         <header>
            <!-- Título principal de la página -->
            <h1 class="gradient-text">Tienda Virtual Batan</h1>
            <!-- Menú de navegación con enlaces -->
            <nav id="nav">
               <a href="index.html" onclick="seleccionar()">Inicio</a>
               <a href="https://samfw.com/" onclick="seleccionar()"><span class="display-2 text-white"><img
                  src="https://samfw.com/assets/img/logo_spin.gif" alt="SamFw" height="30"> SamFw</span></a>
               <a href="https://samfirmtool.com/" onclick="seleccionar()">Samfirm Tool</a>
               <a href="https://frp.gsmneo.com/" onclick="seleccionar()">GSMneo</a>
               <a href="Paginas/formulario_productos.html" onclick="seleccionar()">Cargar Productos</a>
               <a href="https://hack4u.io/" onclick="seleccionar()"><img
                  src="sistema/imagenes/Hack4u_FondoBlanco-300x63.png" alt="Hack4u_FondoBlanco" height="30"></a>
               <a href="emir-yuliana/index.html" onclick="seleccionar()">Técnico</a>
            </nav>
            <!-- Icono del menú responsive para dispositivos móviles -->
            <div id="icono-nav" class="nav-responsive" onclick="mostrarOcultarMenu()">
               <!-- Imagen del ícono de hamburguesa -->
               <img src="sistema/imagenes/ini.png" alt="Ícono de hamburguesa">
            </div>
         </header>
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
            
                    // Muestra la imagen del producto
                    echo '<img src="' . $row['imagen'] . '" alt="' . $row['nombre'] . '">';
            
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
                    echo '<span>Envío: ' . $row['envio'] . '</span>';
            
                    // Muestra la cantidad disponible del producto
                    echo '<span>Cantidad: ' . $row['cantidad'] . '</span>';
            
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
            
                    // Cierra los detalles de los productos que estaban abiertos
                    otherDetails.hide();
            
                    // Alternar la visibilidad del detalle actual
                    productDetails.toggle();
            
                    // Cerrar el detalle automáticamente después de 5 segundos (5000 milisegundos)
                    if (productDetails.is(":visible")) {
                        setTimeout(function() {
                            productDetails.hide();
                        }, 5000);
                    }
                });
            });
         </script>
      </div>
      <!-- Contenedor de íconos de redes sociales fijos -->
      <div class="sticky-container">
         <ul class="sticky">
            <li>
               <p><a href="https://wa.me/50687895592" target="_self"><img src="sistema/imagenes/whatsapp.png"
                  width="35" height="35"></a></p>
            </li>
            <li>
               <p><a href="https://www.youtube.com/channel/UCQla-SX_xSInWU86Z4z0iYg" target="_self"><img
                  src="sistema/imagenes/youtube.png" width="35" height="35"></a></p>
            </li>
            <li>
               <p><a href="https://www.instagram.com/yuliana.emir/" target="_self"><img
                  src="sistema/imagenes/instagram.png" width="35" height="35"></a></p>
            </li>
            <li>
               <p><a href="https://www.facebook.com/tiendavirtualbataan/" target="_self"><img
                  src="sistema/imagenes/facebook.png" width="35" height="35"></a></p>
            </li>
            <li>
               <p><a href="https://twitter.com/emiryuliana" target="_self"><img src="sistema/imagenes/twiter.gif"
                  width="35" height="35"></a></p>
            </li>
            <li>
               <p><a href="emiryuliana/index.html" target="_self"><img src="sistema/imagenes/logo.png" width="35"
                  height="35"></a></p>
            </li>
         </ul>
      </div>
      <!-- Archivo JavaScript para manipulación de la página -->
      <script src="sistema/js/index.js"></script>
   </body>
</html>
<?php
   // Finalizar almacenamiento en buffer y guardar el contenido en una variable
   $htmlContent = ob_get_clean();
   
   // Guardar el contenido del buffer en un archivo HTML llamado index.html
   file_put_contents('index.html', $htmlContent);
   
   // Redirigir al usuario a index.html
   header('Location: index.html');
   
   // Asegurar que no se ejecute más código después de la redirección
   exit();
   ?>