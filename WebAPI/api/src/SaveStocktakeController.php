<?php

class SaveStocktakeController
{
    public function __construct(private SaveStocktakeGateway $gateway) {

    }
    public function processRequest(string $method, ?string $code) : void
    {
        if($code === '') {
            if($method == "GET") {
                $this->repondMethodNotAllowed("GET");
                // http_response_code(404);
                // echo json_encode(["message" => "Unspecified search parameters"]);
                // $data = (array) json_decode(file_get_contents("php://input"), true);

                //     $errors = $this->getValidationErrors($data);
    
                //     if(!empty($errors)) {
                //         $this->respondUnprocessableEntity($errors);
                //         return;
                //     }
    
            } 
            elseif($method == "POST") {
                
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if(!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $id = $this->gateway->create($data);

                $this->respondCreated($id);
                
            } 
            else {
                $this->repondMethodNotAllowed("GET");
            }
        } else {
            $task = $this->gateway->get($code);
            if($task === false) {
                $this->respondNotFound($code);
                return;
            }

            if(count($task) <= 0) {
                $this->respondNotFound($code);
                return;
            }
             switch($method) {
                case "GET":
                    // echo json_encode($task);
                    // break;
                    $this->repondMethodNotAllowed("GET");
                case "PATCH":

                    // $data = (array) json_decode(file_get_contents("php://input"), true);

                    // $errors = $this->getValidationErrors($data, false);

                    // if(!empty($errors)) {
                    //     $this->respondUnprocessableEntity($errors);
                    //     return;
                    // }

                    // $rows = $this->gateway->update($so, $data);
                    // echo json_encode(["message" => "Successfully updated!", "rows" => $rows]);
                    // break;
                    $this->repondMethodNotAllowed("PATCH");
                case "DELETE":
                    // $rows = $this->gateway->delete($so);
                    // echo json_encode(["message" => "Successfully deleted.", "rows" => $rows]);
                    // break;
                    $this->repondMethodNotAllowed("DELETE");
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
            $errors[] = "ProductCode is required";
        }
        if(filter_var($data["StocktakeCount"], FILTER_VALIDATE_INT) === false) {
            $errors[] = "Invalid stock count";
        }
        if(empty($data["CountLocation"])) {
            $errors[] = "CountLocation is required";
        }
        if(empty($data["CorrectPickface"])) {
            $errors[] = "Correct Pickface is required";
        }
        if(empty($data["LocationClass"])) {
            $errors[] = "Location class is required";
        }
        if(empty($data["CountUser"])) {
            $errors[] = "CountUser is required";
        }
        if(empty($data["CountedOn"])) {
            $errors[] = "Timestamp is required";
        }
        if(empty($data["WarehouseId"])) {
            $errors[] = "Warehouse Id is required";
        }
        if(empty($data["StocktakeNumber"])) {
            $errors[] = "StocktakeNumber is required";
        }

        

        return $errors;
    }
}