<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Contacto</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000000;
        }

        .block {
            position: relative;
            margin: 50px auto 20px;
            width: 900px;
            height: auto;
            background: linear-gradient(0deg, #75747462, #a6a5a537);
        }

        .block:before,
        .block:after {
            content: '';
            position: absolute;
            left: -2px;
            top: -2px;
            background: linear-gradient(45deg, #fb0094, #0000ff, #00ff00, #ffff00, #ff0000, #fb0094,
                    #0000ff, #00ff00, #ffff00, #ff0000);
            background-size: 400%;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            z-index: -1;
            animation: steam 20s linear infinite;
        }

        @keyframes steam {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 400% 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        .block:after {
            filter: blur(50px);
        }
        @media (max-width: 960px) {
            .block {
                width: 90%;
                margin: 30px auto;
            }
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 5px;
            padding: 10px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .product-container img {
            max-width: 90%;
            height: auto;
        }

        .contenedor {
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input,
        button {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 2;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Efecto 3D en la tarjeta */
        .contenedor {
            transform: translateZ(50px);
            transition: transform 0.5s;
        }

        .contenedor:hover {
            transform: translateZ(70px);
        }

        /* Estilo adicional para el botón */
        button {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(0);
            transition: transform 0.3s;
        }

        .contenedor:hover button {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
<div class="block">
        <div class="product-container">
            <div class="contenedor">
                <h1>Agregar Nuevo Contacto</h1>
                <form action="procesar_formulario.php" method="post" enctype="multipart/form-data">
                    <label for="categoria">Categoría:</label>
                    <select name="categoria">
                        <?php
                        // Conexión a la base de datos
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "guardar-contactos";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Error de conexión: " . $conn->connect_error);
                        }

                        // Obtener categorías existentes
                        $query = "SELECT id, nombre FROM categorias";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["nombre"] . '</option>';
                        }

                        // Agregar opción para agregar nueva categoría
                        echo '<option value="-1">Agregar Nueva Categoría</option>';

                        // Cerrar la conexión
                        $conn->close();
                        ?>
                    </select>
                    <br>
                    <!-- Campo para ingresar nueva categoría -->
                    <input type="text" name="nueva_categoria" placeholder="Nueva Categoría">
                    <br>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required>
                    <br>
                    <label for="numeros">Números:</label>
                    <input type="text" name="numeros" required>
                    <br>
                    <label for="img">Imagen:</label>
                    <input type="file" name="img" accept="image/*" required>
                    <br>
                    <!-- Resto del formulario -->
                    <button type="submit">Agregar Contacto</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
