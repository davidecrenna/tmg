<?
	require_once "headerbasic.php";
	include("header.php");
	
	define('DB_HOST',"localhost");
	define('DB_USER',"topmanager_root");
	define('DB_PASSWORD',"Manolo2012");
	define('DB_DATABASE',"topmanager_db");
	
	define('USER_CONTACT_TABLE',"user_contact");
	define('USER_TABLE',"user");
	define('USER_ADMIN_TABLE',"user_admin");
	define('USER_TEMP_TABLE',"user_temp");
	define('USER_DATA_TABLE',"user_data");
	define('USER_SLIDE_TABLE',"user_slide");
	define('USER_BV_TABLE',"user_bv");
	define('USER_CURREUROP_TABLE',"user_curreurop");
	define('USER_PROMOTER_TABLE',"promoter");
	define('USER_NEWSLETTER_TABLE',"user_newsletter");
	define('USER_NEWSLETTER_GROUP_TABLE',"user_newsletter_group");
	define('MESSAGES_ATTACHMENTS_TABLE',"messages_attachments");
	define('USER_FILEBOX_TABLE',"user_filebox");
	define('USER_SIMPLE_CURR_TABLE',"user_simple_curriculum");
	define('USER_EVIDENZA_TABLE',"user_evidenza");
	
	$connessione = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	mysql_select_db(DB_DATABASE, $connessione);
	
	$query = "SELECT ID,Username FROM ".USER_TABLE;
	$result = mysql_query($query, $connessione);
	
	for($i=0;$row = mysql_fetch_array($result, MYSQLI_ASSOC);$i++){
		
		$utenti[$i]['ID'] = $row["ID"];
		$utenti[$i]['Username'] = $row["Username"];
		
		$card = new Card(NULL,$utenti[$i]['Username']);
		for($j=0;$j<count($card->news_rows);$j++){
			$card->pubblica_news($card->news_rows[$j]["id"]);
		}
	}
?>