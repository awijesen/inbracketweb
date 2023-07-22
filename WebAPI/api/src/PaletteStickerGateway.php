<?php

class PaletteStickerGateway
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
        $sql = "SELECT 
        li.CustomerName as 'OrderCustomerName',
        li.AddressStreet as 'Street',
        li.AddressSuburb as 'Suburb',
        li.AddressPostCode as 'PostCode',
        li.AddressState as 'State',
        so.DeliveryInstructions as 'DeliveryInstructions'
        FROM INB_ORDER_PICKS p 
        LEFT OUTER JOIN GRW_INB_SALES_ORDERS so on so.SalesOrderNumber=p.SalesOrderNumber
        LEFT OUTER JOIN INB_CUSTOMER_LIST li on li.CustomerId=so.OrderCustomerId
        WHERE p.SalesOrderNumber=:SalesOrderNumber
        GROUP BY li.CustomerName;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":SalesOrderNumber", $so, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
        
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
