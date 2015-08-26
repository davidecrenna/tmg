<?
interface AreaDatabase
{
	function Get_admin_data(&$admin);
	function Get_all_users(&$users);
	function verifica_login($email,$password_utente,$sfida);
	function invia_sfida_area($sfida,$email);
	function Elimina_sfida($email);
	function Create_temp_user($username,$nome_utente,$cognome_utente,$password,$email,$id_referente,$idTransazione,$is_society,$is_giovane,$codfiscale,$alt_url);
	function Ctrlusernotexists($username);
	function Ctrlemailnotexists($email);
	function Getidreferente($username_referente);
	function Insert_new_panel_log($type, $fromID,$toID, $email,$refer_id);
	function Insert_new_fattura($user_id,$data,$ammount);
	function Get_panel_log($log_id);
	function Block_user($user_id);
	function Get_panel_logs(&$logs,$num);
	function Get_users_transactions(&$transactions,$num);
	function Insert_new_user_transaction($type, $value, $fromID, $toID,$nomebeneficiario, $iban,$codfis, $swift);
	function Update_promoter_table($value,$user_id);
	function Get_users_assistenza(&$assistenza,$num);
	function Get_users_abuso(&$abuso,$num);
	function Do_process_users_transaction($transaction);
	function Get_sub_users($user_id);
	function Get_all_sub_users();
	function Get_promoter_table($user_id);
	function Do_delete_sub_user($username);
	function Change_user_status($user_id,$status);
	function Set_account_deleted_from_admin($user_id);
}

class AreaMySqlDatabase implements AreaDatabase{
	private	$db_host = DB_HOST;
	private $db_user = DB_USER;
	private $db_password = DB_PASSWORD;
	private $db_database = DB_DATABASE;
	
	public function Get_all_users(&$users){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".USER_TABLE;
		$result = $mysqli->query($query);
		if($result==NULL){
			$error_msg = "Database error in [page].php / "; 
			$error_msg .= $mysqli->errno." / "; 
			$error_msg .= $query; 
			$this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   	
		}
		
		for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
			$users[$i]=$row;
		}
		
	}
	
	public function Get_admin_data(&$admin){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT ID,Cognome FROM ".USER_ADMIN_TABLE;
		$result = $mysqli->query($query);
		if($result==NULL){
			$error_msg = "Database error in [page].php / "; 
			$error_msg .= $mysqli->errno." / "; 
			$error_msg .= $query; 
			$this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   	
		}
		
		for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
			$admin[$i]["id"]=$row["ID"];
			$admin[$i]["cognome"]=$row["Cognome"];
		}
		
	}
	public function Get_control_mail(&$control_email){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT email FROM ".ADMIN_PANEL_CTRL_MAIL;
		$result = $mysqli->query($query);
		if($result==NULL){
			$error_msg = "Database error in [page].php / "; 
			$error_msg .= $mysqli->errno." / "; 
			$error_msg .= $query; 
			$this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   	
		}
		
		for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
			$control_email[$i]["id"]=$row["ID"];
			$control_email[$i]["email"]=$row["email"];
		}
	}
	
	public function invia_sfida_area($sfida,$email){
		 /* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		//$mysqli->set_charset('utf8');
		
		/* check connection */
		if (mysqli_connect_errno()) {
			$this->UpdateLog ( ERR_DB_CONNECTION. "on Update_curriculum()",DB_ERROR_LOG_FILE);
		}
		$stmt = $mysqli->prepare("UPDATE ".USER_ADMIN_TABLE." SET sfida_corrente=? WHERE Email=?");
		/* bind parameters for markers */
		$stmt->bind_param("ss",$sfida,$email);
		
		$stmt->execute();
		
		$stmt->close();
		/* close connection */
		$mysqli->close();
	}
	
	public function Elimina_sfida($email){
		 /* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		//$mysqli->set_charset('utf8');
		
		/* check connection */
		if (mysqli_connect_errno()) {
			$this->UpdateLog ( ERR_DB_CONNECTION. "on Update_curriculum()",DB_ERROR_LOG_FILE);
		}
		$stmt = $mysqli->prepare("UPDATE ".USER_ADMIN_TABLE." SET sfida_corrente=NULL WHERE Email=?");
		/* bind parameters for markers */
		$stmt->bind_param("s",$email);
		
		$stmt->execute();
		
		$stmt->close();
		/* close connection */
		$mysqli->close();
	}
	
	public function Block_user($user_id){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		
		/* check connection */
		if (mysqli_connect_errno()) {
			$this->UpdateLog ( ERR_DB_CONNECTION. "on Update_curriculum()",DB_ERROR_LOG_FILE);
		}
		$stmt = $mysqli->prepare("UPDATE ".USER_TABLE." SET status='2' WHERE ".USER_TABLE_ID."=?");
		/* bind parameters for markers */
		$stmt->bind_param("i",$user_id);
		
		$stmt->execute();
		
		$stmt->close();
		/* close connection */
		$mysqli->close();
	}
	
	public function Unblock_user($user_id){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		
		/* check connection */
		if (mysqli_connect_errno()) {
			$this->UpdateLog ( ERR_DB_CONNECTION. "on Update_curriculum()",DB_ERROR_LOG_FILE);
		}
		$stmt = $mysqli->prepare("UPDATE ".USER_TABLE." SET status='0' WHERE ".USER_TABLE_ID."=?");
		/* bind parameters for markers */
		$stmt->bind_param("i",$user_id);
		
		$stmt->execute();
		
		$stmt->close();
		/* close connection */
		$mysqli->close();
	}
	public function Change_user_status($user_id,$status){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		
		/* check connection */
		if (mysqli_connect_errno()) {
			$this->UpdateLog ( ERR_DB_CONNECTION. "on Update_curriculum()",DB_ERROR_LOG_FILE);
		}
		$stmt = $mysqli->prepare("UPDATE ".USER_TABLE." SET status=?,remove_date=NULL WHERE ".USER_TABLE_ID."=?");
		/* bind parameters for markers */
		$stmt->bind_param("ii",$status,$user_id);
		
		$stmt->execute();
		
		$stmt->close();
		/* close connection */
		$mysqli->close();
	}
	public function Set_account_deleted_from_admin($user_id){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		
		/* check connection */
		if (mysqli_connect_errno()) {
			$this->UpdateLog ( ERR_DB_CONNECTION. "on Update_curriculum()",DB_ERROR_LOG_FILE);
		}
		$today = date("Y/m/d");
		
		$date_added = strtotime('+8 day',strtotime($today));
		$date_added = date ( 'Y/m/d' , $date_added );
					
		$datetime = $date_added.' '.date('H:i:s') ;
		$status=4;
		$stmt = $mysqli->prepare("UPDATE ".USER_TABLE." SET status=?,remove_date=? WHERE ".USER_TABLE_ID."=?");
		/* bind parameters for markers */
		$stmt->bind_param("isi",$status,$datetime,$user_id);
		
		$stmt->execute();
		
		$stmt->close();
		/* close connection */
		$mysqli->close();
	}
	public function verifica_login($email,$password_utente,$sfida){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		//$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		
		$query = "SELECT ID,Nome,Cognome FROM ".USER_ADMIN_TABLE." WHERE Email='".$email."' AND sfida_corrente='".$sfida."' AND MD5(CONCAT('".$sfida."',Password))='".$password_utente."'";
		$result = $mysqli->query($query);
		if($result==NULL){
			$error_msg = "Database error in [page].php / "; 
			$error_msg .= $mysqli->errno." / "; 
			$error_msg .= $query; 
			$this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   	
		}

		/* associative array */
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if($row==NULL){
			/* free result set */
			$result->close();
			
			/* close connection */
			$mysqli->close();
			return false;
		}else{
			/* free result set */
			$result->close();
			/* close connection */
			$mysqli->close();
			return array("ID" => $row["ID"],"Cognome" => $cognome = $row["Cognome"],"Nome" => $row["Nome"]);
		}
			
		
	}
	public function Create_temp_user($username,$nome_utente,$cognome_utente,$password,$email,$id_referente,$idTransazione,$is_society,$is_giovane,$codfiscale,$alt_url){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		
		/* create a prepared statement */
		$stmt = $mysqli->prepare("INSERT INTO ".USER_TEMP_TABLE." (Username,Nome,Cognome,Password,Email,ID_Referente,idTransazione,society,is_giovane,codfiscale,alternative_url) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		/* bind parameters for markers */
		$stmt->bind_param("sssssisiiss",$username,$nome_utente,$cognome_utente,$password,$email,$id_referente,$idTransazione,$is_society,$is_giovane,$codfiscale,$alt_url);
		$stmt->execute();
		$stmt->close();
		/* close connection */
		$mysqli->close();	
	}
	public function Ctrlusernotexists($username){
		//controllo che l'utente non sia già presente nel DB
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
	
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		
		$query = "SELECT Username FROM ".USER_TABLE." WHERE Username = '$username'";
		$result = $mysqli->query($query);
		/* associative array */
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		/* close connection */
		$result->close();
		$mysqli->close();
		if($row==NULL){
			return true;	
		}else{
			return false;	
		}
	}
	
	 public function Ctrlemailnotexists($email){
		//controllo che l'utente non sia già presente nel DB
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
	
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		
		$query = "SELECT Email FROM ".USER_TABLE." WHERE Email = '$email'";
		$result = $mysqli->query($query);
		/* associative array */
		$row = $result->fetch_array(MYSQLI_ASSOC);
		/* close connection */
		$result->close();
		$mysqli->close();
		if($row==NULL){
			return true;	
		}else{
			return false;	
		}
	 }
	 
	 public function Getidreferente($username_referente){
		//controllo che l'utente non sia già presente nel DB
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
	
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT ".USER_TABLE_ID." FROM ".USER_TABLE." WHERE Username = '$username_referente'";
		$result = $mysqli->query($query);
	
		/* associative array */
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row['ID'];
		/* close connection */
		$mysqli->close();
	}
	
	
	
	public function Insert_new_user_transaction($type, $value, $fromID, $toID,$nomebeneficiario, $iban,$codfis, $swift){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$datetime =date("Y/m/d").' '.date('H:i:s') ;
		/* create a prepared statement */
		$stmt = $mysqli->prepare("INSERT INTO ".USER_TRANSACTION_TABLE." (type,datetime,value,nomebeneficiario,iban,codfis,swift,fromID,toID) VALUES (?,?,?,?,?,?,?,?,?)");
		/* bind parameters for markers */
		$stmt->bind_param("isissssii",$type,$datetime,$value,$nomebeneficiario, $iban,$codfis, $swift,$fromID,$toID);
		$stmt->execute();
		$stmt->close();
		$transaction_id = $mysqli->insert_id;
		/* close connection */
		$mysqli->close();
		return $transaction_id;
	}
	
	public function Update_promoter_table($value,$user_id){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".USER_PROMOTER_TABLE." WHERE id_user= '".$user_id."'";
		$result = $mysqli->query($query);
		if($result==NULL){
			$error_msg = "Database error in [page].php / "; 
			$error_msg .= $mysqli->errno." / "; 
			$error_msg .= $query; 
			$this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   	
		}

		/* associative array */
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if($row==NULL){
		}else{
			$total_ammount = $row["total_ammount"];
		}
		
		//incremento di $value la colonna total_ammount
		$total_ammount=$total_ammount+$value;
		
		$stmt = $mysqli->prepare("UPDATE ".USER_PROMOTER_TABLE." SET total_ammount=? WHERE id_user=?");
		
		/* bind parameters for markers */
		$stmt->bind_param("ii", $total_ammount, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	public function Insert_new_panel_log($type, $fromID, $toID, $email, $refer_id=NULL){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$datetime =date("Y/m/d").' '.date('H:i:s') ;
		/* create a prepared statement */
		$stmt = $mysqli->prepare("INSERT INTO ".ADMIN_PANEL_LOG." (type,from_id,to_id,email,data,refer_id) VALUES (?,?,?,?,?,?)");
		/* bind parameters for markers */
		$stmt->bind_param("iiissi",$type,$fromID,$toID,$email,$datetime,$refer_id);
		$stmt->execute();
		$stmt->close();
		$log_id = $mysqli->insert_id;
		/* close connection */
		$mysqli->close();
		return $log_id;
	}
	
	public function Insert_new_fattura($user_id,$data,$ammount){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$datetime = date("Y/m/d H:i:s",strtotime($data));
		/* create a prepared statement */
		$stmt = $mysqli->prepare("INSERT INTO ".FATTURE." (id_user,datetime,ammount) VALUES (?,?,?)");
		/* bind parameters for markers */
		$stmt->bind_param("isi",$user_id,$datetime,$ammount);
		$stmt->execute();
		$stmt->close();
		$fattura_id = $mysqli->insert_id;
		/* close connection */
		$mysqli->close();
		return $fattura_id;
	}
	
	public function Get_panel_log($log_id){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".ADMIN_PANEL_LOG." WHERE ID= '".$log_id."'";
		$result = $mysqli->query($query);
		if($result==NULL){
			$error_msg = "Database error in [page].php / "; 
			$error_msg .= $mysqli->errno." / "; 
			$error_msg .= $query; 
			$this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   	
		}

		/* associative array */
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$log['type'] = $row["type"];
		$log['from_id'] = $row["from_id"];
		$log['to_id'] = $row["to_id"];
		$log['email'] = $row["email"];
		$log['data'] = $row["data"];
			
		$mysqli->close();
		return $log;
	}
	public function Get_panel_logs(&$logs,$num){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".ADMIN_PANEL_LOG." ORDER BY data DESC LIMIT ".$num;
		$result = $mysqli->query($query);
		if($result==NULL){
			$error_msg = "Database error in [page].php / "; 
			$error_msg .= $mysqli->errno." / "; 
			$error_msg .= $query; 
			$this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   	
		}

		/* associative array */
		for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
			$logs[$i] = $row;
		}
			
		$mysqli->close();
	}
	public function Get_users_transactions(&$transactions,$num){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".USER_TRANSACTION_TABLE." ORDER BY datetime DESC LIMIT ".$num;
		$result = $mysqli->query($query);
		if($result==NULL){
			$transactions = NULL;  	
		}else{
			for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
				$transactions[$i] = $row;
			}
		}
			
		$mysqli->close();
	}
	public function Get_users_assistenza(&$assistenza,$num){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".USER_ASSISTENZA_TABLE." ORDER BY datetime DESC LIMIT ".$num;
		$result = $mysqli->query($query);
		if($result==NULL){
			$assistenza = NULL;  	
		}else{
			for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
				$assistenza[$i] = $row;
			}
		}
			
		$mysqli->close();
	}
	
	public function Get_sub_users($user_id){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".SUB_USER_TABLE." WHERE id_referente = '".$user_id."' ORDER BY data DESC ";
		$result = $mysqli->query($query);
		if($result==NULL){
			$sub_users = NULL;  	
		}else{
			for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
				$sub_users[$i] = $row;
			}
		}
		$mysqli->close();
		return $sub_users;
	}
	public function Get_all_sub_users(){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".SUB_USER_TABLE." ORDER BY data DESC ";
		$result = $mysqli->query($query);
		if($result==NULL){
			$sub_users = NULL;  	
		}else{
			for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
				$sub_users[$i] = $row;
			}
		}
		$mysqli->close();
		return $sub_users;
	}
	
	public function Get_promoter_table($user_id){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".USER_PROMOTER_TABLE." WHERE id_user = '".$user_id."'";
		$result = $mysqli->query($query);
		if($result==NULL){
			$promoter = NULL;  	
		}else{
			$promoter = $result->fetch_array(MYSQLI_ASSOC);
		}
		$mysqli->close();
		return $promoter;
	}
	
	
	
	public function Do_delete_sub_user($username){
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			 $this->UpdateLog ( ERR_DB_CONNECTION. "on Insert_Contact_rows()",DB_ERROR_LOG_FILE);
		}
		
		$query="DELETE FROM ".SUB_USER_TABLE." WHERE username = ?";
		$stmt = $mysqli->prepare($query);
		if($stmt==NULL){
		  $error_msg = "Database error in [page].php / "; 
		  $error_msg .= $mysqli->errno." / "; 
		  $error_msg .= $query; 
		  $this->UpdateLog ( $error_msg , DB_ERROR_LOG_FILE );   
		}
		/* bind parameters for markers */
		$stmt->bind_param("s",$username);
		$stmt->execute();
		
		$stmt->close();
		/* close connection */
		$mysqli->close();
	}
	
	public function Get_users_abuso(&$abuso,$num){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		/* check connection */
		if (mysqli_connect_errno()) {
			$error_message= ERR_DB_CONNECTION;
		}
		$query = "SELECT * FROM ".USER_ASSISTENZA_TABLE." ORDER BY datetime DESC LIMIT ".$num;
		$result = $mysqli->query($query);
		if($result==NULL){
			$abuso = NULL;  	
		}else{
			for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
				$abuso[$i] = $row;
			}
		}
			
		$mysqli->close();
	}
	public function Do_process_users_transaction($transaction){
		/* create a prepared statement */
		$mysqli = new mysqli($this->db_host, $this->db_user , $this->db_password, $this->db_database);
		$mysqli->set_charset('utf8');
		
		/* check connection */
		if (mysqli_connect_errno()) {
			$this->UpdateLog ( ERR_DB_CONNECTION. "on Update_curriculum()",DB_ERROR_LOG_FILE);
		}
		
		
		if($transaction["type"]==1){
			$stmt = $mysqli->prepare("UPDATE ".USER_PROMOTER_TABLE." SET total_confirmed= total_confirmed + ? WHERE id_user=?");
			
			/* bind parameters for markers */
			$stmt->bind_param("ii", $transaction["value"], $transaction["toID"]);
			
			$stmt->execute();
			
			$stmt->close();
			
			
			$stmt = $mysqli->prepare("UPDATE ".USER_PROMOTER_TABLE." SET total_ammount= total_ammount - ? WHERE id_user=?");
			
			/* bind parameters for markers */
			$stmt->bind_param("ii", $transaction["value"], $transaction["toID"]);
			
			$stmt->execute();
			
			$stmt->close();
			
			$stmt = $mysqli->prepare("UPDATE ".USER_TRANSACTION_TABLE." SET processed='1' WHERE ID=?");
			/* bind parameters for markers */
			$stmt->bind_param("i",$transaction["ID"]);
			
			$stmt->execute();
			
			$stmt->close();
		
		}else if($transaction["type"]==2){//se è una trasazione di riscossione
			$stmt = $mysqli->prepare("UPDATE ".USER_PROMOTER_TABLE." SET total_confirmed= total_confirmed - ? WHERE id_user=?");
			
			/* bind parameters for markers */
			$stmt->bind_param("ii", $transaction["value"], $transaction["toID"]);
			
			$stmt->execute();
			
			$stmt->close();
			
			$stmt = $mysqli->prepare("UPDATE ".USER_PROMOTER_TABLE." SET total_payed= total_payed + ? WHERE id_user=?");
			
			/* bind parameters for markers */
			$stmt->bind_param("ii", $transaction["value"], $transaction["toID"]);
			
			$stmt->execute();
			
			$stmt->close();
			
			
			$stmt = $mysqli->prepare("UPDATE ".USER_TRANSACTION_TABLE." SET processed='1' WHERE ID=?");
			/* bind parameters for markers */
			$stmt->bind_param("i",$transaction["ID"]);
			
			$stmt->execute();
			
			$stmt->close();
		}
		
		/* close connection */
		$mysqli->close();
	}
}
?>