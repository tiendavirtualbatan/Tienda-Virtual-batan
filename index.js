// Código JavaScript para filtrar productos por nombre en tiempo real
document.getElementById('buscador').addEventListener('keyup', function() {
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

phoneLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        var phoneNumber = link.textContent;
        var productName = link.closest('.product').querySelector('h3').textContent;
        var productPrice = link.closest('.product').querySelector('p').textContent;
        var productInfo = 'Hola... Estoy interesado/a en el producto "' + productName +
            '" con precio de ' + productPrice + '.';
        var whatsappLink = 'https://wa.me/506' + phoneNumber + '?text=' + encodeURIComponent(
            productInfo);
        window.open(whatsappLink);
    });
});

// Código menu nav responsive


let menuVisible = false;
//Función que oculta o muestra el menu
function mostrarOcultarMenu() {
    if (menuVisible) {
        document.getElementById("nav").classList = "";
        menuVisible = false;
    } else {
        document.getElementById("nav").classList = "responsive";
        menuVisible = true;
    }
}

function seleccionar() {
    //oculto el menu una vez que selecciono una opcion
    document.getElementById("nav").classList = "";
    menuVisible = false;
}
