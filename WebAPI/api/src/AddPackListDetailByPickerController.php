<?php

class AddPackListDetailByPickerController
{
    public function __construct(private AddPackListDetailByPickerGateway $gateway) {

    }
    public function processRequest(string $method) : void
    {
        if($method === 'POST') {
            if($method == "GET") {
                http_response_code(404);
                $this->repondMethodNotAllowed("GET");
                
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
        
            // $task = $this->gateway->get('');
            // if($task === false) {
            //     $this->respondNotFound('');
            //     return;
            // }

            // if(count($task) <= 0) {
            //     $this->respondNotFound('');
            //     return;
            // }
             switch($method) {
                case "GET":
                    $this->repondMethodNotAllowed("GET, DELETE");
                    break;
                case "PATCH":
                    $data = (array) json_decode(file_get_contents("php://input"), true);

                    $errors = $this->getValidationErrors($data, false);

                    if(!empty($errors)) {
                        $this->respondUnprocessableEntity($errors);
                        return;
                    }

                    $rows = $this->gateway->update($data);
                    echo json_encode(["message" => "Successfully updated!", "rows" => $rows]);
                    break;
                case "DELETE":
                    $this->repondMethodNotAllowed("GET, DELETE");
                    break;
                default:
                    $this->repondMethodNotAllowed("GET, DELETE");
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
            echo json_encode(["message" => "BarcodeNotFound"]);
        }

    private function respondCreated(string $so): void
    {
        http_response_code(201);
        echo json_encode(["message"=>"Pack list saved", "id" => $so]);
    }

    private function getValidationErrors(array $data): array
    {
        $errors = [];

        if(empty($data["SalesOrderNumber"])) {
            $errors[] = "Sales order number is required";
        }

        // if($is_new && empty($data["ProductCode"])) {
        //     $errors[] = "ProductCode is required";
        // }

        // if($is_new && empty($data["Picker"])) {
        //     $errors[] = "Picker is required";
        // }

        // if($is_new && empty($data["PickedOn"])) {
        //     $errors[] = "Picked time unavailable. Please review";
        // }


        // if($is_new && filter_var($data["PickedQuantity"], FILTER_VALIDATE_INT) === false) {
        //     $errors[] = "Invalid order quantity";
        // }

        return $errors;
    }
}