<?php

class ReturnsSaveGateway
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

    public function get(string $id): array | false
    {

        return array('aa' => $id);
    }

    public function create(array $data)
    {

        date_default_timezone_set('Australia/Darwin');
        $actualtime=date("Y-m-d h:i:s", time());

        $sql = "INSERT INTO INB_BULK_STOCK(ProductCode, BulkStock, WarehouseId, BulkLocation)
        VALUES(:ProductCode, :BulkStock, :WarehouseId, :BulkLocation)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
        $stmt->bindValue(":BulkStock", $data["stock"], PDO::PARAM_INT);
        $stmt->bindValue(":WarehouseId", $data["WarehouseId"], PDO::PARAM_STR);
        $stmt->bindValue(":BulkLocation", $data["location"], PDO::PARAM_STR);
        $stmt->execute();

        if ($this->conn->lastInsertId() > 0) {
            $sqlv = "INSERT INTO INB_STOCK_RETURNS(ProductCode, ReturnQty, ReturnedOn, ReturnedBy, ReturnedWarehouse, ReturnedBin)
            VALUES(:ProductCode, :ReturnQty, :ReturnedOn, :ReturnedBy, :ReturnedWarehouse, :ReturnedBin)";

            $stmtv = $this->conn->prepare($sqlv);

            $stmtv->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
            $stmtv->bindValue(":ReturnQty", $data["stock"], PDO::PARAM_INT);
            $stmtv->bindValue(":ReturnedOn", $actualtime, PDO::PARAM_STR);
            $stmtv->bindValue(":ReturnedBy", $data["User"], PDO::PARAM_STR);
            $stmtv->bindValue(":ReturnedWarehouse", $data["WarehouseId"], PDO::PARAM_STR);
            $stmtv->bindValue(":ReturnedBin", $data["location"], PDO::PARAM_STR);
            $stmtv->execute();
        }

        return $this->conn->lastInsertId();
    }

    public function update(string $id, array $data): int
    {
        $fields = [];

        if (array_key_exists("ProductCode", $data)) {
            $fields["ProductCode"] = [
                $data["ProductCode"],
                PDO::PARAM_STR
            ];
        }

        if (array_key_exists("BulkStock", $data)) {
            $fields["BulkStock"] = [
                $data["stock"],
                PDO::PARAM_INT
            ];
        }

        if (array_key_exists("WarehouseId", $data)) {
            $fields["WarehouseId"] = [
                $data["WarehouseId"],
                PDO::PARAM_STR
            ];
        }

        if (array_key_exists("BulkLocation", $data)) {
            $fields["BulkLocation"] = [
                $data["location"],
                PDO::PARAM_STR
            ];
        }

        if (empty($fields)) {
            return 0;
        } else {

            date_default_timezone_set('Australia/Darwin');
            $actualtime=date("Y-m-d h:i:s", time());

            $sql = "UPDATE INB_PICKFACE_STOCK SET PickfaceStock=PickfaceStock + " . $data['stock'] . " WHERE ProductCode=:pCode";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":pCode", $id, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $sqlb = "INSERT INTO INB_STOCK_RETURNS(ProductCode, ReturnQty, ReturnedOn, ReturnedBy, ReturnedWarehouse, ReturnedBin)
                VALUES(:ProductCode, :ReturnQty, :ReturnedOn, :ReturnedBy, :ReturnedWarehouse, :ReturnedBin)";
    
                $stmtb = $this->conn->prepare($sqlb);
    
                $stmtb->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
                $stmtb->bindValue(":ReturnQty", $data["stock"], PDO::PARAM_INT);
                $stmtb->bindValue(":ReturnedOn", $actualtime, PDO::PARAM_STR);
                $stmtb->bindValue(":ReturnedBy", $data["User"], PDO::PARAM_STR);
                $stmtb->bindValue(":ReturnedWarehouse", $data["WarehouseId"], PDO::PARAM_STR);
                $stmtb->bindValue(":ReturnedBin", $data["location"], PDO::PARAM_STR);
                $stmtb->execute();

                return $stmtb->rowCount();
            } else {
                return 0;
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
