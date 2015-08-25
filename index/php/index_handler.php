<?php
	require_once("../../headerbasic.php");
	include("../../header.php");
	
	if (isset($_POST['logged_control']))
    {
		$mysql_database = new MySqlDatabase();
		if(isset($_COOKIE["resta_collegato"])){
			$username = $mysql_database->Get_username_from_cookie($_COOKIE["resta_collegato"]);
			if($username!= false)
				$json_string = json_encode(array("logged"=>"true","username"=>$username));
			else
				$json_string = json_encode(array("logged"=>"false"));
		}else{
			$json_string = json_encode(array("logged"=>"false"));
		}
		echo $json_string;
		return;
    }
	if (isset($_POST['Show_login']))
    {
		$login = new Login();
        echo $login->Show_login_home_banner();
    }
?>