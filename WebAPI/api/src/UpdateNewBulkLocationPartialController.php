<?php

class UpdateNewBulkLocationPartialController
{
    public function __construct(private UpdateNewBulkLocationPartialGateway $gateway) {

    }
    public function processRequest(string $method, ?string $IDToUpdate) : void
    {
        if($IDToUpdate !== null) {
            if($method == "GET") {
                http_response_code(404);
                echo json_encode(["message" => "Unspecified search parameters"]);
                // $data = (array) json_decode(file_get_contents("php://input"), true);

                //     $errors = $this->getValidationErrors($data);
    
                //     if(!empty($errors)) {
                //         $this->respondUnprocessableEntity($errors);
                //         return;
                //     }
    
            } 
            else if($method == "POST") {
                
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if(!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $id = $this->gateway->create($data, $IDToUpdate);

                $this->respondCreated($id);
                
            } 
            else {
                $this->repondMethodNotAllowed("GET");
            }
        } else {
            // $task = $this->gateway->get($id, $IDToUpdate);
            // if($task === false) {
            //     $this->respondNotFound($id);
            //     return;
            // }

            // if(count($task) <= 0) {
            //     $this->respondNotFound($id);
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

    private function respondNotFound(string $id): void
        {
            http_response_code(404);
            echo json_encode(["message" => "Order with picker code $id not found"]);
        }

    private function respondCreated(string $id): void
    {
        http_response_code(201);
        echo json_encode(["message"=>"Order Assigned!", "id" => $id]);
    }

    private function getValidationErrors(array $data): array
    {
        $errors = [];

        if(empty($data["ProductCode"])) {
            $errors[] = "Product code is required";
        }

        if(empty($data["BulkStock"])) {
            $errors[] = "Bulk stock qty is required";
        }


        if(empty($data["WarehouseId"])) {
            $errors[] = "Warehouse ID is required";
        }


        if(empty($data["BulkLocation"])) {
            $errors[] = "Bulk location is required";
        }

        // if($is_new && filter_var($data["OrderQuantity"], FILTER_VALIDATE_INT) === false) {
        //     $errors[] = "Invalid order quantity";
        // }

        return $errors;
    }
}