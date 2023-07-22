<?php 

include(__DIR__. '/../../dbconnect/db.php');

$orderToFetchto = $_POST['links'];

$output= array();
$sql = "SELECT
pk.ID, 
pk.ProductCode,
ord.ProductDescription,
pk.SalesOrderNumber,
sum(ord.OrderQuantity) as 'OrderQty',
pk.PickedQty,
pk.PickedOn,
pk.ReasonCode,
pk.PickedBy,
(SELECT distinct(l.Pricing_Tow) FROM INB_PRODUCT_MASTER l WHERE l.ProductCode=pk.ProductCode) as 'Price'
FROM INB_ORDER_PICKS pk 
LEFT OUTER JOIN GRW_INB_ASSIGNED_ORDERS ord on ord.SalesOrderNumber=pk.SalesOrderNumber and ord.ProductCode=pk.ProductCode
WHERE pk.SalesOrderNumber='".$orderToFetchto."'
GROUP BY pk.ProductCode";

$totalQuery = mysqli_query($conn,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " HAVING(ProductCode IS NOT NULL)";
	$sql .= " AND(ProductCode like '%".$search_value."%'";
	$sql .= " OR ReasonCode like '%".$search_value."%'";
	$sql .= " OR PickedBy like '%".$search_value."%'";
	$sql .= " OR ProductDescription like '%".$search_value."%')";
	
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$column_name." ".$order."";
}
else
{
	$sql .= " ORDER BY ProductCode desc";
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
	$sub_array[] = $row['OrderQty'];
	$sub_array[] = $row['PickedQty'];
	$sub_array[] = $row['ReasonCode'];
	$sub_array[] = $row['PickedOn'];
	$sub_array[] = $row['PickedBy'];
	$sub_array[] = "<a href='#' sonum='".$row['SalesOrderNumber']."' pricetag='".$row['Price']."' class='delete_this' id='".$row['ID']."' code='".$row['ProductCode']."' qty='".$row['PickedQty']."'><i class='fas fa-trash'></i></a>";
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
