<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "guardar-contactos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen
    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if ($check === false) {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Verificar el tamaño del archivo
    if ($_FILES["img"]["size"] > 20000000) { // Cambiar el valor a 20,000,000 para un límite de 20 MB
        echo "Lo siento, el archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Si $uploadOk es igual a 0, significa que hubo un error
    if ($uploadOk == 0) {
        echo "Lo siento, el archivo no fue subido.";
    } else {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
            echo "El archivo " . basename($_FILES["img"]["name"]) . " ha sido subido.";

            // Obtener los valores del formulario
            $categoria_id = $_POST["categoria"];
            $nombre = $_POST["nombre"];
            $numeros = $_POST["numeros"];
            $imagen_nombre = basename($_FILES["img"]["name"]);

            // Si la categoría seleccionada es -1, significa que se debe agregar una nueva categoría
            if ($categoria_id == -1) {
                $nueva_categoria = $_POST["nueva_categoria"];
    
                // Insertar la nueva categoría en la tabla "categorias"
                $insert_categoria_sql = "INSERT INTO categorias (nombre) VALUES ('$nueva_categoria')";
    
                if ($conn->query($insert_categoria_sql) === TRUE) {
                    // Obtener el ID de la nueva categoría insertada
                    $categoria_id = $conn->insert_id;
                } else {
                    echo "Error al agregar nueva categoría: " . $conn->error;
                    $conn->close();
                    exit(); // Detener el script
                }
            }

            // Realizar operaciones para almacenar los datos en la base de datos
            $sql = "INSERT INTO contactos (categoria_id, img, nombre, numeros) VALUES ('$categoria_id', '$imagen_nombre', '$nombre', '$numeros')";

            if ($conn->query($sql) === TRUE) {
                echo "Datos guardados en la base de datos.";
            } else {
                echo "Error al guardar los datos en la base de datos: " . $conn->error;
            }

        } else {
            echo "Lo siento, hubo un error al subir el archivo.";
        }
    }

    // Cerrar la conexión
    $conn->close();
    // Redirigir a index.html
    header("Location: generar-html-contactos.php");
    exit(); // Asegura que el script se detenga después de la redirección
}
?>
