<?php
include("database.php");
class Basic {
    public $userdata = array();
	//DB configuration
	private $mysql_database;
	public function __construct() {
        $this->mysql_database = new BasicMySqlDatabase();

		 // set our custom session functions.
		 session_set_save_handler(array($this, 'open_session'), array($this, 'close_session'), array($this, 'read_session'), array($this, 'write_session'), array($this, 'destroy_session'), array($this, 'gc_session'));
	   
		 // This line prevents unexpected effects when using objects as save handlers.
		 register_shutdown_function('session_write_close');
	}
	
    public function __destruct() {
    
	}
   /*
	* PUBLIC FUNCTION: Show_header()
	* DESCRIPTION: Video printing of the main header
	* PARAMS: ---
	* RETURN: ---
	*/
	public function Show_header($is_card){
        $this->userdata = $this->Get_user_logged();
			 echo '<div id="tmgheader" class="tmgheader" align="center">
			 		<div class="tmgheader_container">
						<div class="tmgheader_logo">';
						if($is_card)
							echo '<a href="../index.php">'; 
						else
							echo '<a href="index.php">';
						echo '
							<img src="../../image/banner/logo_headertmg.png" id="tmgheader_logo_img" alt="Logo Topmanagergroup.com" title="Logo Topmanagergroup.com"/></a>
						</div>';
						if($is_card)
							echo '<div class="tmgheader_actions_card">';
						else
							echo '<div class="tmgheader_actions">';
						
						echo '
							<div id="menu_avatar_container" class="triggers_personal">';
								$this->Show_menu_avatar($is_card);
							echo '</div>';
							if(!$this->userdata["username"]){
								if($is_card){
									echo '
										<div class="ti_piace_la_card">
											<a href="../index.php?tab=iscrizione&u='.$this->userdata["username"].'" class="banner_right_text">
												Ti piace la card?<br/>
												Crea la tua gratis.
											</a>
										 </div>';
									}else{
										echo '
										<div class="iscriviti">
											<a href="../index.php?tab=iscrizione" class="banner_right_text">
												Iscriviti gratis </br>
												Crea la tua card
											</a>
										 </div>
										';
								}
							}
							 
					echo'						
						</div>
					</div>
		 		</div> ';
			if(!$is_card)
				$this->Show_overlay_login();
	}
	
	
	public function Show_overlay_login(){
		echo '<div class="apple_overlay_login" id="login">
				<div class="scrollable vertical_personal">
					 <div class="item_personal" id="area_login"></div>
				</div>
			 </div>';
	}
	public function Show_Login($prepath="",$in_login=NULL,$password=NULL,$error_messsage=NULL,$login_attempt=NULL){
		echo "<div class='login_container'>
			<div class='login_content_container' id='login_container'>
				LOGIN
			</div>
			<div class='login_label'>NOME UTENTE</div>";
			echo '<input type="text" name="login_user" id="login_user" class="login_input" value="" onchange="Javascript:Login_request_sfida(\''.$prepath.'\')" />';
			echo "<div class='login_label'>PASSWORD</div>";
			echo '<input type="password" class="login_input" name="login_pwd" id="login_pwd" onkeydown="PressioneLogin(event)" value="" />';
			echo "
			<div class='styledbutton grey login_button' onclick='Javascript:Login_submit(\"".$prepath."\")'>
				<span class='text14px'>LOGIN</a>
			</div>
			 <div class='ajax_login' id='ajax_login'></div>
			<div class='login_img'></div>
		</div>
		";
		echo "<input type='hidden' name='copia_sfida' id='copia_sfida'>";
		echo '<input type="hidden" name="pwd_codified" id="pwd_codified" value="" />';
	}
	
	/*
	* PUBLIC FUNCTION: Show_menu_avatar($is_card)
	* DESCRIPTION: Print the avatar menu
	* PARAMS: boolean $is_card
	* RETURN: boolean value
	*/
	public function Show_menu_avatar($is_card=true){
        $this->userdata = $this->Get_user_logged();
		if(!$this->userdata){
            echo '<input type="hidden" value="" id="avatar_username" />';
			if(!$this->Is_mobile()||($is_card && $this->userdata["username"]== "davidecrenna")){
				if($is_card){
					echo '<span id="triggers_personal">
							<a rel="#personal_area" style="color:#000">
								<div class="card_menu_avatar_text">
									PERSONAL AREA
								</div>	
								<div class="card_menu_avatar_icon">
									<img src="../../image/icone/icona_user.png" style="width:32px; height:32px; vertical-align:middle;" alt="Accesso Personal Area." title="Login." />
								</div> 
																						
							</a>
						  </span>';
				}else{
					echo '<span id="overlay_login"><a rel="#login" style="color:#000">
						<img src="../../image/icone/icona_user.png" style="width:32px; height:32px; vertical-align:middle;" alt="Accesso Personal Area." title="Login." /> LOGIN															
					</a></span>';	
				}
			}
		}else{
            echo '<input type="hidden" value="'.$this->userdata["username"].'" id="avatar_username" />';
			echo '<ul class="avatar_header_menu">
					<li>
						<div class="header_button_utente">';
							echo '<img src="../../'.USERS_PATH.$this->userdata["username"].'/'.USER_PHOTO_PATH.'main/'.$this->userdata["photo"].'" alt="Avatar Utente." title="Avatar '.$this->userdata["username"].'." class="avatar_utente" /> &nbsp;&nbsp;'.strtoupper($this->userdata["username"]).'
						';
			
						echo '</div>
						<ul class="sub">
							<li>';
                                if($is_card)
                                    echo '<a onclick="Logout(\'../\')" style="color:#000">';
                                else
                                    echo '<a onclick="Logout(\'\')" style="color:#000">';
                                echo '
									<div class="avatar_header_menu_element"><img src="../../image/icone/logout.png" style="width:28px; height:28px; vertical-align:middle;" alt="Logout." title="Logout utente." /> LOGOUT					</div>
								</a>
							</li>
							<li>
								<span id="triggers_personal">';
								    if($is_card)
									    echo '<a rel="#personal_area" style="color:#000">';
                                    else
                                        echo '<a href="'.$this->userdata["username"].'/personal_area" style="color:#000">';
										echo '<div class="avatar_header_menu_element">
											<img src="../../image/icone/icona_user.png" style="width:28px; height:28px; vertical-align:middle;" alt="Accesso Personal Area." title="Login." /> PERSONAL AREA															
										</div>
									</a>
								</span>
							</li>            
						</ul>    
					</li>
				</ul>';
		}
		
	}
	/*
	* PUBLIC FUNCTION: Is_user($username)
	* DESCRIPTION: Return if a user exists or not in the DB
	* PARAMS: string $username
	* RETURN: boolean value
	*/
    public function Is_user($username){
		return $this->mysql_database->Is_user($username);
	}

	/*
	* PUBLIC FUNCTION: Is_email($email)
	* DESCRIPTION: Return if a email exists or not in the DB
	* PARAMS: string $email
	* RETURN: boolean value
	*/
	public function Is_email($email){
		return $this->mysql_database->Is_email($email);
	}

	/*
	* PUBLIC FUNCTION: Print_phpinfo()
	* DESCRIPTION: Print Server's php info 
	* PARAMS: ---
	* RETURN: ---
	*/
	public function Print_phpinfo(){
		echo phpversion();	
	}
	
	
	
	public function Get_user_logged(){
		// Verifica che tutte le variabili di sessione siano impostate correttamente
		if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
			$user_id = $_SESSION['user_id'];
			$login_string = $_SESSION['login_string'];
			$username = $_SESSION['username'];
			$user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.
			if ($stmt = $this->mysql_database->Get_stmt_avatar_logged()) {
				$stmt->bind_param('i', $user_id); // esegue il bind del parametro '$user_id'.
				$stmt->execute(); // Esegue la query creata.
				$stmt->store_result();

				if($stmt->num_rows == 1) { // se l'utente esiste
					$stmt->bind_result($db_username, $db_password); // recupera le variabili dal risultato ottenuto.
					$stmt->fetch();
					$login_check = hash('sha512', $db_password.$user_browser);
					if($login_check == $login_string) {
						// Login eseguito!!!!
                        $data["username"] = $db_username;
                        $data["photo"] = $this->mysql_database->Get_main_photo_path($user_id);
						return $data;
					} else {
						//  Login non eseguito
						return false;
					}
				} else {
					// Login non eseguito
					return false;
				}
			} else {
				// Login non eseguito
				return false;
			}
		} else {
			// Login non eseguito
			return false;
		}
	}
	
	/*
	* PUBLIC FUNCTION: Is_mobile()
	* DESCRIPTION: Determine if user agent is mobile device
	* PARAMS: ---
	* RETURN: boolean value
	*/
	public function Is_mobile(){
		$useragent=$_SERVER['HTTP_USER_AGENT'];

		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
				return true;
			else
				return false;
		
	}
	
	//SESSION START ----------------------------------------------------------------------------------------
	/*
	* PUBLIC FUNCTION: Sec_session_start() 
	* DESCRIPTION: Start secure sessions
	* PARAMS: ---
	* RETURN: ---
	*/
	public function Sec_session_start() {
        $session_name = SESSION_NAME; // Imposta un nome di sessione
        $secure = false; // Imposta il parametro a true se vuoi usare il protocollo 'https'.
        $httponly = true; // Questo impedirà ad un javascript di essere in grado di accedere all'id di sessione.
	   // Hash algorithm to use for the session. (use hash_algos() to get a list of available hashes.)
	   $session_hash = 'sha512';
	 
	   // Check if hash is available
	   if (in_array($session_hash, hash_algos())) {
		  // Set the has function.
		  ini_set('session.hash_function', $session_hash);
	   }
	   // How many bits per character of the hash.
	   // The possible values are '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ",").
	   ini_set('session.hash_bits_per_character', 5);
	 
	   // Force the session to only use cookies, not URL variables.
	   ini_set('session.use_only_cookies', 1);
	 
	   // Get session cookie parameters 
	   $cookieParams = session_get_cookie_params(); 
	   // Set the parameters
	   session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
	   // Change the session name 
	   session_name($session_name);
	   // Now we cat start the session
	   session_start();
	   // This line regenerates the session and delete the old one. 
	   // It also generates a new encryption key in the database. 
	   session_regenerate_id(true);

	}
	function open_session() {
	   return true;
	}
	function close_session() {
	   return true;
	}
	
	function read_session($id) {
	   if(!isset($this->read_stmt)) {
		  $this->read_stmt = $this->mysql_database->Read_stmt_session();
	   }
	   $this->read_stmt->bind_param('s', $id);
	   $this->read_stmt->execute();
	   $this->read_stmt->store_result();
	   $this->read_stmt->bind_result($data);
	   $this->read_stmt->fetch();
	   $key = $this->getkey_session($id);
	   $data = $this->decrypt_session($data, $key);
	   return $data;
	}
	
	function write_session($id, $data) {
	   // Get unique key
	   $key = $this->getkey_session($id);
	   // Encrypt the data
	   $data = $this->encrypt_session($data, $key);
	 
	   $time = time();
	   if(!isset($this->w_stmt)) {
		  $this->w_stmt = $this->mysql_database->Write_stmt_session();
	   }
	 
	   $this->w_stmt->bind_param('siss', $id, $time, $data, $key);
	   $this->w_stmt->execute();
	   return true;
	}
	
	function destroy_session($id) {
	   if(!isset($this->delete_stmt)) {
		  $this->delete_stmt = $this->mysql_database->Destroy_stmt_session();
	   }
	   $this->delete_stmt->bind_param('s', $id);
	   $this->delete_stmt->execute();
	   return true;
	}
	function gc_session($max) {
	   if(!isset($this->gc_stmt)) {
		  $this->gc_stmt = $this->mysql_database->Garbage_stmt_session();
	   }
	   $old = time() - $max;
	   $this->gc_stmt->bind_param('s', $old);
	   $this->gc_stmt->execute();
	   return true;
	}
	private function getkey_session($id) {
	   if(!isset($this->key_stmt)) {
		  $this->key_stmt = $this->mysql_database->Key_stmt_session();
	   }
	   $this->key_stmt->bind_param('s', $id);
	   $this->key_stmt->execute();
	   $this->key_stmt->store_result();
	   if($this->key_stmt->num_rows == 1) { 
		  $this->key_stmt->bind_result($key);
		  $this->key_stmt->fetch();
		  return $key;
	   } else {
		  $random_key = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		  return $random_key;
	   }
	}
	private function encrypt_session($data, $key) {
	   $salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
	   $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
	   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	   $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv));
	   return $encrypted;
	}
	private function decrypt_session($data, $key) {
	   $salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
	   $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
	   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	   $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($data), MCRYPT_MODE_ECB, $iv);
	   return $decrypted;
    }
	
	//END SESSION ------------------------------------------------------------------------------------------
}
?>