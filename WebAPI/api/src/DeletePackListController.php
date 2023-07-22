<?php

class DeletePackListController
{
    public function __construct(private DeletePackListGateway $gateway) {

    }
    public function processRequest(string $method, ?string $id) : void
    {
        if($id === '') {
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

                $this->respondCreated($id);
                // $this->respondCreated('moon');

            }else{
                // $this->respondCreated($so);
                http_response_code(404);
                echo json_encode(["message" => "Unspecified delete parameters"]);
                
            } 
          
                
        } else {
            // $task = $this->gateway->get($id);
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
            echo json_encode(["message" => "BarcodeNotFound"]);
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