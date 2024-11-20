<?php

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    header("HTTP/1.1 200 OK");
    header("Content-type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: GET, POTS, DELETE, PUT, OPTIONS");
    header("Access-Control-Allow-Headers: Content-type, Authorization");
    http_response_code(200);
    exit();
}
require_once '../config/db.php';
require_once '../controllers/Atleta.php';
require_once '../controllers/Confronto.php';
require_once '../Router.php';
require_once '../models/Atleta.php';
require_once '../models/Confronto.php';

header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$router = new Router();
$atletaController = new AtletaController($pdo);
$confrontoController = new ConfrontoController($pdo);

$router->add('GET', '/atleta', [$atletaController, 'list']);
$router->add('GET', '/atleta/{id}', [$atletaController, 'getById']);
$router->add('POST', '/atleta', [$atletaController, 'create']);
$router->add('DELETE', '/atleta/{id}', [$atletaController, 'delete']);
$router->add('DELETE', '/atleta/all', [$atletaController, 'deleteAll']);
$router->add('PUT', '/atleta/{id}', [$atletaController, 'update']);

$router->add('GET', '/confronto', [$confrontoController, 'list']);
$router->add('GET', '/confronto/{id}', [$confrontoController, 'getById']);
$router->add('GET', '/confronto/{id}/1', [$confrontoController, 'getNome1ById']);
$router->add('GET', '/confronto/{id}/2', [$confrontoController, 'getNome2ById']);
$router->add('GET', '/confronto/{id}/3', [$confrontoController, 'getNome3ById']);
$router->add('GET', '/confronto/{id}/4', [$confrontoController, 'getNome4ById']);
$router->add('POST', '/confronto', [$confrontoController, 'create']);
$router->add('DELETE', '/confronto/{id}', [$confrontoController, 'delete']);
$router->add('DELETE', '/confronto/all', [$confrontoController, 'deleteAll']);
$router->add('PUT', '/confronto/{id}', [$confrontoController, 'update']);
$router->add('PUT', '/confronto/{id}/saldos', [$confrontoController, 'atualizaSaldos']);


$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$requestedPath = str_replace('/public', '', $requestedPath);

echo "Caminho solicitado: " . $requestedPath;
$router->dispatch($requestedPath);