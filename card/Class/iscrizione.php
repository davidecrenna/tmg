<?
class Iscrizione
{
	private $mysql_database;	
	public $nome;
	public $cognome;
	public $username;
	public $password;
	public $email;
	public $id_referente;
	public $idTransazione;
	public $paypal_email;
	public $pagina_utente;
	public $user_referente;
	public $user_id;
	public $email_referente;
	public $emailtmg_referente;
	public $nome_referente;
	public $cognome_referente;
	public $pagina_referente;
	public $data_iscrizione;
	public $society;
	public $is_giovane;
	public $codfiscale;
	public $alternative_url;
	public $status;
	
	function Iscrizione($idTransazione,$paypal_email){
		
		$this->idTransazione = $idTransazione;
		
		if($paypal_email==""||$paypal_email==NULL)
			$paypal_email="none";
		$this->paypal_email = $paypal_email;
		
		$this->mysql_database = new MySqlDatabase();
		//prelevo le informazioni dell'utente dalla temporanea
		$this->Get_from_temp();
	}
	function Get_user_referente(){
		$this->mysql_database->Get_user_referente($this->user_referente,$this->email_referente,$this->nome_referente,$this->cognome_referente,$this->id_referente);
		$this->emailtmg_referente = $this->user_referente."@topmanagergroup.com";
	}
	function Update_promoter($is_giovane,$preview=NULL){
		$this->mysql_database->Update_promoter($this->id_referente,$is_giovane,$preview);
	}
	function Update_sub_user(){
		$this->mysql_database->Update_sub_user($this->username,$this->data_iscrizione,$this->is_giovane,$this->id_referente);
	}
	function Get_from_temp(){
		$this->mysql_database->Get_from_temp($this->username,$this->nome,$this->cognome,$this->email,$this->password,$this->id_referente,$this->society,$this->is_giovane,$this->codfiscale,$this->idTransazione,$this->alternative_url); 
	}
	//iscardfree=1 se l'iscrizione proviene dall'area e quindi non devo pagare
	public function Create_new_user($preview=NULL,$iscardfree=NULL){
		$md5password = md5($this->password);
		$professione = "";
		$level = 0;
		$sfida_corrente = "";
		$this->data_iscrizione = date("Y-m-d H:i:s");
		
		echo "username: ".$this->username."<br/>";
		echo "email: ".$this->email."<br/>";
		echo "md5password: ".$md5password."<br/>";
		echo "password: ".$this->password."<br/>";
		echo "nome: ".$this->nome."<br/>";
		echo "cognome: ".$this->cognome."<br/>";
		echo "professione: ".$professione."<br/>";
		echo "idreferente: ".$this->id_referente."<br/>";
		echo "idTransazione: ".$this->idTransazione."<br/>";
		echo "level: ".$level."<br/>";
		echo "sfida corrente: ".$sfida_corrente."<br/>";
		echo "paypal_email: ".$this->paypal_email."<br/>";
		echo "data iscrizione: ".$this->data_iscrizione."<br/>";
		echo "society: ".$this->society."<br/>";
		echo "giovane: ".$this->is_giovane."<br/>";
		echo "codfis: ".$this->codfiscale."<br/>";
		echo "alternative_url: ".$this->alternative_url."<br/>";
		
		//se $preview!= NULL significa che non è stata pagata e quindi la card verrà creata in modalità non pagato
		if($preview==NULL)
			$this->status=0;
		else
			$this->status=3;

		$area = new Area();
		//creo il record del nuovo utente nella cartella user
		$this->user_id = $this->mysql_database->Create_new_user($this->username,$this->email,$md5password,$this->nome,$this->cognome,$professione,$this->id_referente,$this->idTransazione,$level,$sfida_corrente,$this->paypal_email,$this->data_iscrizione,$this->society,$this->is_giovane,$this->codfiscale,$this->status,$this->alternative_url);
		
		
		if(!empty($this->username)){
			if($this->user_id!=NULL &&$this->user_id!=0 ){
				//pagina card dell'utente
				$this->pagina_utente = PATH_SITO.$this->username."/";
				//elimino il record temporaneo
				$this->mysql_database->Delete_temp_user($this->idTransazione);
				//creo le tabelle dell'utente nel DB
				$this->mysql_database->Set_user_table($this->user_id,$this->email,$this->username);
				//creo la mail dell'utente nel server
				$this->CreateUserTmgMail();
				
				
				//Se l'id referente è valido il referente non è TMG e lo status è 0 quindi PAGATO
				if($this->id_referente!=0&&$this->status==0&&$iscardfree==NULL){
					//prendo i dati del referente
					$this->Get_user_referente();
					
					//incremento di 25 il total ammount e incremento di 1 il numero dei sub_user nella cartella PROMOTER
					$this->Update_promoter($this->is_giovane);
					
					//inserisco il record del nuovo utente nella tabella SUB_USER
					$this->Update_sub_user();
					
					//se l'utente iscritto non è giovane inserisco la PROVVIGIONE nelle transazioni, invio la mail e inserisco il log ---- creo la fattura dell'iscrizione
					if($this->is_giovane==0){
						$transaction_id = $area->Insert_new_user_transaction(1,PROVVIGIONE,$this->user_id,$this->id_referente);
						//crea la fattura e la salva nella cartella fatture
						//$area->Create_fattura_iscrizione($this->username,$this->data_iscrizione,1);
					}
				//altrimenti se l'id referente è valido il referente non è TMG e lo status è 3 quindi NON PAGATO
				}else if($this->id_referente!=0&&$this->status==3){
					//prendo i dati del referente
					$this->Get_user_referente();
					
					//inserisco il record del nuovo utente nella tabella SUB_USER
					$this->Update_sub_user();
					
					//incremento di 1 il numero dei sub_user nella cartella PROMOTER
					$this->Update_promoter($this->is_giovane,1);
					
				}else{//il referente è TMG quindi non verrà riconosciuta alcuna provvigione inoltre non ha referenti poiche il referente è TOPMANAGERGROUP
					$this->user_referente="TMG";
					$transaction_id = (-1);
				}
				$area->Send_mail_new_iscrizione($this->data_iscrizione,$this->user_id ,$this->username,$this->id_referente,$this->user_referente,$this->is_giovane,$this->status);
			}
		}else{
			echo "l'username dell'utente è vuoto";	
		}
	}
	public function printall(){
		$txt=fopen("nuova_iscrizione.txt","w");
		fwrite($txt, "\n username: ".$this->username);
		fwrite($txt, "\n nome: ". $this->nome);
		fwrite($txt, "\n cognome: ". $this->cognome);	
		fwrite($txt, "\n email: ".$this->email);	
		fwrite($txt, "\n id_referente: ".$this->id_referente);
		fclose($txt);
	}
	public function send_mail(){
		$mail = new PHPMailer(true);
		$email = $this->email;
		try { 
		  $mail->AddAddress($email,$this->username);
		  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
				  
		  $oggetto = $this->username.", ti diamo il benvenuto su TopManagerGroup.com.";
		  $mail->Subject = $oggetto;	  
		  				  
		  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				  
		  $messaggio = "<html>
				<style>
					#corpomail{
						width: 576px;
						text-align: left;
						color:#000;
					}
					body{
						font-family:'Franklin Gothic Medium';
						font-size:14px;
						background-color:#fff;
					}
					#titolo{
						font-size:20px;
					}
			
				</style>
					<body>
					<div align='center'>
						
						<div align='center'id='corpomail'> 
							<img src='".PATH_SITO."image/banner/logo_small.png' width='368' height='140' />
							<p id='titolo'>".$this->username.", ti diamo il benvenuto su TopManagerGroup.com.</p>
							<p>La prima societ&aacute; di carte d'identit&aacute; web.</p>
							Potrai visualizzare la tua carta d'identit&aacute; web all'indirizzo:<br/>
							<a href='".$this->pagina_utente."'>".$this->pagina_utente."</a><br/>
							Data iscrizione: ".date("Y-m-d H:i:s",strtotime($this->data_iscrizione))."<br/>
							E accedere alla tua personal area inserendo le seguenti credenziali:<br/>
							Username: ".$this->username."<br/>
							Email: ".$this->email."<br/>
							Password: ".$this->password."<br/>
							";
							
							$messaggio.="Il tuo referente TMG: ".$this->user_referente."<br/>";
							if($this->is_giovane==1){
								$messaggio.="Codice fiscale: ".$this->codfiscale."<br/>";
							}
							$messaggio.="
							Accedi ed inizia a personalizzare la tua carta d'identit&aacute; web!
							<br/>
							</p>
							
							<p>Per qualsiasi problema contattaci all'indirizzo info@topmanagergroup.com</p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation ".date("Y")."</p>
						</div> 
					</div>
					</body>
				</html>
				";
			  $mail->MsgHTML($messaggio);
			  
			  //error_log("Sono qui 1");
			  if($this->status==0&&$this->is_giovane==0){
				  /*error_log("entro qui 1");
				  error_log("path: ../../fatture/fattura ".$this->username." ".date("d-m-Y").".pdf");*/	
					//$mail->AddAttachment("fatture/fattura ".$this->username." ".date("d-m-Y").".pdf");
					
			  }
			  
			  $mail->Send();
		} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		}
		
		if($this->id_referente!=0&&$this->is_giovane!=1){
			$mail2 = new PHPMailer(true);
			$data_ora = date("m.d.y, g:i a");
			$this->pagina_referente = PATH_SITO.$this->user_referente."?personal_area=true";
			try { 
			  $mail2->AddAddress($this->emailtmg_referente,$this->user_referente);
			  $mail2->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = $this->user_referente.", Hai appena guadagnato con TopManagerGroup.com.";
			  $mail2->Subject = $oggetto;	  
							  
			  $mail2->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			  
			  $messaggio = "<html>
				<style>
					#corpomail{
						width: 576px;
						text-align: left;
						color:#000;
					}
					body{
						font-family:'Franklin Gothic Medium';
						font-size:14px;
						background-color:#fff;
					}
					#titolo{
						font-size:20px;
					}
			
				</style>
					<body>
					<div align='center'>
						<div align='center'id='corpomail'> 
							<img src='".PATH_SITO."image/banner/logo_small.png' width='368' height='140' />
							<p id='titolo'>".$this->nome_referente.", Complimenti ".$this->username." si &eacute; iscritto a TopManagerGroup.com.</p>
							<p>La prima societ&aacute; di carte d'identit&aacute; web.</p>
							In data ".$data_ora.", ".$this->username." si &eacute; iscritto al nostro gruppo indicando te come referente!<br/>
							Puoi accedere al tuo stato promoter per verificare il tuo saldo GUADAGNO MANAGER aggiornato nella tua personal area:<br/>
							<a href='".$this->pagina_referente."'>".PATH_SITO.$this->user_referente."</a>
							
							<p>Per qualsiasi problema contattaci all'indirizzo info@topmanagergroup.com</p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation ".date("Y")."</p>
						</div> 
					</div>
					</body>
				</html>
				";
				  $mail2->MsgHTML($messaggio);
				  
				  $mail2->Send();
			} catch (phpmailerException $e) {
				  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				  echo $e->getMessage(); //Boring error messages from anything else!
			}
		}else if($this->id_referente!=0&&$this->is_giovane==1){
			$mail2 = new PHPMailer(true);
			$data_ora = date("m.d.y, g:i a");
			$this->pagina_referente = PATH_SITO.$this->user_referente."?personal_area=true";
			try { 
			  $mail2->AddAddress($this->emailtmg_referente,$this->user_referente);
			  $mail2->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = $this->user_referente.", hai nuovo utente TopManagerGroup.com.";
			  $mail2->Subject = $oggetto;	  
							  
			  $mail2->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			  
			  $messaggio = "<html>
				<style>
					#corpomail{
						width: 576px;
						text-align: left;
						color:#000;
					}
					body{
						font-family:'Franklin Gothic Medium';
						font-size:14px;
						background-color:#fff;
					}
					#titolo{
						font-size:20px;
					}
			
				</style>
					<body>
					<div align='center'>
						<div align='center'id='corpomail'> 
							<img src='".PATH_SITO."image/banner/logo_small.png' width='368' height='140' />
							<p id='titolo'>".$this->nome_referente.", Complimenti ".$this->username." si &eacute; iscritto a TopManagerGroup.com.</p>
							<p>La prima societ&aacute; di carte d'identit&aacute; web.</p>
							In data ".$data_ora.", ".$this->username." si &eacute; iscritto al nostro gruppo indicando te come referente!<br/>
							L'utente ".$this->username." non ha ancora 25 anni, di conseguenza non riceverai provviggioni finch&eacute; egli non raggiunger&aacute l'et&aacute; necessaria (Ti avviseremo quando questo avverr&aacute;). Puoi comunque accedere al tuo stato promoter per verificare il tuo saldo GUADAGNO MANAGER aggiornato nella tua personal area:<br/>
							<a href='".$this->pagina_referente."'>".PATH_SITO.$this->user_referente."</a>
							
							<p>Per qualsiasi problema contattaci all'indirizzo info@topmanagergroup.com</p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation ".date("Y")."</p>
						</div> 
					</div>
					</body>
				</html>
				";
				  $mail2->MsgHTML($messaggio);
				  
				  $mail2->Send();
			} catch (phpmailerException $e) {
				  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				  echo $e->getMessage(); //Boring error messages from anything else!
			}	
			
		}
	}
	public function send_mail_bonifico(){
		$mail = new PHPMailer(true);
		$email = $this->email;
		try { 
		  $mail->AddAddress($email,$this->username);
		  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
				  
		  $oggetto = $this->username.", Hai 7 giorni per effettuare il pagamento di TopManagerGroup.com.";
		  $mail->Subject = $oggetto;	  
		  				  
		  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				  
		  $messaggio = "<html>
				<style>
					#corpomail{
						width: 576px;
						text-align: left;
						color:#000;
					}
					body{
						font-family:'Franklin Gothic Medium';
						font-size:14px;
						background-color:#fff;
					}
					#titolo{
						font-size:20px;
					}
			
				</style>
					<body>
					<div align='center'>
						
						<div align='center'id='corpomail'> 
							<img src='".PATH_SITO."image/banner/logo_small.png' width='368' height='140' />
							<p id='titolo'>".$this->username.",Complimenti ora sei iscritto a TopManagerGroup.com!</p>
							<b>Hai 7 giorni per effettuare il pagamento di &euro;96.</b><br>
							
							<b>Puoi pagare tramite un bonifico bancario</b><br/>
							Dati per effettuare il bonifico:<br/>
							NOME COGNOME INTESTATARIO: Exporeclam sas<br/>
							IBAN: IT96W0200850110000041182842<br/>
							CAUSALE: Iscrizione TopManagerGroup di ............. (indicare al posto dei puntini nome e cognome utilizzati nell'iscrizione al gruppo)<br/>
							</div>
							Grazie<br/>
							Lo staff di TMG<br/>
							
							<p>Per qualsiasi problema contattaci all'indirizzo info@topmanagergroup.com</p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation ".date("Y")."</p>
						</div> 
					</div>
					</body>
				</html>
				";
			  	/*Il tuo indirizzo e-mail topmanagergroup sarà:<br/>
				".$this->username."@topmanagergroup.com*/
			  $mail->MsgHTML($messaggio);
			  
			  $mail->Send();
		} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
	public function Create_user_folder($path=""){
		mkdir($path.USERS_PATH.$this->username."/");
		
		chmod($path.USERS_PATH.$this->username."/", 0755);
		mkdir($path.USERS_PATH.$this->username."/user_photo_temp/");
		mkdir($path.USERS_PATH.$this->username."/user_photo_large/");
		mkdir($path.USERS_PATH.$this->username."/user_photo/");
		chmod($path.USERS_PATH.$this->username."/user_photo/", 0755);
		mkdir($path.USERS_PATH.$this->username."/user_photo/main/");
		chmod($path.USERS_PATH.$this->username."/user_photo/main/", 0755);
		
		
		mkdir($path.USERS_PATH.$this->username."/filebox/");
		chmod($path.USERS_PATH.$this->username."/filebox/", 0755);
		mkdir($path.USERS_PATH.$this->username."/filebox/temp/");
		mkdir($path.USERS_PATH.$this->username."/filebox/public/");
		mkdir($path.USERS_PATH.$this->username."/filebox/private/");
		mkdir($path.USERS_PATH.$this->username."/filebox/photo/");
		
		mkdir($path.USERS_PATH.$this->username."/filebox/photo/FOTO");
		
		mkdir($path.USERS_PATH.$this->username."/filebox/public/DOCUMENTI");
		mkdir($path.USERS_PATH.$this->username."/filebox/public/MUSICA");
		mkdir($path.USERS_PATH.$this->username."/filebox/public/VIDEO");
		mkdir($path.USERS_PATH.$this->username."/download_area/");
		chmod($path.USERS_PATH.$this->username."/download_area/", 0755);
		mkdir($path.USERS_PATH.$this->username."/download_area/public/");
		mkdir($path.USERS_PATH.$this->username."/download_area/evidenza/");
		mkdir($path.USERS_PATH.$this->username."/download_area/public/photo");
	}
	public function CreateUserTmgMail(){
		$server_ip=SERVER_IP;
		$server_login=SERVER_LOGIN;
		$server_pass=SERVER_PASS;
		$server_ssl=SERVER_SSL;
		
		
		//echo "Creating user $username on server $ip.... <br>\n";
		 
		 $sock = new HTTPSocket;
		 if ($server_ssl == 'Y')
		 {
		  $sock->connect("ssl://".$server_ip, 2222);
		 }
		 else
		 { 
		  $sock->connect($server_ip, 2222);
		 }
		 $sock->set_login($server_login,$server_pass);
		 $sock->query('/CMD_API_POP',
			 array(
		  'action' => 'create',
		  'domain' => 'topmanagergroup.com',
		  'quota' => '100',
		  'user' => $this->username,
		  'passwd' => $this->password,
			 ));
		 $result = $sock->fetch_parsed_body();
		 if ($result['error'] != "0")
		 {
		  /*echo "<b>Error Creating user $username on server $server_ip:<br>\n";
		  echo $result['text']."<br>\n";
		  echo $result['details']."<br></b>\n";*/
		 }
		 else
		 {
		  //echo "User $username created on server $server_ip<br>\n";
		 }
	}

	private function getRandPassword()
	{
		$N_Caratteri = 8;
		$Stringa = "";
		for($I=0;$I<$N_Caratteri;$I++){
			do{
				$N = ceil(rand(48,122));
			}while(!((($N >= 48) && ($N <= 57)) || (($N >= 65) && ($N <= 90)) || (($N >= 97) && ($N <= 122))));
				
			
			$Stringa = $Stringa.chr($N);
		}
		return $Stringa;
	}
}
?>