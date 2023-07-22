<?php

class SearchPickedItemsController
{
    public function __construct(private SearchPickedItemsGateway $gateway) {

    }
    public function processRequest(string $method, ?string $so) : void
    {
        if($so === null OR $so === '') {
            // if($method == "GET") {
            //     http_response_code(404);
            //     echo json_encode(["message" => "Unspecified search parameters"]);
            //     // $data = (array) json_decode(file_get_contents("php://input"), true);

            //     //     $errors = $this->getValidationErrors($data);
    
            //     //     if(!empty($errors)) {
            //     //         $this->respondUnprocessableEntity($errors);
            //     //         return;
            //     //     }
    
            // } 
            // else
            if($method == "POST") {
                
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if(!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $so = $this->gateway->create($data);

                $this->respondCreated($so);
                
            } 
            else {
                $this->repondMethodNotAllowed("GET");
            }
        } else {
            $task = $this->gateway->get($so);
            if($task === false) {
                $this->respondNotFound($so);
                return;
            }

            if(count($task) <= 0) {
                $this->respondNotFound($so);
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
        echo json_encode(["message"=>"Order Assigned!", "id" => $so]);
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