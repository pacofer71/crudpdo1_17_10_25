CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    admin ENUM('SI', 'NO') NOT NULL DEFAULT 'NO'
);