<?php

class Confronto{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($id, $atleta1, $atleta2, $atleta3, $atleta4, $resultado1, $resultado2){
        $sql = "INSERT INTO confronto (id, atleta1, atleta2, atleta3, atleta4, resultado1, resultado2) VALUES (:id, :atleta1, :atleta2, :atleta3, :atleta4, :resultado1, :resultado2)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
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

    public function getNome1ById($id)
    {
        $sql = "SELECT a.nome FROM confronto c JOIN atleta a ON c.atleta1 = a.id WHERE c.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getNome2ById($id)
    {
        $sql = "SELECT a.nome FROM confronto c JOIN atleta a ON c.atleta2 = a.id WHERE c.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getNome3ById($id)
    {
        $sql = "SELECT a.nome FROM confronto c JOIN atleta a ON c.atleta3 = a.id WHERE c.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getNome4ById($id)
    {
        $sql = "SELECT a.nome FROM confronto c JOIN atleta a ON c.atleta4 = a.id WHERE c.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function update($id, $resultado1, $resultado2)
    {
        $sql = "UPDATE confronto SET resultado1 = :resultado1, resultado2 = :resultado2 WHERE id = :id";
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

    public function deleteAll() {
        $sql = "DELETE FROM confronto";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }

    public function atualizaSaldos($id, $vitorias1, $vitorias2, $games1, $games2){

        try {
            $sql1 = "
                UPDATE atleta 
                SET vitoria = vitoria + :vitorias1, saldo_games = saldo_games + :games1 
                WHERE id = (SELECT atleta1 FROM confronto WHERE id = :id);
            ";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->bindParam(':vitorias1', $vitorias1, PDO::PARAM_INT);
            $stmt1->bindParam(':games1', $games1, PDO::PARAM_INT);
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt1->execute();
    
            $sql2 = "
                UPDATE atleta 
                SET vitoria = vitoria + :vitorias1, saldo_games = saldo_games + :games1 
                WHERE id = (SELECT atleta2 FROM confronto WHERE id = :id);
            ";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(':vitorias1', $vitorias1, PDO::PARAM_INT);
            $stmt2->bindParam(':games1', $games1, PDO::PARAM_INT);
            $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt2->execute();
    
            $sql3 = "
                UPDATE atleta 
                SET vitoria = vitoria + :vitorias2, saldo_games = saldo_games + :games2 
                WHERE id = (SELECT atleta3 FROM confronto WHERE id = :id);
            ";
            $stmt3 = $this->conn->prepare($sql3);
            $stmt3->bindParam(':vitorias2', $vitorias2, PDO::PARAM_INT);
            $stmt3->bindParam(':games2', $games2, PDO::PARAM_INT);
            $stmt3->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt3->execute();
    
            $sql4 = "
                UPDATE atleta 
                SET vitoria = vitoria + :vitorias2, saldo_games = saldo_games + :games2 
                WHERE id = (SELECT atleta4 FROM confronto WHERE id = :id);
            ";
            $stmt4 = $this->conn->prepare($sql4);
            $stmt4->bindParam(':vitorias2', $vitorias2, PDO::PARAM_INT);
            $stmt4->bindParam(':games2', $games2, PDO::PARAM_INT);
            $stmt4->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt4->execute();
    
            return $stmt1->rowCount() + $stmt2->rowCount() + $stmt3->rowCount() + $stmt4->rowCount();
    
        } catch (PDOException $e) {
            error_log("Erro na execução da query: " . $e->getMessage());
            return 0;
        }
    }
}