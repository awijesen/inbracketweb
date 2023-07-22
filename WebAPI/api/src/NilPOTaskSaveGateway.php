<?php

class NilPOTaskSaveGateway
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

    public function get(string $so): array | false
    {

        return array('aa' => $so);
    }

    public function create(array $data)
    {

            $sql = "INSERT INTO INB_PURCHASE_RECEIPTS(
            PONumber, 
            Receiver, 
            ProductCode, 
            ProductDescription, 
            ReceivedQuantity, 
            ReasonCode,
            PlateNumber,
            ReceiptStatus,
            ReceivedTimeStamp)
            VALUES(
            :PONumber, 
            :Receiver, 
            :ProductCode, 
            :ProductDescription, 
            :ReceivedQuantity, 
            :ReasonCode,
            :PlateNumber,
            :ReceiptStatus,
            :ReceivedTimeStamp
            )";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":PONumber", $data["PONumber"], PDO::PARAM_STR);
            $stmt->bindValue(":Receiver", $data["Receiver"], PDO::PARAM_STR);
            $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
            $stmt->bindValue(":ProductDescription", $data["ProductDescription"], PDO::PARAM_STR);
            $stmt->bindValue(":ReceivedQuantity", 0, PDO::PARAM_INT);
            $stmt->bindValue(":ReasonCode", 'SOP', PDO::PARAM_STR);
            $stmt->bindValue(":PlateNumber", null, PDO::PARAM_STR);
            $stmt->bindValue(":ReceiptStatus", 'Received', PDO::PARAM_STR);
            $stmt->bindValue(":ReceivedTimeStamp", $data["ReceivedTimeStamp"], PDO::PARAM_STR);

            if (empty($data["PONumber"])) {
                $stmt->bindValue(":PONumber", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":PONumber", $data["PONumber"], PDO::PARAM_STR);
            }

            if (empty($data["Receiver"])) {
                $stmt->bindValue(":Receiver", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":Receiver", $data["Receiver"], PDO::PARAM_STR);
            }

            if (empty($data["ProductCode"])) {
                $stmt->bindValue(":ProductCode", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
            }

            if (empty($data["ProductDescription"])) {
                $stmt->bindValue(":ProductDescription", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ProductDescription", $data["ProductDescription"], PDO::PARAM_STR);
            }


            $stmt->bindValue(":ReceivedQuantity", 0, PDO::PARAM_INT);


            if (empty($data["ReasonCode"])) {
                $stmt->bindValue(":ReasonCode", 'SOP', PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ReasonCode", 'SOP', PDO::PARAM_STR);
            }

            if (empty($data["PlateNumber"])) {
                $stmt->bindValue(":PlateNumber", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":PlateNumber", null , PDO::PARAM_STR);
            }

            if (empty($data["ReceiptStatus"])) {
                $stmt->bindValue(":ReceiptStatus", 'Received', PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ReceiptStatus", 'Received', PDO::PARAM_STR);
            }

            if (empty($data["ReceivedTimeStamp"])) {
                $stmt->bindValue(":ReceivedTimeStamp", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ReceivedTimeStamp", $data["ReceivedTimeStamp"], PDO::PARAM_STR);
            }

            $stmt->execute();

            return $this->conn->lastInsertId();
       
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
