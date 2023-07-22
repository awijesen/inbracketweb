<?php

class FetchTaskSaveGateway
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

    public function create(array $data, string $so)
    {
        $sql = "SELECT StockPlate FROM INB_FETCH_ORDERS_LIST where StockPlate=:PlateNumber";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":PlateNumber", $so, PDO::PARAM_STR);
        $stmt->execute();

        $datax = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($datax)) {

            $sql = "INSERT INTO INB_FETCH_ORDERS_LIST(
            StockPlate,
            DateReceived,
            ReceivedBy,
            DespatchedStatus,
            DespatchedOn,
            DespatchedBy,
            CustomerId,
            CustomerName,
            ShipDay,
            DeliveryInstructions,
            PostalStreet,
            PostalState,
            PostalPostCode,
            OBSFetchCode,
            ReceivedQty)
            VALUES(
            :StockPlate,
            :DateReceived,
            :ReceivedBy,
            :DespatchedStatus,
            :DespatchedOn,
            :DespatchedBy,
            :CustomerId,
            :CustomerName,
            :ShipDay,
            :DeliveryInstructions,
            :PostalStreet,
            :PostalState,
            :PostalPostCode,
            :OBSFetchCode,
            :ReceivedQty
            )";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":StockPlate", $data["StockPlate"], PDO::PARAM_STR);
            $stmt->bindValue(":DateReceived", $data["DateReceived"], PDO::PARAM_STR);
            $stmt->bindValue(":ReceivedBy", $data["ReceivedBy"], PDO::PARAM_STR);
            $stmt->bindValue(":DespatchedStatus", 'Pending', PDO::PARAM_STR);
            $stmt->bindValue(":DespatchedOn", $data["DespatchedOn"], PDO::PARAM_STR);
            $stmt->bindValue(":DespatchedBy", $data["DespatchedBy"], PDO::PARAM_STR);
            $stmt->bindValue(":CustomerId", $data["CustomerId"], PDO::PARAM_STR);
            $stmt->bindValue(":CustomerName", $data["CustomerName"], PDO::PARAM_STR);
            $stmt->bindValue(":ShipDay", $data["ShipDay"], PDO::PARAM_STR);
            $stmt->bindValue(":DeliveryInstructions", $data["DeliveryInstructions"], PDO::PARAM_STR);
            $stmt->bindValue(":PostalStreet", $data["PostalStreet"], PDO::PARAM_STR);
            $stmt->bindValue(":PostalState", $data["PostalState"], PDO::PARAM_STR);
            $stmt->bindValue(":PostalPostCode", $data["PostalPostCode"], PDO::PARAM_STR);
            $stmt->bindValue(":OBSFetchCode", $data["OBSFetchCode"], PDO::PARAM_STR);
            $stmt->bindValue(":ReceivedQty", $data["ReceivedQty"], PDO::PARAM_INT);

            if (empty($data["StockPlate"])) {
                $stmt->bindValue(":StockPlate", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":StockPlate", $data["StockPlate"], PDO::PARAM_STR);
            }

            if (empty($data["ReceivedBy"])) {
                $stmt->bindValue(":ReceivedBy", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":ReceivedBy", $data["ReceivedBy"], PDO::PARAM_STR);
            }

            if (empty($data["CustomerName"])) {
                $stmt->bindValue(":CustomerName", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":CustomerName", $data["CustomerName"], PDO::PARAM_STR);
            }

            $stmt->execute();

            return $this->conn->lastInsertId();
        } else {
            return "Invalid plate number";
        }
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
