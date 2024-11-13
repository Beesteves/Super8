<?php
require_once '../config/db.php';
require_once '../controllers/Atleta.php';
require_once '../controllers/Confronto.php';
require_once '../Router.php';


header("Content-type: application/json; charset=UTF-8");

$router = new Router();
$atletaController = new AtletaController($pdo);
$confrontoController = new ConfrontoController($pdo);

$router->add('GET', '/atleta', [$atletaController, 'list']);
$router->add('GET', '/atleta/{id}', [$atletaController, 'getById']);
$router->add('POST', '/atleta', [$atletaController, 'create']);
$router->add('DELETE', '/atleta/{id}', [$atletaController, 'delete']);
$router->add('PUT', '/atleta/{id}', [$atletaController, 'update']);

$router->add('GET', '/confronto', [$confrontoController, 'list']);
$router->add('GET', '/confronto/{id}', [$confrontoController, 'getById']);
$router->add('POST', '/confronto', [$confrontoController, 'create']);
$router->add('DELETE', '/confronto/{id}', [$confrontoController, 'delete']);
$router->add('PUT', '/confronto/{id}', [$confrontoController, 'update']);


$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathItems = explode("/", $requestedPath);
$requestedPath = "/" . $pathItems[count($pathItems) - 2] . 
    (isset($pathItems[count($pathItems) - 1]) ? "/" . $pathItems[count($pathItems) - 1] : "");

$router->dispatch($requestedPath);
