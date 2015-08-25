<?php
	define("DEVELOPMENT",true);
	if(DEVELOPMENT ==true){
		define('PATH_SITO', "http://mydomain.home/");
		define('ROOT_FOLDER', "tmg/");
	}else{
		define('PATH_SITO', "http://topmanagergroup.com/");
		define('ROOT_FOLDER', "/home/topmanager/domains/www.topmanagergroup.it/public_html/");
	}
	
	//SESSION
	define('SESSION_NAME', "tmg");
	
	//SMTP SETTINGS
	define("SMTP_HOST", "mail.topmanagergroup.com");
	
	define('SERVER_IP',"81.31.155.59");
	define('SERVER_LOGIN',"topmanager");
	define('SERVER_PASS',"Manolo2012");
	define('SERVER_SSL',"Y");
	
	define('POP3_HOSTNAME',"pop3.topmanagergroup.com");
	define('POP3_PORT',110);
	
	define('USERS_PATH',"users/");
	define('USER_PHOTO_PATH',"user_photo/");
	define('USER_PHOTO_MAIN_PATH',"user_photo/main/");
	define('USER_PHOTO_TEMP_PATH',"user_photo_temp/");
	define('USER_LARGE_PHOTO_PATH',"user_photo_large/");
	define('DOWNLOAD_AREA_PHOTO',"download_area/public/photo/");
	
	//ESTENSIONI CONSENTITE
	define('ALLOWEDEXTENSION',"jpeg,jpg,gif,png,zip,doc,odt,txt,rar,rtf,xls,xlsx,ods,docx,odt,pdf,mov,mp4,mp3,wav,avi,wma,mpeg");
	//CARD MAX SPACE FOR USERS
	define('TOTAL_SIZE',2147483648);
	define('TOTAL_SIZE_GIOVANE',524288000);
	
	
	//PAYPAL SETTINGS
	define("SIMULATION", "0");
	define("SIMULATION_URL", "www.sandbox.paypal.com");
	define("PRODUCTION_URL", "www.paypal.com");
	define("PRIMARY_PAYPAL_EMAIL", "info@exporeclam.it");
	define("PRIMARY_SANDBOX_EMAIL", "luigim_1348651221_biz@hotmail.com");

	//FACEBOOK
	define('FACEBOOK_APP_ID', '188570874602009');
	define('FACEBOOK_SECRET', '5e54c11d7f0b6baedca713ddecdf4c7b');
	 
	//messages
	define("ADMIN_MAIL", "dvdcrenna@gmail.com");
	define("NO_REPLY", "no_reply@topmanagergroup.com");
	 
	define("AMMOUNT", 96.00);
	define("PROVVIGIONE", 25);
	define("VALUTA","&euro;");
?>