<?php

class PACompleteGateway
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

        if (count($data["Barcode"]) <= 0) {
            return "momo";
        } else {
            return $data;
        }
        // if($data["Barcode"] == null) {
        //     return $data["Barcode"];
        // } else {
        //     $sql = "SELECT 
        //     SO.ProductCode,
        //     PRO.ProductDescription,
        //     PRO.UOM,
        //     sum(SO.OrderQuantity) AS 'OrderQuantity'
        //     FROM GRW_INB_ASSIGNED_ORDERS SO
        //     LEFT OUTER JOIN INB_PRODUCT_MASTER_TEMP PRO ON PRO.ProductCode=SO.ProductCode
        //     WHERE SO.SalesOrderNumber = :SalesOrderNumber
        //     AND PRO.Barcode = :Barcode
        //     GROUP BY SO.ProductCode";

        //     $stmt = $this->conn->prepare($sql);
        //     $stmt->bindValue(":SalesOrderNumber", $so, PDO::PARAM_STR);
        //     $stmt->bindValue(":Barcode", $id, PDO::PARAM_STR);
        //     $stmt->execute();
        //     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     return $data;
        //     }
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

    public function update(string $id, string $po, array $data): string
    {
        $fields = [];

        if (array_key_exists("PutawayCompletedTimeStamp", $data)) {
            $fields["PutawayCompletedTimeStamp"] = [
                $data["PutawayCompletedTimeStamp"],
                PDO::PARAM_STR
            ];
        }

        if (array_key_exists("PutawayStatus", $data)) {
            $fields["PutawayStatus"] = [
                'Completed',
                PDO::PARAM_STR
            ];
        }

        if (empty($fields)) {
            return 0;
        } else {
            $sets = array_map(function ($value) {
                return "$value = :$value";
            }, array_keys($fields));


            $sql = "UPDATE INB_PURCHASE_PUTAWAY"
                . " SET " . implode(", ", $sets)
                . " WHERE PlateNumber=:PlateNumber AND PONumber=:PONumber";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":PlateNumber", $id, PDO::PARAM_STR);
            $stmt->bindValue(":PONumber", $po, PDO::PARAM_STR);

            foreach ($fields as $flds => $values) {
                $stmt->bindValue(":$flds", $values[0], $values[1]);
            }

            $stmt->execute();

            // return $stmt->rowCount();

            if ($stmt->rowCount() > 0) {

                    $sql = "UPDATE INB_PURCHASE_RECEIPTS"
                        . " SET " . implode(", ", $sets)
                        . " WHERE PlateNumber=:PlateNumber AND PONumber=:PONumber";

                    $stmt22 = $this->conn->prepare($sql);

                    $stmt22->bindValue(":PlateNumber", $id, PDO::PARAM_STR);
                    $stmt22->bindValue(":PONumber", $po, PDO::PARAM_STR);

                    foreach ($fields as $flds => $values) {
                        $stmt22->bindValue(":$flds", $values[0], $values[1]);
                    }

                    $stmt22->execute();

                    return $stmt22->rowCount();

            } else {
                return "ERR-09090";
            }
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
