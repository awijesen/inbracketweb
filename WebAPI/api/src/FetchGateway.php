<?php

class FetchGateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array | false
    {
        $sql = "SELECT * FROM GRW_INB_ASSIGNED_ORDERS";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get(string $plate): array | false
    {

        $sql = "SELECT * FROM INB_FETCH_ORDERS where OBSFetchCode=:fcode";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":fcode", $plate, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function create(array $data)
    {
        $sql = "SELECT p.ProductCode
        FROM INB_ORDER_PICKS p
        WHERE p.ProductCode = :ProductCode
        AND p.SalesOrderNumber=:SalesOrderNumber
        GROUP BY p.ProductCode";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
        $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
        $stmt->execute();

        $datax = $stmt->fetch(PDO::FETCH_ASSOC);
        // return $data;

        if (empty($datax)) {
            $sql = "INSERT INTO INB_ORDER_PICKS 
        (SalesOrderNumber, ProductCode, PickedBy, PickedQty, PickStatus, ProductId, ReasonCode, PickedOn)
        VALUES (:SalesOrderNumber, :ProductCode, :PickedBy, :PickedQuantity, :PickStatus, :ProductId, :ReasonCode, :PickedOn)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
            $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
            $stmt->bindValue(":ProductId", $data["ProductId"], PDO::PARAM_STR);
            $stmt->bindValue(":PickedBy", $data["Picker"], PDO::PARAM_STR);
            $stmt->bindValue(":PickedQuantity", $data["PickedQuantity"], PDO::PARAM_INT);
            $stmt->bindValue(":PickStatus", 'InProgress', PDO::PARAM_STR);
            $stmt->bindValue(":ReasonCode", $data["ReasonCode"], PDO::PARAM_STR);
            $stmt->bindValue(":PickedOn", $data["PickedOn"], PDO::PARAM_STR);

            if (empty($data["ProductCode"])) {
                $stmt->bindValue(":ProductCode", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
            }

            if (empty($data["ProductId"])) {
                $stmt->bindValue(":ProductId", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ProductId", $data["ProductId"], PDO::PARAM_STR);
            }

            if (empty($data["PickedOn"])) {
                $stmt->bindValue(":PickedOn", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":PickedOn", $data["PickedOn"], PDO::PARAM_STR);
            }

            if (empty($data["Picker"])) {
                $stmt->bindValue(":PickedBy", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":PickedBy", $data["Picker"], PDO::PARAM_STR);
            }


            $stmt->bindValue(":PickedQuantity", $data["PickedQuantity"], PDO::PARAM_STR);
            $stmt->bindValue(":PickStatus", 'InProgress', PDO::PARAM_STR);


            if (empty($data["ProductId"])) {
                $stmt->bindValue(":ProductId", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ProductId", $data["ProductId"], PDO::PARAM_STR);
            }

            if (empty($data["ReasonCode"])) {
                $stmt->bindValue(":ReasonCode", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ReasonCode", $data["ReasonCode"], PDO::PARAM_STR);
            }

            $stmt->execute();

            return $this->conn->lastInsertId();
        } else {
            // http_response_code(200);
            // return array(["errors" => "Record exists"]);
            // exit;
            
            // ---
            $fields = [];

            // if (array_key_exists("SalesOrderNumber", $data)) {
            //     $fields["SalesOrderNumber"] = [
            //         $data["SalesOrderNumber"],
            //         PDO::PARAM_STR
            //     ];
            // }
    
            // if (array_key_exists("ProductCode", $data)) {
            //     $fields["ProductCode"] = [
            //         $data["ProductCode"],
            //         PDO::PARAM_STR
            //     ];
            // }
    
            if (array_key_exists("PickedQuantity", $data)) {
                $fields["PickedQty"] = [
                    $data["PickedQuantity"],
                    PDO::PARAM_INT
                ];
            }

            if (array_key_exists("Picker", $data)) {
                $fields["PickedBy"] = [
                    $data["Picker"],
                    PDO::PARAM_STR
                ];
            }

            if (array_key_exists("ProductId", $data)) {
                $fields["ProductId"] = [
                    $data["ProductId"],
                    PDO::PARAM_STR
                ];
            }

            if (array_key_exists("PickedOn", $data)) {
                $fields["PickedOn"] = [
                    $data["PickedOn"],
                    PDO::PARAM_STR
                ];
            }

            if (array_key_exists("ReasonCode", $data)) {
                $fields["ReasonCode"] = [
                    $data["ReasonCode"],
                    PDO::PARAM_STR
                ];
            }
            
    
            // print_r($fields);
            // exit;

            if (empty($fields)) {
                return "none";
            } else {
              

                $sets = array_map(function ($value) {
                    return "$value = :$value";
                }, array_keys($fields));
    
                $sql = "UPDATE INB_ORDER_PICKS"
                    . " SET " . implode(", ", $sets)
                    . "  WHERE ProductCode = :ProductCode AND SalesOrderNumber=:SalesOrderNumber";
    
                       

                $stmt = $this->conn->prepare($sql);
    
                $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
                $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
    
                foreach ($fields as $SalesOrderNumber => $values) {
                    $stmt->bindValue(":$SalesOrderNumber", $values[0]);
                    // print_r($stmt);
                }
                
                // exit;
                $stmt->execute();
    
                // return $stmt->rowCount();
                return "done";
            };
            // ---

        } // else closer
    }

    public function update(string $id, array $data): int
    {
        $fields = [];

        if (array_key_exists("SalesOrderNumber", $data)) {
            $fields["SalesOrderNumber"] = [
                $data["SalesOrderNumber"],
                PDO::PARAM_STR
            ];
        }

        if (array_key_exists("ProductCode", $data)) {
            $fields["ProductCode"] = [
                $data["ProductCode"],
                PDO::PARAM_STR
            ];
        }

        if (array_key_exists("OrderQuantity", $data)) {
            $fields["OrderQuantity"] = [
                $data["OrderQuantity"],
                PDO::PARAM_INT
            ];
        }

        if (empty($fields)) {
            return 0;
        } else {
            $sets = array_map(function ($value) {
                return "$value = :$value";
            }, array_keys($fields));

            $sql = "UPDATE GRW_INB_ASSIGNED_ORDERS"
                . " SET " . implode(", ", $sets)
                . " WHERE Picker = :Picker";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":Picker", $id, PDO::PARAM_INT);

            foreach ($fields as $SalesOrderNumber => $values) {
                $stmt->bindValue(":$SalesOrderNumber", $values[0], $values[1]);
            }

            $stmt->execute();

            return $stmt->rowCount();
        };
    }

    public function delete(string $id)
    {
        $sql = "DELETE FROM GRW_INB_ASSIGNED_ORDERS
                    WHERE Picker = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
