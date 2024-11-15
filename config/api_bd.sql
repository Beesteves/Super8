CREATE DATABASE api_db;

USE api_db;

CREATE TABLE atleta(
    id INT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    vitoria INT,
    saldo_games INT
);

CREATE TABLE confronto(
    confronto_id INT AUTO_INCREMENT PRIMARY KEY,
    atleta1 INT,
    atleta2 INT,
    atleta3 INT,
    atleta4 INT,
    resultado1 INT,
    resultado2 INT
)