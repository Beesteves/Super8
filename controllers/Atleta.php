<?php
require_once '../models/Atleta.php';

class AtletaController{
    private $atleta;

    public function __construct($db){
        $this->atleta = new Atleta($db);
    }

    public function list(){
        $atletas = $this->atleta->list();
        echo json_encode($atletas);
    }

    public function create()    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && isset($data['nome'])) {
            try {
                $this->atleta->create($data['id'], $data['nome']);

                http_response_code(201);
                echo json_encode(["message" => "Atleta inserido com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao inserir atleta."]);
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
                $atletas = $this->atleta->getById($id);
                if ($atletas) {
                    echo json_encode($atletas);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Atleta não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar atleta."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->nome)) {
            try {
                $count = $this->atleta->update($id, $data->nome);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Atleta atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar atleta."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar atleta."]);
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
                $count = $this->atleta->delete($id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Atleta deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar atleta."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar atleta."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function deleteAll()
    {
        try {
            $count = $this->atleta->deleteAll();

            if ($count > 0) {
                http_response_code(200);
                echo json_encode(["message" => "Todos os atletas foram deletados com sucesso."]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Nenhum atleta encontrado para deletar."]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao deletar atletas."]);
        }
    }
}