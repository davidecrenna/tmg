<?php
	require_once "headerbasic.php";
	require_once 'header.php';
	$idTransazione = "YuCmPAeiy0DshRr4";
	$iscrizione = new Iscrizione($idTransazione,"none");
	$iscrizione->Create_new_user();
	$iscrizione->send_mail();
	$iscrizione->Create_user_folder();
?>