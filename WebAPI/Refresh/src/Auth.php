<?php

class Auth
{
    public function __construct(private UserGateway $user_gateway,
                                private JWTCodec $codec)
    {
    }
    public function authenticateAPIKey(): bool
    {
        if(empty($_SERVER["HTTP_X_API_KEY"])){
            http_response_code(400);
            echo json_encode(["message" => "Missing API Key"]);
            return false;   
        }
        
        $api_key = $_SERVER["HTTP_X_API_KEY"];

        if($this->user_gateway->getByAPIKey($api_key) === false)
            {
                http_response_code(401);
                echo json_encode(["message" => "Invalid API key"]);
                return false;
            }
        return true;
    }

    public function authenticationAccessToken(): bool
    {
        if(! preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete authorization header"]);
            return false;
        }

        try{
        $data = $this->codec->decode($matches[1]);
        }catch (InvalidSignatureException){
            http_response_code(401);
            echo json_encode(["message" => "Invalid Singnature"]); 
            return false;

        } catch(TokenExpiredException) {
            http_response_code(401);
            echo json_encode(["message" => "Token has expired"]);
            return false;
            
        } catch(Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }
       

        return true;
    }
}