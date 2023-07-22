<?php 
session_start();

include(__DIR__. '/../../dbconnect/db.php');

$output= array();
$sql = "SELECT 
fname,
lname, 
UserCode, 
UserId,
em,
UserRole,
IsLoggedIn,
LastLoggedIn,
ActiveStatus
FROM INB_USERMASTER 
WHERE tenent_id='".$_SESSION["TID"]."'";

$totalQuery = mysqli_query($conn,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " HAVING(UserCode IS NOT NULL)";
	$sql .= " AND(fname like '%".$search_value."%'";
	$sql .= " OR lname like '%".$search_value."%'";
	$sql .= " OR UserCode like '%".$search_value."%'";
	$sql .= " OR ActiveStatus like '%".$search_value."%'";
	$sql .= " OR em like '%".$search_value."%')";
	
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$column_name." ".$order."";
}
else
{
	$sql .= " ORDER BY fname desc";
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
	if($row['LastLoggedIn'] == null) {$dateToBeInserted = '';} else {
	$dateToBeInserted = date('d-m-Y h:i a', strtotime($row['LastLoggedIn'] ?? ''));
	}
	
	if($row["UserRole"] == 'warehouse_staff'){
		$role = "Warehouse Staff";
	} else if($row["UserRole"] == 'super_admin'){
		$role = "Super Administrator";
	} else if($row["UserRole"] == 'local_manager'){
		$role = "Warehouse Manager";
	} else if($row["UserRole"] == 'local_admin'){
		$role = "Administrator";
	} else if($row["UserRole"] == 'local_non_wh_st'){
		$role = "Office Staff";
	} 

	$row["ActiveStatus"] == '' || $row['ActiveStatus'] == null || $row["ActiveStatus"] == '0' ? $astatus = "<span class='badge badge-soft-danger'; min-width: 62px !important'>Inactive</span>" : $astatus = "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success); min-width: 62px !important'>Active</span>";
	$sub_array = array();
	// $sub_array[] = "<a href='../so-detail/index.php?l=".$row['SalesOrderNumber']."' class='orderRef_' id=".$row['SalesOrderNumber'].">".$row['SalesOrderNumber']."</a>";
	// $sub_array[] = $segment;
	// $sub_array[] = $pickerassigned;
	$sub_array[] = $row['fname'];
	$sub_array[] = $row['lname'];
	$sub_array[] = $row['UserCode'];
	$sub_array[] = $row['UserId'];
	$sub_array[] = $row['em'];
	$sub_array[] = $role;
	// $sub_array[] = $row['IsLoggedIn'];
	$sub_array[] = $dateToBeInserted;
	$sub_array[] = $astatus;
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
