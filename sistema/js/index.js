// Búsqueda de productos
document.getElementById('buscador').addEventListener('keyup', function () {
    // Obtener el término de búsqueda y convertirlo a minúsculas para hacer la comparación
    var searchTerm = this.value.toLowerCase();
    // Obtener todos los elementos con clase "product"
    var products = document.getElementsByClassName('product');

    // Recorrer todos los productos y mostrar u ocultar según coincida con el término de búsqueda
    for (var i = 0; i < products.length; i++) {
        var productName = products[i].getElementsByClassName('product-details')[0]
            .getElementsByTagName('h3')[0].innerText.toLowerCase();

        if (productName.includes(searchTerm)) {
            products[i].style.display = 'block'; // Mostrar el producto
        } else {
            products[i].style.display = 'none'; // Ocultar el producto
        }
    }
});

// Enlaces de WhatsApp
var phoneLinks = document.querySelectorAll('.product-details a');

phoneLinks.forEach(function (link) {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        // Obtener el número de teléfono del enlace
        var phoneNumber = link.textContent;
        // Obtener el nombre y precio del producto asociado al enlace
        var productName = link.closest('.product').querySelector('h3').textContent;
        var productPrice = link.closest('.product').querySelector('p').textContent;
        // Crear un mensaje de WhatsApp con la información del producto
        var productInfo = 'Hola... Estoy interesado/a en el producto "' + productName +
            '" con precio de ' + productPrice + '.';
        // Construir la URL del enlace de WhatsApp con el mensaje
        var whatsappLink = 'https://wa.me/506' + phoneNumber + '?text=' + encodeURIComponent(
            productInfo);
        // Abrir una nueva ventana del navegador con el enlace de WhatsApp
        window.open(whatsappLink);
    });
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