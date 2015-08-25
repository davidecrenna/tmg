<?php
class Ctrluser
{
	//DB configuration
	public	$db_host = DB_HOST;
	public $db_user = DB_USER;
	public $db_password = DB_PASSWORD;
	public $db_database = DB_DATABASE;
	private $mysql_database;
	
	public function Ctrluser(){
		$this->mysql_database = new MySqlDatabase();
	}
	public function IsUsername($user){
		return $this->mysql_database->IsUsername($user);
	}
}
?>