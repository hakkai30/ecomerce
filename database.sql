-- Creación de la base de datos (por si no existe)
CREATE DATABASE IF NOT EXISTS mydb;
USE mydb;

-- Creación de la tabla de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido VARCHAR(20) PRIMARY KEY,
    fecha DATE NOT NULL,
    cliente VARCHAR(100) NOT NULL,
    total DECIMAL(10,2) NOT NULL
);

-- Inserción de datos de prueba simulados
INSERT INTO pedidos (id_pedido, fecha, cliente, total) VALUES
('ORD-001', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'usuario1@email.com', 125.50),
('ORD-002', DATE_SUB(CURDATE(), INTERVAL 2 DAY), 'cliente2@email.com', 349.99),
('ORD-003', DATE_SUB(CURDATE(), INTERVAL 3 DAY), 'comprador3@email.com', 89.99),
('ORD-004', DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'fabio@email.com', 450.00),
('ORD-005', DATE_SUB(CURDATE(), INTERVAL 7 DAY), 'robin@email.com', 210.25);