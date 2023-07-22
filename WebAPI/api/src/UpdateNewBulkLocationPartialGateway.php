<?php

class UpdateNewBulkLocationPartialGateway
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
 
    public function get(string $id, string $IDToUpdate): array | false
    {
        $sql = "SELECT Barcode
        FROM INB_PRODUCT_MASTER
        WHERE Barcode = :Barcode";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":Barcode", $id, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($data["Barcode"]) <= 0 ) {
            return "momo";
        } else {
        return $data;
        }
    }

    public function create(array $data, string $IDToUpdate): string
    {
        $sql = "INSERT INTO INB_BULK_STOCK (ProductCode, BulkStock, WarehouseId, BulkLocation)
                VALUES(:ProductCode, :BulkStock, :WarehouseId, :BulkLocation)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);

        $stmt->bindValue(":BulkStock", $data["BulkStock"], PDO::PARAM_INT);

        $stmt->bindValue(":WarehouseId", $data["WarehouseId"], PDO::PARAM_STR);

        $stmt->bindValue(":BulkLocation", $data["BulkLocation"], PDO::PARAM_STR);

        $stmt->execute();

        // return $this->conn->lastInsertId();
        if($this->conn->lastInsertId() > 0) {
            $sql = "UPDATE INB_BULK_STOCK SET BulkStock = BulkStock - :BulkStockReduce WHERE ID=:IDToUpdate";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":BulkStockReduce", $data["BulkStock"], PDO::PARAM_INT);
        $stmt->bindValue(":IDToUpdate", $IDToUpdate, PDO::PARAM_STR);

        // foreach($fields as $Location => $values) {
        //     $stmt->bindValue(":$Location", $values[0], $values[1]);
        // }

        $stmt->execute();

        return $stmt->rowCount();
        }
    }

    public function update(string $code, array $data) : int
    {
        $fields = [];

        if (array_key_exists("NewLocation", $data)) {
            $fields["BulkLocation"] = [
                $data["NewLocation"],
                PDO::PARAM_STR
            ];
        }

        // if (array_key_exists("ProductCode", $data)) {
        //     $fields["ProductCode"] = [
        //         $data["ProductCode"],
        //         PDO::PARAM_STR
        //     ];
        // }

        // if (array_key_exists("OrderQuantity", $data)) {
        //     $fields["OrderQuantity"] = [
        //         $data["OrderQuantity"],
        //         PDO::PARAM_INT
        //     ];
        // }

        if (empty($fields)) {
            return 0;
        } else {
            $sets = array_map(function ($value) {
                return "$value = :$value";
            }, array_keys($fields));

            $sql = "UPDATE INB_BULK_STOCK"
                . " SET " . implode(", ", $sets)
                . " WHERE ID = :IDToUpdate";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":IDToUpdate", $code, PDO::PARAM_STR);

            foreach($fields as $Location => $values) {
                $stmt->bindValue(":$Location", $values[0], $values[1]);
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
