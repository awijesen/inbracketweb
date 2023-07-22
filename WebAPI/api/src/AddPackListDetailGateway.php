<?php

class AddPackListDetailGateway
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

    public function get(string $barcode): array | false
    {

        $sql = "SELECT ProductCode FROM INB_PRODUCT_MASTER WHERE Barcode=:Barcode";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":Barcode", $barcode, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function create(array $data)
    {
        // $a = $data[0]["SalesOrderNumber"];
        // return $a;
        // exit;

        $sql = "SELECT SalesOrderNumber
        FROM INB_PACK_LIST_DETAIL
        WHERE SalesOrderNumber = :SalesOrderNumber";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
        $stmt->execute();

        $datax = $stmt->fetch(PDO::FETCH_ASSOC);
        // return $data;

        if (empty($datax)) {
            $sqlX = "INSERT INTO INB_PACK_LIST_DETAIL 
        (packListId, CustomerName, SalesOrderNumber, PalletCount, BoxCount, WarehouseId, PackedOn, PackedBy, OrderCustomerId)
        VALUES (:packListId, :CustomerName, :SalesOrderNumber, :PalletCount, :BoxCount, :WarehouseId, :PackedOn, :PackedBy, :OrderCustomerId)";

            $stmtX = $this->conn->prepare($sqlX);

            $stmtX->bindValue(":packListId", $data["packListId"], PDO::PARAM_STR);
            $stmtX->bindValue(":CustomerName", $data["CustomerName"], PDO::PARAM_STR);
            $stmtX->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
            $stmtX->bindValue(":PalletCount", $data["PalletCount"], PDO::PARAM_INT);
            $stmtX->bindValue(":BoxCount", $data["BoxCount"], PDO::PARAM_INT);
            $stmtX->bindValue(":WarehouseId", 'WarehouseId', PDO::PARAM_STR);
            $stmtX->bindValue(":PackedOn", $data["PackedOn"], PDO::PARAM_STR);
            $stmtX->bindValue(":PackedBy", $data["PackedBy"], PDO::PARAM_STR);
            $stmtX->bindValue(":OrderCustomerId", $data["OrderCustomerId"], PDO::PARAM_STR);

            if (empty($data["packListId"])) {
                $stmtX->bindValue(":packListId", null, PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":packListId", $data["packListId"], PDO::PARAM_STR);
            }

            if (empty($data["CustomerName"])) {
                $stmtX->bindValue(":CustomerName", null, PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":CustomerName", $data["CustomerName"], PDO::PARAM_STR);
            }

            if (empty($data["SalesOrderNumber"])) {
                $stmtX->bindValue(":SalesOrderNumber", null, PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
            }

            if (empty($data["PalletCount"])) {
                $stmtX->bindValue(":PalletCount", '0', PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":PalletCount", $data["PalletCount"], PDO::PARAM_INT);
            }

            if (empty($data["BoxCount"])) {
                $stmtX->bindValue(":BoxCount", '0', PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":BoxCount", $data["BoxCount"], PDO::PARAM_INT);
            }

            if (empty($data["WarehouseId"])) {
                $stmtX->bindValue(":WarehouseId", null, PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":WarehouseId", $data["WarehouseId"], PDO::PARAM_STR);
            }

            if (empty($data["PackedOn"])) {
                $stmtX->bindValue(":PackedOn", null, PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":PackedOn", $data["PackedOn"], PDO::PARAM_STR);
            }

            if (empty($data["PackedBy"])) {
                $stmtX->bindValue(":PackedBy", null, PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":PackedBy", $data["PackedBy"], PDO::PARAM_STR);
            }

            if (empty($data["OrderCustomerId"])) {
                $stmtX->bindValue(":OrderCustomerId", null, PDO::PARAM_NULL);
            } else {
                $stmtX->bindValue(":OrderCustomerId", $data["OrderCustomerId"], PDO::PARAM_STR);
            }

            $stmtX->execute();

            return $this->conn->lastInsertId();
        } else {
            return "orderexists";
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
