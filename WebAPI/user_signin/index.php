<?php
declare(strict_types=1);

require __DIR__ . "/bootstrap.php";

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[3];

$so = $parts[4] ?? null;
$id = $parts[5] ?? null;

if($resource != 'sign') {
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

if(!array_key_exists("username", $data) ||
    !array_key_exists("password", $data)) {

        http_response_code(400);
        echo json_encode(["message" => "Missing login credentials"]);
        exit;
    }

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$user_gateway = new UserGateway($database);

$user = $user_gateway->getByUsername($data["username"]);

if($user === false) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid Authentication."]);
    exit;
}

if(! password_verify($data["password"], $user["pw"])) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid Authentication.."]);
    exit;
}
$codec = new JWTCodec($_ENV["SECRET_KEY"]);

require __DIR__ . "/tokens.php";

$refresh_token_gateway = new RefreshTokenGateway($database, $_ENV["SECRET_KEY"]);

$refresh_token_gateway->create($refresh_token, $refresh_token_expiry);