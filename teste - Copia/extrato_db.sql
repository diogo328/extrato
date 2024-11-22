CREATE DATABASE extrato_db;

USE extrato_db;

CREATE TABLE extrato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    tipo ENUM('Entrada', 'Saída') NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);