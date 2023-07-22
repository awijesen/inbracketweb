<?php include(__DIR__.'/../../dbconnect/db.php');

$output= array();
$sql = "SELECT SalesOrderNumber, OrderCustomer, Reference, ProcessedDate, CreatedBy FROM GRW_INB_SALES_ORDERS";

$totalQuery = mysqli_query($conn,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE SalesOrderNumber is not null";
	$sql .= " AND SalesOrderNumber like '%".$search_value."%'";
	// $sql .= " OR PICKFACE like '%".$search_value."%'";
	// $sql .= " OR PF_QTY like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$column_name." ".$order."";
}
else
{
	$sql .= " ORDER BY ProcessedDate desc";
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
	$sub_array = array();
	$sub_array[] = $row['SalesOrderNumber'];
	$sub_array[] = $row['OrderCustomer'];
	$sub_array[] = $row['Reference'];
	$sub_array[] = $row['ProcessedDate'];
	$sub_array[] = $row['CreatedBy'];
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
