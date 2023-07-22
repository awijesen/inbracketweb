<?php

class FetchTaskSaveController
{
    public function __construct(private FetchTaskSaveGateway $gateway)
    {
    }
    public function processRequest(string $method, ?string $so): void
    {
        if ($so !== '') {
            if ($method == "GET") {
                // http_response_code(404);
                // echo json_encode(["message" => "Unspecified search parameters"]);
                $this->repondMethodNotAllowed("GET, PATCH, DELETE");
            } else 
            
            if ($method == "POST") {

                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if (!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $so = $this->gateway->create($data, $so);

                $this->respondCreated($so);
                // $this->respondCreated('moon');

            } else {
                // $this->respondCreated($so);
                $this->repondMethodNotAllowed("DELETE");
            }
        } else {
            $task = $this->gateway->get($so);
            if ($task === false) {
                $this->respondNotFound($so);
                return;
            }

            if (count($task) <= 0) {
                $this->respondNotFound($so);
                return;
            }
            switch ($method) {
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

    private function respondCreated(string $so): void
    {
        if ($so === "Invalid plate number") {
            http_response_code(405);
            echo json_encode(["message" => $so]);
        } else {
            http_response_code(201);
            echo json_encode(["message" => $so]);
        }
    }

    private function getValidationErrors(array $data): array
    {
        $errors = [];

        if (empty($data["StockPlate"])) {
            $errors[] = "Stock plate is required";
        }

        if (empty($data["ReceivedBy"])) {
            $errors[] = "Receiver is required";
        }

        if (empty($data["CustomerName"])) {
            $errors[] = "Customer name is required";
        }

        return $errors;
    }
}
