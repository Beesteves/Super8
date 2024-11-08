CREATE DATABASE api_db;

USE api_db;

CREATE TABLE atleta(
    atleta_id INT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    vitoria INT,
    saldo_games INT
);

CREATE TABLE confronto(
    confronto_id INT AUTO_INCREMENT PRIMARY KEY,
    atleta1 VARCHAR(50),
    atleta2 VARCHAR(50),
    atleta3 VARCHAR(50),
    atleta4 VARCHAR(50),
    resultado1 INT,
    resultado2 INT
)