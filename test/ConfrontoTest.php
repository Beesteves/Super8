<?php

namespace Tests\Confronto;

use PHPUnit\Framework\TestCase;
use ConfrontoController;
use App\Models\Confronto;

class ConfrontoControllerTest extends TestCase
{
    private $confrontoMock;
    private $controller;

    protected function setUp(): void
    {
        // Criar um mock do modelo Confronto
        $this->confrontoMock = $this->createMock(Confronto::class);

        // Injetar o mock no controlador
        $this->controller = new ConfrontoController($this->confrontoMock);
    }

    public function testListRetornaConfrontos()
    {
        // Simular o retorno do método list()
        $this->confrontoMock->method('list')->willReturn([
            ['id' => 1, 'atleta1' => 'João', 'atleta2' => 'Maria', 'resultado1' => 2, 'resultado2' => 3],
            ['id' => 2, 'atleta1' => 'Carlos', 'atleta2' => 'Ana', 'resultado1' => 1, 'resultado2' => 2]
        ]);

        // Capturar a saída
        ob_start();
        $this->controller->list();
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"id":1', $output);
        $this->assertStringContainsString('"atleta1":"João"', $output);
    }

    public function testCreateComDadosValidos()
    {
        // Simular a entrada de dados
        $inputData = json_encode([
            'id' => 1,
            'atleta1' => 'João',
            'atleta2' => 'Maria',
            'atleta3' => 'Carlos',
            'atleta4' => 'Ana',
            'resultado1' => 2,
            'resultado2' => 3
        ]);
        file_put_contents('php://input', $inputData);

        // Garantir que o método create será chamado
        $this->confrontoMock->expects($this->once())
                            ->method('create')
                            ->with(1, 'João', 'Maria', 'Carlos', 'Ana', 2, 3);

        // Capturar a saída
        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Confronto criado com sucesso."', $output);
    }

    public function testGetByIdConfrontoEncontrado()
    {
        // Simular o retorno do método getById
        $this->confrontoMock->method('getById')->with(1)->willReturn([
            'id' => 1,
            'atleta1' => 'João',
            'atleta2' => 'Maria',
            'resultado1' => 2,
            'resultado2' => 3
        ]);

        // Capturar a saída
        ob_start();
        $this->controller->getById(1);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"id":1', $output);
        $this->assertStringContainsString('"atleta1":"João"', $output);
    }

    public function testGetByIdConfrontoNaoEncontrado()
    {
        // Simular retorno nulo para um ID inexistente
        $this->confrontoMock->method('getById')->with(99)->willReturn(null);

        // Capturar a saída
        ob_start();
        $this->controller->getById(99);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Confronto não encontrado."', $output);
    }

    public function testUpdateComSucesso()
    {
        // Simular entrada de dados
        $inputData = json_encode(['resultado1' => 3, 'resultado2' => 4]);
        file_put_contents('php://input', $inputData);

        // Garantir que o método update será chamado
        $this->confrontoMock->method('update')->with(1, 3, 4)->willReturn(1);

        // Capturar a saída
        ob_start();
        $this->controller->update(1);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Resultado atualizado com sucesso."', $output);
    }

    public function testDeleteComSucesso()
    {
        // Garantir que o método delete será chamado
        $this->confrontoMock->method('delete')->with(1)->willReturn(1);

        // Capturar a saída
        ob_start();
        $this->controller->delete(1);
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Confronto deletado com sucesso."', $output);
    }

    public function testDeleteAll()
    {
        // Simular a deleção de todos os registros
        $this->confrontoMock->method('deleteAll')->willReturn(3);

        // Capturar a saída
        ob_start();
        $this->controller->deleteAll();
        $output = ob_get_clean();

        $this->assertJson($output);
        $this->assertStringContainsString('"Todos os confrontos foram deletados com sucesso."', $output);
    }
}
