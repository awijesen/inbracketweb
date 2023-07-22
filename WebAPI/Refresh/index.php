<?php

declare(strict_types=1);

require __DIR__ . "/bootstrap.php";

header("Cache-Control: no-cache");

ini_set("display_errors", "On");



$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[3];

$so = $parts[4] ?? null;
$id = $parts[5] ?? null;
 
// echo $resource, ", ", $id, ", ", $so;
// exit;

if($resource != 'token') {
    http_response_code(404);
    // header("{$_SERVER['SERVER_PROTOCOL']} 404 Not FOund!!");
    exit;
}
 
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    header("Allow: POST");
    exit;
}

$data = (array) json_decode(file_get_contents("php://input"), true);

if(!array_key_exists("token", $data)) {

        http_response_code(400);
        echo json_encode(["message" => "Missing token"]);
        exit;
    }

$codec = new JWTCodec($_ENV["SECRET_KEY"]);

try{
    $payload = $codec->decode($data["token"]);
} catch (Exception){

    http_response_code(400);
    echo json_encode(["message" => "Invalid token"]);
    exit;

}

$user_id = $payload["sub"];

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$refresh_token_gateway = new RefreshTokenGateway($database, $_ENV["SECRET_KEY"]);

$refresh_token = $refresh_token_gateway->getByToken($data["token"]);

if($refresh_token === false) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid token - nonsanitized"]);
    exit;
}

$user_gateway = new UserGateway($database);

$user = $user_gateway->getByID($user_id);

if($user === false){
    http_response_code(401);
    echo json_encode(["message" => "Invalid authentication"]);
    exit;
}

require __DIR__ . "/tokens.php";



$refresh_token_gateway->delete($data["token"]);

$refresh_token_gateway->create($refresh_token, $refresh_token_expiry);