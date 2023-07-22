<?php
session_start();
                  require(__DIR__ . '../../../dbconnect/db.php');

                  $sql = "SELECT distinct(StockTakeMode) as 'mode' FROM INB_USERMASTER where UserCode !='".$_SESSION['UCODE']."'";

                  $stmt = $conn->prepare($sql);
                  // $stmt->bind_param("s", $search);
                  // $search = $findOrder;
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['mode'];
                    }
                  } else {
                    echo "error";
                  }    ?>