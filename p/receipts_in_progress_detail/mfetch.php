<?php 

include(__DIR__. '/../../dbconnect/db.php');

$orderToFetchto = $_POST['links'];

$output= array();
$sql = "SELECT
pr.ProductCode,
pr.ProductDescription,
sum(distinct(pr.ReceivedQuantity)) as 'ReceivedQuantity',
sum(distinct(ass.OrderQuantity)) as 'OrderQuantity',
pr.ReasonCode,
pr.ReceivedTimeStamp,
pr.Receiver
FROM INB_PURCHASE_RECEIPTS pr 
LEFT OUTER JOIN INB_ASSIGNED_PURCHASE_ORDERS ass on ass.PurchaseOrderNumber=pr.PONumber and ass.ProductCode=pr.ProductCode
WHERE pr.PONumber='".$orderToFetchto."'
GROUP BY pr.ProductCode";

$totalQuery = mysqli_query($conn,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " HAVING(pr.ProductCode IS NOT NULL)";
	$sql .= " AND(pr.ProductCode like '%".$search_value."%'";
	$sql .= " OR pr.ReasonCode like '%".$search_value."%'";
	$sql .= " OR Receiver like '%".$search_value."%'";
	$sql .= " OR pr.ProductDescription like '%".$search_value."%')";
	
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$column_name." ".$order."";
}
else
{
	$sql .= " ORDER BY pr.ProductCode desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($conn,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_array($query))
{
	// $row['OrderSegmentId'] == 'C' ? $segment = '<i class="fas fa-circle" style="font-size:8px; color: rgb(9, 87, 189)"></i>' : $segment=null;
	// $row["OrderPicker"] == '' || $row['OrderPicker'] == null ? $pickerassigned = "<span class='badge badge-pill badge-soft-danger'>Schedule</span>" : $pickerassigned = $row["OrderPicker"];
	$sub_array = array();
	// $sub_array[] = "<a href='../so-detail/index.php?l=".$row['SalesOrderNumber']."' class='orderRef_' id=".$row['SalesOrderNumber'].">".$row['SalesOrderNumber']."</a>";
	// $sub_array[] = $segment;
	// $sub_array[] = $pickerassigned;
	$sub_array[] = $row['ProductCode'];
	$sub_array[] = $row['ProductDescription'];
	$sub_array[] = $row['OrderQuantity'];
	$sub_array[] = $row['ReceivedQuantity'];
	$sub_array[] = $row['ReasonCode'];
	$sub_array[] = $row['ReceivedTimeStamp'];
	$sub_array[] = $row['Receiver'];
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
