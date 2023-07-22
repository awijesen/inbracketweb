<?php
?>
<select name="_upkr" id="_upkr" class="form-select">
<option value="selectpackinglist">Select Packing List</option>
<?php
require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT det.packListId, det.CustomerName
FROM INB_PACK_LIST_DETAIL det
LEFT OUTER JOIN (select PKLStatus, packListId from INB_PACK_LIST) as t on t.packListId=det.packListId 
WHERE DispatchStatus is null AND t.PKLStatus='Completed'
GROUP BY packListId";

$stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $search);
// $search = $findOrder;
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value=' . $row["packListId"] . '>' . $row["packListId"] . ' - ' . $row["CustomerName"] . '</option>';
    }
} else {
    echo "error";
}    ?>

</select>