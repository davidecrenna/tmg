<?php
    require_once "config/config_all.php";
	if(DEVELOPMENT == true){
		require_once "config/db_user_config_dev.inc.php";
		require_once "config/db_config.inc.php";
	}else{
		require_once "config/db_user_config_topmanagergroup.inc.php";
		require_once "config/db_config.crypto.inc.phpinc.php";
	}
	require_once "config/db_config.inc.php";
	
	require_once "lang/Globals_lang_it.php";
	
	require_once "phpuploader/include_phpuploader.php";
	
	require_once("basic/class/basic.php");
	$basic = new Basic();
?>