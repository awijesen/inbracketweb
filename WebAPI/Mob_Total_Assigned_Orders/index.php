<?php

declare(strict_types=1);

require __DIR__ . "/bootstrap.php";

header("Cache-Control: no-cache");

ini_set("display_errors", "On");



$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[3];

$id = $parts[4] ?? null;
 
// echo $resource, ", ", $id, ", ", $ord;
// exit;

if($resource != 'Orders') {
    http_response_code(404);
    // header("{$_SERVER['SERVER_PROTOCOL']} 404 Not FOund!!");
    exit;
}

$database = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

$user_gateway = new UserGateway($database);

$auth = new Auth($user_gateway);

if(!$auth->authenticateAPIKey()) {
    exit;
}

$task_gateway = new TaskGateway($database);
$controller = new TaskController($task_gateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);