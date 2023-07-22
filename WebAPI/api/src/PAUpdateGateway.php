<?php

class PAUpdateGateway
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

    public function get(string $plate): array | false
    {
        $sql = "SELECT Barcode
        FROM INB_PRODUCT_MASTER
        WHERE Barcode = :Barcode";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":Barcode", $plate, PDO::PARAM_STR);
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

    public function create(array $data, string $plate): string
    { 
        $sql = "SELECT distinct(PlateNumber) FROM INB_PURCHASE_RECEIPTS WHERE PlateNumber=:Plate";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":Plate", $plate, PDO::PARAM_STR);
        $stmt->execute();
        $datax = $stmt->fetch(PDO::FETCH_ASSOC);

        if($datax === false) {
            return "no";
        } else if(count($datax) > 0 ){
            // print_r($data);
            // exit;
            $sql = "UPDATE INB_PURCHASE_RECEIPTS SET 
                    PutawayTimeStamp=:PutawayTimeStamp,
                    PutawayUser = :PutawayUser,
                    PutawayQuantity = (PutawayQuantity) + :PutawayQuantity,
                    PutawayStatus = :PutawayStatus,
                    LastPutawayQuantity = :LastPutawayQuantity,         
                    LastPutawayLocation = :LastPutawayLocation
                    WHERE PlateNumber=:PlateNumber";


                    $stmt = $this->conn->prepare($sql);

                    $stmt->bindValue(":PlateNumber", $plate, PDO::PARAM_STR);
                    $stmt->bindValue(":PutawayTimeStamp", null, PDO::PARAM_STR);
                    $stmt->bindValue(":PutawayUser", $data["PutawayUser"], PDO::PARAM_STR);
                    $stmt->bindValue(":PutawayQuantity", $data["PutawayQuantity"], PDO::PARAM_INT);
                    $stmt->bindValue(":PutawayStatus", $data["PutawayStatus"], PDO::PARAM_STR);
                    $stmt->bindValue(":LastPutawayQuantity", $data["PutawayQuantity"], PDO::PARAM_INT);
                    $stmt->bindValue(":LastPutawayLocation", $data["PutawayLocation"], PDO::PARAM_STR);

                    $stmt->execute();

                    // return $stmt->rowCount();

                    if($stmt->rowCount() > 0) {
                        $sql = "INSERT INTO INB_PURCHASE_PUTAWAY (
                            PONumber, 
                            PutawayUser, 
                            PlateNumber, 
                            ProductCode, 
                            ProductDescription, 
                            PutawayTimeStamp, 
                            PutawayQuantity, 
                            PutawayStatus, 
                            PutawayLocation, 
                            PutawayCompletedTimeStamp) 
                            VALUES(
                            :PONumber, 
                            :PutawayUser, 
                            :PlateNumber, 
                            :ProductCode, 
                            :ProductDescription, 
                            :PutawayTimeStamp, 
                            :PutawayQuantity, 
                            :PutawayStatus, 
                            :PutawayLocation, 
                            :PutawayCompletedTimeStamp
                            )";
                
                        $stmt1 = $this->conn->prepare($sql);
                
                        $stmt1->bindValue(":PONumber", $data["PONumber"], PDO::PARAM_STR);
                
                        if (empty($data["PutawayUser"])) {
                            $stmt1->bindValue(":PutawayUser", null, PDO::PARAM_NULL);
                        } else {
                            $stmt1->bindValue(":PutawayUser", $data["PutawayUser"], PDO::PARAM_STR);
                        }
                
                        $stmt1->bindValue(":PlateNumber", $data["PlateNumber"], PDO::PARAM_STR);
                
                        $stmt1->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_INT);
                
                        $stmt1->bindValue(":ProductDescription", $data["ProductDescription"], PDO::PARAM_STR);
                
                        $stmt1->bindValue(":PutawayTimeStamp", $data["PutawayTimeStamp"], PDO::PARAM_STR);
                        $stmt1->bindValue(":PutawayQuantity", $data["PutawayQuantity"], PDO::PARAM_INT);
                        $stmt1->bindValue(":PutawayStatus", $data["PutawayStatus"], PDO::PARAM_STR);
                        $stmt1->bindValue(":PutawayLocation", $data["PutawayLocation"], PDO::PARAM_STR);
                        $stmt1->bindValue(":PutawayCompletedTimeStamp", null, PDO::PARAM_STR);
                
                        $stmt1->execute();
                
                        // return $this->conn->lastInsertId();
                        if($this->conn->lastInsertId() > 0) {
                            //START
                            $sql = "INSERT INTO INB_BULK_STOCK (
                                ProductCode,
                                BulkStock,  
                                BulkLocation) 
                                VALUES(
                                :ProductCode,
                                :PutawayQuantity, 
                                :PutawayLocation)";
                    
                            $stmt2 = $this->conn->prepare($sql);
                    
                            $stmt2->bindValue(":ProductCode", $data["ProductCode"], PDO::PARAM_INT);
                            $stmt2->bindValue(":PutawayQuantity", $data["PutawayQuantity"], PDO::PARAM_INT);
                            $stmt2->bindValue(":PutawayLocation", $data["PutawayLocation"], PDO::PARAM_STR);                    
                            $stmt2->execute();
                    
                            return $this->conn->lastInsertId();
                            //END
                        }
                    }

        } else {
            return "false";
        } 
    }

    public function update(string $plate, array $data) : int
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

            $stmt->bindValue(":Picker", $plate, PDO::PARAM_INT);

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
