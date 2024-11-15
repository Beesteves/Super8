<?php
require_once '../models/Confronto.php';

class ConfrontoController{
    private $confronto;

    public function __construct($db){
        $this->confronto = new Confronto($db);
    }

    public function list(){
        $confrontos = $this->confronto->list();
        echo json_encode($confrontos);
    }

    public function create()    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->atleta1) && isset($data->atleta2) && ($data->atleta3) && ($data->atleta4)) {
            try {
                $result = 0;
                $this->confronto->create($data->atleta1, $data->atleta2, $data->atleta3, $data->atleta4, $data->$result, $data->$result);

                http_response_code(201);
                echo json_encode(["message" => "Confronto criado com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar confronto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function getById($id)
    {
        if (isset($id)) {
            try {
                $confrontos = $this->confronto->getById($id);
                if ($confrontos) {
                    echo json_encode($confrontos);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Confronto não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar confronto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->resultado1) && isset($data->resultado2)) {
            try {
                $count = $this->confronto->update($id, $data->resultado1, $data->resultado2);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Resultado atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar resultado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar resultado."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id)) {
            try {
                $count = $this->confronto->delete($id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Confronto deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar confronto."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar confronto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}