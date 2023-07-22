<?php

class UpdatePackListCompleteGateway
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
        $sql = "SELECT Barcode
        FROM INB_PRODUCT_MASTER
        WHERE Barcode = :Barcode";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":Barcode", $id, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    
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

    public function update(string $id, string $tid, int $box, int $pal) : int
    {
   
          
            $sql = "UPDATE INB_PACK_LIST SET PKLStatus='Completed', CompletedBy=:compuser, PalletCount=:pal, BoxCount=:boxc
            WHERE packListId=:id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_STR);
            $stmt->bindValue(":compuser", $tid, PDO::PARAM_STR);
            $stmt->bindValue(":boxc", $box, PDO::PARAM_INT);
            $stmt->bindValue(":pal", $pal, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->rowCount();

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
