<?
	require_once "phpuploader/include_phpuploader.php";
	session_start();
	require_once "lang/Globals_lang_it.php";
	require_once "config/config_all.php";

	include("config/db_config.inc.php");

	
	//require_once "tcpdf/config/lang/eng.php";
	require_once "tcpdf_min/tcpdf.php";
	require_once "fpdi/fpdi.php";
	require_once "card/Class/main.php";
	require_once "card/Class/uploader.php";
	require_once "area/Class/main.php";
	require_once "card/Class/CreateZipFile.inc.php";
	require_once "card/Class/iscrizione.php";
	require_once "area/Class/secure_login_class.php";
	require_once('PHPMailer/class.phpmailer.php');
	require_once('httpsocket/httpsocket.php');
?>