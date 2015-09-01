<?php	
	require_once "lang/Globals_lang_it.php";
		
	
	//require_once "tcpdf/config/lang/eng.php";
	require_once "tcpdf_min/tcpdf.php";
	require_once "fpdi/fpdi.php";
	
	//AREA CLASS --------------------------------------------------------------------------------
	require_once "area/Class/main.php";
	//END AREA CLASS ----------------------------------------------------------------------------
	
	//CARD CLASS --------------------------------------------------------------------------------
	require_once "card/Class/SimpleImage.php";
	require_once "card/Class/main.php";
	require_once "card/Class/uploader.php";
	require_once "card/Class/login.php";
	require_once "card/Class/CreateZipFile.inc.php";
	//classe necessaria a salvare le vcards nel db o a creare un file vcard
	require_once("card/Class/storevcard.php");
	//classe necessaria a fare il parsing di un file vcard
	require_once("card/Class/readvcard.php");
	require_once "card/Class/iscrizione.php";
	require_once "card/Class/favicon.inc.php";
	require_once "card/Class/secure_login_class.php";
	//END CARD CLASS -----------------------------------------------------------------------------

	require_once 'card/php/PasswordLib/PasswordLib.phar';
	require_once('PHPMailer/class.phpmailer.php');
	require_once('httpsocket/httpsocket.php');
?>