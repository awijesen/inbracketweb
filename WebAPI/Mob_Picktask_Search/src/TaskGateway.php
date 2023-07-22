<?php

class TaskGateway
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

    public function get(string $id, string $so): array | false
    {
        $sql = "SELECT Barcode
        FROM INB_PRODUCT_MASTER
        WHERE Barcode = :Barcode";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":Barcode", $id, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($data)) {
            http_response_code(404);
            return array("message"=>"Product not found");
        } else {
            $sql = "SELECT SO.ProductCode, PRO.ProductDescription,
            SO.UOM,
            (SELECT sum(SOO.OrderQuantity) 
                FROM GRW_INB_ASSIGNED_ORDERS SOO 
                WHERE SOO.ProductCode=SO.ProductCode 
                and SOO.SalesOrderNumber=SO.SalesOrderNumber) as 'OrderQuantity',
            (SELECT sum(pk.PickedQty) 
                FROM INB_ORDER_PICKS pk 
                WHERE pk.ProductCode=SO.ProductCode 
                and pk.SalesOrderNumber=SO.SalesOrderNumber) as 'PickedQty',
            stk.PickfaceStock,
            stk.Pickface,
            B.BulkStock AS 'BulkStock'
            FROM GRW_INB_ASSIGNED_ORDERS SO
            LEFT OUTER JOIN INB_PRODUCT_MASTER PRO ON PRO.ProductCode=SO.ProductCode
            LEFT OUTER JOIN INB_ORDER_PICKS pk on pk.ProductCode=SO.ProductCode and pk.SalesOrderNumber=SO.SalesOrderNumber
            LEFT OUTER JOIN INB_PICKFACE_STOCK stk on stk.ProductCode=SO.ProductCode
            LEFT OUTER JOIN INB_BULK_STOCK B ON B.ProductCode=SO.ProductCode
            WHERE SO.SalesOrderNumber = :SalesOrderNumber
            AND PRO.Barcode = :Barcode
            GROUP BY SO.ProductCode;";
    
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(":SalesOrderNumber", $so, PDO::PARAM_STR);
                $stmt->bindValue(":Barcode", $id, PDO::PARAM_STR);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                if(isset($data["PickedQty"]) && $data["PickedQty"] === $data["OrderQuantity"]){
                    http_response_code(200);
                    return array("Noticealert"=>"Fully picked");
                } else if(isset($data["PickedQty"]) && $data["PickedQty"] < $data["OrderQuantity"] && $data["PickedQty"] > 0) {
                    http_response_code(200);
                    $array1 =  array("Noticealert"=>"Partially picked");
                    $array2 = $data;
                    $merged = array_merge($array1, $array2);
                    return $merged;
                } else {
                    return $data;
                }  
                // return $data;
        }
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO GRW_INB_ASSIGNED_ORDERS (SalesOrderNumber, ProductCode, ProductDescription, OrderQuantity, Picker, AssignedBy)
                VALUES(:SalesOrderNumber, :ProductCode, :ProductDescription, :OrderQuantity, :Picker, :AssignedBy)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);

        if (empty($data["ProductCode"])) {
            $stmt->bindValue(":ProductCode", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
        }

        $stmt->bindValue(":ProductDescription", $data["ProductDescription"], PDO::PARAM_STR);

        $stmt->bindValue(":OrderQuantity", $data["OrderQuantity"], PDO::PARAM_INT);

        $stmt->bindValue(":Picker", $data["Picker"], PDO::PARAM_STR);

        $stmt->bindValue(":AssignedBy", $data["AssignedBy"], PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function update(string $id, array $data) : int
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

            foreach($fields as $SalesOrderNumber => $values) {
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
