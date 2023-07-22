<?php

class MarkPOCompleteGateway
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

    public function get(): array | false
    {

        return array('aa' => null);
        // return array ('s' => 'adadad');
        // $sql = "SELECT p.ProductCode
        // FROM INB_ORDER_PICKS p
        // WHERE p.ProductCode = :ProductCode
        // AND p.SalesOrderNumber=:SalesOrderNumber
        // GROUP BY p.ProductCode";

        // $stmt = $this->conn->prepare($sql);
        // $stmt->bindValue(":SalesOrderNumber", $so, PDO::PARAM_STR);
        // $stmt->bindValue(":ProductCode", $code, PDO::PARAM_STR);
        // $stmt->execute();
        // $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // // return $stmt->rowCount();

        // if(count($data["ProductCode"]) <= 0 ) {
        //     http_response_code(200);
        //     return array("message"=>"exists");
        // } else {
        //     return $data;
        // }
        // return $data;
        // if(strlen($data["message"]) > 8) {
        //     http_response_code(200);
        //     return array("message"=>"exists");
        // } else{
        //     http_response_code(200);
        //     return array("message"=>"Does not exist");
        // }
    }

    public function create(array $data)
    {
        // $sql = "SELECT p.ProductCode
        // FROM INB_ORDER_PICKS p
        // WHERE p.ProductCode = :ProductCode
        // AND p.SalesOrderNumber=:SalesOrderNumber
        // GROUP BY p.ProductCode";

        // $stmt = $this->conn->prepare($sql);
        // $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
        // $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);
        // $stmt->execute();

        // $datax = $stmt->fetch(PDO::FETCH_ASSOC);
        // return $data;

        // if (empty($datax)) {
        $sql = "INSERT INTO INB_COMPLETED_PURCHASE_RECEIPTS(
            INB_COMPLETED_PURCHASE_RECEIPTS.PurchaseOrderId, 
            INB_COMPLETED_PURCHASE_RECEIPTS.PurchaseOrderNumber, 
            INB_COMPLETED_PURCHASE_RECEIPTS.ProductCode, 
            INB_COMPLETED_PURCHASE_RECEIPTS.ProductId,
            INB_COMPLETED_PURCHASE_RECEIPTS.ProductDescription,
            INB_COMPLETED_PURCHASE_RECEIPTS.OrderQuantity,
            INB_COMPLETED_PURCHASE_RECEIPTS.Receiver,
            INB_COMPLETED_PURCHASE_RECEIPTS.AssignedBy,
            INB_COMPLETED_PURCHASE_RECEIPTS.AssignedOn,
            INB_COMPLETED_PURCHASE_RECEIPTS.VendorName,
            INB_COMPLETED_PURCHASE_RECEIPTS.UOM)
            SELECT 
            INB_ASSIGNED_PURCHASE_ORDERS.PurchaseOrderId, 
            INB_ASSIGNED_PURCHASE_ORDERS.PurchaseOrderNumber, 
            INB_ASSIGNED_PURCHASE_ORDERS.ProductCode, 
            INB_ASSIGNED_PURCHASE_ORDERS.ProductId,
            INB_ASSIGNED_PURCHASE_ORDERS.ProductDescription,
            INB_ASSIGNED_PURCHASE_ORDERS.OrderQuantity,
            INB_ASSIGNED_PURCHASE_ORDERS.Receiver,
            INB_ASSIGNED_PURCHASE_ORDERS.AssignedBy,
            INB_ASSIGNED_PURCHASE_ORDERS.AssignedOn,
            INB_ASSIGNED_PURCHASE_ORDERS.VendorName,
            INB_ASSIGNED_PURCHASE_ORDERS.UOM
            FROM INB_ASSIGNED_PURCHASE_ORDERS
            WHERE INB_ASSIGNED_PURCHASE_ORDERS.PurchaseOrderNumber=:PurchaseOrderNumber";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":PurchaseOrderNumber", $data["PurchaseOrderNumber"], PDO::PARAM_STR);

        if($stmt->execute()) {
        
            $sql = "DELETE FROM INB_ASSIGNED_PURCHASE_ORDERS
                WHERE PurchaseOrderNumber = :PurchaseOrderNumber";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":PurchaseOrderNumber", $data["PurchaseOrderNumber"], PDO::PARAM_STR);


            $stmt->execute();
            return $stmt->rowCount();
            
        } else {
            return 'Record not deleted';
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
