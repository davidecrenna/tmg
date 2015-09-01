<?php
define('DB_ERROR_LOG_FILE','../../config/db_log_file.txt');
interface BasicDatabase
{
	function Is_user($username);
	function Is_email($email);
    function Get_stmt_avatar_logged();
    function Get_main_photo_path($user_id);
	//SESSION
	function Read_stmt_session();
	function Write_stmt_session();
    function Destroy_stmt_session();
    function Garbage_stmt_session();
    function Key_stmt_session();
}
class BasicMySqlDatabase implements BasicDatabase{
	private	$db_host = DB_HOST;
	private $db_user = DB_USER;
	private $db_password = DB_PASSWORD;
	private $db_database = DB_DATABASE;
	
	private $sec_db_user = SEC_DB_USER;
	private $sec_db_password = SEC_DB_PASSWORD;
	
	private $mysqli;
	private $sec_mysqli;
	
	public function __construct() {
		  $this->mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		  $this->mysqli->set_charset('utf8');
		  if (mysqli_connect_errno()) {
			   $this->UpdateLog ( ERR_DB_CONNECTION. "Problema di connesione NORMAL USER",DB_ERROR_LOG_FILE);
		  }
		  
		  $this->sec_mysqli = new mysqli($this->db_host, $this->sec_db_user , $this->sec_db_password, $this->db_database);
		  $this->sec_mysqli->set_charset('utf8');
		  if (mysqli_connect_errno()) {
			   $this->UpdateLog ( ERR_DB_CONNECTION. "Problema di connesione SEC USER",DB_ERROR_LOG_FILE);
		  }
		  
	}
	
   public function __destruct() {
	   $thread_id = $this->mysqli->thread_id;
	   $this->mysqli->kill($thread_id);
	   $this->mysqli->close();
	   
	   $thread_id = $this->sec_mysqli->thread_id;
	   $this->sec_mysqli->kill($thread_id);
	   $this->sec_mysqli->close();
   }

    public function Get_stmt_avatar_logged(){
        $query = "SELECT Username, Password FROM ".USER_TABLE." WHERE ID = ? LIMIT 1";
        return $this->sec_mysqli->prepare($query);
    }

    public function Get_main_photo_path($user_id){
        $query = "SELECT photo_1 FROM ".USER_DATA_TABLE." WHERE id_user= ?";
        if($stmt = $this->sec_mysqli->prepare($query)){
            $stmt->bind_param('i',$user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($photo);

            $stmt->fetch();
            if($photo==NULL){
                return false;
            }else{
                return $photo;
            }
        }
    }
   
   public function Is_user($username){
	 $query = "SELECT Username FROM ".USER_TABLE." WHERE Username= ?";
	 if($stmt = $this->sec_mysqli->prepare($query)){
		$stmt->bind_param('s',$username);
		$stmt->execute();
		$stmt->store_result();
    	$stmt->bind_result($user);

		 $stmt->fetch();
		 if($user==NULL){
             return false;
		  }else{
             return true;
		 }
	  }
   }
	public function Is_email($email){
		$query = "SELECT Username FROM ".USER_TABLE." WHERE Email= ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
			$stmt->bind_param('s',$email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($user);

			$stmt->fetch();
			if($user==NULL){
                return false;
			}else{
                return $user;
			}
		}
	}

   
   //SESSION
   public function Read_stmt_session(){
	   return $this->mysqli->prepare("SELECT data FROM ".SESSION." WHERE id = ? LIMIT 1");
   }
   public function Write_stmt_session(){
	   return $this->mysqli->prepare("REPLACE INTO ".SESSION." (id, set_time, data, session_key) VALUES (?, ?, ?, ?)");
   }
   public function Destroy_stmt_session(){
	   return $this->mysqli->prepare("DELETE FROM ".SESSION." WHERE id = ?");
   }
   public function Garbage_stmt_session(){
	   return $this->mysqli->prepare("DELETE FROM ".SESSION." WHERE set_time < ?");
   }
   public function Key_stmt_session(){
	   return $this->mysqli->prepare("SELECT session_key FROM ".SESSION." WHERE id = ? LIMIT 1");
   }
   
   
   
   
   function UpdateLog ( $string , $logfile )  { 
	   $fh = fopen ( $logfile , 'a' ); 
	   fwrite ( $fh ,"\r\n".strftime('%Y-%m-%d %H:%M:%S')." ".$string."\n"); 
	   fclose ( $fh ); 
	}
   
}

?>