<?php
	require_once("headerbasic.php");
	$basic->sec_session_start();
  	$u=$_GET['u'];
	if($u!="davidecrenna" && $u!="melixaroncari"){
		echo "LE CARD SONO ATTUALMENTE IN MANUTENZIONE FINO ALLE 24 DI LUNDEì 31-08. CI SCUSIAMO PER L'INCONVENIENTE.";
	}else{
		if($basic->Is_user($u)){
			header('Content-type: text/html;charset=utf-8');
			require_once "header.php";
			$color=$_GET['color'];
			$personal_area=$_GET['personal_area'];
			$card= new Card(NULL,$u,$color,$personal_area);
			$card->Show_card();
			
		}else{
			header("location: nouser.php");
		}
	}
?>
