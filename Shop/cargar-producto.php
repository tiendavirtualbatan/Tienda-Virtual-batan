<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="all.min.css">
      <link rel="stylesheet" href="cargar-producto.css">
      <link rel="stylesheet" href="swap.css">

      <title>Tienda Virtual Batan</title>
   </head>
   <body>
      <div class="container">
         <header>
            <h1 class="gradient-text">Tienda Virtual Batan</h1>
            <nav id="nav">
               <a href="ver-producto.php" onclick="seleccionar()">Inicio</a>
            </nav>
            <div id="icono-nav" class="nav-responsive" onclick="mostrarOcultarMenu()"> <i class="fa-solid fa-bars"></i> </div>
         </header>
         <section id="porfolio">
            <section>
            <section>
   <div class='product-container'>
      <form id="myForm" method="POST" enctype="multipart/form-data" action="guardar_producto.php">
         <label for="imagen">Archivo de imagen:</label>
         <input type="file" id="imagen" name="imagen" accept="image/*" required><br>
         <label for="nombre">Nombre:</label>
         <input type="text" id="nombre" name="nombre" required><br>
         <label for="detalles">Detalles:</label>
         <textarea id="detalles" name="detalles"></textarea><br>
         <label for="precio">Precio:</label>
         <input type="number" id="precio" name="precio" step="0.01" required><br>
         <input type="submit" value="Enviar">
         <input type="reset" value="Limpiar">
      </form>
   </div>
</section>
</section>
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