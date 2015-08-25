<?php
require_once("../../headerbasic.php");
include("../../header.php");
$q = strtolower($_GET["q"]);
$username=$_GET['u'];
$card= new Card(NULL,$username);

if (!$q) return;
$items = $card->Array_all_email();


$result = array();
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		array_push($result, array(
			"name" => $key,
			"to" => $value
		));
	}
}
echo json_encode($result);
?>