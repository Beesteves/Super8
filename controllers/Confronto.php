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
        if (isset ($data->id) && isset($data->atleta1) && isset($data->atleta2) && isset($data->atleta3) && isset($data->atleta4) && isset($data->resultado1) && isset($data->resultado2)) {
            try {
                $this->confronto->create($data->id, $data->atleta1, $data->atleta2, $data->atleta3, $data->atleta4, $data->resultado1, $data->resultado2);

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

    public function getNome1ById($id)
    {
        if (isset($id)) {
            try {
                $nome = $this->confronto->getNome1ById($id);
                if ($nome) {
                    echo json_encode(["nome" => $nome]);
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

    public function getNome2ById($id)
    {
        if (isset($id)) {
            try {
                $nome = $this->confronto->getNome2ById($id);
                if ($nome) {
                    echo json_encode(["nome" => $nome]);
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

    public function getNome3ById($id)
    {
        if (isset($id)) {
            try {
                $nome = $this->confronto->getNome3ById($id);
                if ($nome) {
                    echo json_encode(["nome" => $nome]);
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

    public function getNome4ById($id)
    {
        if (isset($id)) {
            try {
                $nome = $this->confronto->getNome4ById($id);
                if ($nome) {
                    echo json_encode(["nome" => $nome]);
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

    public function deleteAll()
    {
        try {
            $count = $this->confronto->deleteAll();

            if ($count > 0) {
                http_response_code(200);
                echo json_encode(["message" => "Todos os confrontos foram deletados com sucesso."]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Nenhum confronto encontrado para deletar."]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao deletar confrontos."]);
        }
    }

    public function atualizaSaldos($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->vitoria1) && isset($data->vitoria2) && isset($data->saldo_games1) && isset($data->saldo_games2)) {
            try {                
                $count = $this->confronto->atualizaSaldos($id, $data->vitoria1, $data->vitoria2, $data->saldo_games1, $data->saldo_games2);
                var_dump($data);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Saldo atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar saldo."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Nao consegui atualizar saldo."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}