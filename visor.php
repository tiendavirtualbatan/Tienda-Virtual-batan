<!DOCTYPE html>
<html lang="es-es">

<head>
    <meta property="og:title" content="Ventas Celulares Baratos Batan, Siquirres">
    <meta property="og:description" content="Desbloqueos, Ventas, Reparaciones, Computadoras, Celulares">
    <meta property="og:image" content="sistema/a.png">
    <meta property="og:url" content="https://tiendavirtualbatan.com">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="sistema/css/index.css" />
    <style>
        /* Estilos para los botones de navegación */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f2f2f2;
            padding: 10px;
        }

        .pagination a {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            /* Hace que los botones sean circulares */
            text-align: center;
            line-height: 30px;
            text-decoration: none;
            border: 1px solid #ccc;
            margin-right: 5px;
            font-weight: bold;
            /* Hace que los números sean más gruesos */
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
        }

        /* Agrega colores adicionales para los botones */
        .pagination a:nth-child(2n) {
            background-color: #f39c12;
            color: #fff;
            border: 1px solid #f39c12;
        }

        .pagination a:nth-child(2n+1) {
            background-color: #e74c3c;
            color: #fff;
            border: 1px solid #e74c3c;
        }
    </style>
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
                <a href="visor.php" onclick="seleccionar()">Inicio</a>
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

        <!-- Agrega un div para mostrar los resultados de la búsqueda -->
        <div class="product-container">
            <!-- Aquí se mostrarán los resultados de la búsqueda -->
        </div>
    </div>
    <!-- Archivo JavaScript para manipulación de la página -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var searchTerm = ""; // Variable para almacenar el término de búsqueda
        var paginaActual = obtenerParametroUrl('pagina') || 1; // Obtener el número de página de la URL

        function cargarProductos() {
            // Envía la búsqueda al servidor mediante AJAX
            $.ajax({
                url: 'buscar_productos.php?pagina=' + paginaActual,
                type: 'POST',
                data: {
                    search: searchTerm
                },
                dataType: 'html',
                success: function (response) {
                    $('.product-container').html(response);
                }
            });
        }

        // Función para obtener el valor de un parámetro en la URL
        function obtenerParametroUrl(parametro) {
            var url = new URL(window.location.href);
            return url.searchParams.get(parametro);
        }

        // Función para actualizar la paginación y los productos al cargar la página
        function actualizarPaginacionYProductos() {
            cargarProductos();
        }

        // Agrega el evento input para escuchar los cambios en el cuadro de búsqueda
        $('#buscador').on('input', function () {
            searchTerm = $(this).val();
            paginaActual = 1; // Restablece la página a 1 cuando se modifica el término de búsqueda
            actualizarPaginacionYProductos();
        });

        // Utiliza delegación de eventos para el botón "Más detalles"
        $('.product-container').on('click', '.show-details', function (event) {
            event.preventDefault(); // Evita la acción predeterminada del enlace
            var productDetails = $(this).next('.product-details');

            // Encuentra todos los detalles del producto, excepto el que se está abriendo
            var otherDetails = $('.product-details').not(productDetails);

            // Cierra los detalles de los productos que estaban abiertos
            otherDetails.hide();

            // Muestra el detalle del producto actual
            productDetails.toggle();
        });

        // Utiliza delegación de eventos para los enlaces de paginación
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            paginaActual = $(this).text();
            actualizarPaginacionYProductos();
        });

        // Carga los productos al cargar la página
        actualizarPaginacionYProductos();
    });

    // Funcionalidad del menú responsive
let menuVisible = false;

function mostrarOcultarMenu() {
    // Verificar si el menú ya está visible o no
    if (menuVisible) {
        document.getElementById("nav").classList = "";
        menuVisible = false; // Ocultar el menú
    } else {
        document.getElementById("nav").classList = "responsive";
        menuVisible = true; // Mostrar el menú
    }
}

// Función para ocultar el menú después de hacer clic en un enlace de navegación en modo responsive
function seleccionar() {
    document.getElementById("nav").classList = "";
    menuVisible = false;
}
</script>


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
</body>

</html>
