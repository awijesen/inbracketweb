<?php

class PAUpdateController
{
    public function __construct(private PAUpdateGateway $gateway) {

    }
    public function processRequest(string $method, ?string $plate) : void
    {
        if($plate !== null) {
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
            elseif($method == "POST") {
                
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if(!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $id = $this->gateway->create($data, $plate);

                $this->respondCreated($id);
                
            } 
            else {
                $this->repondMethodNotAllowed("GET");
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

                    $data = (array) json_decode(file_get_contents("php://input"), true);

                    $errors = $this->getValidationErrors($data, false);

                    if(!empty($errors)) {
                        $this->respondUnprocessableEntity($errors);
                        return;
                    }

                    $rows = $this->gateway->update($plate, $data);
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

        if($is_new && empty($data["PONumber"])) {
            $errors[] = "PO number is required";
        }

        if($is_new && empty($data["PutawayUser"])) {
            $errors[] = "Putaway user is required";
        }

        if($is_new && empty($data["PlateNumber"])) {
            $errors[] = "Plate number is required";
        }

        if($is_new && empty($data["ProductCode"])) {
            $errors[] = "Product code is required";
        }

        if($is_new && empty($data["ProductDescription"])) {
            $errors[] = "Product description is required";
        }

        if($is_new && empty($data["PutawayTimeStamp"])) {
            $errors[] = "Putaway timestamp is required";
        }

        if($is_new && empty($data["PutawayQuantity"])) {
            $errors[] = "Putaway quantity is required";
        } else if($is_new && filter_var($data["PutawayQuantity"], FILTER_VALIDATE_INT) === false) {
            $errors[] = "Invalid putaway quantity";
        }

        if($is_new && empty($data["PutawayStatus"])) {
            $errors[] = "Putaway status is required";
        }

        if($is_new && empty($data["PutawayLocation"])) {
            $errors[] = "Putaway location is required";
        }

        // if($is_new && empty($data["PutawayCompletedTimeStamp"])) {
        //     $errors[] = "Putaway completed timestamp is required";
        // }

        return $errors;
    }
}