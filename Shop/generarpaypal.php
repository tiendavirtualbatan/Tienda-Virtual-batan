<?php
ob_start(); // Iniciar el almacenamiento en búfer de salida
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta property="og:title" content="Ventas Celulares Baratos Batan, Siquirres">
<meta property="og:description" content="Desbloqueos, Ventas, Reparaciones, Computadoras, Celulares">
<meta property="og:image" content="img/log.png">
<meta property="og:url" content="https://tiendavirtualbatan.com/Shop/index.html">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="all.min.css">
  <link rel="stylesheet" href="generar_copia.css">
  <link rel="stylesheet" href="swap.css">
  <title>Tienda Virtual Batan</title>

  <!-- Agregar el script de PayPal -->
  <script src="https://www.paypal.com/sdk/js?client-id=Aci8OeCE39xD0lUF-0GQM1DgnKq0Lx59GW5s8G6VwpMINJdxh4VvTAaWzF5WR3h7VswalUe8cHr9TtoK"></script>
</head>
<body>
  <div class="container">
    <header>
      <h1 class="gradient-text">Tienda Virtual Batan</h1>
      <nav id="nav">
        <a href="/index.html" onclick="seleccionar()">Inicio</a>
        <a href="menu.html" onclick="seleccionar()">Menu</a>
        <a href="cargar-producto.php" onclick="seleccionar()">Subir</a>
        <a href="eliminar-producto.php" onclick="seleccionar()">Eliminar</a>
      </nav>
      <div id="icono-nav" class="nav-responsive" onclick="mostrarOcultarMenu()">
        <i class="fa-solid fa-bars"></i>
      </div>
    </header>
    <section id="porfolio">
      <div class="product-container">

        <?php
        // Función para convertir colones a dólares utilizando una API de conversión de moneda
        function convertirColonesADolares($cantidad) {
          $url = "https://api.exchangerate-api.com/v4/latest/USD";

          $response = file_get_contents($url);
          $data = json_decode($response);

          if ($data && isset($data->rates) && isset($data->rates->CRC)) {
            $tipoCambio = $data->rates->CRC;
            $cantidadEnDolares = $cantidad / $tipoCambio;
            return round($cantidadEnDolares, 2);
          }

          return $cantidad; // Si no se puede obtener el tipo de cambio, se devuelve la cantidad original en colones
        }

        // Conexión a la base de datos
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

        // Consultar los productos de la base de datos
        $sql = "SELECT * FROM productos";
        $resultado = $conn->query($sql);

        // Verificar si se encontraron productos
        if ($resultado->num_rows > 0) {
          $contador = 0; // Inicializar el contador
          // Recorrer los productos y generar las tarjetas
          while ($fila = $resultado->fetch_assoc()) {
            $imagen = htmlspecialchars($fila['imagen']);
            $nombre = htmlspecialchars($fila['nombre']);
            $detalles = htmlspecialchars($fila['detalles']);
            $precio = htmlspecialchars($fila['precio']);
            $precioEnDolares = convertirColonesADolares($precio);

            // Formatear el precio con separador de miles
            $precioFormateado = number_format($precio, 2, '.', ',');

            // Agregar el símbolo de la moneda al precio
            $moneda = '₡';

            // Agregar la tarjeta del producto al contenido HTML
            echo "
              <div class='product-card'>
                <div class='product-card-inner'>
                  <div class='image-container' onclick='window.open(\"$imagen\",\"_self\");'>
                    <img src='$imagen' alt='$nombre'>
                  </div>
                  <h3>$nombre</h3>
                  <p>$detalles</p>
                  <p class='price'>Precio: <span>$moneda $precioFormateado</span></p>
                  <form>
                    <input type='hidden' name='descripcion' value='$nombre'>
                    <input type='hidden' name='precio' value='$precio'>
                    <div id='paypal-button-container-$contador'></div>
                  </form>
                </div>
              </div>
            ";

            // Bloque de script de PayPal para el producto actual
            echo "
              <script>
                paypal.Buttons({
                  createOrder: function(data, actions) {
                    return actions.order.create({
                      purchase_units: [{
                        description: '$nombre',
                        amount: {
                          currency_code: 'USD',
                          value: '$precioEnDolares'
                        }
                      }]
                    });
                  },
                  onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                      alert('Pago realizado con éxito. ID de transacción: ' + details.id);
                    });
                  }
                }).render('#paypal-button-container-$contador');
              </script>
            ";

            $contador++; // Incrementar el contador
          }
        } else {
          echo "No se encontraron productos en la base de datos.";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>

      </div>
    </section>
    <section id="contacto"></section>
  </div>
  <script src="script.js"></script>

</body>
</html>

<?php
$contenidoHTML = ob_get_clean();

// Guardar el contenido HTML en el archivo index.html
file_put_contents('index.html', $contenidoHTML);

// Redirigir a la página index.html
header("Location: index.html");
exit();
?>
