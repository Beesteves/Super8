<?php
require_once '../config/db.php';

class Atleta{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($id, $nome){
        $sql = "INSERT INTO atleta (id, nome, vitoria, saldo_games) VALUES (:id, :nome, 0, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        return $stmt->execute();
    }

    public function list(){
        $sql = "SELECT id, nome, vitoria, saldo_games FROM atleta";
        $stmt = $this->conn->prepare($sql);
        $stmt-> execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM atleta WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nome)
    {
        $sql = "UPDATE atleta SET nome = :nome WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM atleta WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteAll() {
        $sql = "DELETE FROM atleta";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
}