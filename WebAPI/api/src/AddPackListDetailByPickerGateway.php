<?php

class AddPackListDetailByPickerGateway
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
        $sql = "SELECT SalesOrderNumber
        FROM INB_PACK_LIST_DETAIL
        WHERE SalesOrderNumber = :SalesOrderNumber";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
        $stmt->execute();

        $datax = $stmt->fetch(PDO::FETCH_ASSOC);
        // return $data;

        if (empty($datax)) {
            $sql = "INSERT INTO INB_PACK_LIST_DETAIL 
            (packListId, CustomerName, SalesOrderNumber, PalletCount, BoxCount, WarehouseId, PackedOn, PackedBy)
            VALUES (:packListId, :CustomerName, :SalesOrderNumber, :PalletCount, :BoxCount, :WarehouseId, :PackedOn, :PackedBy)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":packListId", $data["packListId"], PDO::PARAM_STR);
            $stmt->bindValue(":CustomerName", $data["CustomerName"], PDO::PARAM_STR);
            $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
            $stmt->bindValue(":PalletCount", $data["PalletCount"], PDO::PARAM_INT);
            $stmt->bindValue(":BoxCount", $data["BoxCount"], PDO::PARAM_INT);
            $stmt->bindValue(":WarehouseId", 'WarehouseId', PDO::PARAM_STR);
            $stmt->bindValue(":PackedOn", $data["PackedOn"], PDO::PARAM_STR);
            $stmt->bindValue(":PackedBy", $data["PackedBy"], PDO::PARAM_STR);

            if (empty($data["packListId"])) {
                $stmt->bindValue(":packListId", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":packListId", $data["packListId"], PDO::PARAM_STR);
            }

            if (empty($data["CustomerName"])) {
                $stmt->bindValue(":CustomerName", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":CustomerName", $data["CustomerName"], PDO::PARAM_STR);
            }

            if (empty($data["SalesOrderNumber"])) {
                $stmt->bindValue(":SalesOrderNumber", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
            }

            if (empty($data["PalletCount"])) {
                $stmt->bindValue(":PalletCount", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":PalletCount", $data["PalletCount"], PDO::PARAM_INT);
            }

            if (empty($data["BoxCount"])) {
                $stmt->bindValue(":BoxCount", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":BoxCount", $data["BoxCount"], PDO::PARAM_INT);
            }

            if (empty($data["WarehouseId"])) {
                $stmt->bindValue(":WarehouseId", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":WarehouseId", $data["WarehouseId"], PDO::PARAM_STR);
            }

            if (empty($data["PackedOn"])) {
                $stmt->bindValue(":PackedOn", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":PackedOn", $data["PackedOn"], PDO::PARAM_STR);
            }

            if (empty($data["PackedBy"])) {
                $stmt->bindValue(":PackedBy", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":PackedBy", $data["PackedBy"], PDO::PARAM_STR);
            }

            $stmt->execute();

            return $this->conn->lastInsertId();
        } else {
            return "orderexists";
        } // else closer
    }

    public function update(array $data): string
    {
        $fields = [];

        if (array_key_exists("SalesOrderNumber", $data)) {
            $fields["SalesOrderNumber"] = [
                $data["SalesOrderNumber"],
                PDO::PARAM_STR
            ];
        }

        if (array_key_exists("PalletCount", $data)) {
            $fields["PalletCount"] = [
                $data["PalletCount"],
                PDO::PARAM_INT
            ];
        }

        if (array_key_exists("BoxCount", $data)) {
            $fields["BoxCount"] = [
                $data["BoxCount"],
                PDO::PARAM_INT
            ];
        }

        if (empty($fields)) {
            return 0;
        } else {
            $sets = array_map(function ($value) {
                return "$value = :$value";
            }, array_keys($fields));

            $sql = "UPDATE INB_ORDER_PICKS SET BoxCount=:boxcount, PalCount=:palcount WHERE SalesOrderNumber = :ordernumber";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":boxcount", $fields["BoxCount"][0], PDO::PARAM_INT);
            $stmt->bindValue(":palcount", $fields["PalletCount"][0], PDO::PARAM_INT);
            $stmt->bindValue(":ordernumber", $fields["SalesOrderNumber"][0], PDO::PARAM_STR);

            // foreach ($fields as $SalesOrderNumber => $values) {
            //     $stmt->bindValue(":$SalesOrderNumber", $values[0], $values[1]);
            // }

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
