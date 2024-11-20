<?php

namespace Tests\Atletas;

use PHPUnit\Framework\TestCase;
use controllers\AtletaController;
use models\Atleta;

class AtletaControllerTest extends TestCase
{
    private $atletaMock;
    private $controller;

    protected function setUp(): void
    {
        // Criar um mock do modelo Atleta
        $this->atletaMock = $this->createMock(Atleta::class);

        // Injetar o mock no controlador
        $this->controller = new AtletaController($this->atletaMock);
    }

    public function testListRetornaAtletas()
    {
        // Simular o retorno do modelo
        $this->atletaMock->method('list')->willReturn([
            ['id' => 1, 'nome' => 'João'],
            ['id' => 2, 'nome' => 'Maria']
        ]);

        // Capturar a saída do método
        ob_start();
        $this->controller->list();
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"id":1', $output);
        $this->assertStringContainsString('"nome":"João"', $output);
    }

    public function testCreateComDadosValidos()
    {
        // Simular a entrada do JSON
        $inputData = json_encode(['id' => 3, 'nome' => 'Ana']);
        file_put_contents('php://input', $inputData);

        // Garantir que o método create será chamado
        $this->atletaMock->expects($this->once())
                         ->method('create')
                         ->with(3, 'Ana');

        // Capturar a saída do método
        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Atleta inserido com sucesso."', $output);
    }

    public function testGetByIdAtletaEncontrado()
    {
        // Simular o retorno do método getById
        $this->atletaMock->method('getById')->with(1)->willReturn(['id' => 1, 'nome' => 'João']);

        // Capturar a saída do método
        ob_start();
        $this->controller->getById(1);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"id":1', $output);
        $this->assertStringContainsString('"nome":"João"', $output);
    }

    public function testGetByIdAtletaNaoEncontrado()
    {
        // Simular retorno vazio para um ID inexistente
        $this->atletaMock->method('getById')->with(99)->willReturn(null);

        // Capturar a saída do método
        ob_start();
        $this->controller->getById(99);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Atleta não encontrado."', $output);
    }

    public function testUpdateComSucesso()
    {
        // Simular a entrada do JSON
        $inputData = json_encode(['nome' => 'Carlos']);
        file_put_contents('php://input', $inputData);

        // Garantir que o método update será chamado e retornará sucesso
        $this->atletaMock->method('update')->with(1, 'Carlos')->willReturn(1);

        // Capturar a saída do método
        ob_start();
        $this->controller->update(1);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Atleta atualizado com sucesso."', $output);
    }

    public function testDeleteComSucesso()
    {
        // Garantir que o método delete será chamado e retornará sucesso
        $this->atletaMock->method('delete')->with(1)->willReturn(1);

        // Capturar a saída do método
        ob_start();
        $this->controller->delete(1);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Atleta deletado com sucesso."', $output);
    }

    public function testDeleteAll()
    {
        // Simular a deleção de todos os registros
        $this->atletaMock->method('deleteAll')->willReturn(5);

        // Capturar a saída do método
        ob_start();
        $this->controller->deleteAll();
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Todos os atletas foram deletados com sucesso."', $output);
    }
}
