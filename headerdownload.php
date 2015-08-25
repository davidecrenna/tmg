<?php
	
	require_once "phpuploader/include_phpuploader.php";
	session_start();
	require_once "lang/Globals_lang_it.php";
	require_once "config/config_all.php";
	
	include("config/db_config.inc.php");
	
	require_once "tcpdf_min/tcpdf.php";
	require_once "fpdi/fpdi.php";
	require_once "card/Class/SimpleImage.php";
	require_once "card/Class/main.php";
	require_once "card/Class/CreateZipFile.inc.php";
	
	//classe necessaria a salvare le vcards nel db o a creare un file vcard
	require_once("card/Class/storevcard.php");
	
	//classe necessaria a fare il parsing di un file vcard
	require_once("card/Class/readvcard.php");
	
?>