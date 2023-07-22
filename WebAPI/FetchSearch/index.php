<?php

declare(strict_types=1);

require __DIR__ . "/../api/bootstrap.php";

header("Cache-Control: no-cache");

ini_set("display_errors", "On");



$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[3];

$plate = $parts[4] ?? null;
// $plate = $parts[5] ?? null;
 
// echo $resource, ", ", $so, ", ", $qty;
// exit;

if($resource != 'search') {
    http_response_code(404);
    exit;
}

$database = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

$user_gateway = new UserGateway($database);

$codec = new JWTCodec($_ENV["SECRET_KEY"]);

$auth = new Auth($user_gateway, $codec);

if(!$auth->authenticationAccessToken()) {
    exit;
}

$task_gateway = new FetchGateway($database);
$controller = new FetchController($task_gateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $plate);