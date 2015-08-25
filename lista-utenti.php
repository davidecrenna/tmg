<?php
require_once "config/config_all.php";
		
include("config/db_config.inc.php");

$q = $_GET['term'];

$mysqli = new mysqli(DB_HOST, DB_USER , DB_PASSWORD, DB_DATABASE);

/* check connection */
if (mysqli_connect_errno()) {
	$error_message=ERROR_GET_UTENTI;
}
	
$query = "SELECT * FROM ".USER_TABLE." WHERE `Nome` LIKE '".$q."%' OR `Cognome` LIKE '".$q."%' OR `Username` LIKE '".$q."%' ";

$result = $mysqli->query($query);

$resArray = array();

/* associative array */
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$query2 = "SELECT * FROM ".USER_DATA_TABLE." WHERE id_user = ".$row['ID'];
	$result2 = $mysqli->query($query2);
	$row2 = $result2->fetch_array(MYSQLI_ASSOC);
	///if($row2['findinhome']==1){
		$insertRow = array('label' => $row['Username']);
		array_push($resArray,$insertRow);
	//}
	$result2->close();
}

echo json_encode($resArray);

$result->close();
$mysqli->close();
?>