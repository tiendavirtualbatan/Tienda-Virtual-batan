-- Crear la tabla de categorías
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

-- Crear la tabla de contactos
CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT,
    img VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    numeros VARCHAR(255) NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

