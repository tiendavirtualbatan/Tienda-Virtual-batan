CREATE TABLE IF NOT EXISTS productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  imagen VARCHAR(255) NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  precio VARCHAR(50) NOT NULL,
  cantidad INT NOT NULL,
  envio VARCHAR(100) NOT NULL,
  categoria VARCHAR(100),
  telefono VARCHAR(20),
  cedula VARCHAR(15),
  tienda VARCHAR(100)
);