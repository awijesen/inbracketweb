<?php include('../../dbconnect/db.php');

$output= array();
$sql = "SELECT
o.SalesOrderNumber,
o.OrderCustomer,
o.Reference,
o.OrderValue,
o.ShipDay,
o.ProcessedDate,
o.CreatedOn,
o.CreatedBy
FROM GRW_INB_SALES_ORDERS o
GROUP BY o.SalesOrderNumber";

$totalQuery = mysqli_query($conn,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	// $sql .= " ";
	$sql .= " HAVING (OrderCustomer LIKE '%".$search_value."%'";
	$sql .= " OR Reference LIKE '%".$search_value."%'";
	$sql .= " OR ShipDay LIKE '%".$search_value."%'";
	$sql .= " OR CreatedBy LIKE '%".$search_value."%')";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$column_name." ".$order."";
}
else
{
	$sql .= " ORDER BY ProcessedDate DESC";
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
	if($row['ShipDay'] == '5 Friday Fortnightly') {
		$sday = 'Fri Fort..';
	} else if($row['ShipDay'] == '1 Monday Fortnightly') {
		$sday = 'Mon Fort..';
	} else if($row['ShipDay'] == '2 Tuesday Fortnightly') {
		$sday = 'Tue Fort..';
	} else if($row['ShipDay'] == '3 Wednesday Fortnightly') {
		$sday = 'Wed Fort..';
	} else if($row['ShipDay'] == '4 Thursday Fortnightly') {
		$sday = 'Thu Fort..';
	} else if($row['ShipDay'] == '1 Monday') {
		$sday = 'Mon';
	} else if($row['ShipDay'] == '2 Tuesday') {
		$sday = 'Tue';
	} else if($row['ShipDay'] == '3 Wednesday') {
		$sday = 'Wed';
	} else if($row['ShipDay'] == '4 Thursday') {
		$sday = 'Thu';
	} else if($row['ShipDay'] == '5 Friday') {
		$sday = 'Fri';
	} else if($row['ShipDay'] == 'NATS') {
		$sday = 'NATS';
	} else if($row['ShipDay'] == 'Special') {
		$sday = 'Special';
	} else {
		$sday = $row['ShipDay'];
	}
	
	strlen($row['OrderCustomer']) > 30 ? $newcust=substr($row['OrderCustomer'], 0, 30) . '...' : $newcust=$row['OrderCustomer'];

	// $row['SortCodeDescription'] == 'C' ? $segment = '<i class="fas fa-circle" style="font-size:8px; color: rgb(9, 87, 189)"></i>' : $segment=null;
	$row["Picker"] == '' || $row['Picker'] == null || $row['Picker'] == 'Schedule'? $pickerassigned = "<span class='badge' style='background-color: var(--falcon-blue)'>Schedule</span>" : $pickerassigned = $row["Picker"];
	$sub_array = array();
	$sub_array[] = '<label class="switch"><input type="checkbox" value='. $row['SalesOrderNumber'] .' name="id[]"><span class="slider"></span></label>';
	$sub_array[] = "<a href='../so-detail/index.php?link=".$row['SalesOrderNumber']."' class='orderRef_' id=".$row['SalesOrderNumber'].">".$row['SalesOrderNumber']."</a>";
	$sub_array[] = '-';
	$sub_array[] = $pickerassigned;
	$sub_array[] = $newcust;
	$sub_array[] = $row['Reference'];
	$sub_array[] = $row['OrderValue'];
	$sub_array[] = $sday;
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
