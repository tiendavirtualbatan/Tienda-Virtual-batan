<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="all.min.css">
      <link rel="stylesheet" href="ver-producto.css">
      <link rel="stylesheet" href="swap.css">
      <title>Tienda Virtual Batan</title>
   </head>
   <body>
      <div class="container">
         <header>
            <h1 class="gradient-text">Tienda Virtual Batan</h1>
            <nav id="nav">
               <a href="index.html" onclick="seleccionar()">Inicio</a>
               <a href="Menu.html" onclick="seleccionar()">Menu</a>
               <a href="cargar-producto.php" onclick="seleccionar()">Subir</a>
               <a href="eliminar-producto.php" onclick="seleccionar()">Eliminar</a>
            </nav>
            <div id="icono-nav" class="nav-responsive" onclick="mostrarOcultarMenu()"> <i class="fa-solid fa-bars"></i> </div>
         </header>
         <section id="porfolio">
            <?php
               // Configuración de la base de datos
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
               
               // Consulta SQL para obtener todos los productos
               $sql = "SELECT * FROM productos";
               $result = $conn->query($sql);
               
               // Verificar si se encontraron resultados
               if ($result->num_rows > 0) {
                 // Estilos CSS                
                 
                 echo "<div class='product-container'>"; // Contenedor adicional
                 
                 while ($row = $result->fetch_assoc()) {
                   $imagen = $row['imagen'];
                   $nombre = $row['nombre'];
                   $detalles = $row['detalles'];
                   $precio = $row['precio'];
                 
                   // Formatear el precio con separador de miles y decimales
                   $precio_formateado = number_format($precio, 2, ".", ",");
                 
                   echo "<div class='product-card'>";
                   echo "  <div class='product-card-inner'>";
                   echo "    <div class='image-container' onclick='window.open(\"$imagen\",\"_self\");'>";
                   echo "      <img src='$imagen' alt='$nombre'>";
                   echo "    </div>";
                   echo "    <div>";
                   echo "      <h3>$nombre</h3>";
                   if (!empty($detalles)) {
                     echo "      <p>$detalles</p>";
                   }
                   echo "      <p class='price'>Precio: <span>₡$precio_formateado</span></p>"; // Agregamos el símbolo de la moneda colón (₡) antes del precio                   
                   echo "    </div>";
                   echo "  <button class='buy-button'>Comprar</button>"; // Botón "Comprar"
                   echo "  </div>";
                   echo "</div>";
                 }                 
                 echo "</div>"; // Cierre del contenedor adicional              
               } else {
                 echo "No se encontraron productos.";
               }
               
               // Cerrar la conexión
               $conn->close();
               ?>
         </section>
         <section id="contacto"></section>
      </div>
      <script>
         let menuVisible = false;
         //Función que oculta o muestra el menu
         function mostrarOcultarMenu(){
         if(menuVisible){
         document.getElementById("nav").classList ="";
         menuVisible = false;
         }else{
         document.getElementById("nav").classList ="responsive";
         menuVisible = true;
         }
         }
         function seleccionar(){
         //oculto el menu una vez que selecciono una opcion
         document.getElementById("nav").classList = "";
         menuVisible = false;
         }
      </script>
   </body>
</html>