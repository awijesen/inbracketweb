<?php
 
class FinalReplenishSaveGateway
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

    public function get(string $so, string $code): array | false
    {

        return array('aa' => $code);
        // return array ('s' => 'adadad');
        // $sql = "SELECT p.ProductCode
        // FROM INB_ORDER_PICKS p
        // WHERE p.ProductCode = :ProductCode
        // AND p.SalesOrderNumber=:SalesOrderNumber
        // GROUP BY p.ProductCode";

        // $stmt = $this->conn->prepare($sql);
        // $stmt->bindValue(":SalesOrderNumber", $so, PDO::PARAM_STR);
        // $stmt->bindValue(":ProductCode", $code, PDO::PARAM_STR);
        // $stmt->execute();
        // $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // // return $stmt->rowCount();

        // if(count($data["ProductCode"]) <= 0 ) {
        //     http_response_code(200);
        //     return array("message"=>"exists");
        // } else {
        //     return $data;
        // }
        // return $data;
        // if(strlen($data["message"]) > 8) {
        //     http_response_code(200);
        //     return array("message"=>"exists");
        // } else{
        //     http_response_code(200);
        //     return array("message"=>"Does not exist");
        // }
    }

    public function create(array $data)
    {
        $fields = [];

        if (array_key_exists("ProductCode", $data)) {
            $fields["ProductCode"] = [
                $data["ProductCode"],
                PDO::PARAM_STR
            ];
        }

        if (array_key_exists("AddtoPickfaceStock", $data)) {
            $fields["AddtoPickfaceStock"] = [$data["AddtoPickfaceStock"], PDO::PARAM_INT];
        }

        if (array_key_exists("ID", $data)) {
            $fields["ID"] = [$data["ID"], PDO::PARAM_INT];
        }

        if (array_key_exists("BulkQuantity", $data)) {
            $fields["BulkQuantity"] = [$data["BulkQuantity"], PDO::PARAM_INT];
        }

        if (empty($fields)) {
            return "none"; 
        } else {

            $sql = "UPDATE INB_PICKFACE_STOCK SET PickfaceStock=PickfaceStock + " . $fields["AddtoPickfaceStock"][0] . " WHERE ProductCode=:ProductCode";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);

            $stmt->execute();

            $sqlX = "INSERT INTO INB_STOCK_REPLENISHMENT(ProductCode, ProductDescription, FromLocation, ToLocation, WarehouseId, ReplenQty, ReplenBy, ReplenOn)
            VALUES (:ProductCode, :ProductDescription, :FromLocation, :ToLocation, :WarehouseId, :AddtoPickfaceStock, :User, :ReplenOn)";
    
                $stmtX = $this->conn->prepare($sqlX);
    
                $stmtX->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
                $stmtX->bindValue(":ProductDescription", $data["ProductDescription"], PDO::PARAM_STR);
                $stmtX->bindValue(":FromLocation", $data["FromLocation"], PDO::PARAM_STR);
                $stmtX->bindValue(":ToLocation", $data["ToLocation"], PDO::PARAM_STR);
                $stmtX->bindValue(":WarehouseId", $data["WarehouseId"], PDO::PARAM_STR);
                $stmtX->bindValue(":AddtoPickfaceStock", $data["AddtoPickfaceStock"], PDO::PARAM_INT);
                $stmtX->bindValue(":User", $data["User"], PDO::PARAM_STR);
                $stmtX->bindValue(":ReplenOn", $data["ReplenOn"], PDO::PARAM_STR);

                $stmtX->execute();

            if ($stmt->rowCount() > 0) {
                if ($fields["AddtoPickfaceStock"][0] < $fields["BulkQuantity"][0]) {

                    $sql = "UPDATE INB_BULK_STOCK SET BulkStock=BulkStock - " . $fields["AddtoPickfaceStock"][0] . " WHERE ID=:ID";

                    $stmt = $this->conn->prepare($sql);

                    $stmt->bindValue(":ID", $data["ID"], PDO::PARAM_INT);

                    $stmt->execute();

                    return "Bulk qty updated";
                } else if ($fields["AddtoPickfaceStock"][0] == $fields["BulkQuantity"][0]) {

                    $sql = "DELETE FROM INB_BULK_STOCK WHERE ID = :ID";
                    $stmt = $this->conn->prepare($sql);

                    $stmt->bindValue(":ID", $fields["ID"][0], PDO::PARAM_INT);

                    $stmt->execute();

                    return "Delete from bulk and pickface updated";
                }
            } else {
                return $stmt->rowCount();
            }
        };
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
