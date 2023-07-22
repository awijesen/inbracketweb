<?php

class PASaveController
{
    public function __construct(private PASaveGateway $gateway) {

    }
    public function processRequest(string $method, ?string $plate) : void
    {
        if($plate !== null) {
            if($method == "GET") {
                http_response_code(404);
                echo json_encode(["message" => "Unspecified search parameters"]);
                
            } else 
            
            if($method == "POST") {
                
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if(!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $so = $this->gateway->create($data, $plate);

                $this->respondCreated($so);
                // $this->respondCreated('moon');

            }else{
                // $this->respondCreated($so);
                $this->repondMethodNotAllowed("DELETE");
                
            } 
          
                
        } else {
            // $task = $this->gateway->get($plate);
            // if($task === false) {
            //     $this->respondNotFound($plate);
            //     return;
            // }

            // if(count($task) <= 0) {
            //     $this->respondNotFound($plate);
            //     return;
            // }
             switch($method) {
                case "GET":
                    $this->repondMethodNotAllowed("GET, PATCH, DELETE");
                    break;
                case "PATCH":
                    $this->repondMethodNotAllowed("GET, PATCH, DELETE");
                    break;
                case "DELETE":
                    $this->repondMethodNotAllowed("GET, PATCH, DELETE");
                    break;
                default:
                    $this->repondMethodNotAllowed("GET, PATCH, DELETE");
            }
        }
    }

    private function respondUnprocessableEntity(array $errors): void
    {
        http_response_code(422);
        echo json_encode(["errors" => $errors]);
    }

    private function repondMethodNotAllowed(string $allowed_methods): void
    {
        http_response_code(405);
        header("Allow: $allowed_methods");
    }

    private function respondNotFound(string $so): void
        {
            http_response_code(404);
            echo json_encode(["message" => "Order with picker code $so not found"]);
        }

    private function respondCreated(): void
    {
        http_response_code(201);
        echo json_encode(["message"=>"Pick Saved!", "id" => '']);
    }

    // private function respondCreated(string $plate): void
    // {
    //     http_response_code(201);
    //     echo json_encode(["message"=>"Pick Saved!", "id" => $plate]);
    // }

    private function getValidationErrors(array $data): array
    {
        $errors = [];

        if(empty($data["PutawayTimeStamp"])) {
            $errors[] = "Putaway timestamp missing!";
        }

        if(empty($data["PutawayUser"])) {
            $errors[] = "Putaway user is required";
        }

        // if(empty($data["PutawayQuantity"])) {
        //     $errors[] = "Putaway quantity is required";
        // } else 
        
        if(filter_var($data["PutawayQuantity"], FILTER_VALIDATE_INT) === false) {
            $errors[] = "Putaway quantity invalid";
        }

        if(empty($data["PutawayStatus"])) {
            $errors[] = "Putaway status required";
        }

        if(empty($data["LastPutawayLocation"])) {
            $errors[] = "Last putaway location required";
        }

        // if(empty($data["LastPutawayQuantity"])) {
        //     $errors[] = "Last putaway quantity is required.";
        // } else 
        
        if(filter_var($data["LastPutawayQuantity"], FILTER_VALIDATE_INT) === false) {
            $errors[] = "Last putaway quantity required";
        }

        return $errors;
    }
}