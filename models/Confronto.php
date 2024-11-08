<?php

class Confronto{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($atleta1, $atleta2, $atleta3, $atleta4, $resultado1, $resultado2){
        $sql = "INSERT INTO confronto (atleta1, atleta2, atleta3, atleta4, resultado1, resultado2) VALUES (:atleta1, :atleta2, :atleta3, :atleta4, :resultado1, :resultado2)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':atleta1', $atleta1);
        $stmt->bindParam(':atleta2', $atleta2);
        $stmt->bindParam(':atleta3', $atleta3);
        $stmt->bindParam(':atleta4', $atleta4);
        $stmt->bindParam(':resultado1', $resultado1);
        $stmt->bindParam(':resultado2', $resultado2);
        return $stmt->execute();
    }

    public function list(){
        $sql = "SELECT atleta1, atleta2, atleta3, atleta4, resultado1, resultado2 FROM confronto";
        $stmt = $this->conn->prepare($sql);
        $stmt-> execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM confronto WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $resultado1, $resultado2)
    {
        $sql = "UPDATE confronto SET resultado1 = :resultado1 AND resultado2 = :resultado2 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':resultado1', $resultado1);
        $stmt->bindParam(':resultado2', $resultado2);
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
}