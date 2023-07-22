<?php

class CreatePackListGateway
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

    public function create(array $data)
    {
        $sql = "SELECT max(IdNum) as 'IdNum' FROM INB_PACK_LIST";

        $stmt = $this->conn->prepare($sql);
        // $stmt->bindValue(":PlateNumber", $so, PDO::PARAM_STR);
        $stmt->execute();

        $datax = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($datax["IdNum"])) {
            
        //   return "not empty";
          //insert
          $sqlx = "INSERT INTO INB_PACK_LIST(
           IdNum,
           packListId,
           CreatedBy,
           CreatedOn,
           PKLStatus,
           CompletedBy)
            VALUES(
            :IdNum,
            :packListId,
            :CreatedBy,
            :CreatedOn,
            :PKLStatus,
            :CompletedBy
            )";

            $stmtx = $this->conn->prepare($sqlx);

            $stmtx->bindValue(":IdNum", "1", PDO::PARAM_INT);
            $stmtx->bindValue(":packListId", "PKL1", PDO::PARAM_STR);
            $stmtx->bindValue(":CreatedBy", $data["User"], PDO::PARAM_STR);
            $stmtx->bindValue(":CreatedOn", $data["TimeStamp"] , PDO::PARAM_STR);
            $stmtx->bindValue(":PKLStatus", null, PDO::PARAM_NULL);
            $stmtx->bindValue(":CompletedBy", null, PDO::PARAM_NULL);

            $stmtx->execute();

            return "PKL1";
          //close insert
        } else {
            // return "not empty";
            $pklId="PKL".($datax["IdNum"]+1);
            $newId = $datax["IdNum"] + 1;
            $sqlx = "INSERT INTO INB_PACK_LIST(
                IdNum,
                packListId,
                CreatedBy,
                CreatedOn,
                PKLStatus,
                CompletedBy)
                 VALUES(
                 :IdNum,
                 :packListId,
                 :CreatedBy,
                 :CreatedOn,
                 :PKLStatus,
                 :CompletedBy
                 )";
     
                 $stmtx = $this->conn->prepare($sqlx);
     
                 $stmtx->bindValue(":IdNum", $newId, PDO::PARAM_INT);
                 $stmtx->bindValue(":packListId", $pklId, PDO::PARAM_STR);
                 $stmtx->bindValue(":CreatedBy", $data["User"], PDO::PARAM_STR);
                 $stmtx->bindValue(":CreatedOn", $data["TimeStamp"] , PDO::PARAM_STR);
                 $stmtx->bindValue(":PKLStatus", null, PDO::PARAM_NULL);
                 $stmtx->bindValue(":CompletedBy", null, PDO::PARAM_NULL);
     
                 $stmtx->execute();
     
                 return $pklId;
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
