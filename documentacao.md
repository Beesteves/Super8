
# Super8 - Beach Tennis 🎾

Super8 - Beach Tennis é um sistema para organizar torneios de Beach Tennis no formato "Super 8". Através de uma interface simples, os usuários podem cadastrar atletas, realizar sorteios automáticos de confrontos, registrar resultados em tempo real e visualizar o vencedor do torneio ao final.


## 🚀 Funcionalidades

- Cadastro de Atletas: Insira os atletas que irão competir no torneio.
- Criação Automática de Confrontos: O sistema organiza automaticamente os confrontos entre os atletas.
- Registro de Resultados: Insira os resultados dos jogos conforme eles acontecem.
- Acompanhamento em Tempo Real: Visualize o progresso do torneio com os placares e o vencedor.
- Determinação do Vencedor: O sistema calcula automaticamente o vencedor após todos os confrontos serem finalizados.

## 🎯 Público Alvo

O Super8 - Beach Tennis é destinado a jogadores de Beach Tennis que buscam uma maneira prática e organizada de estruturar torneios no formato "Super 8". Ele simplifica o processo de criação, atualização e visualização dos confrontos, permitindo que os organizadores e participantes foquem no que realmente importa: a diversão e a competição.

## 🛠 Tecnologias Utilizadas

- Front-end: Desenvolvido com JavaScript para fornecer uma interface interativa e responsiva para os usuários.
- Back-end: Implementado com PHP, utilizando um sistema baseado em rotas RESTful para criar, listar, atualizar e deletar confrontos e e atletas.
- Banco de Dados: Utiliza Postgres para armazenar dados de atletas, confrontos e resultados dos jogos.
## 🎮 Como Usar

1. Configuração Inicial
*Clone o repositório para o seu ambiente local:*

    git clone https://github.com/Beesteves/Super8.git
    cd Super8

2. Rodando o Servidor PHP
*Para iniciar o servidor PHP embutido, execute o comando abaixo no diretório do projeto:*

    php -S localhost:8000 -t public
*O sistema estará disponível em http://localhost:8000.*

3. Testando a API e Funções

*Cadastro de Atletas* 

Para cadastrar um atleta, envie uma requisição POST para o endpoint /atleta com o nome do atleta:

    POST http://localhost:8000/atleta
    {
        "id": 1,
        "nome": "Atleta"
    }

*Gerar Confrontos*

Para gerar os confrontos, use o endpoint POST /confronto com os IDs dos atletas:

    POST http://localhost:8000/public/confronto
    { 
        id:1,
        atleta1: 1,
        atleta2: 2, 
        atleta3: 3, 
        atleta4: 4, 
        resultado1: 0, 
        resultado2: 0 
    }

*Registrar Resultado de Confrontos*

Para registrar o placar de um confronto, envie uma requisição PUT para o endpoint /confronto/{id} com o placar dos atletas:

    PUT http://localhost:8000/public/confronto/1
    {
        "id": 1
        "resultado1": 6,
        "resultado2": 4
    }

*Consultar Confrontos e Resultados*

Para visualizar como esta a classificaçao dos atletas, faça uma requisição GET:

    GET http://localhost:8000/atleta

4. Frontend - Interface de Usuário
*A interface de usuário foi projetada em HTML, CSS e JavaScript. Ao rodar o servidor, acesse http://localhost:8000 para interagir com a aplicação, cadastrar atletas, gerar confrontos, registrar resultados e visualizar o andamento do torneio.*

## 🔧 Exemplo de Interação com a API

Para facilitar a interação com a API, o sistema front-end realiza requisições usando JavaScript. Aqui está um exemplo de como você pode interagir com a API para criar um confronto e registrar resultados:

* Inserir um Atleta:
```
    fetch("http://localhost:8000/public/atleta", {
        method: "POST",
        headers: { "Content-Type": "application/json"},
        body: JSON.stringify({ id: i, nome: nome})
    });
```
* Criar um Confronto:
```
    fetch("http://localhost:8000/public/confronto", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id:1, atleta1: 1,
        atleta2: 2, atleta3: 3, atleta4: 4, 
        resultado1: 0, resultado2: 0 
    });
```
* Atualizar o Resultado de um Confronto:
```
    fetch(`http://localhost:8000/public/confronto/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({id: id, resultado1: resultado1, resultado2: resultado2 })
    });
```
## Documentação da API

#### API do Atleta


| Metodo   | Endpoint       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `GET` | `/atleta` | Lista os atletas em ordem decrecente da sua prontuação |
| `GET` | `/atleta/{id}` | Busca pelo ID |
| `POST` | `/atleta` | Cria o atleta |
| `DELETE` | `/atleta/{id}` | Exclui o atleta |
| `DELETE` | `/atleta/all` | Exclui todos os atletas ja inseridos, limpando o banco |
| `PUT` | `/atleta/{id}` | Atualiza o nome do atleta|

#### API dos Confrontos

| Metodo   | Endpoint       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `GET` | `/confronto` | Lista todos os confrontos|
| `GET` | `/confronto/{id}` | Busca pelo ID |
| `GET` | `/confronto/{id}/1` | Busca o nome do atleta1 no confronto |
| `GET` | `/confronto/{id}/2` | Busca o nome do atleta2 no confronto |
| `GET` | `/confronto/{id}/3` | Busca o nome do atleta3 no confronto |
| `GET` | `/confronto/{id}/4` | Busca o nome do atleta4 no confronto|
| `POST` | `/confronto` | Cria o confronto |
| `DELETE` | `/confronto/{id}` | Exclui o confronto |
| `DELETE` | `/confronto/all` | Exclui todos os confrontos ja inseridos, limpando o banco |
| `PUT` | `/confronto/{id}` | Atualiza o resultado dos confrontos|
| `PUT` | `/confronto/{id}/saldos` | Atualiza o numero de vitorias e games do atletas de acordo com cada confronto|

## Contato

Para mais informações ou ajuda, entre em contato:

Email: bestevesgoncalves@gmail.com

GitHub: github.com/Beesteves
