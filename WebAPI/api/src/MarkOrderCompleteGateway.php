<?php

class MarkOrderCompleteGateway
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
        $sql = "INSERT INTO INB_COMPLETED_PICKS (
            INB_COMPLETED_PICKS.SalesOrderId,
            INB_COMPLETED_PICKS.SalesOrderNumber,
            INB_COMPLETED_PICKS.ProductCode,
            INB_COMPLETED_PICKS.ProductId,
            INB_COMPLETED_PICKS.PickedBy,
            INB_COMPLETED_PICKS.PickedQty,
            INB_COMPLETED_PICKS.PickedOn,
            INB_COMPLETED_PICKS.PickStatus,
            INB_COMPLETED_PICKS.ReasonCode,
            INB_COMPLETED_PICKS.PushedTime,
            INB_COMPLETED_PICKS.PushedStatus,
            INB_COMPLETED_PICKS.AssignedBy,
            INB_COMPLETED_PICKS.AssignedOn,
            INB_COMPLETED_PICKS.Reference,
            INB_COMPLETED_PICKS.OrderQuantity,
            INB_COMPLETED_PICKS.OrderCustomer,
            INB_COMPLETED_PICKS.OrderCustomerId,
            INB_COMPLETED_PICKS.UOM,
            INB_COMPLETED_PICKS.Notes,
            INB_COMPLETED_PICKS.ShipDay,
            INB_COMPLETED_PICKS.CustomerGroupId)
            SELECT 
            p.SalesOrderId,
            p.SalesOrderNumber,
            p.ProductCode,
            p.ProductId,
            p.PickedBy,
            p.PickedQty,
            p.PickedOn,
            'Completed',
            p.ReasonCode,
            p.PushedTime,
            p.PushedStatus,
            ass.AssignedBy,
            ass.AssignedOn,
            ass.Reference,
            ass.OrderQuantity,
            ass.OrderCustomer,
            ass.OrderCustomerId,
            ass.UOM,
            ass.Notes,
            ass.ShipDay,
            ass.CustomerGroupId
            FROM INB_ORDER_PICKS p
            LEFT OUTER JOIN GRW_INB_ASSIGNED_ORDERS ass on ass.SalesOrderNumber= p.SalesOrderNumber AND ass.ProductCode=p.ProductCode
            WHERE p.SalesOrderNumber = :SalesOrderNumber
            GROUP BY p.ProductCode";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);

        $stmt->execute();

        // return $this->conn->lastInsertId();
        if ($this->conn->lastInsertId() > 0) {
            $sql = "DELETE FROM INB_ORDER_PICKS
                WHERE SalesOrderNumber = :SalesOrderNumber";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);


            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $sql = "DELETE FROM GRW_INB_ASSIGNED_ORDERS
                WHERE SalesOrderNumber = :SalesOrderNumber";
                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);


                $stmt->execute();
                return $stmt->rowCount();
            }
        } else {
            return 'nothing inserted';
        }
        // } else {
        // http_response_code(200);
        // return array(["errors" => "Record exists"]);
        // exit;

        // ---
        // $fields = [];

        // if (array_key_exists("SalesOrderNumber", $data)) {
        //     $fields["SalesOrderNumber"] = [
        //         $data["SalesOrderNumber"],
        //         PDO::PARAM_STR
        //     ];
        // }

        // if (array_key_exists("ProductCode", $data)) {
        //     $fields["ProductCode"] = [
        //         $data["ProductCode"],
        //         PDO::PARAM_STR
        //     ];
        // }

        // if (array_key_exists("PickedQuantity", $data)) {
        //     $fields["PickedQty"] = [
        //         $data["PickedQuantity"],
        //         PDO::PARAM_INT
        //     ];
        // }

        // if (array_key_exists("Picker", $data)) {
        //     $fields["PickedBy"] = [
        //         $data["Picker"],
        //         PDO::PARAM_STR
        //     ];
        // }

        // if (array_key_exists("ProductId", $data)) {
        //     $fields["ProductId"] = [
        //         $data["ProductId"],
        //         PDO::PARAM_STR
        //     ];
        // }

        // if (array_key_exists("PickedOn", $data)) {
        //     $fields["PickedOn"] = [
        //         $data["PickedOn"],
        //         PDO::PARAM_STR
        //     ];
        // }

        // if (array_key_exists("ReasonCode", $data)) {
        //     $fields["ReasonCode"] = [
        //         $data["ReasonCode"],
        //         PDO::PARAM_STR
        //     ];
        // }


        // print_r($fields);
        // exit;

        // if (empty($fields)) {
        //     return "none";
        // } else {


        //     $sets = array_map(function ($value) {
        //         return "$value = :$value";
        //     }, array_keys($fields));

        //     $sql = "UPDATE INB_ORDER_PICKS"
        //         . " SET " . implode(", ", $sets)
        //         . "  WHERE ProductCode = :ProductCode AND SalesOrderNumber=:SalesOrderNumber";



        //     $stmt = $this->conn->prepare($sql);

        //     $stmt->bindValue(":SalesOrderNumber", $data["SalesOrderNumber"], PDO::PARAM_STR);
        //     $stmt->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_STR);

        //     foreach ($fields as $SalesOrderNumber => $values) {
        //         $stmt->bindValue(":$SalesOrderNumber", $values[0]);
        //         // print_r($stmt);
        //     }

        //     // exit;
        //     $stmt->execute();

        //     // return $stmt->rowCount();
        //     return "done";
        // };
        // ---

        // } // else closer
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
