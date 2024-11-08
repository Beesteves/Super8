<?php
require_once '../config/db.php';
require_once '../controllers/Atleta.php';


header("Content-type: ap[lication/json; charset=UTF-8");

$router = new Router();
$controller = new AtletaController($pdo);

$router->add('GET', '/atleta', [$controller, 'list']);
$router->add('GET', '/atleta/{id}', [$controller, 'getById']);
$router->add('POST', '/atleta', [$controller, 'create']);
$router->add('DELETE', '/atleta/{id}', [$controller, 'delete']);
$router->add('PUT', '/atleta/{id}', [$controller, 'update']);

$router->add('GET', '/confronto', [$controller, 'list']);
$router->add('GET', '/confronto/{id}', [$controller, 'getById']);
$router->add('POST', '/confronto', [$controller, 'create']);
$router->add('DELETE', '/confronto/{id}', [$controller, 'delete']);
$router->add('PUT', '/confronto/{id}', [$controller, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathItems = explode("/", $requestedPath);
$requestedPath = "/" . $pathItems[3] . ($pathItems[4] ? "/" . $pathItems[4] : "");

$router->dispatch($requestedPath);
