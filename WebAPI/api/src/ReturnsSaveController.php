<?php

class ReturnsSaveController
{
    public function __construct(private ReturnsSaveGateway $gateway) {

    }
    public function processRequest(string $method, ?string $id) : void
    {
        if($id === null) {
            if($method == "GET") {
                http_response_code(404);
                echo json_encode(["message" => "Unspecified search parameters"]);
                
            } else if($method == "POST") {
                
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
            $task = $this->gateway->get($id);
            if($task === false) {
                $this->respondNotFound($id);
                return;
            }

            if(count($task) <= 0) {
                $this->respondNotFound($id);
                return;
            }
             switch($method) {
                case "POST":
                    $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if(!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $so = $this->gateway->create($data);

                $this->respondCreated($so);
                break;
                case "GET":
                    $this->repondMethodNotAllowed("GET, PATCH, DELETE");
                    break;
                case "PATCH":
                    $data = (array) json_decode(file_get_contents("php://input"), true);

                    $errors = $this->getValidationErrors($data, false);

                    if(!empty($errors)) {
                        $this->respondUnprocessableEntity($errors);
                        return;
                    }

                    $rows = $this->gateway->update($id, $data);
                    echo json_encode(["message" => "Successfully updated!", "rows" => $rows]);
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

        if($is_new && empty($data["ProductCode"])) {
            $errors[] = "Product code is required";
        }

        if($is_new && empty($data["stock"])) {
            $errors[] = "Stock is required";
        }

        if($is_new && empty($data["WarehouseId"])) {
            $errors[] = "Warehouse ID is required";
        }

        if($is_new && empty($data["location"])) {
            $errors[] = "Location is required";
        }


        if($is_new && filter_var($data["stock"], FILTER_VALIDATE_INT) === false) {
            $errors[] = "Invalid stock quantity";
        }

        return $errors;
    }
}