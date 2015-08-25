<?
	include("../../area_header.php");
	
	if (isset($_GET['__user']))
    {
		if (trim($_POST['email'])!="")
		{
			// Ritorna al client la sfida.
			$login = new classe_login($db_conn);
			echo $login->invia_sfida($_POST['email']);
		}
		exit;
    }
	
	if (isset($_GET['__submit']))
    {
		
    	if (trim($_POST['email'])!="" && trim($_POST['pwd'])!="" && trim($_POST['copia_sfida'])!="")
        {
			$login = new classe_login($db_conn);
			if ($dati = $login->verifica_login($_POST['email'],$_POST['pwd'],$_POST['copia_sfida']))
			{
				// Utente valido: inserisco i dati contenuti nel db nella sessione.
				session_regenerate_id();
				//session_start();
				
				$_SESSION['ID'] = $dati['ID'];
            	$_SESSION['Cognome'] = $dati['Cognome'];
				
				echo "<input id='admin_logged' type='hidden' value='1' />";
				$area = new Area();
				$area->Show_area();
			}
			else{
				echo "non sei loggato 1";
			}
			exit;
        }
		else{
				echo "non sei loggato 2";
		}
    //altrimenti ri-visualizza il form di login.
    }
	//--------------------------------------------------------------------------------------------------------------
	
	
	if(isset($_POST["Logout"]))
	{
		$card = new Card(NULL,$_POST["Username"]);
		$card->Logout();
		$card->Show_personal_login();
	}
		
	if(isset($_POST["Show_area_user_list"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
		 	echo $area->Show_user_list();
		}else{ 					
			//$area->Logout();
		}
	}
	if(isset($_POST["Show_area_accounting"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
		 	echo $area->Show_area_accounting();
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Show_area_logs"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
		 	$area->Show_area_logs();
		}else{ 					
			//$area->Logout();
		}
	}
	if(isset($_POST["Show_users_transactions"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
		 	$area->Show_users_transactions();
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Show_assistenza_details"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
		 	$area->Show_assistenza_details();
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Show_user_details"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$index = $_POST["index"];
		 	$area->Show_user_details($index);
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Show_log_details"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$index = $_POST["index"];
		 	$area->Show_log_details($index);
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Show_transaction_details"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$index = $_POST["index"];
		 	$area->Show_transaction_details($index);
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Show_area_create_user"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
		 	echo $area->Show_area_create_user();
		}else{ 					
			//$area->Logout();
		}
	}
	
	//eliminazione immediata da pannelo di amministrazione
	if(isset($_POST["Delete_user"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$index = $_POST["index"];
			
		 	echo $area->Delete_user($index,1);
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Change_user_status"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$userindex = $_POST["userindex"];
			$status = $_POST["status"];
			$area->Change_user_status($userindex,$status);
		}else{ 					
			//$area->Logout();
		}
	}
	
	
	if(isset($_POST["Block_user"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$index = $_POST["index"];
		 	echo $area->Block_user($index);
		}else{ 					
			//$area->Logout();
		}
	}
	if(isset($_POST["Unblock_user"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$index = $_POST["index"];
		 	echo $area->Unblock_user($index);
		}else{ 					
			//$area->Logout();
		}
	}
	
	if(isset($_POST["Create_temp_user"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			echo "\n\nSTART CREATE TEMP USER\n\n";
			
			//prelevo le variabili del form
			$nome_utente = $_POST["nome"];
			$cognome_utente = $_POST["cognome"];
			$nickname = $_POST["nickname"];
			$is_society = $_POST["is_society"];
			$is_giovane = $_POST["is_giovane"];
			$codfiscale = $_POST["codfiscale"];
			$iscardfree = $_POST["iscardfree"];
			$email = $_POST["email"];
			$username_referente = $_POST["username_referente"];
			$password = $_POST["pass"];
			$alt_url = $_POST["alt_url"];
			
			
			if($iscardfree==0){
				$iscardfree=NULL;	
			}
			
			//Se è società non può essere giovane
			if($is_society==1)
				$is_giovane==0;
			
			if($is_society==0&&$nickname=="")
				$username = correggi($nome_utente).correggi($cognome_utente);
			else
				$username = correggi($nickname);
			
			$username = strtolower($username);
			
			
			$result = Ctrlusernotexists($username);
			
			
			if($result==false){
				$error_message= "Esiste già un membro con Username: ".$username.", ripeti la registrazione cambiando Username.";
			}else{
				if($username_referente!="tmg"){
					$id_referente = $area->Getidreferente($username_referente);
				}else{
					$id_referente = 0;
					$username_referente = "TOPMANAGERGROUP";
				}
			}
			
			$idTransazione =  Generate_IDT();
			
			echo "CREAZIONE UTENTE \nUSER: ".$username."\nNOME UTENTE: ".$nome_utente."\nCOGNOME UTENTE: ".$cognome_utente."\nPASSWORD: ".$password."\nEMAIL: ".$email."\nIDREFERENTE: ".$id_referente."\nIDTRANSAZIONE: ".$idTransazione."\nè SOCIETà: ".$is_society."\nè GIOVANE: ".$is_giovane."\nCODICE FISCALE: ".$codfiscale;
			
			if($error_message==""){
				if(($username!= "")&&($email != "") && ($password != "") && ($id_referente != "") && ($codfiscale != "") && ($idTransazione != "") ){
					$area->Create_temp_user($username,$nome_utente,$cognome_utente,$password,$email,$id_referente,$idTransazione,$is_society,$is_giovane,$codfiscale,$alt_url);
					
					echo "\n\nEXECUTE CREATE TEMP USER\n\n";
				}
				else{
					$error_message=ERR_REGISTRATION_DATA;
				}
			}
		}else{ 					
			//$area->Logout();
		}
		
		if($error_message!=""){
			echo $error_message;
		}else{
			$area->Create_new_user($idTransazione,$iscardfree);
			echo "\n\nEXECUTE CREATE NEW USER\n\n";
		}
		
		echo "\n\nEND CREATE TEMP USER\n\n";
		
	}
	
	if(isset($_POST["Personal_area_riscuoti_effettuato"]))
	{
		$area = new Area();
		if($area->is_user_logged()){
			$id = $_POST["transaction_id"];
			$area->Personal_area_riscuoti_effettuato($id);
		}else{ 					
			//$area->Logout();
		}
	}
	
	function Ctrlusernotexists($username){
		//controllo che l'utente non sia già presente nel DB
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	
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
	
	
	function Generate_IDT(){
		$N_Caratteri = 16;
		$Stringa = "";
		for($I=0;$I<$N_Caratteri;$I++){
			do{
				$N = ceil(rand(48,122));
			}while(!((($N >= 48) && ($N <= 57)) || (($N >= 65) && ($N <= 90)) || (($N >= 97) && ($N <= 122))));
				
			
			$Stringa = $Stringa.chr($N);
		}
		return $Stringa;
	}
	
	function correggi($stringa) {
		$correzioni = array("À" => "A", "Á" => "A", "Â" => "A", "Ä" => "A", "Å" => "A", "Æ" => "AE", "Ç" => "C", "È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I", "Ñ" => "N", "Ò" => "O", "Ó" => "O", "Ô" => "O", "Ö" => "O", "Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U", "ß" => "ss", "à" => "a", "á" => "a", "â" => "a", "ä" => "a", "æ" => "ae", "ç" => "c", "è" => "e", "é" => "e", "ê" => "e", "ë" => "e", "ì" => "i", "í" => "i", "î" => "i", "ï" => "i", "ñ" => "n", "ò" => "o", "ó" => "o", "ô" => "o", "ö" => "o", "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "Ő" => "O", "ő" => "o", "Œ" => "OE", "œ" => "oe");
		foreach($correzioni as $chiave => $valore) {
			$stringa = str_replace($chiave, $valore, $stringa);
		}
		$stringa = eregi_replace("[[:space:]]" , "", $stringa);
		//$stringa = eregi_replace("[^a-z0-9._-]" , "", $stringa);
		$stringa = eregi_replace("[^[:alnum:]_-]" , "", $stringa);
		return $stringa;
	} 
?>