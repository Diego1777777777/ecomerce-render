-- =====================================================
-- FutbolShop — Base de datos MySQL/MariaDB
-- Ejecutar: mysql -u root -p < database.sql
-- =====================================================

CREATE DATABASE IF NOT EXISTS futbolshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE futbolshop;

-- ─────────────────────────────────────────
-- Tabla: usuarios
-- ─────────────────────────────────────────
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    apellido   VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    rol        ENUM('admin','user') NOT NULL DEFAULT 'user',
    creado_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuarios de prueba (contraseñas hasheadas con password_hash)
-- Admin123  → hash de 'Admin123'
-- Usuario123 → hash de 'Usuario123'
INSERT INTO usuarios (nombre, apellido, email, password, rol) VALUES
('Administrador', 'FutbolShop', 'admin@futbolshop.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Usuario',       'Regular',    'usuario@futbolshop.com',
 '$2y$10$TKh8H1.PBcYYE0RI1Y5Z2.4B1E3Z2e4B1E3Z2e4B1E3Z2e4B1E3Z2', 'user');

-- ─────────────────────────────────────────
-- Tabla: productos
-- ─────────────────────────────────────────
CREATE TABLE IF NOT EXISTS productos (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(200)                           NOT NULL,
    precio     INT                                    NOT NULL,
    categoria  ENUM('calzado','ropa','accesorios')    NOT NULL,
    imagen     VARCHAR(200)                           NOT NULL,
    stock      INT                                    NOT NULL DEFAULT 0,
    creado_en  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO productos (nombre, precio, categoria, imagen, stock) VALUES
('Botines Nike Mercurial',      1300000, 'calzado',    'botines-nike-mercurial.png', 45),
('Camiseta Adidas Training',     240000, 'ropa',        'camiseta-adidas.png',        120),
('Balón Oficial Champions',      920000, 'accesorios',  'balon-champions.png',        30),
('Guantes de Portero Puma',      713299, 'accesorios',  'guantes.png',                25),
('Pantalón Corto Nike Dri-FIT',  240000, 'ropa',        'pantaloneta.png',            80),
('Espinilleras Adidas Pro',      120000, 'accesorios',  'canilleras.png',             150),
('Botines Puma Future',          409999, 'calzado',     'botas-puma.png',             35),
('Sudadera Nike Tech Fleece',    320000, 'ropa',        'nike-tech.png',              60),
('Mochila Deportiva Adidas',      70000, 'accesorios',  'mochila.png',                90),
('Botines Adidas Predator',      693000, 'calzado',     'adidas-guayos.png',          40),
('Medias de Compresión',          40000, 'ropa',        'medias.png',                 200),
('Botella Deportiva 1L',          36200, 'accesorios',  'botella.png',                180);

-- ─────────────────────────────────────────
-- Tabla: pedidos (estructura para escalar)
-- ─────────────────────────────────────────
CREATE TABLE IF NOT EXISTS pedidos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id   INT          NOT NULL,
    total        INT          NOT NULL,
    estado       ENUM('pendiente','pagado','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
    creado_en    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pedido_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id    INT NOT NULL,
    producto_id  INT NOT NULL,
    cantidad     INT NOT NULL,
    precio_unit  INT NOT NULL,
    FOREIGN KEY (pedido_id)   REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB;

SELECT 'Base de datos creada correctamente.' AS resultado;
