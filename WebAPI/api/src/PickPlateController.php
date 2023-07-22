<?php

class PickPlateController
{
    public function __construct(private PickPlateGateway $gateway) {

    }
    public function processRequest(string $method, ?string $plate) : void
    {
        if($plate === '') {
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

                $so = $this->gateway->create($data);

                $this->respondCreated($so);
                // $this->respondCreated('moon');

            }else{
                // $this->respondCreated($so);
                $this->repondMethodNotAllowed("DELETE");
                
            } 
          
                
        } else {
            $task = $this->gateway->get($plate);
            if($task === false) {
                $this->respondNotFound($plate);
                return;
            }

            if(count($task) <= 0) {
                $this->respondNotFound($plate);
                return;
            }
             switch($method) {
                case "GET":
                    echo json_encode($task);
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

    private function respondCreated(string $so): void
    {
        http_response_code(201);
        echo json_encode(["message"=>"Pick Saved!", "id" => $so]);
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if($is_new && empty($data["SalesOrderNumber"])) {
            $errors[] = "Sales order number is required";
        }

        if($is_new && empty($data["ProductCode"])) {
            $errors[] = "ProductCode is required";
        }

        if($is_new && empty($data["Picker"])) {
            $errors[] = "Picker is required";
        }

        if($is_new && empty($data["PickedOn"])) {
            $errors[] = "Picked time unavailable. Please review";
        }


        if($is_new && filter_var($data["PickedQuantity"], FILTER_VALIDATE_INT) === false) {
            $errors[] = "Invalid order quantity";
        }

        return $errors;
    }
}