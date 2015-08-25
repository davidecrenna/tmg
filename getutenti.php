<?php
	require_once "headerbasic.php";
	include("header.php");
	include("isuser.php");
	include("lang/Globals_lang_it.php");
	
	$username = $_POST["referente"];
	if(($basic->Is_user($username)==true)||($username=="tmg")||($username=="TMG")){
		echo 1;	
	}else{
		echo 0;
	}
?>