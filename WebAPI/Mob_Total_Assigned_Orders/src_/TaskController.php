<?php

class TaskController
{
    public function __construct(private TaskGateway $gateway) {

    }
    public function processRequest(string $method, ?string $id) : void
    {
        if($id === null) {
            if($method == "GET") {
                http_response_code(404);
                echo json_encode(["message" => "Picker unspecified"]);
                // $data = (array) json_decode(file_get_contents("php://input"), true);

                //     $errors = $this->getValidationErrors($data);
    
                //     if(!empty($errors)) {
                //         $this->respondUnprocessableEntity($errors);
                //         return;
                //     }
    
            } 
            // elseif($method == "POST") {
                
            //     $data = (array) json_decode(file_get_contents("php://input"), true);

            //     $errors = $this->getValidationErrors($data);

            //     if(!empty($errors)) {
            //         $this->respondUnprocessableEntity($errors);
            //         return;
            //     }

            //     $id = $this->gateway->create($data);

            //     $this->respondCreated($id);
                
            // } 
            else {
                $this->repondMethodNotAllowed("GET");
            }
        } else {
            $task = $this->gateway->get($id);
            if($task === false) {
                $this->respondNotFound($id);
                return;
            }

             switch($method) {
                case "GET":
                    echo json_encode($task);
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
                    $rows = $this->gateway->delete($id);
                    echo json_encode(["message" => "Successfully deleted.", "rows" => $rows]);
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

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if($is_new && empty($data["SalesOrderNumber"])) {
            $errors[] = "Sales order number is required";
        }

        if($is_new && filter_var($data["OrderQuantity"], FILTER_VALIDATE_INT) === false) {
            $errors[] = "Invalid order quantity";
        }

        return $errors;
    }
}