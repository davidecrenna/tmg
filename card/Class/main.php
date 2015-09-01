<?php
include("database.php");
include("Ctrluser.php");
include("pdf.php");

//##############################################################################################
//##############################################################################################
/*
	Class Card
	DESCRIPTION: handles all the user card's function
	AUTHOR: Davide Crenna
	COPYRIGHT: TOP MANAGER GROUP 2014
*/
//##############################################################################################
//##############################################################################################
class Card {
	//attributes
	public $color_preview;
	public $personal_area;
	
	//from table: 'user'
	public $username;
	public $user_id;
	public $personalemail;
	public $password;
	public $Nome;
	public $Cognome;
	public $Professione;
	public $Category;
	public $user_level;
	public $society;
	public $id_referente;
	public $is_giovane;
	public $resta_collegato;
	public $status;
	public $remove_data;
	public $data_iscrizione;
	public $codfis;
	public $alternative_url;
	
	//from table: 'userdata'
	public $photo1_path;
	public $curriculum;
	public $opt_curr;
	public $cellulare;
	public $email_bv_value;
	public $alt_professione;
	public $colore_card;
	public $flagnameshowed;
	
	//from table 'userposition'
	public $address_via;
	public $address_citta;
	public $address_desc;
	public $address_on;
	
	
	//from table: 'userevidenza'
	public $news_rows = array();
	public $empty_news_rows = array();
	public $user_news_rows_count;
	
	//from table: 'userslide'
	public $user_photo_slide_path = array();
	public $user_photo_slide_big_path=array();
	
	//from table: 'usercontact'
	public $contact_rows = array();
	
	//from table: 'usersocial'
	public $social_rows = array();
	
	//from table: 'usernewsletter'
	public $newsletter_rows = array();
	public $user_newsletter_rows_count;
	
	//from table: 'usernewsletter_group'
	public $newsletter_group = array();
	
	//from table: 'user_bv'
	public $bv_cellulare;
	public $bv_email;
	public $bv_tmg_email;
	public $bv_professione;
	public $bv_web;
	
	//from table: 'user_curreurop'
	public $curriculum_europeo_data;
	
	//from table: 'user_filebox'
	public $folders = array();
	
	//from table: 'promoter'
	public $num_subuser;
	public $total_ammount;
	public $total_confirmed;
	public $total_payed;
	
	//from table: 'user_simple_curriculum'
	public $sudime;
	
	
	//from table: 'user_job_categories'
	public $job_categories= array();
	
	//from MAILBOX
	public $email_messages = array();
	public $email_messages_sent = array();
	public $email_messages_trash = array();
	
	//DB configuration
	private $mysql_database;
	
	//BASIC CLASS
	public $basic;
	
	//Uploader
	private $my_uploader;
	
	/*  METHOD: Card()
		
		IN: $server_uri[DEFAULT:NULL],$username[DEFAULT:NULL]
		OUT: -
		DESCRIPTION: (constructor) Initialize the class, calculate username of the user from server's url, call Get_from_db that populate class attributes.
	*/
	function Card($server_uri=NULL,$username = NULL, $options_color = NULL, $options_personal_area=NULL ,$options_tab=NULL){
		$this->basic = new Basic();
		$this->mysql_database = new MySqlDatabase();
		$this->color_preview=$options_color;

		$this->options_personal_area=$options_personal_area;
        $this->options_tab=$options_tab;
		if($server_uri!=NULL){
			$server_uri=str_replace("index.php","",$server_uri);
			if(strpos($server_uri,"?"))
			$server_uri= substr($server_uri,0,strpos($server_uri,"?"));
			
			if(LOCALE==1){
				$uri_len = strlen($server_uri);
				$pos_slash = strpos($server_uri,"/",1);
				$user = substr($server_uri,$pos_slash,$uri_len - $pos_slash);
				$this->username = str_replace("/","",$user);
			}else{
				$this->username = str_ireplace("/","",$server_uri);
			}
			
		}else{
			$this->username = $username;
		}
		if($this->Get_from_db()==NULL)
			return NULL;
	}
	
	//##################################################################################
	//DB FUNCTIONS START
	//##################################################################################
	
	/*  METHOD:  Get_from_db()
		IN: - 
		OUT: -
		DESCRIPTION: populate class attributes by getting data from DB.
		
	*/
	function Get_from_db(){
		$this->mysql_database->Get_from_db($this->username,$this->user_id,$this->Nome,$this->Cognome,$this->Professione,$this->password,$this->personalemail,$this->user_level,$this->society,$this->resta_collegato,$this->id_referente,$this->is_giovane,$this->Category,$this->status,$this->remove_data,$this->data_iscrizione,$this->codfis,$this->alternative_url,$this->photo1_path, $this->user_photo_slide_path,$this->user_photo_slide_big_path, $this->contact_rows,$this->social_rows, $this->newsletter_rows, $this->user_newsletter_rows_count, $this->newsletter_group,$this->bv_cellulare,$this->bv_email,$this->bv_tmg_email,$this->bv_web,$this->bv_professione,$this->curriculum_europeo_data ,$this->opt_curr,$this->folders,$this->cellulare,$this->email_bv_value, $this->alt_professione,$this->colore_card,$this->flagnameshowed,$this->sudime,$this->news_rows,$this->empty_news_rows,$this->user_news_rows_count,$this->email_messages,$this->email_messages_sent,$this->email_messages_trash,$this->address_via,$this->address_citta,$this->address_desc,$this->address_on,$this->job_categories,$this->num_subuser,$this->total_ammount,$this->total_confirmed,$this->total_payed);
	}
	
			
	/*  METHOD: Update_profilo()
		
		IN: $new_profilo_nome, $new_profilo_nome, $new_profilo_professione.
		OUT: -
		DESCRIPTION: Update profile's informaion in the DB.
	*/
	public function Update_profilo($new_profilo_professione,$new_profilo_cellulare,$new_bv_professione,$new_bv_cellulare,$new_bv_email ){
		$this->mysql_database->Update_profilo( $this->user_id, $new_profilo_professione, $new_profilo_cellulare,$this->Professione,$this->cellulare,$new_bv_professione,$new_bv_cellulare,$new_bv_email,$this->bv_cellulare,$this->bv_professione);
	}
	

	public function Evidenza_save_row($id_row,$title,$subtitle,$desc,$file){
		$this->mysql_database->Evidenza_save_row($this->user_id,$id_row, $title,$subtitle,$desc,$file);
	}
	
	public function Evidenza_save_data($id_row,$data,$sendto,$check_alt){
		$this->mysql_database->Evidenza_save_data($id_row,$data,$sendto,$check_alt,$this->user_id);
	}
	/*public function Evidenza_save_sendto($id_row,$sendto,$check_alt){
		$this->mysql_database->Evidenza_save_sendto($id_row,$sendto,$check_alt,$this->user_id);
	}*/
	public function Evidenza_delete_post_pubblica(){
		$this->mysql_database->Evidenza_delete_post_pubblica($this->user_id);
	}
	
	public function Move_rows_up($index,$row_num){
		$this->mysql_database->Move_rows_up($this->news_rows[$index]['id'],$row_num,$this->user_id);
	}
	public function Move_rows_down($index,$row_num){
		$this->mysql_database->Move_rows_down($this->news_rows[$index]['id'],$row_num,$this->user_id);
	}
	
	public function Create_new_news(){
		return $this->mysql_database->Create_new_news($this->user_id,$this->user_news_rows_count);	
	}
	public function Delete_single_news($index_delete){
		return $this->mysql_database->Delete_single_news($this->news_rows[$index_delete]["id"],$this->news_rows[$index_delete]["row_num"],$this->user_id);
	}
	public function Get_newsletter_num(){
		return count($this->newsletter_rows);
	}
	public function Delete_not_completed_news(){
		for($i=0;$i<count($this->empty_news_rows);$i++){
			//$this->SureRemoveDir($this->username."/download_area/evidenza/news_".$this->empty_news_rows[$i]["id"],true);
			if(is_dir("../../".USERS_PATH.$this->username."/download_area/evidenza/news_".$this->empty_news_rows[$i]["id"])){
				$this->SureRemoveDir("../../".USERS_PATH.$this->username."/download_area/evidenza/news_".$this->empty_news_rows[$i]["id"],true);
			}
		}
		$this->mysql_database->Delete_not_completed_news($this->user_id);
	}
	public function delete_news_folder($news_id){
		if(is_dir("../../".USERS_PATH.$this->username."/download_area/evidenza/news_".$news_id)){
			$this->SureRemoveDir("../../".USERS_PATH.$this->username."/download_area/evidenza/news_".$news_id,true);
		}
	}


	public function pubblica_news($id_row){
		$this->Get_from_db();
		
		for($i=0;$i<count($this->news_rows);$i++){
			if($this->news_rows[$i]["id"]==$id_row)
				$index=$i;
		}
		
		$now_data = date("Y-m-d");
		
		if($this->news_rows[$index]["data"]==$now_data&&$this->news_rows[$index]["sent"]==0){
			$selected_index = $this->news_rows[$index]["sendto"];
			$check_alt = $this->news_rows[$index]["check_alt"];
			$id=substr($selected_index,0,strpos($selected_index,","));
			while($id!=""){
				for($i=0;$i<count($this->newsletter_group);$i++){
					
					if($this->newsletter_group[$i]["id"]==$id){
					  for($j=0;$j<count($this->newsletter_rows);$j++){
						  if($this->newsletter_rows[$j]["id_group"]==$this->newsletter_group[$i]["id"]){
							  if($check_alt==1){
							  	$this->send_newsletter_mail($this->newsletter_rows[$j]["emails"][0]["row_value"],$this->newsletter_rows[$j]["nome"],$this->newsletter_rows[$j]["cognome"],$index);
							  }else{
								  
								 foreach($this->newsletter_rows[$j]["emails"] as $email){
									 $this->send_newsletter_mail($email["row_value"],$this->newsletter_rows[$j]["nome"],$this->newsletter_rows[$j]["cognome"],$index);
								 } 
							  }
						  }	
					  }
					}
					
					
				}
				$selected_index=substr($selected_index,strpos($selected_index,",")+1);
				$id=substr($selected_index,0,strpos($selected_index,","));
			}
			$this->mysql_database->Update_evidenza_sent($id_row,$this->user_id);
		}
	}
	public function Set_account_deleted_now(){
		$this->mysql_database->Set_account_deleted_now($this->user_id);
	}
	public function Set_account_deleted(){
		$this->mysql_database->Set_account_deleted($this->user_id,$this->data_iscrizione);
	}
	
	public function Unset_account_deleted(){
		if($this->status!=2&&$this->status!=3&&$this->status!=4)
			$this->mysql_database->Unset_account_deleted($this->user_id);
	}
	
	public function Send_mailing_group_email($body,$emails,$subject){
		foreach($emails as $mail_address){
			$mail = new PHPMailer(true);
			try { 
				  $mail->AddAddress($mail_address,$this->Getnameshowed());
				  $mail->SetFrom("no-reply@topmanagergroup.com", $this->Getnameshowed());
				  
				  $oggetto = $subject." - TopManagerGroup.com.";
				  
				  $mail->Subject = $oggetto;
				  
				  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		
				  $messaggio = "
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
					#news_titolo{
						font-size:15px;
					}
					#news_descrizione{
						font-size:12px;
					}
				</style>
					<body>
					<div align='center'>
						
						<div align='center'id='corpomail'> 
							<img src='".PATH_SITO."image/banner/logo_small.png' width='368' height='140' />
							<p id='titolo'>".$this->Getnameshowed().",  Ha un messaggio per te inviato tramite TopManagerGroup.com</p>
							<p>".$body."</p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation ".date("Y")."</p>
						</div> 
					</div>
					</body>";
				  
				  $mail->MsgHTML($messaggio);
				  $mail->Send();
			} catch (phpmailerException $e) {
				  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				  echo $e->getMessage(); //Boring error messages from anything else!
			}
		}
	}
	public function send_newsletter_mail($mail_address,$nome,$cognome,$index){
		$mail = new PHPMailer(true);
		$email = $mail_address;
		try { 
			  $mail->AddAddress($email,$this->Getnameshowed());
			  $mail->SetFrom("no-reply@topmanagergroup.com", $this->Getnameshowed());
			  
			  $oggetto = $this->news_rows[$index]["titolo"]." - ".$this->Getnameshowed()." - TopManagerGroup.com.";
			  
			  $mail->Subject = $oggetto;
			  
			  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	
			  $messaggio = "
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
				#news_titolo{
					font-size:15px;
				}
				#news_descrizione{
					font-size:12px;
				}
			</style>
				<body>
				<div align='center'>
					
					<div align='center'id='corpomail'> 
						<img src='".PATH_SITO."image/banner/logo_small.png' width='368' height='140' />
						<p id='titolo'>".$this->Getnameshowed().",  Ha pubblicato una news su TopManagerGroup.com</p>
						<br/>
						<span id='news_titolo'>".$this->news_rows[$index]["titolo"]."</span><br/>
						<span id='news_descrizione'>".$this->news_rows[$index]["sottotitolo"]."</span><br/><br/>
						Vai alla card di ".$this->Getnameshowed().": <br/>
						<a href='".PATH_SITO.$this->username."/'>".PATH_SITO.$this->username."/</a><br/>
						<br/></p>
						
						<p>Per qualsiasi problema contattaci all'indirizzo info@topmanagergroup.com</p>
					</div>
					<div align='center' id='copyright'>
						<p>Topmanagergroup Corporation ".date("Y")."</p>
					</div> 
				</div>
				</body>";
			  
			  $mail->MsgHTML($messaggio);
			  if(is_file("../../".USERS_PATH.$this->username."/download_area/evidenza/news_".$this->news_rows[$index]["id"]."/".$this->news_rows[$index]["file"]))
				$mail->AddAttachment("../../".USERS_PATH.$this->username."/download_area/evidenza/news_".$this->news_rows[$index]["id"]."/".$this->news_rows[$index]["file"]);
			  $mail->Send();
		} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		}
	
	}
	public function Personal_card_ctrl_riscuoti(){
		$this->mysql_database->GetPromoterData($this->num_subuser,$this->total_ammount,$this->total_confirmed,$this->total_payed,$this->user_id);
		$ctrl_inserted = array();
		$area = new Area();
		$ctrl_inserted = $area->Ctrl_riscossione_inserted($this->user_id);
		
		if($this->total_confirmed < 100){
			return false;	
		}
		if($ctrl_inserted["result"]==true){
			$this->send_mail_riscossione($ctrl_inserted["nomebeneficiario"],$ctrl_inserted["iban"],$ctrl_inserted["codfis"],$ctrl_inserted["swift"],date("d-m-Y",strtotime($ctrl_inserted["datetime"])));
			return false;	
		}
		return true;
	}
	public function Personal_card_riscuoti($nomebeneficiario,$iban,$codfis,$swift){
		$this->mysql_database->GetPromoterData($this->num_subuser,$this->total_ammount,$this->total_confirmed,$this->total_payed,$this->user_id);
		if($this->total_confirmed < 100){
			return "Potrai richiedere la riscossione del tuo Saldo disponibile quando verrà raggiunta la soglia di €100.";	
		}else{
			$area = new Area();
			$data = date("d-m-Y");
			//inserisco la transazione di riscossione
			$id = $area->Insert_new_user_transaction(2,$this->total_confirmed,0,$this->user_id,$nomebeneficiario,$iban,$codfis,$swift);
			
			$area->Create_ritenuta_acconto($this->total_confirmed,$this->username,$nomebeneficiario,$iban,$codfis,$swift,$data);
			
			$this->send_mail_riscossione($nomebeneficiario,$iban,$codfis,$swift,$data);
			return "La tua richiesta è stata inoltrata. Riceverai a breve una mail con i dettagli per effetturare la riscossione.";	
		}
	}
	
	
	
	public function send_mail_riscossione($nomebeneficiario,$iban,$codfis,$swift,$data){
		$mail = new PHPMailer(true);
		try { 
			$mail->AddAddress($this->personalemail, $this->Getnameshowed());
			$mail->AddAddress($this->Get_member_email(), $this->Getnameshowed());
			$mail->SetFrom("no-reply@topmanagergroup.com", "TopManagerGroup.com");
			  
			$oggetto = "Riscossione saldo disponibile TopManagerGroup.com.";
			  
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
							<p id='titolo'>".$this->Getnameshowed().", abbiamo ricevuto la Sua richiesta di riscossione del saldo disponibile.</p>
							<p>Eseguiremo entro 7 giorni lavorativi il bonifico sul conto da lei indicato.<br/>In allegato a questa e-mail trover&aacute; la ritenuta d'acconto in cui sono indicate le tasse (R.A. 20%) e il netto a pagare, si prega di conservare il documento con cura.<br/></p>
							<p>Ecco un promemoria dei Suoi dati:<br/>
							Nome Beneficiario: ".$nomebeneficiario."<br/>
							Iban: ".$iban."<br/>
							C.F.: ".$codfis."<br/>";
							if($swift!="")
								$messaggio.= "Codice Swift: ".$swift."<br/>";
							$messaggio.="</p>
							<br/>
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
			 $mail->AddAttachment("../../ritenute/RA ".$this->username." ".$data.".pdf");
			 $mail->Send();
		}catch(phpmailerException $e){
			 echo $e->errorMessage(); //Pretty error messages from PHPMailer
		}catch(Exception $e){
			 echo $e->getMessage(); //Boring error messages from anything else!
		}
		
	}
	
	
	public function Lista_gruppi_mailing(){
		echo "\n";
		for($i=0,$c=0; $i<sizeof($this->newsletter_group); $i++) {
			
			if($this->newsletter_group[$i]["active"]==1){
				echo $this->newsletter_group[$i]["nome"]."\n";
				$c++;
			}	
		}
		if($c==0){
			echo "Non ci sono gruppi attivi nella mailing list.";	
		}
	}
	
	/*  METHOD: Update_curriculum()
		
		IN: $text (simple curriculum text)
		OUT: -
		DESCRIPTION: Update simple curriculum informaion in the DB.
	*/
	public function Update_curriculum($text){
		$this->mysql_database->Update_curriculum($text,$this->user_id);
	}
	
	/*  METHOD:  Insert_contact_rows()
		
		IN: $num_contact_rows,$rows=array().
		OUT: {on video print contact_rows}
		DESCRIPTION: Insert in the db the input parameters, in the table user_contact.
	*/
	public function Insert_contact_row($value,$type){
		$this->mysql_database->Insert_contact_rows($value,$type,$this->user_id);
	}
	public function Add_newsletter_row($row_value,$nome,$cognome,$cell,$id_group){
		$this->mysql_database->Add_newsletter_row($row_value,$nome,$cognome,$cell,$id_group,$this->user_id);
	}
	public function Update_mailing_contact_row($index,$nome,$middle_name,$addon,$cognome,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note){
		$fn = $nome." ".$middle_name." ".$cognome." ".$addon;
		$this->mysql_database->Update_mailing_contact_row($this->newsletter_rows[$index]["idusernewsletter"],$nome,$middle_name,$addon,$cognome,$fn,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note,$this->user_id);
	}
	
	public function Add_new_mailing_contact_row($id_group,$nome,$middle_name,$addon,$cognome,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note){
		$fn = $nome." ".$middle_name." ".$cognome." ".$addon;
		return $this->mysql_database->Add_new_mailing_contact_row($this->newsletter_group[$id_group]["id"],$nome,$middle_name,$addon,$cognome,$fn,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note,$this->user_id);
	}
	
	public function Delete_all_mailing_emails($index){
		$this->mysql_database->Delete_all_mailing_emails($this->user_id,$this->newsletter_rows[$index]["idusernewsletter"]);
	}
	
	
	public function Delete_all_mailing_urls($index){
		$this->mysql_database->Delete_all_mailing_urls($this->user_id,$this->newsletter_rows[$index]["idusernewsletter"]);
	}
	
	public function Store_vcard_emails($email,$index,$is_main){
		$this->mysql_database->Store_vcard_emails($this->user_id,$this->newsletter_rows[$index]["id_group"],$this->newsletter_rows[$index]["idusernewsletter"],$email,$is_main);
	}
	public function Store_new_vcard_emails($email,$index,$id_group,$is_main){
		$this->mysql_database->Store_vcard_emails($this->user_id,$id_group,$index,$email,$is_main);
	}
	public function Store_vcard_urls($url,$index,$is_main){
		$this->mysql_database->Store_vcard_urls($this->user_id,$this->newsletter_rows[$index]["id_group"],$this->newsletter_rows[$index]["idusernewsletter"],$url,$is_main);
	}
	public function Store_new_vcard_urls($url,$index,$id_group,$is_main){
		$this->mysql_database->Store_vcard_urls($this->user_id,$id_group,$index,$url,$is_main);
	}
	
	public function Add_newsletter_group($nome){
		$this->mysql_database->Add_newsletter_group($nome,$this->user_id);
	}
	
	public function Set_mailing_contacts_old(){
		$this->mysql_database->Set_mailing_contacts_old($this->user_id);
	}
	
	public function Delete_newsletter_row($id){
		$this->mysql_database->Delete_newsletter_row($id,$this->user_id);
	}
	public function Move_newsletter_row($id,$id_group){
		$this->mysql_database->Move_newsletter_row($id ,$id_group,$this->user_id);
	}
	public function Delete_newsletter_group($id){
		$this->mysql_database->Delete_newsletter_group($id ,$this->user_id);
	}
	public function Rename_newsletter_group($name,$group_id){
		$this->mysql_database->Rename_newsletter_group($name,$group_id,$this->user_id);	
	}
	public function Move_contact_up($index,$row_num){
		$this->mysql_database->Move_contact_up($this->contact_rows[$index]['id'],$row_num,$this->user_id);
	}
	public function Move_contact_down($index,$row_num){
		$this->mysql_database->Move_contact_down($this->contact_rows[$index]['id'],$row_num,$this->user_id);
	}
	public function delete_contact_row($index){
		$this->mysql_database->delete_contact_row($index,$this->contact_rows[$index]['id'],$this->user_id);
	}
	
	public function update_contact_row($index,$new_row_value,$new_row_type){
		$this->mysql_database->update_contact_row($this->contact_rows[$index]['id'],$new_row_value,$new_row_type,$this->user_id);
	}
	
	
	public function Evidenza_delete_all(){
		$this->mysql_database->Evidenza_delete_all($this->user_id);	
	}
	
	
	/*  METHOD: Update_main_photo()
		
		IN: $photo_path, $photo_name
		OUT: -
		DESCRIPTION: Update main photo path informaion in the DB.
	*/
	public function Update_main_photo($photo_name){
		$this->mysql_database->Update_main_photo($photo_name, $this->user_id,$this->photo1_path);
	} 
	
	public function Crop_photo($photo,$top,$left,$width,$height,$max_width,$max_height,$quality,$thumbs_path){
		$source_file = $photo;
		$filename = substr($photo,strrpos($photo,"/")+1);
		$filename = explode('.', $filename);
		$extension = array_pop($filename);
		
		//we create a new filename from the original with the "thumb" suffix.
		$thumb = implode('.',$filename) .".". $extension;
		//dove salver la foto croppata
		//the full target path + file name
		$target_file = $thumbs_path.$thumb;
		
		$info = getimagesize($source_file);
		
		if(!$info){
			die('{"error":"The file type is not supported."}');
		}
		
		// we use the the GD library to load the image, using the file extension to choose the right function
		ini_set('memory_limit', -1);
		switch($info[2]) {
			case IMAGETYPE_GIF:
				if(!$source_image = imagecreatefromgif($source_file)){
					die('{"error":"Could not open GIF file."}');
				}
				break;
			case IMAGETYPE_PNG:
				if(!$source_image = imagecreatefrompng($source_file)){
					die('{"error":"Could not open PNG file."}');
				}
				break;
			case IMAGETYPE_JPEG:
				if(!$source_image = imagecreatefromjpeg($source_file)){
					die('{"error":"Could not open JPG file."}');
				}
				break;
			default:
				die('{"error":"The file type is not supported."}');
				break;
		}
		ini_restore('memory_limit');
		
		//Calculate the new size based on the selected area and the minimums
		if($width > $height) {
			$dest_width = $max_width;
			$dest_height = round($max_width*$height/$width);
		} else {
			$dest_width = round($max_height*$width/$height);
			$dest_height = $max_height;
		}
		
		//we generate a new image object of the size calculated above, using PHP's GD functions
		if(!$dest_image = imagecreatetruecolor($dest_width, $dest_height)){
			die('{"error":"Could not create new image from source file."}');
		}
		
		//hack to keep transparency in gif and png
		if($info[2]==IMAGETYPE_GIF||$info[2]==IMAGETYPE_PNG){
			if($info[2]==IMAGETYPE_PNG){
				imageAntiAlias($dest_image,true);
			}
			imagecolortransparent($dest_image, imagecolorallocatealpha($dest_image, 0, 0, 0,127));
			imagealphablending($dest_image, false);
			imagesavealpha($dest_image, true);
		}
		
		/*
			this is where we crop the image,
			-the first parameter is the destinatation image (not a physical file, but a GD image object)
			-second is the source image. Again it's not the physical file but a GD object (which was generated from an image file this time)
			-third and fourth params are the X and Y coordinates to paste the copied region in the destination image. In this case we want both of them to be 0,
			-fifth and sixth are the X and Y coordinates to start cropping in the source image. So they are pretty much the coordinates we got from UvumiCrop.
			-seventh and eighth are the width and height of the destination image, the one calculated right above
			-ninth and tenth are the width and height of the cropping region, directly from UvumiCrop again
			
			By just setting $max_width and $max_height above, you should not have to worry about this
		*/
		
		if(!imagecopyresampled($dest_image, $source_image, 0, 0, $left, $top, $dest_width, $dest_height, max($width, $max_width), max($height, $max_height))){
			die('{"error":"Could not crop the image with the provided coordinates."}');
		}
		
		//just as we used $extension to pick the loading function, we'll use it again here to determine which GH function we need for outputting the cropped image
		switch($info[2]) {
			case IMAGETYPE_GIF:
				if(!imagegif($dest_image, $target_file)){
					die('{"error":"Could not save GIF file."}');
				}
				break;
			case IMAGETYPE_PNG:
				if(!imagepng($dest_image, $target_file, max(9 - floor($quality/10),0))){
					die('{"error":"Could not save PNG file."}');
				}
				break;
			case IMAGETYPE_JPEG:
				if(!imagejpeg($dest_image, $target_file, $quality)){
					die('{"error":"Could not save JPG file."}');
				}
				break;
		}
		imagedestroy($dest_image);
		imagedestroy($source_image);
		
		return $thumb;
		//If we made it that far with no error, we can return a success message, with the thumb filename
		//die('{"success":"'.$thumb.'"}');
	}
	
	/*  METHOD: Update_slide_photo()
		
		IN: $photo_path, $photo_name,$index
		OUT: -
		DESCRIPTION: Update slide photo path informaion in the DB.
	*/
	public function Update_slide_photo($thumb_photo_name,$photo_big_name,$index){
		$this->mysql_database->Update_slide_photo($thumb_photo_name,$photo_big_name,$this->user_id, $index);
	} 
	
	/*  METHOD:  Add_slide_photo($photo_path, $photo_name ,$index)
		
		IN: $photo_path, $photo_name, $index
		OUT: -
		DESCRIPTION: Add a slide-show foto informaion in the DB.
	*/
	public function Add_slide_photo($photo_path,$thumb_photo_name,$index){
		//copio la foto temp nella cartella user_photo / copy temp photo in the folder user_photo
		if(sizeof($this->user_photo_slide_path)<7){
			copy($photo_path,"../../".USERS_PATH.$this->username."/user_photo/"."sp_".$thumb_photo_name);
			copy("../../".USERS_PATH.$this->username."/".USER_LARGE_PHOTO_PATH.$thumb_photo_name,"../../".USERS_PATH.$this->username."/download_area/public/photo/".$thumb_photo_name);
			$this->mysql_database->Add_slide_photo("sp_".$thumb_photo_name, $this->user_id , $photo_path, $this->user_photo_slide_path, $index);
			unlink($photo_path);
		}
	}
	
	public function Add_social_element($value,$type,$title){
		if($type!="accsk"){
			$url = str_replace("http://",'',$value);
			$favicon = "http://www.google.com/s2/favicons?domain=" . $url;
		}else{
			$favicon = "../../image/icone/skype.png";
		}
		$this->mysql_database->Add_social_element($value,$type,$favicon,$title,$this->user_id);
	}
	public function Update_social_element($value,$type,$title,$index){
		if($type!="accsk"){
			$url = str_replace("http://",'',$value);
			$favicon = "http://www.google.com/s2/favicons?domain=" . $url;
		}else{
			$favicon = "../../image/icone/skype.png";
		}
		$this->mysql_database->Update_social_element($value,$type,$favicon,$title,$this->social_rows[$index]["id"],$this->user_id);
	}
	
	public function Move_social_up($index,$row_num){
		$this->mysql_database->Move_social_up($this->social_rows[$index]['id'],$row_num,$this->user_id);
	}
	
	public function Move_social_down($index,$row_num){
		$this->mysql_database->Move_social_down($this->social_rows[$index]['id'],$row_num,$this->user_id);
	}
	
	public function Delete_social_element($index){
		$this->mysql_database->Delete_social_element($index,$this->social_rows[$index]['id'],$this->user_id);
	}
	
	public function Change_card_colour($colour){
		$this->mysql_database->Change_card_colour($colour, $this->user_id);	
	}
	
	
	/*public function Update_impostazioni($check_findinhome){
		$this->mysql_database->Update_impostazioni( $this->user_id,$check_findinhome);
	}*/
	/*  METHOD:  Update_impostazioni()
		
		IN: $old_pass=NULL,$new_pass=NULL.
		OUT: -
		DESCRIPTION: Update settings (userdata table) in the DB.
	*/
	public function Update_impostazioni_password($old_pass,$new_pass){
        $lib = new PasswordLib\PasswordLib();
        $hash_new_pass = $lib->createPasswordHash($new_pass);
        if( $lib->verifyPasswordHash($old_pass, $this->password)){
            if(!$this->Update_tmg_email_password($old_pass, $new_pass)){
                $this->mysql_database->Save_notify_change_tmg_email_password($new_pass, $this->user_id);
                $this->Notify_update_tmg_email_password($new_pass);
            }

            if(!DEVELOPMENT) {
                $this->Send_email_new_password($new_pass);
            }
            $this->mysql_database->Change_password($hash_new_pass,$this->user_id);
            return true;
        }else{
            return false;
        }
	}

    private function encrypt_data($data, $key ,$salt) {
        $salt = substr($salt, 0, 32);
        $key = substr($key, 0, 12);
        $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv));
        return $encrypted;
    }
    private function decrypt_data($data, $key ,$salt) {
        $salt = substr($salt, 0, 32);
        $key = substr($key, 0, 12);
        $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($data), MCRYPT_MODE_ECB, $iv);
        return $decrypted;
    }

	public function Update_tmg_email_password($old_pass,$new_pass){
		$server_ip=SERVER_IP;
		$server_login=SERVER_LOGIN;
		$server_pass=SERVER_PASS;
		$server_ssl=SERVER_SSL;
		
		 
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
		 $sock->query('/CMD_CHANGE_EMAIL_PASSWORD',
			 array(
		  'email' => $this->Get_member_email(),
		  'oldpassword' => $old_pass,
		  'password1' => $new_pass,
		  'password2' => $new_pass
			 ));
		 $result = $sock->fetch_parsed_body();
		 if ($result['error'] != "0")
		 {
			 return true;
		 }
		 else
		 {
			 return false;
		 }	
	}

	public function Send_email_new_password($new_pass){
		$emailtmg = $this->Get_member_email();
		$mail = new PHPMailer(true);
			try { 
			  $mail->AddAddress($emailtmg, $this->username);

			  $mail->SetFrom("no-reply@topmanagergroup.com", "TopManagerGroup.com");
			  
			  $oggetto = $this->username.", Hai cambiato la tua password TopManagerGroup.com.";
			  
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
							<p id='titolo'>Hai cambiato la password della tua card su TopManagerGroup.</p>
							<p>Ecco la tua nuova password: ".$new_pass."</p>
							
							<p>Conserva questo messaggio email.</p>
							<p>Per qualsiasi problema contattaci all'indirizzo info@topmanagergroup.com</p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation 2015</p>
						</div> 
					</div>
					</body>
				</html>
				";
					  
				  $mail->MsgHTML($messaggio);
				  
				  $mail->Send();
				
			} catch (phpmailerException $e) {
				  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				  echo $e->getMessage(); //Boring error messages from anything else!
			}
	}
	public function Update_impostazioni_curr($change_opt_curr){
		$this->mysql_database->Update_impostazioni_curr($this->user_id,$change_opt_curr);
	}
	
	
	/*  METHOD: Update_europ_cv_step1()
		
		IN: -
		OUT: -
		DESCRIPTION: update european curriculum step 1 (user_curreurop table) in the DB.
	*/
	public function Update_europ_cv_step1($nomecognome, $sesso, $cittadinanza, $dataluogo, $telefono, $email, $indirizzo){
		$sottotitolo = $nomecognome."<br/>".$indirizzo."<br/><br/>Tel: ".$telefono."<br/>e-mail: ".$email;
		$this->mysql_database->Update_europ_cv_step1($nomecognome, $sottotitolo, $sesso, $cittadinanza, $dataluogo,$this->user_id);
	}
	
	public function Update_crea_step0($sudime){
		$this->mysql_database->Update_curriculum($sudime,$this->user_id);	
	}
	
	/*  METHOD: Update_europ_cv_step1()
		
		IN: -
		OUT: -
		DESCRIPTION: update european curriculum step 1 (user_curreurop table) in the DB.
	*/
	public function Update_crea_step1($nomecognome, $sesso, $cittadinanza, $dataluogo, $telefono, $email, $indirizzo,$sudime){
		$sottotitolo = $nomecognome."<br/>".$indirizzo."<br/><br/>Tel: ".$telefono."<br/>e-mail: ".$email;
		
		$this->mysql_database->Update_europ_cv_step1($nomecognome, $sottotitolo, $sesso, $cittadinanza, $dataluogo,$this->user_id);
	}
	
	
	/*  METHOD: Update_europ_cv_step2()
		
		IN: -
		OUT: -
		DESCRIPTION: update european curriculum step 2 (user_curreurop table) in the DB.
	*/
	public function Update_europ_cv_step2($istruzformaz,$esplavorativa){
		$this->mysql_database->Update_europ_cv_step2($istruzformaz, $esplavorativa, $this->user_id);
	}
	
	/*  METHOD: Update_europ_cv_step3()
		
		IN: -
		OUT: -
		DESCRIPTION: update european curriculum step 3 (user_curreurop table) in the DB.
	*/
	public function Update_europ_cv_step3($linguestraniere, $madrelingua, $capacitacompet, $compinformatiche, $comprelsoc, $comporganiz){
		$this->mysql_database->Update_europ_cv_step3($linguestraniere, $madrelingua, $capacitacompet, $compinformatiche, $comprelsoc, $comporganiz, $this->user_id);	
	}
	
	/*  METHOD: Update_europ_cv_step4()
		
		IN: -
		OUT: -
		DESCRIPTION: update european curriculum step 4 (user_curreurop table) in the DB.
	*/
	public function Update_europ_cv_step4($compartistiche, $comptecniche, $comprelativeallav, $altrecompedinteressi){
		$this->mysql_database->Update_europ_cv_step4($compartistiche, $comptecniche, $comprelativeallav, $altrecompedinteressi, $this->user_id);
	}
	
	/*  METHOD: Update_europ_cv_step5()
		
		IN: -
		OUT: -
		DESCRIPTION: update european curriculum step 5 (user_curreurop table) in the DB.
	*/
	public function Update_europ_cv_step5($patente, $ulteriori){
		$this->mysql_database->Update_europ_cv_step5($patente, $ulteriori, $this->user_id);
	}
	
	
	/*  METHOD: Update_bv()
		
		IN: $bv_nome,$bv_professione
		OUT: -
		DESCRIPTION: Update_bv table in the DB.
	*/
	
	public function Update_bv($bv_check_cellulare,$bv_check_email,$bv_check_tmg_email,$bv_check_professione,$bv_cellulare,$bv_email,$bv_professione,$personal_in_bv_web){
		$this->bv_cellulare = $bv_check_cellulare;
		$this->bv_professione = $bv_check_professione;
		
		$this->bv_email = $bv_check_email;
		$this->bv_tmg_email = $bv_check_tmg_email;
		
		$this->cellulare = $bv_cellulare;
		$this->alt_professione = $bv_professione;
		
		$this->email_bv_value = $bv_email;
		
		$this->bv_web = $personal_in_bv_web;
		$this->mysql_database->Update_bv($this->user_id,$bv_check_cellulare,$bv_check_email,$bv_check_tmg_email,$bv_check_professione,$bv_cellulare,$bv_email,$bv_professione,$personal_in_bv_web);
	}
	
	public function delete_me($path="",$eliminazione_immediata=NULL){
		$this->mysql_database->delete_me($this->user_id,$this->id_referente,$this->status,$eliminazione_immediata,$this->username);
		$this->SureRemoveDir($path.USERS_PATH.$this->username."/",true);
		$this->DeleteUserTmgMail($this->username);
	}
	public function DeleteUserTmgMail($username){
		$server_ip=SERVER_IP;
		$server_login=SERVER_LOGIN;
		$server_pass=SERVER_PASS;
		$server_ssl=SERVER_SSL;
		
		echo "Deleteing user $username on server $ip.... <br>\n";
		 
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
		  'action' => 'delete',
		  'domain' => 'topmanagergroup.com',
		  'user' => $username,
			 ));
		 $result = $sock->fetch_parsed_body();
		 if ($result['error'] != "0")
		 {
		  echo "<b>Error Deleting user $username on server $server_ip:<br>\n";
		  echo $result['text']."<br>\n";
		  echo $result['details']."<br></b>\n";
		 }
		 else
		 {
		  echo "User $username deleted on server $server_ip<br>\n";
		 }
	}
	public function Update_professione($professione,$category,$nameshowed){
		$this->mysql_database->Update_professione($professione,$category,$nameshowed,$this->user_id);
		if($this->alt_professione==""){
			$this->bv_cellulare = $bv_check_cellulare;
			$this->bv_professione = $bv_check_professione;
			$this->cellulare = $bv_cellulare;
			$this->alt_professione = $professione;
			Update_bv($bv_check_cellulare,$bv_check_professione,$bv_cellulare,$bv_professione);
		}
	}
	public function Update_dove_siamo($address_via,$address_citta,$address_desc,$address_on){
		$this->mysql_database->Update_dove_siamo($address_via,$address_citta,$address_desc,$address_on,$this->user_id);
	}
	
	public function Add_friend($nome,$cognome,$email,$cell,$friend_note){
		for($i=0;$i<count($this->newsletter_group);$i++)
			if($this->newsletter_group[$i]["nome"]=="richieste di contatto")
				$id_group = $this->newsletter_group[$i]["id"];
				
		/*for($i=0;$i<count($this->newsletter_rows);$i++)
			if($this->newsletter_rows[$i]["row_value"]==$email)
				return 1;*/
		
		$inserted_id = $this->mysql_database->Add_friend($nome,$cognome,$id_group,$cell,$friend_note,$this->user_id);
		$this->Store_new_vcard_emails($email,$inserted_id,$id_group,1);
		$this->Send_mail_add_friend($nome,$cognome,$email,$cell);
		return 0;
	}
	public function Save_assistenza($email,$textarea,$ip){
		$id = $this->mysql_database->Save_assistenza($email,$textarea,$ip);
		$this->Send_mail_assistenza($email,$textarea,$ip);
		$area = new Area();
		$area->Insert_new_panel_log(3,0,0,$email,$id);
		return 0;
	}
	public function Save_abuso($email,$type,$textarea,$ip){
		$id = $this->mysql_database->Save_abuso($email,$type,$textarea,$ip,$this->username);
		$this->Send_mail_abuso($email,$type,$textarea,$ip,$this->username);
		
		$area = new Area();
		$area->Insert_new_panel_log(4,0,0,$email,$id);
		return 0;
	}
	
	public function Send_mail_assistenza($email,$textarea,$ip){
		$mail = new PHPMailer(true);
		try { 
			$mail->AddAddress("info@topmanagergroup.com");
			$mail->SetFrom("no-reply@topmanagergroup.com", "TopManagerGroup.com");
			  
			$oggetto = "RICHIESTA ASSISTENZA.";
			  
			$mail->Subject = $oggetto;
			  
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			$data = date("d/m/Y H:i:s");
			$messaggio = "Ricevuta richiesta di assistenza in data ".$data.":<br/>
			Email: ".$email."<br/>
			Specifiche: <br/>
			".$textarea."<br/>";
			  
			 $mail->MsgHTML($messaggio);
			 $mail->Send();
		}catch(phpmailerException $e){
			 echo $e->errorMessage(); //Pretty error messages from PHPMailer
		}catch(Exception $e){
			 echo $e->getMessage(); //Boring error messages from anything else!
		}
		
	}
	
	
	public function Send_mail_abuso($email,$type,$textarea,$ip,$username){
		$mail = new PHPMailer(true);
		try { 
			$mail->AddAddress("info@topmanagergroup.com");
			$mail->SetFrom("no-reply@topmanagergroup.com", "TopManagerGroup.com");
			  
			$oggetto = "SEGNALAZIONE ABUSO.";
			  
			$mail->Subject = $oggetto;
			  
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			$data = date("d/m/Y H:i:s");
			$messaggio = "Ricevuta segnalazione di abuso data ".$data.":<br/>
			Email: ".$email."<br/>
			CODICE: ".$type."<br/>
			username: ".$username."<br/>
			Specifiche: <br/>
			".$textarea."<br/>";
			  
			 $mail->MsgHTML($messaggio);
			 $mail->Send();
		}catch(phpmailerException $e){
			 echo $e->errorMessage(); //Pretty error messages from PHPMailer
		}catch(Exception $e){
			 echo $e->getMessage(); //Boring error messages from anything else!
		}
		
	}

	//##################################################################################
	//DB FUNCTIONS END
	//##################################################################################
	//##################################################################################
	//GET/SET ATTRIBUTES FUNCTIONS
	//##################################################################################
	public function Show_nome(){
		echo $this->Nome;
	}
	public function Show_Cognome(){
		echo $this->Cognome;
	}
	public function Get_nome(){
		return $this->Nome;
	}
	public function Get_cognome(){
		return $this->Cognome;
	}
	public function Get_nomeandcognome(){
		return $this->Nome.' '.$this->Cognome;
	}
	public function Get_professione(){
		return $this->Professione;	
	}
	
	public function Get_user_id(){
		return $this->user_id;
	}
	public function Get_member_email(){
		return $this->username.'@topmanagergroup.com';	
	}
	public function Get_email(){
		return $this->personalemail;	
	}
	public function Get_username(){
		return strtoupper($this->username);
	}
	public function Getnameshowed(){
		if($this->flagnameshowed==0){
			return strtoupper($this->username);
		}else if ($this->flagnameshowed==1){	
			return strtoupper($this->Nome)." ".strtoupper($this->Cognome);
		}else if ($this->flagnameshowed==2){
			return strtoupper($this->username)." (".strtoupper($this->Nome)." ".strtoupper($this->Cognome).")";
		}
		
	}
	
	//##################################################################################
	//GET/SET ATTRIBUTES FUNCTION END
	//##################################################################################
	//##################################################################################
	//GENERIC FUNCTIONS START
	//##################################################################################
	
	/*  METHOD: Show_explainer($text)
		
		IN: $text
		OUT: {on video print explainer with $text}
		DESCRIPTION: on video printing function.
	*/
	public function Show_explainer($text){
		return '(<span class="explainer" title="'.$text.'">?</span>)';
	}
	
	/*  METHOD:  Get_client_ip()
		
		IN: -
		OUT: -
		DESCRIPTION: return the ip of the remote user.
	*/
	public function Get_client_ip(){
		$ip = getenv('REMOTE_ADDR');
		return $ip;	
	}
	
	/*  METHOD:  del_file_in_dir()
		
		IN: $dirpath
		OUT: -
		DESCRIPTION: delete all the files in $dirpath.
	*/
	function del_file_in_dir($dirpath) {
		  $handle = opendir($dirpath);
		  while (($file = readdir($handle)) !== false) {
			@unlink($dirpath . $file);
		  }
		  closedir($handle);
	}
	
	
	
	function empty_dir($dir) {
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir),
												  RecursiveIteratorIterator::CHILD_FIRST);
		foreach ($iterator as $path) {
		  if ($path->isDir()) {
			 rmdir($path->__toString());
		  } else {
			 unlink($path->__toString());
		  }
		}
		rmdir($dir);
	}
	
	
	
	
	/*  METHOD:  resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale,$newImageWidth,$newImageHeight )
		
		IN: $thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale,$newImageWidth,$newImageHeight.
		OUT: $thumb_image_name
		DESCRIPTION: resize $thumb_image_name as setted by the parameters.
	*/
	public function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale,$newImageWidth,$newImageHeight){
		$thumb_image_name = trim($thumb_image_name);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		$estensione = pathinfo($image, PATHINFO_EXTENSION);
		switch($estensione){
			case "JPG": case "jpg": 
				$source = imagecreatefromjpeg($image);
			break;
			case "JPEG": case "jpeg": 
				$source = imagecreatefromjpeg($image);
			break;	
			case "PNG": case "png": 
				$source = imagecreatefrompng($image);
			break;	
			case "GIF": case "gif": 
				$source = imagecreatefromgif($image);
			break;	
		}
		
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		imagejpeg($newImage,$thumb_image_name,90);
		chmod($thumb_image_name, 0777);
		
		copy($thumb_image_name,"../../".USERS_PATH.$this->username."/user_photo_temp/thumb_".$thumb_image_name);
		//unlink($thumb_image_name);
		return "../../".USERS_PATH.$this->username."/user_photo_temp/thumb_".$thumb_image_name;
	}
	public function Send_mail_add_friend($nome,$cognome,$email,$cell){
		$mail = new PHPMailer(true);
		$emailtmg = $this->Get_member_email();
		try { 
			  $mail->AddAddress($emailtmg, $this->username);
			  $mail->SetFrom("no-reply@topmanagergroup.com", "TopManagerGroup.com");
			  $oggetto = $this->username.", Hai un nuovo richiesta di contatto su TopManagerGroup.com.";
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
							<p id='titolo'>".$this->username.", Hai ricevuto una nuova richiesta di contatto su TopManagerGroup da <a href='mailto:$nome'><b>".$nome." ".$cognome."</b></a>.</p>
							Ecco l'email che ha effettuato la richiesta:<br/>
							<span style='font-style:italic;'>".$email."</span>
							<br/>
							";
							if($cell!=""&&$cell!=NULL){
								$messaggio.="L'utente ha inserito anche un numero cellulare:<br/>
							<span style='font-style:italic;'>".$cell."</span>";
							}
							$messaggio.="<br/>
							Puoi visualizzare le tue richieste di contatto dalla tua personal area nella sezione MAILING LIST: <br/>
							<a href='".PATH_SITO.$this->username."/index.php?personal_area'>".PATH_SITO.$this->username."/</a><br/>
							<br/></p>
							
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
			  
			  $mail->Send();
		} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		}
		
		
		$mail = new PHPMailer(true);
		try { 
			  $mail->AddAddress($email,$nome." ".$cognome);
			  $mail->SetFrom("no-reply@topmanagergroup.com", "TopManagerGroup.com");
			  $oggetto = $nome." ".$cognome.", Grazie per aver utilizzato TopManagerGroup.com.";
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
							<p id='titolo'>".$nome." ".$cognome.", Grazie per aver utilizzato il servizio RICHIESTA AMICIZIA su Topmanagergroup.com</p>
							<p style='font-size:16px;'>Clicca su questo link per creare la tua card e iniziare a guadagnare:<br/><a href='http://www.topmanagergroup.com/'>topmanagergroup.com</a></p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation ".date("Y")."</p>
						</div> 
					</div>
					</body>
				</html>
				";
			  $mail->MsgHTML($messaggio);
			  
			  $mail->Send();
		} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
	
	/*  METHOD:  Show_file_zip($path,$file_name)()		
	IN: $path,$file_name
	OUT: print the list of the zipped directory in $path.$file_name. 
	DESCRIPTION: return the user email address if stored in the DB.
	*/
	public function Show_file_zip($path,$file_name){
		
		$za = new ZipArchive();
		$za->open($path.$file_name);
		echo "<img src='../image/WinZip.png' alt='Cartella compressa .zip' style='vertical-align:middle;'/> ".$file_name." (<a href='".$path.$file_name."' alt='scarica il file.'>download</a>)<br/>";
		echo "<div class='folder_file'>";
			for ($i=0; $i<$za->numFiles;$i++) {
				if($i+1<$za->numFiles)
					echo "<img class='file_separator' src='../image/file_separator_middle.png' alt='file nella cartella' /> ".$za->getNameIndex($i);
				else
					echo "<img class='file_separator' src='../image/file_separator_end.png' alt='file nella cartella' /> ".$za->getNameIndex($i);
				
				echo "<br/>";
			}
		echo "</div>";
	
	}
	/*  METHOD:   delete_slide_photo()		
	IN: $index
	OUT: . 
	DESCRIPTION: remove a photo by $index from the slide.
	*/
	public function delete_slide_photo($index){
		$index = trim($index);
		if(strpos($this->user_photo_slide_path[$index],"../../image/default_photo/")===FALSE){
			@unlink("../../".USERS_PATH.$this->username."/user_photo/".$this->user_photo_slide_path[$index]);
			
			
			$name = trim(substr($this->user_photo_slide_path[$index],4));
			$ctrl=0;
			for($i=0;$i<(count($this->user_photo_slide_big_path));$i++){
				if(($name==$this->user_photo_slide_big_path[$i])&&($i!=$index)){
					$ctrl=1;
				}
			}
			if($name==$this->photo1_path){
				$ctrl=1;	
			}
			if($ctrl==0){
				@unlink("../../".USERS_PATH.$this->username."/download_area/public/photo/".$name);
				@unlink("../../".USERS_PATH.$this->username."/filebox/photo/FOTO_PROFILO/".$name);
				@unlink("../../".USERS_PATH.$this->username."/filebox/photo/FOTO_PROFILO/big_thumb/big_thumb_".$name);
				
			}
		}
		$this->sx_shift_array($this->user_photo_slide_path,count($this->user_photo_slide_path),$index);
		$this->sx_shift_array($this->user_photo_slide_big_path,count($this->user_photo_slide_big_path),$index);
		$this->mysql_database->Recreate_photo_slide($this->user_id , $this->user_photo_slide_path,$this->user_photo_slide_big_path);
	}
	
	/*  METHOD: sx_shift_array()		
	IN: &$array,&$count,$index
	OUT: . 
	DESCRIPTION: shift an array to the left starting from the $index position.
	*/
	function sx_shift_array(&$array,$count,$index){
		$count--;
		for($i=$index;$i<$count;$i++){
			$array[$i]=$array[$i+1];
		}
	}
	
	/*  METHOD: SetArrayBv()		
	IN: &$arraybv
	OUT: . 
	DESCRIPTION: populate &$arraybv with visiting card information.
	*/
	public function SetArrayBv(&$arraybv){
		if($this->bv_cellulare=='1'){
			$arraybv['cell']= $this->cellulare;
		}else{
			$arraybv['cell']= NULL;
		}
		
		if($this->bv_email=='1'){
			$arraybv['email']= $this->email_bv_value;
		}else{
			$arraybv['email']= "";
		}
		
		if($this->bv_web=='1'){
			$arraybv['web']= substr($this->alternative_url,4);
		}else{
			$arraybv['web']= "topmanagergroup.com";
		}
		if($this->bv_professione=='1'){
			if($this->alt_professione!=NULL&&$this->alt_professione!="")
				$arraybv['p']= $this->alt_professione;
			else
				$arraybv['p']= $this->Professione;
		}else{
			$arraybv['p']= NULL;
		}
	}
	
	/*  METHOD: Set_arraycurriculumeurop_titolo()		
	IN: &$arraybv
	OUT: . 
	DESCRIPTION: populate &$array with european curriculum information.
	*/
	public function Set_arraycurriculumeurop_titolo(&$array){
	foreach ($this->curriculum_europeo_data as $key => $value) {
		//echo 'index '.$key.': '.$value;
		switch($key){
			case "nomecognome":
				if($value==''){
					if($this->society==1){
						$array[$key] = strtoupper($this->username);	
					}else{
						$array[$key] = $this->Get_nomeandcognome();	
					}
				}else{
					$array[$key] = $value;
				}
				
			break;
			case "sottotitolo":
				if($value==''){
					$array[$key] = $this->Get_nomeandcognome();			
				}else{
					$array[$key] = $value;
				}
			break;
		}
	}
	}
	
	/*  METHOD: Set_arraycurriculumeurop()		
	IN: &$array_curr,&$array_curr_desc,&$array_num_righe.
	OUT: . 
	DESCRIPTION: populate arrays with european curriculum information(  &$array_curr = right col information , &$array_curr_desc = left col information , &$array_num_righe = number of rows ).
	*/
	public function Set_arraycurriculumeurop(&$array_curr,&$array_curr_desc,&$array_num_righe,&$array_offset){
	foreach ($this->curriculum_europeo_data as $key => $value) {
		$array_num_righe[$key] = (substr_count($value, "<br")+2);
		
		$array_offset[$key] = 0;
		//echo 'index '.$key.': '.$value;
		switch($key){
			case "dataluogo":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['dataluogo']='Data e Luogo di nascita:';
			break;
			case "sesso":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['sesso']='Sesso:';
			break;
			case "cittadinanza":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['cittadinanza']='Cittadinanza:';
			break;
			case "istruzformaz":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['istruzformaz']='Istruzione e Formazione:';
			break;
			case "esplavorativa":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['esplavorativa']='Esperienza Lavorativa:';
			break;
			case "capacitacompet":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['capacitacompet']='Capacità e Competenze personali:';
				if($array_num_righe[$key]==1)
					$array_num_righe[$key]+2;
			break;
			case "madrelingua":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['madrelingua']='Madrelingua:';
			break;
			case "linguestraniere":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['linguestraniere']='Lingue Straniere:';
			break;
			case "compinformatiche":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['compinformatiche']='Capacità e competenze informatiche:';
				$array_offset[$key] = 1;
			break;
			case "comprelsoc":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['comprelsoc']='Capacità e Competenze Relazionali/ Sociali:';
				$array_num_righe[$key]+3;
				$array_offset[$key] = 1;
			break;
			case "comporganiz":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['comporganiz']='Competenze Organizzative:';
				$array_offset[$key] = 1;
			break;
			case "compartistiche":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['compartistiche']='Competenze Artistiche:';
			break;
			case "comptecniche":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['comptecniche']='Competenze Tecniche:';
			break;
			case "comprelativeallav":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['comprelativeallav']='Competenze relative al lavoro per cui ci si candida:';	
				$array_num_righe[$key]+5;
				$array_offset[$key] = 1;
			break;
			case "altrecompedinteressi":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['altrecompedinteressi']='Altre Competenze ed Interessi personali:';
				if($array_num_righe[$key]==0)
					$array_num_righe[$key]+2;
				$array_offset[$key] = 1;
			break;
			case "patente":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['patente']='Patente:';
			break;
			case "ulteriori":
				if($value!=''){
					$array_curr[$key] = $value;			
				}else{
					$array_curr[$key] = NULL;
				}
				$array_curr_desc['ulteriori']='Ulteriori informazioni:';
			break;
			
		}	
	}
	
	}
	
	public function delete_folder($folder,$name){
		echo $this->mysql_database->delete_folder($name,$this->user_id);
		$folder=str_replace("/", "", $folder);
		$name=str_replace("/", "", $name);
		if(is_dir("../../".USERS_PATH.$this->username."/filebox/".$folder."/".$name)){
			$this->SureRemoveDir("../../".USERS_PATH.$this->username."/filebox/".$folder."/".$name,true);
		}
	}
	public function Rename_folder($folder,$name,$new_name){
		if($folder=="private"){
			echo $this->mysql_database->Rename_folder($name,$new_name,$this->user_id);
		}
		$folder=str_replace("/", "", $folder);
		$name=str_replace("/", "", $name);
		$new_name=str_replace("/", "", $new_name);
		if(!is_dir("../../".USERS_PATH.$this->username."/filebox/".$folder."/".$new_name)){
			rename("../../".USERS_PATH.$this->username."/filebox/".$folder."/".$name, "../../".USERS_PATH.$this->username."/filebox/".$folder."/".$new_name);
		}
	}
	
	public function SureRemoveDir($dir, $DeleteMe) {
		if(!$dh = @opendir($dir)) return;
		while (false !== ($obj = readdir($dh))) {
			if($obj=='.' || $obj=='..') continue;
			if (!@unlink($dir.'/'.$obj)) $this->SureRemoveDir($dir.'/'.$obj, true);
    	}
		closedir($dh);
		if ($DeleteMe){
			@rmdir($dir);
		}
	}
	
	/*  METHOD: Show_files($folder)		
	IN: $folder.
	OUT: . 
	DESCRIPTION: Show files in folder.
	*/
	public function Show_files($folder_path){
		$path = "../../".USERS_PATH.$this->username."/filebox/".$folder_path."/";
		
		if(strpos($folder_path,"/")){
			$parent=substr($folder_path,0,strpos($folder_path,"/"));
			$folder=substr($folder_path,strpos($folder_path,"/")+1);
		}else{
			$parent=substr($folder_path,strpos($folder_path,"/"));
			$folder="";
		}
			
		echo "<input id='folder' type='hidden' value='".$folder."' />";
		echo "<input id='parent' type='hidden' value='".$parent."' />";
		
		echo "Elenco File contenuti nella cartella ".$folder_path.":<br/>";
		echo "<div style='height:20px; width: 760px;'>";
		echo "<span style='position:relative; left:3px;'><input type='checkbox' id='check_all' onchange='check_all_files()'/></span> ";
		echo "<span style='position:relative; left:10px;'>Nome</span> ";
		
		echo "<span style='position:absolute; left:550px;'>Ultima mod.</span> ";
		echo "<span style='position:absolute; left:632px;'>Dimensione |</span> ";
		echo "<span style='position:absolute; left:720px;'>Download</span> ";
		echo "</div>";
		echo "<div id='files_container'>";
		
		
		$num_files = 0;
		$total_size = 0;
		// array che conterrà tutti i file contenuti nella cartella
		$file_contenuti = array();
		$handler = opendir($path);
		while ($file = readdir($handler)){
		// if file isn't this directory or its parent, add it to the results
			if ($file != "." && $file != "..") {
				if(!is_dir($path.$file)){
					$file_contenuti[$num_files]=$file;
					$num_files++;
				}
			}
		}
		closedir($handler);
		
		natcasesort($file_contenuti);
		
		$index=0;
		foreach ($file_contenuti as $file) {
			$size = filesize($path.$file);
			$extension = pathinfo($path.$file, PATHINFO_EXTENSION);
			$last_mod = filemtime($path.$file);
			$listed_extension = array("JPG","jpg","JPEG","jpeg","PNG","png","GIF","gif","ZIP","zip","RAR","rar","DOC","doc","DOCX","docx","ODT","odt","TXT","txt","xls","xlsx","PDF","pdf","MP3","mp3","WAV","wav","MP4","mp4","MPEG","mpeg","MOV","mov","AVI","avi","WMA","wma","ODS","ods");
			//jpeg,jpg,gif,png,zip,doc,txt,rar,xls,xlsx,docx,pdf,mov,mp4
			
			$allowed = 0;
			foreach ($listed_extension as $value) {
				if($extension == $value){
					$allowed = 1;
				}
			}
			
			$file_name = $file;
			
			if(strlen($file_name)>52){
				$file_name = substr($file,0,strrpos($file,"."));
				$end_of_name = substr($file_name,strlen($file_name)-5);
				$file_name = substr($file,0,52);
				$file_name = $file_name."...".$extension;
			}
			echo "<input id='file_path_".$index."' type='hidden' value='".$path.$file."' />";
			echo "<input id='file_name_".$index."' type='hidden' value='".$file."' />";
			echo "<div class='container' title='".$file."'>";
			if( $allowed == 1 ){
				echo "<div id='div_file_".$index."' class='file_container'  >";
				if($parent=="public")
					$filebox_type = "file_box";
				else if($parent=="private")
					$filebox_type = "file_box_private";
				else if($parent=="private")
					$filebox_type = "file_box_photo";
				
				echo "<input type='checkbox' id='file_check_".$index."' style='width:16px; height:16px;' onchange='file_check(\"".$index."\")' />".$this->show_file_personal($file_name,$extension,'../../image/filebox/',NULL,$path.$file,$file,$folder_path,"../../",$filebox_type,$folder);
				
				echo "
				<span style='position:relative; float:right; padding-right:25px;'><a href='download.php?u=".$this->username."&".$filebox_type."=true&subfolder=".$folder."&name=".$file."' onclick='uncheck(\"".$index."\")'><img src='../../image/filebox/icona_download.png' alt='Scarica file.' style='width:16px; height:16px;'/></a></span>
				
				<span style='position:relative; float:right; margin-right:18px; width:80px;'> ".$this->format_file_fize_size($size)."</span>
				
				<span style='position:relative; float:right; margin-right:7px; width:80px;'>".idate('d',$last_mod)."/".idate('m',$last_mod)."/".idate('Y',$last_mod)."</span>";
				
				echo "</div>";
				echo "</div>";
				$index++;
			}
				
		}
		
		if($index==0){
			echo "<p>Non sono presenti file. Carica un nuovo file.</p>";
		}
		echo '</div>';
		echo "<div class='file_actions_container'>";
			
			echo '<a target="_self" onclick="Javascript:delete_selected()" style="cursor:pointer;"><img src="../../image/icone/edit-delete.png" style="width:18px; height:18px; cursor:pointer;" alt="elimina" title="Elimina i file selezionati." ><span style="position:relative; top:-4px;">&nbsp;Elimina selezionati</span></a><br/>';
		echo "</div>";
		
		echo "<input type='hidden' id='num_rows' value='".(int)($index/4)."' >";
		echo "<input type='hidden' id='num_files' value='".$index."' >";
		
		echo "<div id='file_actions' class='filebox_upload'>";
		if($parent=="private"){
			$folder_name=$folder;
			echo "<input type='hidden' value='".$this->folders[$folder_name]['folder_pass']."' id='folder_pass' class='passinput'> <a target='_self' onclick='Javascript:change_password()'><img src='../../image/btn/btn_cambia_password_cartella.png' alt='Cambio Password' /></a>";
		}
		echo "</div>";
		echo "<div id='file_down' style='position:absolute; top:325px;'>";
			echo "<div style='position:absolute; left:0px; width:500px;'>";
				if($parent=="photo"){
					$this->Show_upload_file('&sub_folder=true&folder='.$folder.'&parent='.$parent,'1073741','photo');
				}else{
					$this->Show_upload_file('&sub_folder=true&folder='.$folder.'&parent='.$parent,'1073741');	
				}
				echo '
				<div id="uploaderbutton" class="personal_button" style="cursor:pointer; vertical-align:middle; width:140px;" alt="Carica file qui.">
					<span class="text14px">CARICA FILE QUI</a>
				</div>';
				if($parent=="public"){
					echo '<div id="Indietro" class="personal_button" style="cursor:pointer; vertical-align:middle; " onclick="Javascript:torna_root_from_public()" alt="Indietro.">
						<span class="text14px">INDIETRO</a>
					</div>';
				}else if($parent=="private"){
					echo '<div id="Indietro" class="personal_button" style="cursor:pointer; vertical-align:middle; " onclick="Javascript:torna_root()" alt="Indietro.">
						<span class="text14px">INDIETRO</a>
					</div>';
				}else if($parent=="photo"){
					echo '<div id="Indietro" class="personal_button" style="cursor:pointer; vertical-align:middle; " onclick="Javascript:torna_root_from_public()" alt="Indietro.">
						<span class="text14px">INDIETRO</a>
					</div>';
				}
				
				echo '
				<div id="uploadercancelbutton" class="personal_button" style="display:none; position:relative;" alt="Cancel">
					<span class="text14px">CANCELLA</a>
				</div>';
					
			echo "</div>";
		echo "<div>";
	}
	
	/*  METHOD: Show_upload_allegato()		
	IN: .
	OUT: . 
	DESCRIPTION: show the upload button for the attachments.
	*/
	public function Show_upload_file($opt,$max_size,$type=""){
		$uploader=new PhpUploader();    
		// Set a unique name to Uploader  
		$uploader->Name="upload_filebox";    
		//Create a new file upload handler    
		$uploader->UploadUrl = "filebox_handler.php?u=".$this->username.$opt;
		//Step 4: Enable Multiple Files Upload.    
		$uploader->MultipleFilesUpload=true; 
		//Specify the maximum allowed size of the file using MaxSizeKB property  
		$uploader->MaxSizeKB=$max_size;
		//Allowed file extensions
		if($type=='photo')
		$uploader->AllowedFileExtensions="jpeg,jpg,gif,png";
		else
		$uploader->AllowedFileExtensions=ALLOWEDEXTENSION;
		//File Too Large Msg
		$uploader->FileTooLargeMsg="{0} non può essere caricato!\n\nIl file ({1}) è troppo grande. La grandezza massima consentita è: {2}.";
		$uploader->FileTypeNotSupportMsg="L'estensione del file non è consentita! Estensioni consentite: '{0}'";  
		$uploader->CancelUploadMsg="Annulla Caricamento";
		$uploader->CancelAllMsg="Cancella tutto";    
		$uploader->CancelButtonID="uploadercancelbutton";
		
		//Specify the ID of the control that will be used as progress bar panel.        
		$uploader->ProgressCtrlID="uploaderprogresspanel";        
		//Specify the ID of the control that will be used as progress text label.        
		$uploader->ProgressTextID="uploaderprogresstext";
		
		$uploader->InputboxCSSText="font-size: 12px;";
		
		$uploader->InsertButtonID="uploaderbutton";
		//$uploader->MaxFilesLimit=10;
		//$uploader->MaxFilesLimitMsg="Puoi caricare fino ad un massimo di {0} file per volta."; 
		$uploader->NumFilesShowCancelAll=2;
		$uploader->ProgressTextTemplate="%F%..";
		$uploader->UploadingMsg="Caricamento in corso.."; 
		$uploader->TempDirectory="../../".USERS_PATH.$this->username."/filebox/temp/";   
		return $uploader->Render();	
	}
	
	
	public function puliscistringa($stringa)
	{
		$stringa = str_replace("à", "a", $stringa);
		$stringa = str_replace("è", "e", $stringa);
		$stringa = str_replace("à", "a", $stringa);
		$stringa = str_replace("ì", "i", $stringa);
		$stringa = str_replace("ù", "u", $stringa);
		//$stringa = str_replace("\"", "", $stringa);
		$stringa = str_replace("'", "", $stringa);
		return $stringa;
	}
	
	public function show_filebox_subfolder($folder_name){
		$path = "../../".USERS_PATH.$this->username."/filebox/".$folder_name."/";
		$handler = opendir($path);
		
		if(strpos($folder_name,"/")){
			$parent_folder_name=substr($folder_name,0,strpos($folder_name,"/"));
			$subfolder=substr($folder_name,strpos($folder_name,"/")+1);
		}else{
			$parent_folder_name=substr($folder_name,strpos($folder_name,"/"));
			$subfolder="";
		}
		
		$file_contenuti = array();
		$i=0;
		while ($file = readdir($handler)){
			if ($file != "." && $file != ".."){
				if(is_dir($path.$file)&&($file!="thumb")){
					$file_contenuti[$i] = $file;
					$i++;
				}
			}
		}
		closedir($handler);
		
		natcasesort($file_contenuti);
		$index = 0;
		foreach ($file_contenuti as $file) {
			$file_name = $this->Get_short_filename($file,40,40);
			$num_file = $this->Get_numfiles_in_dir($path.$file);		  
			
			echo '<input id="dir_path_'.$index.'" type="hidden" value="'.$path.$file.'" />';
			echo '<input id="'.$folder_name.'_dir_name_'.$index.'" type="hidden" value="'.$file.'" />';
					  
			echo "<div class='sub_folder_main_container'>";
				echo "<div id='div_file_".$index."' class='subfolder_container' title='".$file."'>";
				if($parent_folder_name=="public"){
					echo "<div class='subfolder_icon' onclick='Javascript:dir_clicked(\"".$index."\",\"".$folder_name."\");'>
							<img src='../../image/filebox/icona_folder.png' alt='image.' class='folder_icon' />
						  </div>";
						  echo "<div class='subfolder_name' onclick='Javascript:dir_clicked(\"".$index."\",\"".$folder_name."\");'>".$file_name."</div>";
						  echo "<div class='subfolder_info'>";
						  	echo $num_file." file - <a target='_self' onclick='delete_folder(\"".$folder_name."\",\"".$index."\")' >Elimina</a> - ";
							echo "<a target='_self' onclick='Rename_folder(\"".$folder_name."\",\"".$index."\")' >Rinomina</a>";
						  echo "</div>";
				}else if($parent_folder_name=="private"){
					echo "<div class='subfolder_icon' onclick='Javascript:dir_clicked(\"".$index."\",\"".$folder_name."\");'>
							<img src='../../image/filebox/icona_folder_locked.png' alt='image.' class='folder_icon' />
						  </div>";
						  echo "<div class='subfolder_name' onclick='Javascript:dir_clicked(\"".$index."\",\"".$folder_name."\");'>".$file_name."</div>";
						  echo "<div class='subfolder_info'>";
						  	echo $num_file." file - <a target='_self' onclick='delete_folder(\"".$folder_name."\",\"".$index."\")' >Elimina</a> - ";
							echo "<a target='_self' onclick='Rename_folder(\"".$folder_name."\",\"".$index."\")' >Rinomina</a>";
						  echo "</div>";
	
				}else if($parent_folder_name=="photo"){
					echo "<div class='subfolder_icon' onclick='Javascript:dir_clicked(\"".$index."\",\"".$folder_name."\");'>
							<img src='../../image/filebox/icona_folder_photo.png' alt='image.' class='folder_icon' />
						  </div>";
						  echo "<div class='subfolder_name' onclick='Javascript:dir_clicked(\"".$index."\",\"".$folder_name."\");'>".$file_name."</div>";
						  echo "<div class='subfolder_info'>";
						  	echo $num_file." file - <a target='_self' onclick='delete_folder(\"".$folder_name."\",\"".$index."\")' >Elimina</a> - ";
							echo "<a target='_self' onclick='Rename_folder(\"".$folder_name."\",\"".$index."\")' >Rinomina</a>";
						  echo "</div>";
				}
				
				echo "</div>";
			echo "</div>";
			$index++;
		}
		
		
		if($index==0){
			echo "<p>Non sono presenti cartelle. Crea una nuova cartella.</p>";	
		}
		
		$h = opendir($path.$file);
		$i=0;
		while ($sub_file = readdir($h)) {
			  if ($sub_file != "." && $sub_file != ".." && !(is_dir($path.$file.$sub_file)))
				  $i++;
		}
		echo "<input type='hidden' id='num_rows' value='".(int)($index/4)."' >";
		echo "<input type='hidden' id='num_subfolders' value='".$i."' >";
	
		// tidy up: close the handler
		closedir($h);
	}
	
	public function Get_short_filename($file_name,$max_lenght,$min_lenght){
		if(strlen($file_name)>$max_lenght){
			$file_name = substr($file_name,0,$min_lenght);
		    $file_name = $file_name."...";
		}
		return $file_name;
	}
	
	public function Get_numfiles_in_dir($dir_path){
		$h = opendir($dir_path);
		$i=0;			  
		while ($f = readdir($h)) {
			  if ($f != "." && $f != ".." && !(is_dir($dir_path."/".$f))){
				  $i++;
			  }
		}
		return $i;
	}
	
	
	public function load_create_public_folder(){
		
		echo "<div style='position:absolute; text-align:right; width:300px; color:#FFF; font-size:14px;'>";
			echo "<span style='font-size: 10px;'>MAX 18 CAR</span><br/>";
			echo "Nome: <input id='public_folder_name' onKeyDown='limitText(this,18); Enter_on_create_public_folder(event);' onKeyUp='limitText(this,18);' type='text' class='folderinput'/><br/>";
			echo "<div class='personal_button green_button' style='width:150px; position:relative; top:3px;' onclick='create_public_folder()'><span class='text14px'>CREA CARTELLA</span></div>";
			echo "</div>";
			echo "<div id='results'></div>";
		echo "</div>";
		
	}
	
	public function Load_create_photo_folder(){
		
		echo "<div style='position:absolute; text-align:right; width:300px; color:#FFF; font-size:14px;'>";
			echo "<span style='font-size: 10px;'>MAX 18 CAR</span><br/>";
			echo "Nome: <input id='photo_folder_name' onKeyDown='limitText(this,18); Enter_on_create_photo_folder(event);' onKeyUp='limitText(this,18);' type='text' class='folderinput'/><br/>";
			echo "<div class='personal_button green_button' style='width:150px; position:relative; top:3px;' onclick='create_photo_folder()'><span class='text14px'>CREA ALBUM</span></div>";
			echo "</div>";
			echo "<div id='results'></div>";
		echo "</div>";
		
	}
	
	public function load_create_private_folder(){
		
		echo "<div style='position:absolute; text-align:right; width:300px; color:#FFF; font-size:14px;'>";
			echo "<span style='font-size: 10px;'>MAX 18 CAR</span><br/>";
			echo "Nome: <input id='private_folder_name' onKeyDown='limitText(this,18);' onKeyUp='limitText(this,18);' type='text' class='folderinput'/><br/>";
			echo "<span style='font-size: 10px;'>MAX 10 CAR</span><br/>";
			echo "Password: <input id='private_folder_pass' type='text' class='folderinput' onKeyDown='limitText(this,10);  Enter_on_create_private_folder(event);' onKeyUp='limitText(this,10);'/><br/>";
			echo "<div class='personal_button green_button' style='width:150px; position:relative; top:3px;' onclick='create_private_folder()'><span class='text14px'>CREA CARTELLA</span></div>";
			echo "</div>";
			echo "<div id='results'></div>";
		echo "</div>";
		
	}
	
	public function show_folder_private_filebox($folder,$prepath){
		// create a handler for the directory
		$path = $prepath.USERS_PATH.$this->username."/filebox/".$folder."/";
		$handler = opendir($path);
		echo "<input id='folder' type='hidden' value='".$folder."' />";
		$index = 0;
		$total_size = 0;
		// open directory and walk through the filenames
		while ($file = readdir($handler)) {
		// if file isn't this directory or its parent, add it to the results
			if ($file != "." && $file != ".."){
				if(is_dir($path.$file)){
					  $file_name = $file;
					  if(strlen($file_name)>18){
						  $file_name = substr($file,0,18);
					  }
					  $h = opendir($path.$file);
					  $i=0;
					  $tot_size=0;
					  while ($f = readdir($h)) {
						  	$size=0;
					  		if ($f != "." && $f != ".." && $f != "thumb"){
					  			$i++;
								$size = filesize($path.$file."/".$f);
							}
							$tot_size= $tot_size + $size;
					  }
					  $total_size = $total_size + $tot_size;
					  
					  echo "<input id='dir_path_".$index."' type='hidden' value='".$path.$file."' />";
					  echo "<input id='private_dir_name_".$index."' type='hidden' value='".$file."' />";
					  
					  echo "<div class='container' onmouseover='Javascript:private_dir_over(\"".$index."\");' onmouseout='Javascript:private_dir_out(\"".$index."\");' onclick='Javascript:Load_accedi(\"".$index."\");' title='".$file."'>";
					  //echo "<div class='container' onclick='Javascript:Load_accedi(\"".$index."\");' title='".$file."'>";
					  echo "<div id='private_div_dir_".$index."' class='file_container'>";
					  
					  echo $this->show_dir_locked($file_name,'../image/filebox/',$index);
					  
					  echo "</div>";
					  
					  echo "<div id='private_mod_dir_".$index."' class='mod_dir'>";
					  
					  /*<span style='float:right; margin-right:10px;'>".$i." file.</span>*/
					  
					  echo "</div>";
					  echo "</div>";
					  $index++;
				}else{
					unlink($path.$file);
				}	
			}
			
		}
		if($index==0){
			echo "<p>Non sono presenti cartelle.</p>";	
		}
		
		$h = opendir($path.$file);
		$i=0;
		while ($sub_file = readdir($h)) {
			  if ($file != "." && $file != "..")
				  $i++;
		}
		echo "<input type='hidden' id='num_rows' value='".(int)($index/4)."' >";
		//echo "<input type='hidden' id='num_files' value='".$index."' >";
		$progress_value = ($total_size * 100) / 2048000000;
		closedir($handler);
		
	}
	public function show_dir($file_name,$img_path,$index){
		return "<img src='".$img_path."icona_folder.png' alt='image.' class='folder_icon' /> ".$file_name;
	}
	public function show_dir_locked($file_name,$img_path,$index){
		return "<img src='".$img_path."icona_folder_locked.png' alt='image.' class='folder_icon' /> ".$file_name;
	}
	
	public function Create_private_folder($folder_name,$folder_pass){
		// create a handler for the directory
		$path = "../../".USERS_PATH.$this->username."/filebox/private/";
		$handler = opendir($path);
		$index = 0;
		while ($file = readdir($handler)) {
			if ($file != "." && $file != ".."){
				if(is_dir($path.$file)){ 
					  $index++;
				}else{
					unlink($path.$file);
				}
			}
		}
		closedir($handler);
		if($index>19){
			return "<img src='../../image/icone/error.png' style='width:18px; height:18px; vertical-align:middle;'/> Hai raggiunto il limite massimo di 20 cartelle!";
		}
		
		$folder_name=str_replace("/","",$folder_name);
		$folder_name=str_replace(" ","_",$folder_name);
		$folder_name = $this->puliscistringa($folder_name);
		$this->mysql_database->Add_private_folder($folder_name,$folder_pass,$this->user_id);
		$path = "../../".USERS_PATH.$this->username."/filebox/private/".$folder_name;
		$thumb_path = "../../".USERS_PATH.$this->username."/filebox/private/".$folder_name."/thumb";
		if(!is_dir($path)){
			mkdir($path, 0755);
			mkdir($thumb_path, 0755);
		}
		else{
			return "<img src='../../image/icone/error.png' style='width:18px; height:18px; vertical-align:middle;'/> Esiste già una cartella con questo nome!";
		}
		return "<img src='../../image/icone/ok.png' style='width:22px; height:20px; vertical-align:middle;'/> Cartella creata con successo!";
	}
	
	public function Create_public_folder($folder_name){
		// create a handler for the directory
		$path = "../../".USERS_PATH.$this->username."/filebox/public/";
		$handler = opendir($path);
		$index = 0;
		while ($file = readdir($handler)) {
			if ($file != "." && $file != ".."){
				if(is_dir($path.$file)){ 
					  $index++;
				}
			}
		}
		closedir($handler);
		/*if($index>20){
			return "<img src='../../image/icone/error.png' style='width:18px; height:18px; vertical-align:middle;'/> Hai raggiunto il limite massimo di 10 cartelle!";
		}*/
		
		$folder_name=str_replace("/","",$folder_name);
		$folder_name=str_replace(" ","_",$folder_name);
		$folder_name = $this->puliscistringa($folder_name);
		$path = "../../".USERS_PATH.$this->username."/filebox/public/".$folder_name;
		$thumb_path = "../../".USERS_PATH.$this->username."/filebox/public/".$folder_name."/thumb";
		if(!is_dir($path)){
			mkdir($path, 0755);
			mkdir($thumb_path, 0755);
		}else{
			return "<img src='../../image/icone/error.png' style='width:18px; height:18px; vertical-align:middle;'/> Esiste già una cartella con questo nome!";
		}
		return "<img src='../../image/icone/ok.png' style='width:22px; height:20px; vertical-align:middle;'/> Cartella creata con successo!";
	}
	
	public function Create_photo_folder($folder_name){
		// create a handler for the directory
		$path = "../../".USERS_PATH.$this->username."/filebox/photo/";
		$handler = opendir($path);
		$index = 0;
		while ($file = readdir($handler)) {
			if ($file != "." && $file != ".."){
				if(is_dir($path.$file)){ 
					  $index++;
				}
			}
		}
		closedir($handler);
		/*if($index>9){
			return "<img src='../../image/icone/error.png' style='width:18px; height:18px; vertical-align:middle;'/> Hai raggiunto il limite massimo di 10 cartelle!";
		}*/
		
		$folder_name=str_replace("/","",$folder_name);
		$folder_name=str_replace(" ","_",$folder_name);
		$folder_name = $this->puliscistringa($folder_name);
		$path = "../../".USERS_PATH.$this->username."/filebox/photo/".$folder_name;
		$thumb_path = "../../".USERS_PATH.$this->username."/filebox/photo/".$folder_name."/thumb";
		if(!is_dir($path)){
			mkdir($path, 0755);
			mkdir($thumb_path, 0755);
		}else{
			return "<img src='../../image/icone/error.png' style='width:18px; height:18px; vertical-align:middle;'/> Esiste già una cartella con questo nome!";
		}
		return "<img src='../../image/icone/ok.png' style='width:22px; height:20px; vertical-align:middle;'/> Cartella creata con successo!";
	}
	
	
	public function Change_folder_password($folder_name,$folder_pass){
		$this->mysql_database->Change_folder_password($folder_name,$folder_pass,$this->user_id);
	}

	
	public function format_file_fize_size( $size, $display_bytes=false )
	{
		if( $size < 1024 )
			$filesize = $size . ' bytes';
		elseif( $size >= 1024 && $size < 1048576 )
			$filesize = round( $size/1024, 2 ) . ' KB';
	
		elseif( $size >= 1048576 )
			$filesize = round( $size/1048576, 2 ) . ' MB';
	
		if( $size >= 1024 && $display_bytes )
			$filesize = $filesize . ' (' . $size . ' bytes)';
	
		return $filesize;
	}
	public function show_file($file_name,$extension,$img_path,$only_icon=NULL,$file_path=NULL,$file=NULL,$folder_path,$pre_thumb_path,$fileboxtype,$subfolder){
		if($only_icon!=NULL)
			$file_name=NULL;
		switch($extension){
			case "JPG":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			case "JPEG":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			
			case "jpeg":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			case "PNG":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			case "jpg":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			case "png":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			case "GIF":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			case "gif":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a><div class='file_text_container'>".$file_name."</div>" ;
			break;
			case "ZIP":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "zip":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;			break;
			case "RAR":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "rar":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "DOC":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "doc":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "DOCX":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "docx":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "ODT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "odt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "TXT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "txt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "XLS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "xls":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "XLSX":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "xlsx":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "ODS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "ods":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "PDF":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "pdf":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MP3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mp3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "AVI":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "avi":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MP4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mp4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "WAV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "wav":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MPEG":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mpeg":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MOV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mov":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name;
			break;
			case "WMA":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "wma":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
		}	
	}
	
	public function show_file_personal($file_name,$extension,$img_path,$only_icon=NULL,$file_path=NULL,$file=NULL,$folder_path,$pre_thumb_path,$fileboxtype,$subfolder){
		if($only_icon!=NULL)
			$file_name=NULL;
		switch($extension){
			case "JPG":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name ;
			break;
			case "JPEG":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name ;
			break;
			
			case "jpeg":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name ;
			break;
			case "PNG":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name ;
			break;
			case "jpg":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name ;
			break;
			case "png":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name ;
			break;
			case "GIF":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name;
			break;
			case "gif":
				return "<a class='preview' title='".$file."'><img src='".$pre_thumb_path.USERS_PATH.$this->username."/filebox/".$folder_path."/thumb/thumb_".$file."' alt='image.' class='file_icon'/></a>&nbsp;&nbsp; ".$file_name ;
			break;
			case "ZIP":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "zip":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;			break;
			case "RAR":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "rar":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "DOC":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "doc":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "DOCX":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "docx":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "ODT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "odt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "TXT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "txt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "XLS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "xls":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "XLSX":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "xlsx":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "ODS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "ods":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "PDF":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "pdf":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MP3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mp3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "AVI":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "avi":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MP4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mp4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "WAV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "wav":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MPEG":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mpeg":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "MOV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "mov":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name;
			break;
			case "WMA":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
			case "wma":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='file_icon'/>&nbsp;&nbsp; ".$file_name ;
			break;
		}	
	}
	
	public function show_file_mail_allegato_sent($file_name,$extension,$complete_file_name,$email_id){
		$img_path="../../image/filebox/";
		switch($extension){
			case "JPG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "JPEG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			
			case "jpeg":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "PNG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "jpg":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "png":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "GIF":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle; ' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "gif":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle; color:#000;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px'>&nbsp;".$file_name."</span></a>";
			break;
			case "ZIP":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "zip":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "RAR":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "rar":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "DOC":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "doc":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "DOCX":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "docx":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "ODT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "odt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "TXT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "txt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "XLS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "xls":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "XLSX":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "xlsx":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "ODS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "ods":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "PDF":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "pdf":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MP3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mp3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "AVI":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "avi":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MP4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mp4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "WAV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "wav":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MPEG":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mpeg":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MOV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mov":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			case "WMA":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "wma":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			default:
				return "<img src='".$img_path."mail-attachment.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato_sent=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
        	break;
		}	
	}
	public function show_file_mail_allegato($file_name,$extension,$complete_file_name,$email_id){
		$img_path="../../image/filebox/";
		switch($extension){
			case "JPG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "JPEG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			
			case "jpeg":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "PNG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "jpg":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "png":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "GIF":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle; ' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "gif":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle; color:#000;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px'>&nbsp;".$file_name."</span></a>";
			break;
			case "ZIP":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "zip":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "RAR":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "rar":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "DOC":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "doc":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "DOCX":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "docx":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "ODT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "odt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "TXT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "txt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "XLS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "xls":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "XLSX":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "xlsx":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "ODS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "ods":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "PDF":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "pdf":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MP3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mp3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "AVI":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "avi":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MP4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mp4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "WAV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "wav":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MPEG":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mpeg":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "MOV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "mov":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			case "WMA":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			case "wma":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
			break;
			default:
				return "<img src='".$img_path."mail-attachment.png' alt='image.' class='mail_allegati_icon'/><a style='vertical-align:middle;' href='../card/php/download.php?u=".$this->username."&mail_allegato=true&email_id=".$email_id."&name=".$complete_file_name."' title='Scarica file'><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span></a>";
        	break;
		}	
	}
	public function show_file_new_mail_allegato($file_name,$extension,$complete_file_name){
		$img_path="../../image/filebox/";
		switch($extension){
			case "JPG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "JPEG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			
			case "jpeg":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "PNG":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "jpg":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "png":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "GIF":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "gif":
				return "<img src='".$img_path."icona_image.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "ZIP":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "zip":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "RAR":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "rar":
				return "<img src='".$img_path."icona_zip.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "DOC":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "doc":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "DOCX":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "docx":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "ODT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "odt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "TXT":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "txt":
				return "<img src='".$img_path."icona_doc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "XLS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "xls":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "XLSX":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "xlsx":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "ODS":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "ods":
				return "<img src='".$img_path."icona_calc.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "PDF":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "pdf":
				return "<img src='".$img_path."icona_pdf.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "MP3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "mp3":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "AVI":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "avi":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "MP4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "mp4":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "WAV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "wav":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "MPEG":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "mpeg":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "MOV":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "mov":
				return "<img src='".$img_path."icona_avi.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			case "WMA":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
			case "wma":
				return "<img src='".$img_path."icona_music.png' alt='image.' class='mail_allegati_icon'/><span class='text12px' style='color:#000;'>&nbsp;".$file_name."</span>";
			break;
		}	
	}
	
	
	/*  METHOD: Show_files_public($folder)		
	IN: $folder.
	OUT: . 
	DESCRIPTION: Show files in folder.
	*/
	public function Show_files_public($folder_path,$pre_path='../'){
		// create a handler for the directory
		$path = $pre_path.USERS_PATH.$this->username."/filebox/".$folder_path."/";
		
		
		$handler = opendir($path);
		//echo "<input id='folder' type='hidden' value='".$folder."' />";
		//echo "<br>Elenco cartelle in: ".$folder."<br/>";
		
		$file_contenuti = array();
		$i=0;
		while ($file = readdir($handler)){
			if ($file != "." && $file != ".." && $file!="thumb" && $file!="big_thumb"){
				$file_contenuti[$i] = $file;
				$i++;
			}
		}
		closedir($handler);
		
		natcasesort($file_contenuti);
		
		$index = 0;
		foreach ($file_contenuti as $file) {
			if(!is_dir($path.$file)&&$folder_path=="photo"){
				if(pathinfo($path.$file, PATHINFO_EXTENSION)=="zip"||pathinfo($path.$file, PATHINFO_EXTENSION)=="ZIP")
					@unlink($path.$file);
			}else{
				if(!is_dir($path.$file)){
						
						$size = filesize($path.$file);
						$extension = pathinfo($path.$file, PATHINFO_EXTENSION);
						$last_mod = filemtime($path.$file);
						$listed_extension = array("JPG","jpg","JPEG","jpeg","PNG","png","GIF","gif","ZIP","zip","RAR","rar","DOC","doc","DOCX","docx","ODT","odt","TXT","txt","xls","xlsx","PDF","pdf","MP3","mp3","WAV","wav","MP4","mp4","MPEG","mpeg","MOV","mov","AVI","avi","WMA","wma","ODS","ods");
						$allowed = 0;
						foreach ($listed_extension as $value) {
							if($extension == $value){
								$allowed = 1;
							}
						}
						
						$file_name = $this->Get_short_filename($file,28,20);
						$html_file.= "<input id='file_path_".$index."' type='hidden' value='".$path.$file."' />";
						$html_file.= "<input id='file_name_".$index."' type='hidden' value='".$file."' />";
						if(strpos($folder_path,"/"))
								$subfolder= substr($folder_path,strpos($folder_path,"/")+1);
							else
								$subfolder="";
						$html_file.= "<div class='container' onclick=\"Javascript:location.href='../card/php/download.php?u=".$this->username."&file_box=true&subfolder=".$subfolder."&name=".$file."'\">";
						if( $allowed == 1 ){
							$html_file.= "<div id='div_file_".$index."' class='file_container'>";
							
							$html_file.= $this->show_file($file_name,$extension,'../image/filebox/',NULL,$path.$file,$file,$folder_path,"../","file_box",$subfolder);
							$html_file.= "</div>";
							
							$html_file.= "<div id='mod_file_".$index."' class='mod_file'>
									<span style='float:right; margin-right:10px; color:#000;'><a style='vertical-align:middle; color:#000;' href='../card/php/download.php?u=".$this->username."&file_box=true&subfolder=".$subfolder."&name=".$file."' >(Scarica file <img src='../image/filebox/icona_download.png' alt='Scarica file.' style='width:15px; height:15px;' />)</a>&nbsp;".$this->format_file_fize_size($size)."</span>
								  </div>";
							$html_file.= "</div>";
							$index++;
						}
					}else if(is_dir($path.$file)){
						  $file_name = $this->Get_short_filename($file,28,20);
						  $h = opendir($path.$file);
						  $i=0;
						  $tot_size=0;
						  
						  while ($f = readdir($h)) {
								$size=0;
								if ($f != "." && $f != ".." && $f != "thumb" && $f != "big_thumb"){
									$i++;
									$size = filesize($path.$file."/".$f);
								}
								$tot_size= $tot_size + $size;
						  }
						  $total_size = $total_size + $tot_size;
						  if($folder_path=="public"){
							  
							  $html_folder.= '<input id="public_dir_path_'.$index.'" type="hidden" value="'.$path.$file.'" />';
							  $html_folder.= '<input id="public_dir_name_'.$index.'" type="hidden" value="'.$file.'" />';
							  
							  $html_folder.= "<div class='container' onmouseover='Javascript:public_dir_over(\"".$index."\");' onmouseout='Javascript:public_dir_out(\"".$index."\");' onclick='Javascript:Show_public_folder(\"".$index."\");' title='".$file."'>";
							  $html_folder.= "<div id='public_div_dir_".$index."' class='file_container'>";
							  
							  $html_folder.= $this->show_dir($file_name,'../image/filebox/',$index);
							  
							  $html_folder.= "</div>";
							  
							  $html_folder.= "<div id='public_mod_dir_".$index."' class='mod_dir'><span style='float:right; margin-right:10px;'>".$i." file.</span></div>";
							  $html_folder.= "</div>";
						  }else if($folder_path=="photo"){
							  
							  $html_folder.= "<input id='photo_dir_path_".$index."' type='hidden' value='".$path.$file."' />";
							  $html_folder.= "<input id='photo_dir_name_".$index."' type='hidden' value='".$file."' />";
							  
							  $html_folder.= "<div class='container' onmouseover='Javascript:photo_dir_over(\"".$index."\");' onmouseout='Javascript:photo_dir_out(\"".$index."\");' title='".$file."'>";
							  $html_folder.= "<div id='photo_div_dir_".$index."' onclick='Javascript:Show_photo_folder(\"".$index."\");' class='file_container'>";
							  
							  $html_folder.= $this->show_dir($file_name,'../image/filebox/',$index);
							  
							  $html_folder.= "</div>";
							  
							  $html_folder.= "<div id='photo_mod_dir_".$index."' class='mod_dir'><span style='float:right; margin-right:10px;'> <img src='../image/filebox/icona_download.png' style='width:16px; height:16px; vertical-align:middle;'> <a  href='../card/php/download.php?u=".$this->username."&photo_album=true&subfolder=".$file_name."' style='color:#000;' title='Le immagini verranno scaricate in alta qualità non ridimensionate.'>Scarica album HD</a></span><span style='float:right; margin-right:10px;'>".$i." file.</span></div>";
							  
							  
							 
							  $html_folder.= "</div>";
						  }
						  $index++;
					}
			}

			$total_size = $total_size + $size;
		}
		echo $html_folder;
		echo $html_file;
		if($index==0){
			echo "<p style='width:790px; text_align:center; font-size:14px;'>Non sono presenti file!</p>";	
		}
		echo "<input type='hidden' id='num_rows' value='".(int)($index/4)."' >";
		echo "<input type='hidden' id='num_files' value='".$index."' >";
	}
	
	public function Show_jgallery($folder_path,$pre_path='../'){
		// create a handler for the directory
		$path = $pre_path.USERS_PATH.$this->username."/filebox/".$folder_path."/big_thumb/";
		$handler = opendir($path);
		
		$file_contenuti = array();
		$i=0;
		while ($file = readdir($handler)){
			if ($file != "." && $file != ".." ){
				$file_contenuti[$i] = $file;
				$i++;
			}
		}
		closedir($handler);
		
		natcasesort($file_contenuti);
		
		for($i=0;$i<count($file_contenuti);$i++){
			echo '
				<a href="'.$path.$file_contenuti[$i].'"><img src="'.$path.$file_contenuti[$i].'" alt="Foto '.$i.'" /></a>';
		}	
		
		
	}
	
	
	public function Show_photogallery($folder_path,$pre_path='../'){
		echo '<iframe src="../card/php/jgallery/photo_gallery.php?u='.$this->username.'&folder_path='.$folder_path.'" frameborder="0" style=" position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index:19000;" allowtransparency="true" wmode="Opaque" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	
	public function Show_files_private_area($folder_path){
		// create a handler for the directory
		$path ="../../".USERS_PATH.$this->username."/filebox/private/".$folder_path."/";
		
		$handler = opendir($path);
		
		echo "<input id='folder' type='hidden' value='".$folder_path."' />";
		
		$index = 0;
		$total_size = 0;
		// open directory and walk through the filenames
		while ($file = readdir($handler)) {
		// if file isn't this directory or its parent, add it to the results
			if ($file != "." && $file != ".." && $file != "thumb"  && $file != "bigthumb") {
				$extension = pathinfo($path.$file, PATHINFO_EXTENSION);
				$listed_extension = array("JPG","jpg","JPEG","jpeg","PNG","png","GIF","gif","ZIP","zip","RAR","rar","DOC","doc","DOCX","docx","ODT","odt","TXT","txt","xls","xlsx","PDF","pdf","MP3","mp3","MP4","mp4","MOV","mov","AVI","avi","WMA","wma","ODS","ods");
				
				$allowed = 0;
				foreach ($listed_extension as $value) {
					if($extension == $value){
						$allowed = 1;
					}
				}
				
				
				if( $allowed == 1 ){
					$file_name = $this->Get_short_filename($file,28,20);
					echo "<input id='file_path_".$index."' type='hidden' value='".$path.$file."' />";
					echo "<input id='file_name_".$index."' type='hidden' value='".$file."' />";
					echo "<div class='container' title='".$file."'>";
					echo "<div id='div_file_".$index."' class='file_container'  >";
					echo $this->show_file($file_name,$extension,'../image/filebox/',NULL,"../".USERS_PATH.$this->username."/filebox/private/".$folder_path."/thumb/thumb_".$file,$file,"private/".$folder_path,"../","file_box_private",$folder_path);			
					echo "</div>";
					$size = filesize($path.$file);
					
					echo "<div id='mod_file_".$index."' class='mod_file'>
								<span style='float:right; margin-right:10px; '>
									<a style='vertical-align:middle; color:#000000;' href='../card/php/download.php?u=".$this->username."&file_box_private=true&subfolder=".$folder_path."&name=".$file."'>(Scarica file <img src='../image/filebox/icona_download.png' alt='Scarica file.' style='width:16px; height:16px;' /></a>)&nbsp;".$this->format_file_fize_size($size)."</span>
							  </div>";
					echo "</div>";
					$index++;
				}
			}

			$total_size = $total_size + $size;
		}
		if($index==0){
			echo "<p style='width:900px; text_align:center; font-size:14px;'>Non sono presenti file!</p>";	
		}
		echo "<input type='hidden' id='num_rows' value='".(int)($index/4)."' >";
		echo "<input type='hidden' id='num_files' value='".$index."' >";
	
		// tidy up: close the handler
		closedir($handler);
	}
	
	//##################################################################################
	//GENERIC FUNCTIONS END
	//##################################################################################
	//##################################################################################
	//GENERIC PRINTING FUNCTIONS START
	//##################################################################################
	/*  METHOD:  Show_error()
		
		IN: $errror_message
		OUT: {on video print $errror_message}
		DESCRIPTION: video printing function.
	*/
	public function Show_error($error_message){
		echo $error_message;
	}
	
	/*  METHOD:  Show_error()
		
		IN: $errror_message
		OUT: {on video print user info}
		DESCRIPTION: video printing function.
	*/
	public function Print_user_info(){
		echo $this->Nome;
		echo $this->Cognome;
		echo $this->Professione;
		
	}
	
	/*  METHOD: Show_Nome_Professione()
		
		IN: -
		OUT: {on video print Nome & Professione}
		DESCRIPTION: video printing function.
	*/
	public function Show_Nome_Professione(){
		echo "<div id='nome_professione_text' class='nome_professione_text'>";
			echo $this->Getnameshowed()."<br/>".$this->Professione;
		echo "</div>";
	}
	
	/*  METHOD: Show_photoslide()
		
		IN: -.
		OUT: {on video print slide or secondary photo}
		DESCRIPTION: If user has the slide trigger on print the slide's div, if not print the user secondary photo.
	*/
	public function Show_photoslide(){
			//echo "<div id='slideshow'></div>";
			echo '<div id="gallery" class="photoslide_gallery">
	
				  <div id="slides" class="slides" >';
				  
			for($i=0;$i<sizeof($this->user_photo_slide_path);$i++){
				$pos = strpos($this->user_photo_slide_path[$i], "image/default_photo/foto_slide_");
				if ($pos !== false)
					$path_foto = $this->user_photo_slide_path[$i];
				else
					$path_foto = '../'.USERS_PATH.$this->username.'/'.USER_PHOTO_PATH.$this->user_photo_slide_path[$i];
					
				echo '<div class="slide"><img src="'.$path_foto.'" class="card_slide_photo" id="card_slide_photo_'.$i.'" alt="Foto slideshow"/></div>';
			}
			if(sizeof($this->user_photo_slide_path)==0){
				echo '<div class="slide"><img src="../image/default_photo/foto_slide_1.png" width="350" height="250" alt="Foto slideshow"/></div>';	
				echo '<div class="slide"><img src="../image/default_photo/foto_slide_2.png" width="350" height="250" alt="Foto slideshow"/></div>';	
				echo '<div class="slide"><img src="../image/default_photo/foto_slide_3.png" width="350" height="250" alt="Foto slideshow"/></div>';	
				echo '<div class="slide"><img src="../image/default_photo/foto_slide_4.png" width="350" height="250" alt="Foto slideshow"/></div>';	
				echo '<div class="slide"><img src="../image/default_photo/foto_slide_5.png" width="350" height="250" alt="Foto slideshow"/></div>';	
			}
			echo '</div>
				  <div id="menu">
					  <ul>';
						  for($i=0;$i<sizeof($this->user_photo_slide_path);$i++){
								echo '<li class="menuItem"><a href=""></a></li>';
							}	
					echo '
					  </ul>
				  </div>
				  
				</div>';
				
	}
	
	/*  METHOD: Show_title()
		
		IN: -
		OUT: {on video print title}
		DESCRIPTION: Print the title of the web-page.
	*/
	public function Show_title(){
		return $this->Getnameshowed()." - Top Manager Group";	
	}
	
	/*  METHOD: Show_input_username()
		
		IN: -
		OUT: {on video print personal in_username}
		DESCRIPTION: Print an input containing the username.
	*/
	public function Show_input_username(){
		echo " <input type='hidden' id='in_username' value='".$this->username."'></input> ";
	}
	
	/*  METHOD: Show_main_photo()
		
		IN: $width=210,$height=315,$path.
		OUT: {on video print user main photo}
		DESCRIPTION: video printing function..
	*/
	public function Show_main_photo($width=210,$height=315,$path, $is_card=NULL){
		if($this->photo1_path==""||$this->photo1_path=="../image/default_photo/main.png"){
			$path_foto = $path."image/default_photo/main.png";
		}else
			$path_foto = $path.USERS_PATH.$this->username."/".USER_PHOTO_MAIN_PATH.$this->photo1_path;
		if(!$is_card)
		echo "<img class='main_photo' id='main_photo' src='".$path_foto."' width='".$width."' height='".$height."' />"; 
		else
		echo "<img class='main_photo_card' id='main_photo' src='".$path_foto."'/>"; 
		
	}
	
	
	/*  METHOD: Show_upload_photo()
	IN: .
	OUT: . 
	DESCRIPTION: show the upload button for the attachments.
	*/
	public function Show_upload_photo($index,$new){
		$uploader=new PhpUploader();    
		// Set a unique name to Uploader  
		if($new!=NULL){
			$uploader->Name="upload_photo_slide";    	
		}else{
			$uploader->Name="upload_photo_slide".$index;
		}
		//Create a new file upload handler  
		$upload_url = "../php/slide_upload_handler.php?u=".$this->username."&index=".$index;
		if($new!=NULL)
			$upload_url .= "&new_photo=1";
		$uploader->UploadUrl=$upload_url;
		//Step 4: Enable Multiple Files Upload.    
		$uploader->MultipleFilesUpload=false; 
		//Specify the maximum allowed size of the file using MaxSizeKB property  
		$uploader->MaxSizeKB=10240;
		//Allowed file extensions
		$uploader->AllowedFileExtensions="jpeg,jpg,gif,png";
		//File Too Large Msg
		$uploader->FileTooLargeMsg="{0} non può essere caricato!\n\nIl file ({1}) è troppo grande. La grandezza massima consentita è: {2}.";
		$uploader->FileTypeNotSupportMsg="L'estensione del file non è consentita! Estensioni consentite: '{0}'";  
		$uploader->CancelUploadMsg="Annulla Caricamento";
		$uploader->CancelButtonID="uploadercancelbutton";
		
		//Specify the ID of the control that will be used as progress bar panel.        
		$uploader->ProgressCtrlID="uploaderprogresspanel";        
		//Specify the ID of the control that will be used as progress text label.        
		$uploader->ProgressTextID="uploaderprogresstext";
		
		$uploader->InputboxCSSText="font-size: 12px;";
		if($new!=NULL)
			$uploader->InsertButtonID="uploaderbuttonslide";
		else
			$uploader->InsertButtonID="uploaderbuttonslidenew".$index;
		$uploader->ProgressTextTemplate="%F%..";
		//$uploader->TempDirectory="../tmp_allegati";
		$uploader->TempDirectory="../../tmp/tmp_photo/";
		$uploader->UploadingMsg="Caricamento in corso..";
		
		return $uploader->Render();
	}
	
	/*  _scrollableMETHOD: Show_main_sections()
		
		IN: -
		OUT: {on video print card social buttons}
		DESCRIPTION: Print on video the user's social networks links.
	*/
	public function Show_main_sections() {
		  echo '
		  <nav>
			<h2 id="card_nav_header">SEZIONI</h2>
			<ul class="menu_principale" id="menu-principale">
				<li class="triggers_overlay">
					<a rel="#fotodocumenti">
						<div class="nav_image"><img src="../../image/icone/documenti.png"  /></div>
						<div class="nav_text text14px" >FOTO E DOCUMENTI</div>
					</a>
				</li>
			  
				<li class="triggers_overlay">
					<a rel="#curriculum">
						<div class="nav_image"><img src="../../image/icone/curriculum.png" /></div>
						<div class="nav_text text14px" >STORIA E CURRICULUM</div>
					</a>
				</li>
			  
				<li class="triggers_overlay">
					<a rel="#biglietto">
						<div class="nav_image"><img src="../../image/icone/biglietto.png" /></div>
						<div class="nav_text text14px" >BIGLIETTO DA VISITA</div>
					</a>
				</li>
				
				<li class="triggers_overlay">
					<a rel="#contact">
						<div class="nav_image"><img src="../../image/icone/contatti.png" /></div>
						<div class="nav_text text14px" >CONTATTI</div>
					</a>
				</li>
				
				<li class="triggers_overlay">
					<a rel="#file_box">
						<div class="nav_image"><img src="../../image/icone/filebox.png" /></div>
						<div class="nav_text text14px" >CARTELLE SEGRETE</div>
					</a>
				</li>
			</ul>
			</nav>';
	}
	
	/*  METHOD: Show_card_header()
		
		IN: -
		OUT: {on video print card header section}
		DESCRIPTION: Print on video the user's card header section.
	*/
	public function Show_card_header(){
		echo '<!DOCTYPE html>
				
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="../card/css/index.css" />
				<link rel="stylesheet" type="text/css" href="../card/css/indexresponsive.css" />
				<link rel="stylesheet" type="text/css" href="../card/css/personal_mailing.css" />
				<link rel="stylesheet" type="text/css" href="../common/css/text.css"/>
				<link rel="stylesheet" type="text/css" href="../common/css/icon.css"/>
				<link rel="stylesheet" type="text/css" href="../common/css/buttons.css"/>
				<link rel="stylesheet" type="text/css" href="../basic/css/tmgheader.css"/>
				
				<script>
				function overlay() {
					elem = document.getElementById("overlay");
					 elem.style.visibility="hidden";
					elem = document.getElementById("bodydiv");
					 elem.style.visibility="visible"; 
				 }
				 </script>
				
				';
		if($this->username=="melixaroncari"&& ($this->color_preview!=NULL) ){
			switch($this->color_preview){
			default: 
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_brown.css" />';
			break;
			case 'brown':
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_brown.css" />';
			break;
			case 'pink':
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_pink.css" />';
			break;
			case 'black':
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_black.css" />';
			break;
			case 'azzurro':
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_azzurro.css" />';
			break;
			case 'green':
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_green.css" />';
			break;
			case 'blue':
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_blue.css" />';
			break;
			case 'orange':
				echo '<link rel="stylesheet" type="text/css" href="../card/css/card_orange.css" />';
			break;
			}
		}else{
		switch($this->colore_card){
				default: 
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_brown.css" />';
				break;
				case 'brown':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_brown.css" />';
				break;
				case 'red':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_pink.css" />';
				break;
				case 'black':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_black.css" />';
				break;
				case 'pink':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_pink.css" />';
				break;
				case 'grey':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_grey.css" />';
				break;
				case 'green':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_green.css" />';
				break;
				case 'blue':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_blue.css" />';
				break;
				case 'azzurro':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_azzurro.css" />';
				break;
				case 'orange':
					echo '<link rel="stylesheet" type="text/css" href="../card/css/card_orange.css" />';
				break;
			}
		}
        echo '	<script type="text/javascript">var isIE = false;</script>
				<!--[if IE]>
				
					<script type="text/javascript">

					isIE = true;
					//any other IE specific stuff here
					</script>
				<![endif]-->
				<!-- IE 8 or below -->   
				<!--[if lt IE 9]>
				<script type="text/javascript">

					isIE = true;
					//any other IE specific stuff here
					</script>
				<![endif]-->
				<!-- IE 9 or above -->
				<!--[if gte IE 9]>
				<script type="text/javascript">

					isIE = true;
					//any other IE specific stuff here
				</script>
					        
				<![endif]-->
					
					
				<script src="../common/js/all_jquery_and_tools.min.js "></script>
				<script src="../common/js/login.js" type="text/javascript"></script>
				<script src="../common/js/ajax.inc.js" type="text/javascript"></script>
				<script src="../common/js/md5.js" type="text/javascript"></script>
				<script src="../common/js/sha512.js" type="text/javascript"></script>
				<script src="../common/js/json2.js" type="text/javascript"></script>
				<script src="../common/js/card_common.js" type="text/javascript" ></script>
				
				<!--
				!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				NON CANCELLARE DECOMMENTATO PER MOTIVI DI PRESTAZIONI
				<script type="text/javascript" src="../card/js/checkiban.js"></script>
				NON CANCELLARE SE NON SICURO NECESSARIO PER CONTROLLARE L IBAN AL MOMENTO DELLA RISCOSSIONE
				-->
				<script type="text/javascript" src="../card/js/index.js"></script>
				
				<script type="text/javascript" src="../card/js/personal_mailing.js"></script>
				<script type="text/javascript" src="../card/js/slide-show.js"></script>
				';
				if(DEVEOPMENT==true){
					echo '<script type="text/javascript" src="../common/js/jquery.validate.min.js"></script>';
					echo '<script type="text/javascript" src="../common/js/additional-methods.min.js"></script>';
				}else{
					echo '<script src="http://cdn.jsdelivr.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>';	
					 echo '
				<script src="http://cdn.jsdelivr.net/jquery.validation/1.14.0/additional-methods.min.js"></script>';	
				}
				
               
				
echo '				
				<link type="text/css" href="../common/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
				<script type="text/javascript" src="../common/js/jquery.mousewheel.js"></script>
				<script type="text/javascript" src="../common/js/jquery.jscrollpane.min.js"></script>
				<script type="text/javascript" src="../card/js/triggers_scrollable.js"></script>
				<script type="text/javascript" src="../basic/js/tmgheader.js"></script>
				
				<meta name="description" content="Card Top Manager Group di '.$this->Getnameshowed().'. Top manager Group è la prima società di carte d\' identità online. Entrando a far parte di Top Manager Group potrai godere di tutti i servizi offerti. Utilizzala nel tuo lavoro per farti conoscere e sfrutta il sistema di promoter per guadagnare con noi.">
				<meta name="keywords" content="top, manager, group, la, prima, società, di, web, identity, card">
				
				<meta name="viewport" content="width=device-width, user-scalable=no, 
initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
				<title>'.$this->Show_title().'</title>
				
				</head>';
	}
	
	/*  METHOD: Show_card_down()	
	IN: .
	OUT: . 
	DESCRIPTION: show card section down.
	*/
	public function Show_card_down(){
		echo '<div id="nav_buttons">';
			 $this->Show_main_sections();
		echo '</div>';
		
	}
	
	/*  METHOD: Show_card_down()	
	IN: .
	OUT: . 
	DESCRIPTION: show card section up.
	*/
	public function Show_card_up(){
			echo '<div class="card_up card_shadowed" >';
				if(count($this->news_rows)!=0){
					echo '<div class="show_news_container card_shadowed">';
					echo '<div align="center"><span style="color:#000; font-size:1.4em; font-weight:600;">LE MIE NEWS</span></div>';
					echo '<table id="tabella_agenda_news" class="tabella_agenda_news">';
					$back_row_color_array = array("#3366cc", "#6699ff", "#addee5", "#ade8a6", "#bdc9d7","#b4df89","#dfc889");
					$rand_back_row_color = array_rand($back_row_color_array, sizeof($this->news_rows));
					$k=0;
					foreach($this->news_rows as $news_row){
						if($back_row_color_array[$rand_back_row_color[$k]]=="")
							$back_row_color = "#ade8a6";
						else
							$back_row_color = $back_row_color_array[$rand_back_row_color[$k]];
						echo '	<tr bgcolor="'.$back_row_color.'" class="riga_agenda_news" style="cursor:pointer;" onclick="Javascript:window.open(\'../card/php/show_news_file.php?u='.$this->username.'&id_news='.$news_row["id"].'\')">
							   <td class="col_sottotitolo_news" style="padding-left:7px; text-align:center;" border="1" frame="lhs" rules="none">';
							   		
											echo "<span title='".$news_row["sottotitolo"]."'>".$news_row["sottotitolo"]."</span>";
							   
							   echo '</td>';
							   
							   echo '<td class="col_titolo_news" style="padding-left:15px;">';
							   echo "<span title='".$news_row["titolo"]."'>".$news_row["titolo"]."</span> ";
							   
							   
							   echo '</td>';
							   echo '
							   <td class="col_apri_news" bgcolor="'.$back_row_color.'" style="z-index:10"><span style="color:#0090ff">APRI</span>
							   
							   </td>
						   </tr>
						';
						
						$k++;
					}
						echo '</table>';
					echo '</div>';
				}
			echo '</div>';
	}
	public function check_user_agent ( $type = NULL ) {
        $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
        if ( $type == 'bot' ) {
                // matches popular bots
                if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                        return true;
                        // watchmouse|pingdom\.com are "uptime services"
                }
        } else if ( $type == 'browser' ) {
                // matches core browser types
                if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'mobile' ) {
                // matches popular mobile devices that have small screens and/or touch inputs
                // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
                // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
                if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                        // these are the most common
                        return true;
                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                        // these are less common, and might not be worth checking
                        return true;
                }
        }
        return false;
}

	/*  METHOD: Show_card()	
	IN: .
	OUT: . 
	DESCRIPTION: show all the card.
	*/
	public function Show_card(){
		if($this->status==2){
			$this->Show_card_disabled();
			return;
		}
		$this->Show_card_header();
		
		echo '<body onLoad="overlay()">
		<div id="overlay" class="overlay" align="center">
			<div align="center">
				<div class="overlay_caricamento">
				<p class="text14px"> <img src="../image/icone/loader64.gif" style="vertical-align:middle;"> <span style="padding-left:20px;">Caricamento in corso.</span></p>
				</div>
			</div>
		</div>
		<div id="bodydiv" style="position:relative; top:-10px;">';
			$this->basic->Show_header(true);
			$this->Show_input_username();
			echo '<div align="center">';
			echo '<div style="clear:both;"></div>';	
			
			
				$this->Show_card_up();
			 echo '<div class="cols card_shadowed card_shadowed">
					<div class="col">';
						$this->Show_col1();
					echo '</div>';
					
					echo '<div class="col2">';
						$this->Show_col2();
					echo '</div>';
					echo ' <div class="col3">';
						$this->Show_col3();
					echo '</div>';
					
				
			echo '</div>
				
				<div id="card_down" class="card_down card_shadowed">';
					 $this->Show_card_down();
				echo '</div>
			 </div>';
			 
			 echo '<div id="footer" class="footer" align="center">
			 	<div id="footer_content">
					<span style="position:relative; left:0px; font-size:10px; font-weight:600;" ><a style="cursor:pointer; color:#000; font-weight:700; " href="../index.php">TopManagerGroup website version '.date("Y").'</a> - 
					
						<span class="triggers_overlay"><a style="cursor:pointer; color:#000; font-weight:700; " rel="#assistenza">Assistenza</a></span> - 
						
						<span class="triggers_overlay"><a style="cursor:pointer; color:#000; font-weight:700; " rel="#abuso">Segnala abuso</a></span> - 
						
						<span class="triggers_overlay"><a style="cursor:pointer; color:#000; font-weight:700; " rel="#informazioni">Informazioni</a></span>
					
					</span>
				</div>
			</div>';
			echo '
			<div class="clear"></div>
		</center>
		</div>';
		$this->Show_overlays();
		echo '</body>
		</html>';
		
		
				if($this->options_personal_area!=NULL){
					echo '<script language="javascript" type="text/javascript">
                            $(document).ready(function() {
                                Open_overlay_personal("'.$this->options_tab.'");
							});
						</script>';

				}
				
	}
	public function Show_card_disabled(){
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<link type="text/css" href="../card/css/index.css"/>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>CARD NON DISPONIBILE</title>
			</head>
			<body>
				<div align="center">
					<p>LA CARD NON È DISPONIBILE</p>
				</div>
			</body>
			</html>';	
	}
	/*  METHOD: Show_card_banner()
		
		IN: -
		OUT: {on video print card header section}
		DESCRIPTION: Print on video the user's card banner section.
	*/
	public function Show_card_banner(){
		echo '<div align="center" id="banner_up" class="banner_up">
				<div class="banner_left">
					<a href="../index.php"><img src="../image/banner/banner_scaled.png" width="644" height="70" border="0"/></a>
				</div>
				<div class="banner_right">
					<a href="../index.php?tab=iscrizione&u='.$this->username.'">
		     	      <div class="banner_right_text">
					  	Ti piace la mia carta d\'identità web?<br/>
					  	Apri la tua e guadagna con noi<br/>
					  </div>
					<div class="styledbutton_banner blue" style="width:244px;">
						<span class="text14px" style="color:#FFF">CLICCA QUI</a>
					  </div></a>
				</div>
			</div>';
	}
	
	/*  METHOD: Show_social_buttons()
		
		IN: -
		OUT: {on video print on video the user's card main section}
		DESCRIPTION: Print on video the user's card main section.
	*/
	public function Show_social_buttons(){
		echo '<div class="social_container">';
		echo '<span class="text16px">CONTATTI WEB</span>';
		
		
		if(count($this->social_rows)!=0){
			echo '<div class="show_social_container text14px">';
			echo '<table id="tabella_social_elements" class="tabella_social_elements">';
			$k=0;
			foreach($this->social_rows as $social_row){
				echo '	<tr class="riga_social_elements" style="cursor:pointer;" onclick="Javascript:window.open(\''.$social_row["value"].'\')">
					   <td class="card_social_favicon_coloumn" style="padding-left:7px; text-align:center;" border="1" frame="lhs" rules="none">';
                                if(!DEVELOPMENT)
									echo "<img src='".$social_row["favicon"]."' width='25' height='25' />";
                                else
                                    echo "<img src='' width='25' height='25' />";
					   echo '</td>';
					   
					   echo '<td class="card_social_title_coloumn" style="padding-left:10px;">';
					   echo "<span title='".$social_row["title"]."'>".$social_row["title"]."</span> ";
					   echo '</td>';
					   echo '
				   </tr>
				';
				
				$k++;
			}
				echo '</table>';
			echo '</div>';
		}
		
		
		
		echo '</div>';
	}
	
	public function Show_dove_siamo(){
		echo '<div class="dovesiamo_container">';
			echo '<div class="triggers_overlay"><a rel="#dove_siamo" ><img src="../image/card/btn/btn_dove_siamo.png" border="0" style="cursor:pointer;" /></a></div>';
		echo '</div>';
	}
	
	
	/*  METHOD: Show_col1()		
	IN: .
	OUT: . 
	DESCRIPTION: show card coloumn 1.
	*/
	public function Show_col1(){
		echo "<div class='card_main_photo_container'>";
			$this->Show_main_photo( 210, 315,"../",1);
		echo "</div>";
	}
	
	/*  METHOD: Show_col2()		
	IN: .
	OUT: . 
	DESCRIPTION: show card coloumn 2.
	*/
	public function Show_col2(){
		echo '<div id="nome_professione" class="card_nome_professione_container">';
			$this->Show_Nome_Professione(); 
		echo '</div>';
		echo '<div id="card_slideshow_container" class="card_slideshow_container">';
			//$this->Show_photoslide();
		echo '</div>';
	}
	
	/*  METHOD: Show_col3()		
	IN: .
	OUT: . 
	DESCRIPTION: show card coloumn 3.
	*/
	public function Show_col3(){
		
		echo '<img src="../image/card/col3_line.png" class="col3_line">';	
		$this->Show_social_buttons();
		echo '<div class="card_optionsbutton_container">';
			if($this->address_on==1){
				$this->Show_dove_siamo();
			}
			echo '<div class="contattami_container">';
				echo '<div class="triggers_overlay">';
					echo '<a rel="#friend"><img src="../image/card/btn/btn_contattami.png"  style="z-index:9000;"></a>';		
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	
	/*  METHOD: Show_overlays()		
	IN: .
	OUT: . 
	DESCRIPTION: show card overlays.
	*/
	public function Show_overlays(){
		$this->Show_overlay_curriculum_code();
		$this->Show_overlay_contact_code();
		$this->Show_overlay_file_box_code();
		$this->Show_overlay_personal_area();
		$this->Show_overlay_file_box_public();
		$this->Show_overlay_biglietto();
		$this->Show_overlay_dove_siamo();
		$this->Show_overlay_friend();
		$this->Show_overlay_assistenza();
		$this->Show_overlay_informazioni();
		$this->Show_overlay_abuso();
	}
	
	/*  METHOD: Show_overlay_contact_code()		
	IN: .
	OUT: . 
	DESCRIPTION: show card .
	*/
	public function Show_overlay_contact_code(){
		echo '     
		   <div class="apple_overlay" id="contact">
				<div class="overlay_vertical">
					<div class="clear"></div>';
					$this->Show_Contact();
		echo '
				</div>
		  </div>';	
	}
	
	/*  METHOD: Show_overlay_curriculum_code()		
	IN: .
	OUT: . 
	DESCRIPTION: show curriculum overlay code.
	*/
	public function Show_overlay_curriculum_code(){
		echo '     
		   <div class="apple_overlay" id="curriculum">
				<div class="overlay_vertical">
					<div class="clear"></div>';
					 $this->Show_curriculum(); 
		echo '
				</div>
		  </div>';	
	}
	
	/*  METHOD: Show_overlay_file_box_code()		
	IN: .
	OUT: . 
	DESCRIPTION: show download area overlay code.
	*/
	public function Show_overlay_file_box_code(){	
		echo '     
		   <div class="apple_overlay" id="file_box">
				<div class="overlay_vertical">
					<div class="clear"></div>';
					$this->Show_file_box_private();
		echo '
				</div>
		  </div>';	
	}
	
	/*  METHOD: Show_overlay_personal_area()		
	IN: .
	OUT: . 
	DESCRIPTION: show personal area overlay code.
	*/
	public function Show_overlay_personal_area(){
        echo '
		   <div class="apple_overlay_personal" id="personal_area">
				<div class="overlay_vertical">
					<div class="clear"></div>
                         <div style="display:none">';
									$this->fix_upload();
								echo '</div>
							  <div class="item_personal" id="area_login">';
									if($this->is_user_logged())
										 //$this->Show_personal_logged();
										 echo "<img style='position:absolute; top:240px; left:470px;' src='../image/icone/ajax-loader.gif' alt='loading'/>";
									else{
										 $this->Show_Personal_Login_on_card();
									 }
							 echo ' </div>
				</div>
		  </div>';

        /*echo '<div class="apple_overlay_personal" id="personal_area" style="left:50px;">
					<div id="actions">
						
					</div>
				<div class="scrollable vertical_personal">
					 <div class="items">
						  <div>
						  		<div style="display:none">';
									$this->fix_upload();
								echo '</div>
							  <div class="item_personal" id="personal_area_login">';						
									if($this->is_user_logged())
										 //$this->Show_personal_logged();
										 echo "<img style='position:absolute; top:240px; left:470px;' src='../image/icone/ajax-loader.gif' alt='loading'/>";
									else{ 					
										 $this->Show_Personal_Login_on_card();
									 }
							 echo ' </div>
						  </div>
					 </div>
				  </div>
			  </div>';*/
	}
	
	
	/*  METHOD: Show_overlay_assistenza()		
	IN: .
	OUT: . 
	DESCRIPTION: show personal area overlay code.
	*/
	public function Show_overlay_assistenza(){
		echo '     
		   <div class="apple_overlay" id="assistenza">
				<div class="overlay_vertical">
					<div class="clear"></div>';
					 $this->Show_assistenza();
		echo '
				</div>
		  </div>';	
	}
	
	public function Show_assistenza(){
		 echo "<div id='overlay_biglietto' class='overlay_biglietto'>";
		 	echo '<div class="overlay_title_container"><span class="text14px">RICHIEDI ASSISTENZA</span></div>';
			echo "<div id='overlay_assistenza_container' class='content_overlay_container' style='color:#000;padding:0.2em;'>";
					echo "Email&nbsp;<input type='text' id='assistenza_email' class='input_text_normal' style='width:250px; color:#FFF;'></input><br/>
					Descrivi il tuo problema:<br/>";
					echo '<textarea style="width:90%; height:150px;" required="required" class="textarea_assistenza" id="textarea_assistenza" ></textarea>';
					echo "<div class='overlay_button' id='submit_assistenza' onclick='Submit_assistenza()' style='margin-top: 5px;'>
							<span class='text14px' style='color:#FFF'>INVIA</a>
						</div>";
					echo "<p class='text12px'>Inviando l'indirizzo ip del tuo computer verrà registrato insieme al messaggio. Verrai contattato entro 72 ore lavorative. Eventuali abusi saranno perseguiti.</p>";
					echo '<input type="hidden" id="assitenza_in_ip" value='.$this->Get_client_ip().'></input>';
				echo "</div>";
				echo "<div id='assistenza_results' style='position: absolute; top: 50px; left: 95px; width: 600px; height: 35px; display: none;'></div>";
		echo "</div>";
	}
	
	/*  METHOD: Show_overlay_abuso()		
	IN: .
	OUT: . 
	DESCRIPTION: show personal area overlay code.
	*/
	public function Show_overlay_abuso(){
		echo '     
		   <div class="apple_overlay" id="abuso">
				<div class="overlay_vertical">
					<div class="clear"></div>';
					 	$this->Show_abuso();
		echo '
				</div>
		  </div>';
	}
	
	public function Show_abuso(){
		 echo "<div id='overlay_biglietto' class='overlay_biglietto'>";
		 	echo '<div class="overlay_title_container"><span class="text14px">SEGNALA UN ABUSO</span></div>';
			echo "<div id='overlay_abuso_container' class='content_overlay_container' style='color:#000;padding:0.2em;'>";
					echo "Email&nbsp;<input type='text' id='abuso_email' class='input_text_normal' style='width:250px; color:#FFF;'></input><br/>";
					echo '
					<input type="radio" name="radioabuso" value="porno"> Pornografia o materiale a carattere esplicitamete sessuale<br>
					<input type="radio" name="radioabuso" value="odio"> Incitazione all\'odio o violenza grafica<br>
					<input type="radio" name="radioabuso" value="molestie"> Molestie o bullismo<br/>
					<input type="radio" name="radioabuso" value="copy"> Materiale protetto da copyright<br/>
					<input type="radio" name="radioabuso" value="violato"> Questo account potrebbe essere violato o compromesso<br/>

					<input type="radio" name="radioabuso" value="altro"> Altro (descrivi il tipo di abuso):<br/>
					<textarea style="width:95%; height:120px;" required="required" class="textarea_assistenza" id="textarea_abuso" ></textarea>';
					echo "<div class='overlay_button' id='submit_abuso' onclick='Submit_abuso()' style='margin-top: 5px;'>
							<span class='text14px' style='color:#FFF'>INVIA</a>
						</div>";
					echo "<p class='text12px'>Inviando l'indirizzo ip del tuo computer verrà registrato insieme al messaggio. Eventuali abusi saranno perseguiti.</p>";
					echo '<input type="hidden" id="abuso_in_ip" value='.$this->Get_client_ip().'></input>';
				echo "</div>";
				echo "<div id='abuso_results' style='position: absolute; top: 50px; left: 95px; width: 600px; height: 35px; display: none;'></div>";
		echo "</div>";
	}
	
	/*  METHOD: Show_overlay_informazioni()		
	IN: .
	OUT: . 
	DESCRIPTION: show personal area overlay code.
	*/
	public function Show_overlay_informazioni($on_page=false){
		echo '     
		   <div class="apple_overlay" id="informazioni">
				<div class="overlay_vertical">
					<div class="clear"></div>';
					 if($on_page!=true){
						  $this->Show_informazioni("../");
					 }else{
						 $this->Show_informazioni("../../");
					 }
		echo '
				</div>
		  </div>';	
	}
	
	
	
	public function Show_informazioni($prepath){
		echo '<div class="overlay_title_container"><span class="text14px">INFORMAZIONI</span></div>';
		echo '
			<div class="content_overlay_container" style="color:#000">
				<br/>
				Entrando a far parte della TopManagerGroup otterrai:<br/><br/>
				IL TUO SITO WEB PERSONALE<br/>
				<span style="font-size:12px;">Facile da autogestire, elegante, professionale e pulito nel look senza la presenza di pubblicità.<br/>
Chiaro per chi lo guarda, con l\'essenziale per presentare te stesso o la tua attività.</span><br/>
				<br/>
				
				VALORE AL TUO NOME<br/>
				<span style="font-size:12px;">Il marchio TMG  si unisce al tuo nome suscitando così interesse nella tua persona, hobby o attività.<br/>
				Ti verrà fornita una mail: tuonome.tuocognome@topmanagergroup.com<br/>
				L\'indirizzo del tuo sito sarà: topmanagergroup.com/tuonome.tuocognome</span>
				
				<br/>
				<br/>
				
				GUADAGNO<br/>
				<span style="font-size:12px"> Ti vengono riconosciute € 25 per ogni persona che si iscrive tramite te al nostro gruppo.<br/>Guadagno riconfermato ad ogni sua reiscrizione annuale!</span>
				<br/><br/>
				<div class="overlay_button" id="submit_friend" onclick="window.location.href = \''.$prepath.'index.php?tab=iscrizione&u='.$this->username.'\';" style="width:160px; margin-top: 5px;">
					<span class="text14px" style="color:#FFF">VAI ALLA HOMEPAGE</a>
				</div>
			</div>';
	}
	/*  METHOD: Show_overlay_file_box_public()		
	IN: .
	OUT: . 
	DESCRIPTION: show filebox public overlay code.
	*/
	public function Show_overlay_file_box_public(){
		echo '     
		   <div class="apple_overlay" id="fotodocumenti">
				<div class="overlay_vertical">
					<div class="clear"></div>';
						$this->Show_file_box_public();	
		echo '
				</div>
		  </div>';	
		
	}
	
		/*  METHOD: Show_overlay_biglietto()		
	IN: .
	OUT: . 
	DESCRIPTION: show biglietto overlay code.
	*/
	public function Show_overlay_biglietto(){
		echo '     
		   <div class="apple_overlay" id="biglietto">
				<div class="overlay_vertical">
					<div class="clear"></div>';
					$this->Show_biglietto();
		echo '
				</div>
		  </div>';	
	}
	public function Show_overlay_dove_siamo(){
		echo '     
		   <div class="apple_overlay" id="dove_siamo">
				<div class="overlay_vertical">
					<div class="clear"></div>';
						if($this->address_on)										
							$this->Show_dove_siamo_map();
		echo '
				</div>
		  </div>';
	}
	
	public function Show_overlay_friend(){
		echo '
			<div class="apple_overlay" id="friend">
					<div id="actions">
						
					</div>
				<div class="scrollable overlay_vertical">
					 <div class="items">
						  <div>
							  <div class="item" style="height:200px;" id="item_add_friend">';											
								$this->Show_friend();	
							 echo ' </div>
						  </div>
					 </div>
				  </div>
			  </div>
		
		';
	}
	public function Show_friend(){
		echo "<div class='overlay_title_container'>LASCIAMI IL TUO CONTATTO</div>";
		 echo "<div id='overlay_friend' class='content_overlay_container' style='color:#000'>";
			echo "
				<div class='overlay_friend_input_container'>Nome&nbsp;<input type='text' id='friend_name' class='input_text_normal' style='width:180px; height:25px;'></input></div>
				<div class='overlay_friend_input_container'>Cognome&nbsp;<input type='text' id='friend_surname' class='input_text_normal' style='width:180px; height:25px;'></input></div>
			
				<div class='overlay_friend_input_container'>Email&nbsp;<input type='text' id='friend_email' class='input_text_normal' style='width:250px; height:25px;'></input></div>
				<div class='overlay_friend_input_container'>Cellulare (facoltativo)&nbsp;<input type='text' id='friend_cell' class='input_text_normal' style='width:180px; height:25px;'></input></div>";
				
			echo "<div class='overlay_friend_input_container'>Ulteriori Note:</div>";
			echo '<textarea id="friend_note" class="input_text_normal" cols="77" rows="7" style="width:80%; height:125px;"></textarea>';
			echo "<br/><div class='overlay_button' id='submit_friend' onclick='submit_friend()' style='margin-top: 5px;'>
					<span class='text14px' style='color:#FFF'>INVIA</a>
				</div>";
			echo "<p class='text12px'>Inviando autorizzi ".$this->username." e la topmanagergroup ad inviare messaggi alla tua mail.</p>";
		echo "</div>";
		echo "<div id='friend_results' style='position: absolute; top: 50px; left: 325px; width: 300px; height: 35px; display:none;'></div>";
	}
	
	
	public function Show_dove_siamo_map(){
		echo "<div class='overlay_title_container'>DOVE SIAMO</div>";
		 echo "<div id='overlay_dove_siamo' class='content_overlay_container'>";
		 	echo '<img src="../image/icone/spinner-big.gif" style="width:10%" alt="Loading..." />';
		echo "</div>";
	}

	
	public function Show_biglietto(){
		 	echo '<div class="overlay_title_container"><span class="text14px">BIGLIETTO DA VISITA <a href="../card/php/bvpdfdownload.php?u='.$this->username.'"><span style="font-size:11px;"><img src="../image/filebox/icona_pdf.png" style="width:16px; height:16px; vertical-align:middle; position:relative; top:-2px;"/>&nbsp;PDF</span></a></span>- <a href="../card/php/createvcard.php?u='.$this->username.'"><span style="font-size:11px;"><img src="../image/filebox/icona_download.png" style="width:16px; height:16px; vertical-align:middle; position:relative; top:-2px;"/>&nbsp;VCF</span></a></div>';
			echo "<div class='content_overlay_container'>";
			echo "<div id='overlay_biglietto_container' class='overlay_biglietto_container'></div>";
			echo "</div>";
	}
	
	public function Create_bigliettovisita(){
		// customizable variables
		$font_file 		= '../../font/Futura-Book.ttf';
		$font_color 	= '#000000';
		$image_file 	= '../../image/biglietto/tmgbv2012.jpg';
	
		$x_finalpos 	= 227;
		$y_finalpos 	= 153;
	
		$mime_type 			= 'image/jpg' ;
		$extension 			= '.jpg' ;
		$s_end_buffer_size 	= 4096 ;
	
		// create and measure the text
		$font_rgb = $this->hex_to_rgb($font_color) ;
		$image =  imagecreatefromjpeg($image_file);
		// allocate colors and measure final text position
		$font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],$font_rgb['blue']) ;
		$image_width = imagesx($image);
		$image_height = imagesy($image);
		
		$this->SetArrayBv($arraybv);
	
	
	
		//stampo il nome / cognome / username
		if(strlen($this->Getnameshowed())>35){//il nameshowed è più lungo di 35 caratteri
			$font_size = 14 ; // font size in pts
			if ($this->flagnameshowed==1){	
				$text = strtoupper($this->Nome)." ".strtoupper($this->Cognome);	
				$box = @ImageTTFBBox($font_size,0,$font_file,$text);
				$text_width = abs($box[2]-$box[0]);
				$text_height = abs($box[5]-$box[3]);
				$put_text_x = ($image_width/2)-($text_width/2);
				$currenty = $y_finalpos;
				imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			}else if ($this->flagnameshowed==2){
				$text = strtoupper($this->username);	
				$box = @ImageTTFBBox($font_size,0,$font_file,$text);
				$text_width = abs($box[2]-$box[0]);
				$text_height = abs($box[5]-$box[3]);
				$put_text_x = ($image_width/2)-($text_width/2);
				$currenty = $y_finalpos;
				imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
				
				$text = "(".strtoupper($this->Nome)." ".strtoupper($this->Cognome).")";	
				$box = @ImageTTFBBox($font_size,0,$font_file,$text);
				$text_width = abs($box[2]-$box[0]);
				$text_height = abs($box[5]-$box[3]);
				$put_text_x = ($image_width/2)-($text_width/2);
				$currenty = $currenty+$text_height+12;
				imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
				
			}	
		}else{//name showed ci sta su una riga
			$font_size = 14 ; // font size in pts
			$text = $this->Getnameshowed();	
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $y_finalpos;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}
			
		
		//stampo la professione
		$font_size = 12;
		$font_file 	= '../../font/Futura-Bold.ttf';
		
		if($arraybv['p']!= NULL){
			$text= $arraybv['p'];
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+12;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}
		
		if($arraybv['cell']!= NULL){
			$text = $arraybv['cell'];
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+10;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}
		
		$currenty=220;
		$font_size = 12 ;
		$font_file 	= '../../font/Futura-Book.ttf';
		
		$text="web: ".$arraybv['web']."/".$this->username;
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $currenty+$text_height+8;
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		
		if($arraybv['email']!= ""){
			$text="mail: ".$arraybv['email'];
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+2;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			
			if($this->bv_tmg_email==1){
				$text="TMG mail: ".$this->Get_member_email();
				$box = @ImageTTFBBox($font_size,0,$font_file,$text);
				$text_width = abs($box[2]-$box[0]);
				$text_height = abs($box[5]-$box[3]);
				$put_text_x = ($image_width/2)-($text_width/2);
				$currenty = $currenty+$text_height+2;
				imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			}
		}else{
			if($this->bv_tmg_email==1){
				$text="TMG mail: ".$this->Get_member_email();
				$box = @ImageTTFBBox($font_size,0,$font_file,$text);
				$text_width = abs($box[2]-$box[0]);
				$text_height = abs($box[5]-$box[3]);
				$put_text_x = ($image_width/2)-($text_width/2);
				$currenty = $currenty+$text_height+2;
				imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			}
		}
		
		ImageJPEG($image,'../../'.USERS_PATH.$this->username.'/download_area/public/tmg_'.$this->username.'_biglietto.jpg');
		ImageDestroy($image);	
		echo "<img src='../../".USERS_PATH.$this->username."/download_area/public/tmg_".$this->username."_biglietto.jpg' class='card_biglietto_img'></img>";
		
	}
	public function hex_to_rgb($hex) {

		// remove '#'

		if(substr($hex,0,1) == '#')

			$hex = substr($hex,1) ;

	

		// expand short form ('fff') color to long form ('ffffff')

		if(strlen($hex) == 3) {

			$hex = substr($hex,0,1) . substr($hex,0,1) .

				   substr($hex,1,1) . substr($hex,1,1) .

				   substr($hex,2,1) . substr($hex,2,1) ;

		}

	

		if(strlen($hex) != 6)

			fatal_error('Error: Invalid color "'.$hex.'"') ;

	

		// convert from hexidecimal number systems

		$rgb['red'] = hexdec(substr($hex,0,2)) ;

		$rgb['green'] = hexdec(substr($hex,2,2)) ;

		$rgb['blue'] = hexdec(substr($hex,4,2)) ;

	

		return $rgb ;

	}

	public function Clear_temp($path){
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($dh)) != false) {
					if($file!="."&&$file!=".."){
						//elimino il file se non è stato creato il giorno stesso
						$date_modify = date( "D d M Y g:i A", filemtime($path.$file));
						$timestamp = strtotime($date_modify);
						$day_modify = idate('d', $timestamp);
						$now_data = strtotime(date("F j, Y, G:i"));
						$now_day = idate('d',$now_data);
						
						if($day_modify!=$now_day){
								$this->SureRemoveDir($path.$file,true);
						}else{
							//elimino il file se è stato creato dalla stessa sessione
							$session_id = session_id();
							//$saved_session_id = substr($file,0,strpos($file,'_'));
							$saved_session_id=$file;
							if($session_id==$saved_session_id){
								$this->SureRemoveDir($path.$file,true);
							}
						}
					}
				}
				closedir($dh);
			}
		}
	}
	
	function Get_allegato_desc($file_name){
		$session_id = session_id();
		$path = "../../tmp_allegati/".$session_id."/";
		//echo $path.$file_name;
		$img_path = "../image/filebox/";
		$file_long=$file_name;
		$extension = pathinfo($path.$file_name, PATHINFO_EXTENSION);
		$file_name = str_replace(".".$extension,"",$file_name);
		if(strlen($file_name)>12){
			$file_name= substr($file_name,0,12);
			$file_name.=".".$extension;
		}else{
			$file_name.=".".$extension;
		}
		/*if($only_icon==NULL)
			$file_name=NULL;*/
		$res="";
		switch($extension){
			case "JPG":
				$res = "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "JPEG":
				$res =  "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "PNG":
				$res =  "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "jpg":
				$res =  "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "jpeg":
				$res =  "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "png":
				$res =  "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "GIF":
				$res =  "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "gif":
				$res =  "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "ZIP":
				$res =  "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "zip":
				$res =  "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "RAR":
				$res =  "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "rar":
				$res =  "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "DOC":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "doc":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "DOCX":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "docx":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "ODT":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "odt":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "TXT":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "txt":
				$res =  "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "XLS":
				$res =  "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "xls":
				$res =  "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "XLSX":
				$res =  "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "xlsx":
				$res =  "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "ODS":
				$res =  "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "ods":
				$res =  "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "PDF":
				$res =  "<img src='".$img_path."icona_pdf.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "pdf":
				$res =  "<img src='".$img_path."icona_pdf.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "MP3":
				$res =  "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "mp3":
				$res =  "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "AVI":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "avi":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "MP4":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "mp4":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "WAV":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "wav":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "MPEG":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "mpeg":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "MOV":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "mov":
				$res =  "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "WMA":
				$res =  "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			case "wma":
				$res =  "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span title='".$file_long."'>".$file_name."</span>";
			break;
			default:
				$res =  "<span title='".$file_long."'>".$file_name."</span>";
			break;
		}
		$res.="&nbsp;<img src='../image/filebox/icona_delete.png' style='position:relative; top:3px; width:15px; height:15px; cursor:pointer;' alt='Elimina allegato' title='Elimina allegato' onclick=\"Delete_allegato('".$path.$file_long."')\">&nbsp;&nbsp;";
		return $res;
	}
	
	function Get_evidenza_desc($file,$file_name){
		
		$img_path = "../../image/filebox/";
		$extension = pathinfo($file, PATHINFO_EXTENSION);
		//$file_name= substr($file_long,0,5);
		//$file_name.="..".$extension;
		/*if($only_icon==NULL)
			$file_name=NULL;*/
		switch($extension){
			case "JPG":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "JPEG":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "PNG":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "jpg":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "jpeg":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "png":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "GIF":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "gif":
				return "<img src='".$img_path."icona_image.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "ZIP":
				return "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "zip":
				return "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "RAR":
				return "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "rar":
				return "<img src='".$img_path."icona_zip.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "DOC":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "doc":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "DOCX":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "docx":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "ODT":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "odt":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "RTF":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "rtf":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "TXT":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "txt":
				return "<img src='".$img_path."icona_doc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "XLS":
				return "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "xls":
				return "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "XLSX":
				return "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "xlsx":
				return "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "ODS":
				return "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "ods":
				return "<img src='".$img_path."icona_calc.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "PDF":
				return "<img src='".$img_path."icona_pdf.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "pdf":
				return "<img src='".$img_path."icona_pdf.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "MP3":
				return "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "mp3":
				return "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "AVI":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "avi":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "MP4":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "mp4":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "WAV":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "wav":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "MPEG":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "mpeg":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "MOV":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "mov":
				return "<img src='".$img_path."icona_avi.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "WMA":
				return "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			case "wma":
				return "<img src='".$img_path."icona_music.png' title='".$file_name."' alt='image.' class='file_icon'/> <span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
			default:
				return "<span class='evidenza_file_name' title='".$file_long."'>".$file_name."</span>";
			break;
		}
		echo "&nbsp;&nbsp;&nbsp;";
	}
	
	/*  METHOD: Show_upload_allegato()
	IN: .
	OUT: . 
	DESCRIPTION: show the upload button for the attachments.
	*/
	public function Show_upload_allegato(){
		$uploader=new PhpUploader();    
		// Set a unique name to Uploader  
		$uploader->Name="upload_allegati";    
		//Create a new file upload handler    
		$uploader->UploadUrl="../card/php/upload-handler.php?u=".$this->username;
		//Step 4: Enable Multiple Files Upload.    
		$uploader->MultipleFilesUpload=false; 
		//Specify the maximum allowed size of the file using MaxSizeKB property  
		$uploader->MaxSizeKB=10240;
		//Allowed file extensions
		$uploader->AllowedFileExtensions=ALLOWEDEXTENSION;
		//File Too Large Msg
		$uploader->FileTooLargeMsg="{0} non può essere caricato!\n\nIl file ({1}) è troppo grande. La grandezza massima consentita è: {2}.";
		$uploader->FileTypeNotSupportMsg="L'estensione del file non è consentita! Estensioni consentite: '{0}'";  
		$uploader->CancelUploadMsg="Annulla Caricamento";
		$uploader->CancelButtonID="uploadercancelbutton";
		
		//Specify the ID of the control that will be used as progress bar panel.        
		$uploader->ProgressCtrlID="uploaderprogresspanel";        
		//Specify the ID of the control that will be used as progress text label.        
		$uploader->ProgressTextID="uploaderprogresstext";
		
		$uploader->InputboxCSSText="font-size: 12px;";
		
		$uploader->InsertButtonID="uploaderbutton";
		$uploader->ProgressTextTemplate="%F%";
		//$uploader->SaveDirectory="/myfolder";
		$uploader->TempDirectory="../../tmp_allegati";
		$uploader->UploadingMsg="Caricamento in corso..";
		
		return $uploader->Render();
	}
	
	
	public function Show_scarica_bv(){
		echo '<div style="float:left;"><a href="../card/php/download.php?u='.$this->username.'&bv=true"><img class="img_button" src="../image/btn/btn_bv.png"></a></div>';	
	}
	
	
	/*  METHOD: Show_open_european_curriculum()
		
		IN: -
		OUT: {on video print the button that opens the european curriculum}
		DESCRIPTION: On video printing function.
	*/
	public function Show_open_european_curriculum(){
		if(isset($this->color_preview))
			echo "<img src='../image/card_".$this->color_preview."/btn/btn_visualizza_curr_europ.png' style='cursor:pointer; padding-top:7px; width:100%' class='option_over_tab' onClick='show_curr_europ()'>";
		else
			echo "<img src='../image/card_".$this->colore_card."/btn/btn_visualizza_curr_europ.png' style='cursor:pointer;  padding-top:7px; width:100%' class='option_over_tab' onClick='show_curr_europ()'>";
	}
	
	/*  METHOD: Show_select_photo_slide_showed()
		
		IN: -
		OUT: {on video print on video the button that opens the curriculum}
		DESCRIPTION: Print on video the button that opens the curriculum.
	*/
	public function Show_select_photo_slide_showed($index=NULL){
		if(sizeof($this->user_photo_slide_path)==0){
			//btn aggiungi
			echo "";	
		}
		if(sizeof($this->user_photo_slide_path)>0){
			echo '<select style="display:none;" name="photo_slide_showed" id="photo_slide_showed" class="select_photo_slide_showed" onchange="load_photo_slide(this.value)">';
			if($index==NULL)
				echo '<option value="0" selected="selected">1</option>';
			else if($index==0)
				echo '<option value="0" selected="selected">1</option>';
			else if($index!=NULL&&$index!=0)
				echo '<option value="0">1</option>';
	
				
			for($i=1;$i<sizeof($this->user_photo_slide_path);$i++){
				if($index==$i)
					echo '<option value="'.$i.'" selected="selected">'.($i+1).'</option>';
				else
					echo '<option value="'.$i.'">'.($i+1).'</option>';
			}
			echo '</select>';	
		}
	}
	
	/*  METHOD: Show_in_slide_photo_num()
		
		IN: -
		OUT: {on video print photo slide count}
		DESCRIPTION: on video printing function.
	*/
	public function Show_in_slide_photo_num(){
		echo ' <input type="hidden" id="slide_photo_num" value="'.sizeof($this->user_photo_slide_path).'" />';	
		
	}
	
	/*  METHOD: Show_add_photo_slide()
		
		IN: -
		OUT: {on video print button to add a new photo (in page card/php/slide.php)}
		DESCRIPTION: on video printing function.
	*/
	public function Show_add_photo_slide(){
		echo "<img class='img_button' src='../../image/btn/btn_aggiungi.png' id='btn_ritaglia' alt='Aggiungi una foto.' onclick='Javascript:add_new_photo()' />";
			
	}
	//##################################################################################
	//GENERIC PRINTING FUNCTIONS END
	//##################################################################################
	//##################################################################################
	//LOGIN(IN PERSONAL AREA) FUNCTIONS START
	//##################################################################################
	public function Show_personal_login_on_card(){
		echo '<div class="login_container" id="login_container">';
            echo "<div class='login_content_container' >
                LOGIN
			</div>
			<div class='login_label'>NOME UTENTE</div>";
			
			echo '<input type="text" name="user" id="personal_login_user"  class="login_input" value="" onchange="Personal_login_request_sfida(\'../\')" />';
            echo "<div class='login_label'>PASSWORD</div>";
            echo '<input  class="login_input" type="password" name="personal_login_pwd" id="personal_login_pwd" onkeydown="PressioneInvioLogin(event);" value="" />';

        echo "
			<div class='styledbutton grey login_button' onclick='Personal_form_submit(\"../\")'>
				<span class='text14px'>LOGIN</a>
			</div>
			 <div class='ajax_login' id='ajax_login'></div>
		<div class='login_img'></div>

		</div>";

			echo "<input type='hidden' name='copia_sfida' id='copia_sfida'>";
			echo "</div>";
		echo "</div>"; 
	}
	public function Recupero_password(){
		if($this->mysql_database->Ctrl_recupero($this->user_id)) {
			$crypt = new PasswordLib\PasswordLib();
			$new_pass = $crypt->getRandomToken(16);
			$hash_new_pass = $crypt->createPasswordHash($new_pass);


			$this->mysql_database->Save_notify_change_tmg_email_password($new_pass, $this->user_id);
			$this->mysql_database->Change_password($hash_new_pass, $this->user_id);
			if (!DEVELOPMENT) {
				$this->Notify_update_tmg_email_password($new_pass);
				$this->send_mail_recupero($new_pass);
			}
			return true;
		}else{
			return false;
		}
	}
    function Notify_update_tmg_email_password($password){
        $mail = new PHPMailer(true);
        try {
            $mail->AddAddress("info@topmanagergroup.com","Servizio cambio password");
            $mail->SetFrom("no-reply@topmanagergroup.com", $this->Getnameshowed());

            $oggetto = "Richiesta cambio password";

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
                                    <p id='titolo'>CAMBIO PASSWORD USER: ".$this->Getnameshowed()."</p>
                                    <br/>
                                    <p>NUOVE CREDENZIALI DA IMPOSTARE</p>
                                    Username: ".$this->Get_member_email()."<br/>
                                    Password: ".$password."<br/>

                                    <br/>
                                    Puoi cambiare la tua password nella sezione IMPOSTAZIONI della tua PERSONAL AREA:
                                    <a href='".PATH_SITO."/roundcube'>".PATH_SITO."/roundcube
                                </div>
                                <div align='center' id='copyright'>
                                    <p>Topmanagergroup Corporation ".date("Y")."</p>
                                </div>
                            </div>
                            </body>
                        </html>
                        ";

            $mail->MsgHTML($messaggio);
            $mail->Send();
        }

        catch
        (phpmailerException $e){
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        }catch(Exception $e){
            echo $e->getMessage(); //Boring error messages from anything else!
        }
    }

	
	public function send_mail_recupero($password){
		$mail = new PHPMailer(true);
		try { 
			$mail->AddAddress(trim($this->personalemail),$this->Getnameshowed());
			$mail->SetFrom("no-reply@topmanagergroup.com", "TopManagerGroup.com");
			  
			$oggetto = "Recupero password TopManagerGroup.com.";
			  
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
							<p id='titolo'>".$this->Getnameshowed().", la tua password TopManagerGroup.com.</p>
							<p>Ecco le tue nuove credenziali:</p>
							Username: ".$this->username."<br/>
							Password: ".$password."<br/>
							<br/>
							<p>Utilizza la stessa credenziali per accedere alla tua email topmanagergroup qui:</p>
							Username: ".$this->Get_member_email()."<br/>
							Password: ".$password."<br/>
                            <strong>ATTENZIONE: Per motivi tecnici, il cambio password della email Topmanagergroup richiede un intervento
                            manuale da parte del nostro staff che potrebbe richiedere 1-2 giorni lavorativi.</strong>
							<br/>
							Puoi cambiare la tua password nella sezione IMPOSTAZIONI della tua PERSONAL AREA:
							<a href='".PATH_SITO.$this->username."/personalarea'>".PATH_SITO.$this->username."/personalarea</a>
							<p>Per qualsiasi problema contattaci all'indirizzo info@topmanagergroup.com</p>
							<p>Se non sei ".$this->Getnameshowed()." ignora questa email.</p>
						</div>
						<div align='center' id='copyright'>
							<p>Topmanagergroup Corporation ".date("Y")."</p>
						</div> 
					</div>
					</body>
				</html>
				";
			  
			 $mail->MsgHTML($messaggio);
			 $mail->Send();
		}catch(phpmailerException $e){
			 echo $e->errorMessage(); //Pretty error messages from PHPMailer
		}catch(Exception $e){
			 echo $e->getMessage(); //Boring error messages from anything else!
		}
		
	}
	
	/*  METHOD: Logout()
		
		IN: -
		OUT: -
		DESCRIPTION: unset user login session var .
	*/
	public function Logout(){
        // Elimina tutti i valori della sessione.
        $_SESSION = array();
        // Recupera i parametri di sessione.
        $params = session_get_cookie_params();
        // Cancella i cookie attuali.
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        // Cancella la sessione.
        session_destroy();
	}
	
	/*  METHOD: Login()
		
		IN: -
		OUT: -
		DESCRIPTION: create login session var .
	*/
	public function Login(){
		$_SESSION[$this->username]=1;
		setcookie("tmguser", $this->username,time()+60*60*24*30,"/");
	}
	
	/*  METHOD: is_user_logged()
		
		IN: -
		OUT: -
		DESCRIPTION: return true if user is logged, if not return false .
	*/
	public function is_user_logged()
    {
        // Verifica che tutte le variabili di sessione siano impostate correttamente
        if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];
            $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.
            if ($stmt = $this->mysql_database->Get_stmt_logged()) {
                $stmt->bind_param('i', $user_id); // esegue il bind del parametro '$user_id'.
                $stmt->execute(); // Esegue la query creata.
                $stmt->store_result();

                if ($stmt->num_rows == 1) { // se l'utente esiste
                    $stmt->bind_result($db_password); // recupera le variabili dal risultato ottenuto.
                    $stmt->fetch();
                    $login_check = hash('sha512', $db_password . $user_browser);
                    if ($login_check == $login_string) {
                        // Login eseguito!!!!
                        return true;
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
	
	/*  METHOD: Show_personal_logged()
		
		IN: -
		OUT: {on video print personal area}
		DESCRIPTION: The user has logged in so we need a function that print the personal area where there will be all the card settings.
	*/
	public function Show_personal_logged(){
		echo "<div class='personal_title_container'>PERSONAL AREA</div>";
		echo "<div style='position:absolute; top:47px; left:27px; width:944px; height:485px;'>";
		
		$this->Show_tab_menu();
		$this->Show_personal_interfaccia();
		$this->Show_personal_email();
		$this->Show_personal_email_smartphone_settings();
		$this->Show_personal_curriculum();
		$this->Show_personal_curriculum_new();
		$this->Show_personal_contact();
		$this->Show_personal_social();
		$this->Show_personal_promoter();
		$this->Show_personal_biglietto();
		$this->Show_personal_impostazioni();
		$this->show_personal_dove_siamo();	  
		
		$this->Show_personal_file_box_public();
		$this->Show_personal_evidenza();
		$this->Show_personal_mailing();
		$this->Show_personal_photo();
		$this->Show_personal_slide();
		$this->Show_personal_filebox();
		$this->Show_personal_professione();
		$this->Show_personal_delete();
		
		echo "<div class='personal_tab_down' id='personal_tab_down'></div>
		</div>
		";
	}
	
	//##################################################################################
	//LOGIN(IN PERSONAL AREA) FUNCTIONS END
	//##################################################################################
	//##################################################################################
	//OVERLAYS PRINTING FUNCTIONS START
	//##################################################################################
	/*  METHOD: Show_Contact()
		
		IN: -
		OUT: {on video print user contact}
		DESCRIPTION: video printing function.
	*/
	public function Show_Contact(){
		echo "<div class='overlay_title_container'>CONTATTI</div>";
		echo "<div class='content_overlay_container'>";
			echo "<div class='container_contatti_sx'>";
				echo "<p style='font-size:14px; font-weight:700; padding-left:22px; color:#000;'>Contatti:</p>";
					for($i=0;$i<count($this->contact_rows);$i++){
						echo "<div class='contatto contatto_generic'>".$this->Show_contact_row($i)."</div>";
					}
					if($i==0)
						echo "<p style='font-size:14px; padding-left:50px; color:#000; font-weight:600;'>Non sono presenti contatti.</p>";
			echo "</div>";
			
			if(sizeof($this->social_rows)!=0){
				echo '<div class="container_contatti_dx">';
				echo "<p style='font-size:14px; font-weight:700; padding-left:22px; color:#000;'>Contatti Web:</p>";
				echo '<table id="tabella_social_elements" class="tabella_social_elements">';
				$k=0;
				foreach($this->social_rows as $social_row){
					echo '	<tr class="contatto contatto_social" style="cursor:pointer;" onclick="Javascript:window.open(\''.$social_row["value"].'\')">
					   <td width="25px" style="padding-left:0px; text-align:center;" border="1" frame="lhs" rules="none">';
									
							echo "<img src='".$social_row["favicon"]."' width='25' height='25' />";
							   
					   echo '</td>';
							   
					   echo '<td width="220px" style="padding-left:10px;">';
					     echo "<span title='".$social_row["title"]."'>".$social_row["title"]."</span> ";
					   echo '</td>';
					echo '</tr>';
						$k++;
				}
				echo '</table>';
			  echo '</div>';
			}
			echo "</div>";
	}
	public function Show_contact_row($index){
		switch($this->contact_rows[$index]["type"]){
			case 'mail':
				return "<img src='../image/icone/icona_email.png' alt='E-mail.' class='icona_contact'/><div class='contact_text text12px'> e-mail: <a href='mailto:".$this->contact_rows[$index]["row_value"]."' class='text12px'>".$this->contact_rows[$index]["row_value"]."</div></a>";
			break;
			case 'tel':
				return "<img src='../image/icone/icona_tel.png' alt='Telefono.' class='icona_contact'/><div class='contact_text text12px'> Tel: ".$this->contact_rows[$index]["row_value"]." </div>";
			break;
			case 'cell':
				return "<img src='../image/icone/icona_cell.png' alt='Cellulare.' class='icona_contact'/><div class='contact_text text12px'> Cell: ".$this->contact_rows[$index]["row_value"]." </div>";
			break;	
			case 'fax':
				return "<img src='../image/icone/icona_fax.png' alt='Fax.' class='icona_contact'/><div class='contact_text text12px'> Fax: ".$this->contact_rows[$index]["row_value"]."</div>";
			case 'indirizzo':
				return "<img src='../image/icone/office-address.png' alt='Indirizzo.' class='icona_contact'/><div class='contact_text text12px'>".$this->contact_rows[$index]["row_value"]."</div>";
			break;		
		}
		
					
	}
	
			
	/*  METHOD: Show_curriculum()
		
		IN: -
		OUT: {on video print curricum}
		DESCRIPTION: If user has inserted one, print curriculum.
	*/
	public function Show_curriculum(){
		echo "<div class='overlay_title_container'>STORIA</div>";
		
		echo "<div class='content_overlay_container'>";
			
			echo "<div class='curriculum_content'>";
			if($this->sudime!=""){
				echo "<span style='color:#FFF;' class='text14px'>".$this->sudime."</span>";
			}
			else
				$this->Show_error("<span style='color:#FFF;' class='text14px'>L'utente non ha ancora inserito la propria storia.</span>");
			echo "</div>";
			if($this->opt_curr==1){
				echo "<div class='download_european'>";
				echo "<span style='font-size:14px; font-weight:600; padding-bottom:10px;'>Visualizza</span>";
				$this->Show_open_european_curriculum();
				echo "</div>";
				echo "<div id='overlay_curriculum_noadobe' class='overlay_curriculum_noadobe'>";
				echo "</div>";
				
			}
			if($this->sudime!=""){
				echo "<div class='download_storia_pdf'><a target='_self' onClick='show_story()' style='color:#000;' class='text14px'>Scarica la mia storia in formato PDF.</a></div>";
			}
		echo "</div>";
		
		
	}
	
	/*  METHOD: Show_file_box()
		
		IN: -
		OUT: {on video print curricum}
		DESCRIPTION: Show user download area.
	*/
	public function Show_file_box_private(){
		echo "<div class='overlay_title_container'>CARTELLE SEGRETE CON PASSWORD <img src='../image/icone/ajax-loader.gif' id='file_box_private_loading' class='file_box_loading'></div>";
		echo "<div id='file_box_main' class='file_box_main'>";
			echo "<div class='content_overlay_container_filebox'>";
				echo "<div id='filebox_private_content'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div id='file_box_private_folder' style='display:none; '>
						<div class='content_overlay_container_filebox_file' id='file_box_private_files_content'>
						 
			    </div>";
		echo "<div class='overlay_button' onclick='torna_filebox_main();'><a target='_self' class='text14px' style='text-decoration:none;' >Indietro</a></div>";
        echo  "</div>";
	}
	
	public function Show_file_box_public(){
		echo "<div class='overlay_title_container'>FOTO E DOCUMENTI <img src='../image/icone/ajax-loader.gif' id='file_box_public_loading' class='file_box_loading'></div>";
		echo "<div id='file_box_public_main' class='file_box_main'>";
			echo "<div class='content_overlay_container_filebox'>";
				echo "<div style='position:absolute; width:780px; text-align:center;'></div>";
				echo "<div id='filebox_photo_content_title' class='filebox_photo_content_title'>ALBUM DI FOTO</div>";
				echo "<div id='filebox_photo_content' class='filebox_photo_content'>";
				echo "</div>";
				
				echo "<div id='filebox_document_content_title' class='filebox_document_content_title'>ALTRI DOCUMENTI</div>";
				echo "<div id='filebox_document_content' class='filebox_document_content'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div id='file_box_folder' style='display:none;'>";
		echo "<div class='content_overlay_container_filebox_file' id='file_box_folder_file'></div>";
		echo "<div class='overlay_button' onclick='torna_filebox_public_main();'><a target='_self' class='text14px' style='text-decoration:none;'>Indietro</a></div>";
		echo "</div>";
		
	}
	
	/*  METHOD: create_main_zip_folder()
		
		IN: -
		OUT: {on video print curricum}
		DESCRIPTION: Show user download area.
	*/
	function create_main_zip_folder(){
		// This will zip all the file(s) in this present working directory
		$directoryToZip="../../".USERS_PATH.$this->username."/download_area/public/photo/"; 
		$zipName="tmg_".$this->username."_foto.zip";
		$createZipFile=new CreateZipFile;
		$outputDir = "../../".USERS_PATH.$this->username."/download_area/public/";
		//Code to Zip a directory and all its files/subdirectories
		$createZipFile->zipDirectory($directoryToZip,$outputDir);
		$zipName = $zipName;
		$fd=fopen($outputDir.$zipName, "wb");
		$out=fwrite($fd,$createZipFile->getZippedfile());
		fclose($fd);
	}
	
	
	function create_photo_album_zip_folder($subfolder){
		// This will zip all the file(s) in this present working directory
		$directoryToZip="../../".USERS_PATH.$this->username."/filebox/photo/".$subfolder."/"; 
		$zipName="tmg_".$this->username."_".$subfolder.".zip";
		
		$outputDir = "../../".USERS_PATH.$this->username."/filebox/photo/";
		$fileToZip = $outputDir."foto3.jpg";
		$createZipFile=new CreateZipFile;
		
		//Code to Zip a directory and all its files/subdirectories
		$createZipFile->zipDirectorynosub($directoryToZip,$outputDir);
		$zipName = $zipName;
		$fd=fopen($outputDir.$zipName, "wb");
		$out=fwrite($fd,$createZipFile->getZippedfile());
		fclose($fd);
	}
	
	
	
	
	
	//##################################################################################
	//OVERLAYS PRINTING FUNCTIONS END
	//##################################################################################
	//##################################################################################
	//PERSONAL AREA FUNCTIONS START
	//##################################################################################
	
	public function Show_tab_menu(){
		echo "<input type='hidden' id='personal_tab_showed' value='interfaccia'>";
		
		echo '<div class="menu_header">
				
				<div class="menu_header_section_over" id="menu_link_interfaccia" onclick="personal_tab_change(\'interfaccia\')">
					<span target="_self" class="personal_menu_link"  title="Modifica la tua card" >MODIFICA LA TUA CARD</span>
				</div>';
				if(count($this->email_messages) > 0){
			  		$new_emails=0;
					for($i=1;$i<=count($this->email_messages);$i++){
						if($this->email_messages[$i]['visto'] == 0){
							$new_emails++;
						}
					}
				}
				echo '<div class="menu_header_section"  id="menu_link_email" onclick="personal_tab_change(\'email\');" style="width:90px;">
					<span target="_self" class="personal_menu_link" title="Controlla i tuoi messaggi e-mail" >E-MAIL</a>
				</div>';
				
				
				if(count($this->newsletter_rows) > 0){
			  		$new_contacts=0;
					for($i=1;$i<=count($this->newsletter_rows);$i++){
						if($this->newsletter_rows[$i]['is_new'] == 1){
							$new_contacts++;
						}
					}
				}
				echo '<div class="menu_header_section" id="menu_link_mailing" onclick="personal_tab_change(\'mailing\');" style="width:110px;">
					<span target="_self" class="personal_menu_link" title="Mailing List" >MAILING LIST</a>
				</div>';
				if($new_contacts!=0){
					echo "<span id='new_contact_notification' class='new_contact_notification'>
								<div style='background-image:url(../image/icone/number_icon_mex.png); width:27px; height:22px; padding-top:1px;' >
							  <span id='new_contact_num'>".$new_contacts."</span>
							</div>
						</span>";
			  	}else{
					echo "<span id='new_contact_notification' class='new_contact_notification'>
					</span>";
				}
				
				
				echo '
				<div class="menu_header_section" id="menu_link_promoter" onclick="personal_tab_change(\'promoter\');" style="width:185px;">
					<span target="_self" class="personal_menu_link" title="Controlla lo stato promoter" >GUADAGNO PROMOTER</span>
				</div>
				<div class="menu_header_section" id="menu_link_impostazioni" onclick="personal_tab_change(\'impostazioni\');" style="width:183px;">
					<span class="personal_menu_link" title="Gestisci le tue impostazioni">IMPOSTAZIONI</span>
				</div>
			  </div>';
			  
		$this->Show_tab_menu_js_code();
	}
	
	/*  METHOD: Show_personal_menu_js_code()
		
		IN: -
		OUT: {print js code for menu}
		DESCRIPTION: printing function.
	*/
	public function Show_tab_menu_js_code(){
		echo '
		<script>
			GeneratePersonalMenu();
		</script>
		';
	}
	
	
	/*  METHOD: Show_personal_email()
		
		IN: -
		OUT: {on video print personal area section 'generale'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_email(){
		echo "<div id='tabdiv_btn_card_personal_email' style='display: none;'>
				  <div class='personal_tab_center'>
						<div class='personal_tab_center_content' style='height:410px;'>";
							echo "<div id='browse_email'>";
								echo "<span class='text14px'><strong>Il tuo indirizzo è ".$this->Get_member_email()."</strong><br/>";
								echo "<div style='position:absolute; top:70px; left:30px; padding: 10px; background-color:#A8A8A8; width:700px; text-align:left;'>";
									echo "<div class='personal_button' onclick='go_to_webmail()' style='width:150px;'>
										<span class='text14px'>VAI ALLA POSTA</span>
									</div>";
									echo "<br/><span class='text11px'>Inserisci il tuo indirizzo email e la tua password TopManagerGroup per accedere.</span>";
									echo "<br/><span class='text11px'>Nel campo utente inserisci l'indirizzo completo della tua email: ".$this->Get_member_email().".</span>";
									echo "<br/><span class='text11px'>N.B. La mail @topmanagergroup nasce per essere impostata ed utilizzata sui cellulari di ultima generazione. &Eacute; possibile importare file nel formato VCARD (.vcf) anche nella sezione mailing-list.</span>";
								echo "</div>";			
								
									echo "<div class='personal_button' onclick='Javascript:personal_tab_change(\"smartphone_tablet_mail_settings\")' style='position:absolute; top:220px; left:30px; width:400px; width:290px;'>
										<span class='text14px'>IMPOSTAZIONI PER PC o SMARTPHONE</span>
									</div>";
								
									
							echo "</div>";
					   echo '</div>
				  </div>
				 
			  </div>';	
	}
	
	
	
	public function Show_personal_email_smartphone_settings(){
		echo "<div id='tabdiv_btn_card_personal_smartphone_tablet_mail_settings' style='display: none;'>
				  <div class='personal_tab_center'>
						<div class='personal_tab_center_content' style='height:410px;'>";
									echo "
										<span class='text14px'>IMPOSTAZIONI PER PC o SMARTPHONE</span><br/><br/>";
									echo "Puoi impostare il tuo indirizzo email TopManagerGroup per utilizzarlo su SmartPhone, Tablet o dal tuo Computer tramite<br/> un qualsiasi client di posta elettronica.<br/>";
									echo "<strong>Ecco i dati:</strong><br/>";
									echo "Indirizzo email: ".$this->Get_member_email()."<br/>";
									echo "Password: La tua password TopManagerGroup<br/>";
									echo "Server in Entrata:<br/>";
									echo "Se scegli la configurazione IMAP le email verranno mantenute sui nostri server, se scegli la configurazione POP3<br/> le email verranno scaricate sul tuo Computer,Tablet o SmartPhone<br/>";
									echo "IMAP: imap.topmanagergroup.com<br/>";
									echo "POP3: pop3.topmanagergroup.com<br/>";
									echo "Server in Uscita:<br/>";
									echo "SMTP: smtp.topmanagergroup.com<br/></span>";
					   echo '</div>
				  </div>
				 
			  </div>';	
	}
	
	
	
	
	/*  METHOD: Show_personal_biglietto()
		
		IN: -
		OUT: {on video print personal area section 'biglietto'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_biglietto(){
		echo "<div id='tabdiv_btn_card_personal_biglietto' style='display: none;'>
				  <div class='personal_tab_center'>
						<div class='personal_tab_center_content' style='height:370px;'>";
						echo "<div style='position:absolute; top:80px; left:20px; width:410px; text-align:right;'>";
							echo "<p class='text14px'>Modifica il tuo biglietto da visita</p>";
							echo "<label><span class='text14px'>Informazioni:</span> <input type='text' id='personal_in_bv_professione' class='input_biglietto' value='".$this->alt_professione."'  maxlength='45'></input></label><br/>";
							if($this->bv_professione=='1'){
								echo "<input type='checkbox' id='personal_check_bv_professione' checked='checked' />";
							}else{
								echo "<input type='checkbox' id='personal_check_bv_professione' />";	
							}
							echo "<span class='text14px'>Inserisci nel biglietto da visita.</span><br/>";
							echo "
							<span class='text14px'>Telefono:</span> <input class='input_biglietto' type='text' id='personal_in_bv_cellulare' value='".$this->cellulare."' maxlength='20'><br/>";
							if($this->bv_cellulare=='1'){
								echo " <input type='checkbox' id='personal_check_bv_cellulare' checked='checked' />";
							}else{
								echo " <input type='checkbox' id='personal_check_bv_cellulare' />";	
							}
							
							
							echo "<span class='text14px'>Inserisci nel biglietto da visita.</span><br/>";
							
							echo "
							<span class='text14px'>Email:</span> <input class='input_biglietto' type='text' id='personal_in_bv_email' value='".$this->email_bv_value."'><br/>";
							if($this->bv_email=='1'){
								echo " <input type='checkbox' id='personal_check_bv_email' checked='checked' />";
							}else{
								echo " <input type='checkbox' id='personal_check_bv_email' />";	
							}
							echo "<span class='text14px'>Inserisci nel biglietto da visita.</span><br/>";
							
							
							echo "
							<span class='text14px'>Email TMG:</span> <input class='input_biglietto' type='text' id='personal_in_bv_tmg_email' value='".$this->Get_member_email()."'  readonly='readonly' ><br/>";
							if($this->bv_tmg_email=='1'){
								echo " <input type='checkbox' id='personal_check_bv_tmg_email' checked='checked' />";
							}else{
								echo " <input type='checkbox' id='personal_check_bv_tmg_email' />";	
							}
							echo "<span class='text14px'>Inserisci nel biglietto da visita.</span><br/>";
							
							
							
							echo "
							<span class='text14px'>Sito internet:</span>";
							if($this->bv_web=='0'){
								echo "<input type='radio' name='personal_in_bv_web' value='0' checked='checked'>topmanagergroup.com <br/>";
								echo "<input type='radio' name='personal_in_bv_web' value='1'>".substr($this->alternative_url,4)." <br/>";
							}else{
								echo "<input type='radio' name='personal_in_bv_web' value='0'>topmanagergroup.com <br/>";
								echo "<input type='radio' name='personal_in_bv_web' value='1'  checked='checked'>".substr($this->alternative_url,4)." <br/>";	
							}
							
						echo "</div>";
						echo "<div style='position:absolute; top:70px; left:443px;' id='biglietto_preview'>";
						echo "</div>";
						echo '<script type="text/javascript">
								ctrl_mod_bv_adobe();
							</script>';
						echo "<div style='position:absolute; top:350px; left:150px; width:300px; left:80px; '>";
							echo "<div id='biglietto_saved' style='display:none;'><img src='../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Informazioni Salvate.</div>";
							echo "<div class='personal_button' onclick='personal_tab_change(\"interfaccia\")' style='width:90px;'>
							<span class='text14px'>INDIETRO</span>
						</div>";
							echo "<div class='personal_button' onclick='Javascript:bv_save()' style='width:90px;'>
							<span class='text14px'>SALVA</span>
						</div>";
							
							echo "<div class='personal_button' onclick='Javascript:personal_card_scarica_biglietto(\"".$this->username."\");' style='width:90px;'>
							<span class='text14px'>SCARICA</span>
						</div>";
						echo "</div>";
					echo "</div>
				  </div>
				 
			  </div>";	
	}
	public function Show_personal_professione(){
		echo "<div id='tabdiv_btn_card_personal_professione' style='display: none;'>
				  <div class='personal_tab_center' style='text-align:left;'>
						<div class='personal_tab_center_content text14px' style='height:300px;'>";
						echo "<div id='impostazioni_professione_loading' class='personal_tab_loading'><img src='../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>";
						echo "<div id='impostazioni_professione_saved' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Impostazioni Salvate.<span></div>";
  						
						echo "<input id='personal_check_show_user' type='radio' value='0' name='personal_check_show_radio' class='personal_check_show_radio'"; 
						if($this->flagnameshowed==0){ echo "checked='checked'";}
						echo "></input> Visualizza solo il mio username: <br/>";
						echo "<span class='utente_info'>".strtoupper($this->username)."</span> <br/>";
						echo "<input id='personal_check_show_name' type='radio' value='1' name='personal_check_show_radio' class='personal_check_show_radio'"; 
						if($this->flagnameshowed==1){ echo "checked='checked'";}
						echo "></input> Visualizza solo nome e cognome: <br/>";
						echo "<span class='utente_info'>".strtoupper($this->Nome).' '.strtoupper($this->Cognome)."</span> <br/>";
						echo "<input id='personal_check_show_user_and_name' type='radio' value='2' name='personal_check_show_radio' class='personal_check_show_radio'"; 
						if($this->flagnameshowed==2){ echo "checked='checked'";}
						echo "> Visualizza username + (nome e cognome): <br/>";
						echo "<span class='utente_info'>".strtoupper($this->username)." (".strtoupper($this->Nome).' '.strtoupper($this->Cognome).")</span> <br/><br/>";
						echo "Inserisci la tua professione o hobby (MAX 50 CAR): <br/>";
						echo "<input class='personal_area_mod_contact' type='text' value='".$this->Professione."' id='in_personal_card_mod_professione' onKeyDown='limitText(this,50);' onKeyUp='limitText(this,50);'/>
						<br/>";
						echo "Seleziona la categoria di appartenenza: <br/>";
						
						echo "<select id='in_personal_card_mod_professione_category'>";
						if($category["ID"]==""||$category["ID"]==NULL||$category["ID"]==-1){
								echo "<option value='-1' selected='selected'></option>";
							}
						foreach($this->job_categories as $category){
							if($category["ID"]==$this->Category){
								echo "<option value='".$category["ID"]."' selected='selected'>".$category["value"]."</option>";
							}else{
								echo "<option value='".$category["ID"]."'>".$category["value"]."</option>";	
							}
						}
						echo "</select>
						<br/><br/>";
						echo "
						<div class='personal_button' onclick='Javascript:personal_card_save_professione();' style='width:80px;'>
							<span class='text14px'>SALVA</span>
						</div>
						<div class='personal_button' onclick='personal_tab_change(\"interfaccia\")' style='width:80px;'>
							<span class='text14px'>INDIETRO</span>
						</div>";
					echo "</div>
				  </div>
				 
			  </div>";	
	}
	public function Show_personal_dove_siamo(){
		echo "<div id='tabdiv_btn_card_personal_dove_siamo' style='display: none;'>
				  <div class='personal_tab_center' style='text-align:left;'>
						<div class='personal_tab_center_content' style='height:300px;'>";
						echo "<div id='impostazioni_dove_siamo_loading' class='personal_tab_loading'><img src='../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>";
						echo "<div id='impostazioni_dove_siamo_saved' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Impostazioni Salvate.<span></div>";
						echo "<div style='position:absolute; top:40px; left:20px; width:410px; text-align:right;'>";
							echo "<p class='text14px'>Inserisci il tuo indirizzo:</p>";
							echo '<p class="text14px">Inserisci la tua citt&agrave: <input type="text" id="in_personal_card_mod_address_via" class="personal_area_mod_contact" value="'.$this->address_via.'"></p>';
							echo '<p class="text14px">Inserisci la tua via: <input type="text" id="in_personal_card_mod_address_citta" class="personal_area_mod_contact" value="'.$this->address_citta.'"></p>';
							echo '<p class="text14px">Ulteriore descrizione:<input type="text" id="in_personal_card_mod_address_desc" class="personal_area_mod_contact" value="'.$this->address_desc.'"></p>';
							echo "<p class='text14px'>Visualizza nella tua card:";
							if($this->address_on==1){
								echo "<input type='checkbox' checked='checked' id='in_personal_card_mod_address_on'>";
							}else{
								echo "<input type='checkbox' id='in_personal_card_mod_address_on'>";
							}
							echo "</p>";										
							echo "<div style='position:absolute; top:245px; left:150px; width:250px; left:80px; '>";
									echo "
								<div class='personal_button' onclick='Javascript:personal_card_save_dove_siamo();' style='width:80px;'>
									<span class='text14px'>SALVA</span>
								</div>
								<div class='personal_button' onclick='personal_tab_change(\"interfaccia\")' style='width:80px;'>
									<span class='text14px'>INDIETRO</span>
								</div>";
							echo "</div>";
						echo "</div>";
						
						
						echo "<div style='position:absolute; top:55px; left:443px;' id='dove_siamo_preview'>";
						echo "</div>";
						/*echo '<script type="text/javascript">
								ctrl_mod_bv_adobe();
							</script>';*/
						
					echo "</div>";
				echo "</div>
			  </div>";	
	}
	
	
	public function correggi($stringa) {
		$correzioni = array("À" => "A", "Á" => "A", "Â" => "A", "Ä" => "A", "Å" => "A", "Æ" => "AE", "Ç" => "C", "È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I", "Ñ" => "N", "Ò" => "O", "Ó" => "O", "Ô" => "O", "Ö" => "O", "Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U", "ß" => "ss", "à" => "a", "á" => "a", "â" => "a", "ä" => "a", "æ" => "ae", "ç" => "c", "è" => "e", "é" => "e", "ê" => "e", "ë" => "e", "ì" => "i", "í" => "i", "î" => "i", "ï" => "i", "ñ" => "n", "ò" => "o", "ó" => "o", "ô" => "o", "ö" => "o", "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "Ő" => "O", "ő" => "o", "Œ" => "OE", "œ" => "oe");
		foreach($correzioni as $chiave => $valore) {
			$stringa = str_replace($chiave, $valore, $stringa);
		}
		$stringa = eregi_replace("[[:space:]]" , "_", $stringa);
		//$stringa = eregi_replace("[^a-z0-9._-]" , "", $stringa);
		$stringa = eregi_replace("[^[:alnum:]._-]" , "", $stringa);
		return $stringa;
	}
	
	public function getmessagedata($data){
		$saved_data = strtotime($data);
		$saved_minutes = idate('i',$saved_data);
		$saved_hours = idate('H',$saved_data);
		$saved_month = idate('m',$saved_data);
		$saved_day = idate('d',$saved_data);
		$saved_year = idate('Y',$saved_data);
		
		$now_data = strtotime(date("F j, Y, G:i"));
		$now_minutes = idate('i',$now_data);
		$now_hours = idate('H',$now_data);
		$now_month = idate('m',$now_data);
		$now_day = idate('d',$now_data);
		$now_year = idate('Y',$now_data);
		
		if(($now_year == $saved_year) && ( $now_month == $saved_month ) && ( $now_day == $saved_day ) ){
			/*if( $now_hours == $saved_hours ){
				$msg_data = ($now_minutes - $saved_minutes).' minuti fa.';
			}
			else{
				$msg_data = ($now_hours - $saved_hours).' ore fa.';
			}*/
			
			$saved_total_min = ($saved_hours * 60) + $saved_minutes;
			$now_total_min = ($now_hours*60) + $now_minutes;
			$diff_min = $now_total_min - $saved_total_min;
			if($diff_min<60){
				$msg_data = $diff_min.' minuti fa.';
			}else{
			    $msg_data = round($diff_min/60).' ore fa.';
			}
		}else{
			$msg_data = $saved_day;
			switch($saved_month){
				case 1:
					$msg_data.=' gennaio';
				break;
				case 2:
					$msg_data.=' febbraio';
				break;
				case 3:
					$msg_data.=' marzo';
				break;
				case 4:
					$msg_data.=' aprile';
				break;
				case 5:
					$msg_data.=' maggio';
				break;
				case 6:
					$msg_data.=' giugno';
				break;
				case 7:
					$msg_data.=' luglio';
				break;	
				case 8:
					$msg_data.=' agosto';
				break;
				case 9:
					$msg_data.=' settembre';
				break;
				case 10:
					$msg_data.=' ottobre';
				break;
				case 11:
					$msg_data.=' novembre';
				break;
				case 12:
					$msg_data.=' dicembre';
				break;
				
			}
			$msg_data.=' '.$saved_year;
		}
		return $msg_data;	
	}

	
	/*  METHOD: Show_personal_interfaccia()
		
		IN: -
		OUT: {on video print personal area section 'profilo'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_interfaccia(){
		echo "<div id='tabdiv_btn_card_personal_interfaccia'>
				  <div class='personal_tab_center'>
						<div class='personal_tab_center_content' style='min-height: 420px;'>";
							
							if($this->is_giovane==1){
								echo '<div class="personal_card_size_giovane rounded">';
							}else{
								echo '<div class="personal_card_size rounded">';
							}
								$this->Show_personal_card_size();
							echo '</div>';
							if($this->is_giovane==1){
								echo '<div class="personal_card_color_giovane rounded">';
							}else{
								echo '<div class="personal_card_color rounded">';
							}
							echo "<span class='text14px'>Scegli il colore della tua card<br/>";
							if($this->colore_card=="brown")
								echo '<img class="btn_colore_over" src="../image/card/btn/card_colour/btn_brown.png" onclick="change_card_colour(\'brown\');" id="btn_colore_brown"/>';
							else
								echo '<img class="btn_colore" src="../image/card/btn/card_colour/btn_brown.png" onclick="change_card_colour(\'brown\');" id="btn_colore_brown"/>';
							if($this->colore_card=="black")
								echo '<img class="btn_colore_over" src="../image/card/btn/card_colour/btn_black.png" onclick="change_card_colour(\'black\');" id="btn_colore_black"/>';
							else
								echo '<img class="btn_colore" src="../image/card/btn/card_colour/btn_black.png" onclick="change_card_colour(\'black\');" id="btn_colore_black"/>';
							if($this->colore_card=="green")
								echo '<img class="btn_colore_over" src="../image/card/btn/card_colour/btn_green.png" onclick="change_card_colour(\'green\');" id="btn_colore_green"/>';
							else
								echo '<img class="btn_colore" src="../image/card/btn/card_colour/btn_green.png" onclick="change_card_colour(\'green\');" id="btn_colore_green"/>';
							if($this->colore_card=="blue")
								echo '<img class="btn_colore_over" src="../image/card/btn/card_colour/btn_blue.png" onclick="change_card_colour(\'blue\');" id="btn_colore_blue"/>';
							else
								echo '<img class="btn_colore" src="../image/card/btn/card_colour/btn_blue.png" onclick="change_card_colour(\'blue\');" id="btn_colore_blue"/>';
							if($this->colore_card=="pink")
								echo '<img class="btn_colore_over" src="../image/card/btn/card_colour/btn_pink.png" onclick="change_card_colour(\'pink\');" id="btn_colore_pink"/>';
							else
								echo '<img class="btn_colore" src="../image/card/btn/card_colour/btn_pink.png" onclick="change_card_colour(\'pink\');" id="btn_colore_pink"/>';
							if($this->colore_card=="azzurro")
								echo '<img class="btn_colore_over" src="../image/card/btn/card_colour/btn_azzurro.png" onclick="change_card_colour(\'azzurro\');" id="btn_colore_azzurro"/>';
							else
								echo '<img class="btn_colore" src="../image/card/btn/card_colour/btn_azzurro.png" onclick="change_card_colour(\'azzurro\');" id="btn_colore_azzurro"/>';
							if($this->colore_card=="orange")
								echo '<img class="btn_colore_over" src="../image/card/btn/card_colour/btn_orange.png" onclick="change_card_colour(\'orange\');" id="btn_colore_orange"/>';
							else
								echo '<img class="btn_colore" src="../image/card/btn/card_colour/btn_orange.png" onclick="change_card_colour(\'orange\');" id="btn_colore_orange"/>';
								echo '
								<img src="../image/icone/ajax-loader.gif" id="colour_loading" class="colour_loading" alt="Loading" />
							   <input type="hidden" id="colore_card" />
							 ';
							echo '</div>';
							echo '<div class="personal_card_exit">';
							echo "<div class='personal_button' onclick='return_to_the_card()' style='width:150px;'>
										<span class='text14px'>TORNA ALLA CARD</span>
									</div>";
							echo '</div>';
							echo "<span class='personal_modify_text text14px'>CLICCA SULLE VARIE SEZIONE DELLA CARD PER MODIFICARE.</span>";
							echo '<div class="personal_card_up">';
							
							echo '<div id="personal_card_evidenza" class="personal_card_evidenza" onclick="personal_tab_change(\'evidenza\')" >';
								$this->Show_personal_card_evidenza();
							echo '</div>';
							
							echo '</div>';
							 echo '<div class="personal_card_cols">';
									
									echo '<div class="personal_card_col">';
										$this->Show_personal_card_col1();
									echo '</div>';
									echo '<div class="personal_card_col2">';
										$this->Show_personal_card_col2();
									echo '</div>';
									
									echo '  
									<div class="personal_card_col3">';
										$this->Show_personal_card_col3();
									echo '</div>';
								
							echo '</div>
								<div class="personal_card_down">';
									 $this->Show_personal_card_down();
								echo '</div>';
						echo "</div>
				  </div>
			  </div>";	
	}
	
	/*  METHOD: Show_personal_card_col1()		
	IN: .
	OUT: . 
	DESCRIPTION: show card coloumn 1.
	*/
	public function Show_personal_card_col1(){
		echo "<div id='personal_card_photo' class='personal_card_photo'  onclick='Javascript:Open_photo_manager()'>";
			$pos = strpos($this->photo1_path, "default_photo/main.png");
			if ($pos !== false)
				$this->Show_personal_card_main_photo( 147, 220, "");
			else
				$this->Show_personal_card_main_photo( 147, 220, "../".USERS_PATH.$this->username."/".USER_PHOTO_MAIN_PATH);
		echo "</div>";
		
	}
	
	/*  METHOD: Show_personal_card_main_photo()
		
		IN: $width=210,$height=315,$path.
		OUT: {on video print user main photo}
		DESCRIPTION: video printing function..
	*/
	public function Show_personal_card_main_photo($width=150,$height=215,$path){
		if(strpos($this->photo1_path,"../"))//se non è ancora stata cambiata la foto..
			$path_foto = $this->photo1_path;
		else
			$path_foto = $path.$this->photo1_path;
		echo "<img src='".$path_foto."' width='".$width."' height='".$height."' />";
	}
	
	/*  METHOD: Show_personal_card_col2()		
	IN: .
	OUT: . 
	DESCRIPTION: show card coloumn 2.
	*/
	public function Show_personal_card_col2(){
		echo "<div id='personal_nome_professione' class='personal_card_nome_professione' onclick='Javascript:personal_tab_change(\"professione\")'>";
			$this->Show_personal_card_Nome_Professione();
		echo "</div>";
		echo "<div id='personal_card_photo_slide' class='personal_card_photo_slide'  onclick='Javascript:Open_photo_manager()'>";
			$this->Show_personal_card_mod_photoslide(); 
		echo "</div>";
	}
	public function Show_personal_card_evidenza(){
			echo '<table id="personal_tabella_agenda_news" class="personal_tabella_agenda_news">';
					$back_row_color_array = array("#3366cc", "#6699ff", "#addee5", "#ade8a6", "#bdc9d7","#b4df89","#dfc889");
                    if(sizeof($this->news_rows)>0)
					    $rand_back_row_color = array_rand($back_row_color_array, sizeof($this->news_rows));
					$k=0;
					foreach($this->news_rows as $news_row){
						if($back_row_color_array[$rand_back_row_color[$k]]=="")
							$back_row_color = "#ade8a6";
						else
							$back_row_color = $back_row_color_array[$rand_back_row_color[$k]];
						echo '	<tr bgcolor="'.$back_row_color.'" class="personal_riga_agenda_news" style="cursor:pointer;">
							   <td width="140px" style="padding-left:7px; text-align:center;" border="1" frame="lhs" rules="none">';
							   		
								echo "<span title='".$news_row["sottotitolo"]."'>".$news_row["sottotitolo"]."</span>";
							   
							   echo '</td>';
							   
							   echo '<td width="400px" style="padding-left:15px;">';
							   echo "<span title='".$news_row["titolo"]."'>".$news_row["titolo"]."</span> ";
							   
							   
							   echo '</td>';
							   echo '
						   </tr>
						';
						
						$k++;
					}
						echo '</table>';
			
	}
	/*  METHOD: Show_personal_card_mod_photoslide()
		
		IN: -.
		OUT: {on video print slide or secondary photo}
		DESCRIPTION: If user has the slide trigger on print the slide's div, if not print the user secondary photo.
	*/
	public function Show_personal_card_mod_photoslide(){
		for($i=0;$i<sizeof($this->user_photo_slide_path);$i++){
			$pos = strpos($this->user_photo_slide_path[$i], "default_photo/");
			if ($pos !== false){
				echo "<img src='".$this->user_photo_slide_path[$i]."' class='personal_card_slide_photos'>";
			}else{
				echo "<img src='"."../".USERS_PATH.$this->username."/".USER_PHOTO_PATH.$this->user_photo_slide_path[$i]."' class='personal_card_slide_photos'>";
			}
		}
	}
		
	/*  METHOD: Show_personal_card_Nome_Professione()
		
		IN: -
		OUT: {on video print Nome & Professione}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_card_Nome_Professione(){
		echo "<span id='personal_nameshowed_text'>".$this->Getnameshowed()."</span><br/>";
		echo "<span id='personal_professione_text'>".$this->Professione."</span><br/>";
	}
	
	/*  METHOD: Show_personal_card_col3()	
	IN: .
	OUT: . 
	DESCRIPTION: show card coloumn 3.
	*/
	public function Show_personal_card_col3(){
		echo '<div id="personal_card_social" class="personal_card_social" onclick="personal_tab_change(\'social\')" >';
			$this->Show_personal_card_social();		
		echo '</div>';
		$this->Show_personal_card_dove_siamo();
	}
	
	public function Show_personal_card_social(){
		echo '<span class="text12px">CONTATTI WEB</span>';
		
		
		if(count($this->social_rows)!=0){
			echo '<table id="tabella_social_elements" class="personal_tabella_social_elements">';
			$k=0;
			foreach($this->social_rows as $social_row){
				echo '<tr class="personal_riga_social_elements" style="cursor:pointer;">
					   <td width="20px" style="padding-left:7px; text-align:center;" border="1" frame="lhs" rules="none">';
					  echo "<img src='".$social_row["favicon"]."' width='15' height='15' />";
					   
					   echo '</td>';
					   
					   echo '<td width="120px" style="padding-left:10px;">';
					   echo "<span title='".$social_row["title"]."'>".$social_row["title"]."</span> ";
					   echo '</td>';
					   echo '
				   </tr>
				';
				
				$k++;
			}
			echo '</table>';
		}		
	}
	public function Show_personal_file_box_public(){
		echo "<div id='tabdiv_btn_card_personal_fotodocumenti' style='display:none;'>
				  <div class='personal_tab_center'>
						<div class='personal_tab_center_content_filebox' >";
						echo "<iframe src='../card/php/filebox_pubblica.php?u=".$this->username."' width='834' height='425' frameborder='0'></iframe>";
					echo "</div>
				  </div>
			  </div>";	
	}
	/*  METHOD: Show_personal_card_Nome_Professione()
		
		IN: -
		OUT: {on video print Nome & Professione}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_evidenza(){
		echo "<div id='tabdiv_btn_card_personal_evidenza' style='display:none;'>
				  <div class='personal_tab_center'>
						<div class='personal_tab_center_content' style='height:410px;'>";
						echo '<div id="div_newshandler_content" class="div_newshandler_content">';
							echo "<iframe src='../card/php/news_handler.php?u=".$this->username."' width='895' height='410' frameborder='0' style='overflow-y:hidden;'></iframe>";
							
						echo '</div>';
					echo "</div>
				  </div>
			  </div>";
	}
	
	public function Show_news($news_id,$index){
		$descrizione = preg_replace('#<br\s*/?>#i', "\n", $this->news_rows[$index]["descrizione"]);
                
		echo "<input type='hidden' id='showed_news_id' value='".$news_id."' />";
		echo "<p>Modifica la tua news STEP 1 di 3</p>
        <input type='text' class='in_evidenza' id='in_mod_evidenza' value='";
			echo $this->news_rows[$index]["titolo"];	
		echo "'><br/>
         
      	<textarea class='textbox_evidenza' id='in_mod_evidenza_desc'>";
			echo $descrizione;	
		echo "</textarea>
        <br/>
		
        <div id='div_evidenza_file' class='div_evidenza_file'>";
       		$this->Show_file_in_evidenza($news_id,1);
        echo "</div>
        <div class='personal_button' onclick='Javascript:go_to_mod_news_second_step(".$index.")' style='position:absolute; top:225px; left:206px; width:200px;'>
        	<span class='text14px'>CONTINUA</span>
     	</div>
        <div class='personal_button' onclick='Javascript:return_riepilogo_news_from_mod()' style='position:absolute; top:225px; left:0px; width:200px;'>
        	<span class='text14px'>RIEPILOGO NEWS</span>
     	</div>";
	}
	public function Show_news_second_step($news_id,$index){
		echo '<p>Crea una nuova news STEP 2 di 3</p>
       	<p><input type="checkbox" id="data_no_posticipa" onchange="change_check_no_posticipa(this);" /> Voglio che la news venga pubblicata subito.</p>
       
       <div class="calendario_div" id="calendario_div">
       			<p>Scegli il giorno in cui vuoi sia pubblicata la tua news: (Clicca per cambiare)</p>
              <input type="date" id="data_posticipa" name="data_posticipa" value="Today" />
      </div>
                
                <script>
                   $.tools.dateinput.localize("it", {
                      months:"Gennaio,Febbraio,Marzo,Aprile,Maggio,Giugno,Luglio,Agosto,Settembre,Ottobre,Novembre,Dicembre",
                      shortMonths:  "Gen,Feb,Mar,Apr,Mag,Giu,Lug,Ago,Set,Ott,Nov,Dic",
                      days:        "Domenica,Lunedì,Martedì,Mercoledì,Giovedì,Venerdì,Sabato",
                      shortDays:    "Dom,Lun,Mar,Mer,Gio,Ven,Sab"
                    });
                    //var saved_data = new Date("2012","10","03")
                    // initialize dateinput
                    $(":date").dateinput( {
                        lang: "it",
                        format: "dd mmmm yyyy",
                        min: 0,
                        /* closing is not possible
                        onHide: function()  {
                            return false;
                        },*/
                    
                        /* when date changes update the day display
                        change: function(e, date)  {
                            $("#theday").html("La tua news verrà pubblicata il giorno "+this.getValue("dd <span>mmmm yyyy</span>"));
                        }*/
                    // set initial value and show dateinput when page loads
                    }).data("dateinput").setValue(0);
                    $(":date").bind("onShow onHide", function()  {
						$(this).parent().toggleClass("active");
					});
                </script>
        
        <div class="personal_button" onclick="Javascript:return_riepilogo_news()" style="position:absolute; top:325px; left:10px; width:200px;">
        	<span class="text14px">RIEPILOGO NEWS</span>
     	</div>
        <div class="personal_button" onclick="Javascript:return_to_new_news_first_step()" style="position:absolute; top:325px; left:216px; width:100px;">
        	<span class="text14px">INDIETRO</span>
     	</div>
        <div class="personal_button" onclick="Javascript:go_to_new_news_third_step()" style="position:absolute; top:325px; left:322px; width:100px;">
        	<span class="text14px">CONTINUA</span>
     	</div>';
	}
	
	public function Show_personal_mailing(){
		echo "<div id='tabdiv_btn_card_personal_mailing' style='display:none;'>
				  <div class='personal_tab_center'>
						<div class='personal_tab_center_content' style='height:410px;' >";
							echo "<div id='mailing_loading' class='personal_tab_loading'><img src='../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>";
							echo "<div id='mailing_add_group_success' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>gruppo creato!<span></div>";
							echo "<div id='mailing_add_group_error' class='personal_tab_loading'><img src='../image/icone/error.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>errore<span></div>";
							echo "<div id='mailing_add_contact_success' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>contatto creato!<span></div>";
							echo "<div id='mailing_send_group_mail_success' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Messaggio Inviato!<span></div>";
							echo "<div id='mailing_mod_contact_success' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>contatto modificato!<span></div>";
							echo "<div id='mailing_add_contact_error' class='personal_tab_loading'><img src='../image/icone/error.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>errore<span></div>";
							echo "<div id='mailing_del_contact_success' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>contatti eliminati!<span></div>";
							echo "<div id='mailing_move_contact_success' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>contatti spostati!<span></div>";
							
							echo '<div id="div_mailing_content" class="div_mailing_content">';
								echo $this->Show_mailing();
							echo '</div>';
					echo "</div>
				  </div>
			  </div>";
			  
	}
	public function Show_mailing(){
		echo '<div class="mailing_groups_container" id="mailing_groups_container">';
			$this->Show_mailing_groups(0);
		echo "</div>";
		
		echo '<div class="mailing_groups_action_container" id="mailing_groups_action_container">';
			$this->Show_mailing_groups_action(0);
		echo '</div>';
		echo '<div class="mailing_contacts_container" id="mailing_contacts_container">';
			$this->Show_mailing_contacts(0);
		echo "</div>";
		echo '<div class="mailing_contacts_action_container" id="mailing_contacts_action_container">';
			$this->Show_mailing_contacts_action();
		echo "</div>";
		echo '<div class="mailing_contacts_import_container" id="mailing_contacts_import_container">';
			$this->Show_mailing_import_action();
		echo "</div>";
		echo "<div class='mailing_send_groups_email_container' id='mailing_send_groups_email_container'>";
			$this->Show_mailing_send_groups_email();
		echo "</div>";
		echo "<input type='hidden' id='group_selected' value='0' />";
	}
	public function Refresh_move_contact_list(){
		$this->Show_move_mailing_contacts();
	}
	public function Show_mailing_groups_action($index){
		if($this->newsletter_group[$index]['blocked']!=1){
			echo 'Azioni sul gruppo '.$this->newsletter_group[$index]['nome'].':<br/>';
			echo '<a target="_self" style="cursor:pointer;" onclick="Javascript:Delete_group('.$this->newsletter_group[$index]['id'].');" style="font-size:14px;"><img src="../image/icone/edit-delete.png" style="cursor:pointer; vertical-align:middle; width:18px; height:18px;"/> Elimina gruppo</a><br/>
              <a target="_self" style="cursor:pointer;" onclick="Javascript:Rename_group('.$this->newsletter_group[$index]['id'].',\''.$this->newsletter_group[$index]['nome'].'\','.$index.');" style="font-size:14px;"><img src="../image/icone/pen.png"  style="cursor:pointer; vertical-align:middle; width:18px; height:18px;"/> Rinomina gruppo</a><br/>';
			  
		}else{
			  echo "Questo gruppo non pu&ograve; essere modificato o eliminato";
		}
		echo '<div class="mailing_add_groups_container" id="mailing_add_groups_container">';
				echo '<a target="_self" onclick="Javascript:Add_group()" style="cursor:pointer;"><img src="../image/icone/icona_add.png" style="width:16px; height:16px; cursor:pointer;" alt="aggiungi" title="Crea nuovo gruppo."><span style="position:relative; top:-4px;">&nbsp;Aggiungi gruppo</span></a><br/>';
		echo '</div>';
	}
	
	public function Show_upload_file_vcf($group_index){
		$uploader=new PhpUploader();    
		// Set a unique name to Uploader  
		$uploader->Name="upload_vcf";    
		//Create a new file upload handler    
		$uploader->UploadUrl="../../card/php/vcf_handler.php?u=".$this->username."&group_index=".$group_index;
		//Step 4: Enable Multiple Files Upload.    
		$uploader->MultipleFilesUpload=false; 
		//Specify the maximum allowed size of the file using MaxSizeKB property  
		$uploader->MaxSizeKB=50240;
		//Allowed file extensions
		$uploader->AllowedFileExtensions="vcf";
		//File Too Large Msg
		$uploader->FileTooLargeMsg="{0} non può essere caricato!\n\nIl file ({1}) è troppo grande. La grandezza massima consentita è: {2}.";
		$uploader->FileTypeNotSupportMsg="L'estensione del file non è consentita! Estensioni consentite: '{0}'";  
		$uploader->CancelUploadMsg="Annulla Caricamento";
		$uploader->CancelButtonID="uploadercancelbutton";
		
		//Specify the ID of the control that will be used as progress bar panel.        
		$uploader->ProgressCtrlID="uploaderprogresspanel";        
		//Specify the ID of the control that will be used as progress text label.        
		$uploader->ProgressTextID="uploaderprogresstext";
		
		$uploader->InputboxCSSText="font-size: 12px;";
		
		$uploader->InsertButtonID="uploaderbutton";
		$uploader->ProgressTextTemplate="%F%..";
		//$uploader->SaveDirectory="/myfolder";
		$uploader->TempDirectory="../../tmp_vcf";
		$uploader->UploadingMsg="Caricamento in corso..";
		
		return $uploader->Render();
	}
	public function Show_mailing_send_groups_email(){
		echo '<div class="personal_button" style="cursor:pointer; vertical-align:middle; width:220px;" alt="Invia un messaggio al gruppo selezionato." onclick="Prepare_send_groups_email();">
			<span class="text14px">INVIA E-MAIL AL GRUPPO</a>
		</div>';	
	}
	
	public function Prepare_send_groups_email($id_group){
		echo "<div style='position:absolute; top:0px; left:10px; width:655px; overflow-y:auto; overflow-x:hidden;'>";
			echo '<span class="text14px;">Messaggio al gruppo '.$this->newsletter_group[$id_group]["nome"].'</span><br/>';
			echo 'Oggetto: <input type="text" class="input_email" id="mailing_send_groups_email_subject" style="width:350px; border: 1px solid #FFF; color:#FFF;"><br/>';
			echo 'Corpo del messaggio: <br/>';
			echo '<textarea id="mailing_send_groups_email_body" name="mailing_send_groups_email_body" cols="77" rows="7" style="background-color:#333333; border: 1px solid #FFF; color:#FFF; color:#FFF; font-size:14px; font-weight:700;"></textarea>';
			
			echo '<br/>Il messaggio verrà inviato ai segeuenti indirizzi: <br/>';
			echo '<div style="position:relative; top:0px; left:10px; width:615px; height:90px; overflow-y:auto; overflow-x:hidden; border: 1px solid #FFF;"" class="mailing_contact_field" id="mailing_contacts_emails_div">';
				$i=0;
				foreach($this->newsletter_rows as $row){
					if($row["id_group"]==$this->newsletter_group[$id_group]["id"]){
						foreach($row["emails"] as $email){
							if($email["is_main"]==1){
								echo '<div id="mailing_send_groups_email_emails_div_'.$i.'"><input type="checkbox" checked="checked" id="mailing_send_groups_email_emails_check_'.$i.'"/><input type="text" value="'.$email["row_value"].'" class="personal_area_mod_mailing_contact" id="mailing_send_groups_email_emails_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript:  Hide_emails_contact(this)">Elimina</a></div>';
							}else{
								echo '<div id="mailing_send_groups_email_emails_div_'.$i.'"><input type="checkbox" id="mailing_send_groups_email_emails_check_'.$i.'" /><input type="text" value="'.$email["row_value"].'" class="personal_area_mod_mailing_contact" id="mailing_send_groups_email_emails_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>';	
							}
							$i++;
						}
					}
				}
				echo '<input type="hidden" value="'.$i.'" id="mailing_send_groups_emails_num"></input>';
			echo '</div>';
		echo "</div>";
	}
	
	public function Show_mailing_import_action(){
		$this->Show_upload_file_vcf(count($this->newsletter_group));
		echo '<div id="uploaderbutton" class="personal_button" style="cursor:pointer; vertical-align:middle; width:220px;" alt="Importa da file .vcf.">
			<span class="text14px">IMPORTA DA FILE .VCF</a>
		</div>';
		echo '<div id="uploadercancelbutton" class="personal_button" style="cursor:pointer; vertical-align:middle;  width: 100px; position:absolute;top:2px; left:390px;" alt="Annulla caricamento.">
			<span class="text14px">ANNULLA</a>
		</div>';
	}
	public function Show_mailing_contacts_action($index=NULL){
		echo '<div id="move_contact_container" class="move_contact_container">';
			$this->Show_move_mailing_contacts();
		echo '</div>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<a target="_self" onclick="Javascript:Mod_contact()" style="cursor:pointer;"><img src="../image/icone/pen.png" style="width:18px; height:18px; cursor:pointer;" alt="aggiungi" title="Crea nuovo contatto." ><span style="position:relative; top:-4px;">&nbsp;Modifica selezionato</span></a>&nbsp;&nbsp;';
		echo '<a target="_self" onclick="Javascript:Add_contact()" style="cursor:pointer;"><img src="../image/icone/icona_add.png" style="width:18px; height:18px; cursor:pointer;" alt="aggiungi" title="Crea nuovo contatto." ><span style="position:relative; top:-4px;">&nbsp;Crea nuovo contatto</span></a>&nbsp;&nbsp;<a target="_self" onclick="Javascript:Delete_mailing_selected_contact()" style="cursor:pointer;"><img src="../image/icone/edit-delete.png" style="width:18px; height:18px; cursor:pointer;" alt="elimina" title="Elimina i contatti selezionati." ><span style="position:relative; top:-4px;">&nbsp;Elimina selezionati</span></a>';
	}
	
	public function Show_mailing_contact_save_action($index=NULL){
		echo '<a target="_self" onclick="Javascript:Return_mailing_group()" style="cursor:pointer;"><img src="../image/icone/arrow-left.png" style="width:18px; height:18px; cursor:pointer;" alt="Indietro" title="Torna alla visualizzazione contatti." ><span style="position:relative; top:-4px;">&nbsp;Indietro</span></a>&nbsp;&nbsp;';
		echo '<a target="_self" onclick="Javascript:Update_mailing_contact('.$index.')" style="cursor:pointer;"><img src="../image/icone/pen.png" style="width:18px; height:18px; cursor:pointer;" alt="aggiungi" title="Salva le modifiche." ><span style="position:relative; top:-4px;">&nbsp;Salva le modifiche</span></a>';
	}
	
	public function Show_mailing_new_contact_save_actions($index){
		echo '<a target="_self" onclick="Javascript:Return_mailing_group()" style="cursor:pointer;"><img src="../image/icone/arrow-left.png" style="width:18px; height:18px; cursor:pointer;" alt="elimina" title="Torna alla visualizzazione contatti." ><span style="position:relative; top:-4px;">&nbsp;Indietro</span></a>&nbsp;&nbsp;';
		echo '<a target="_self" onclick="Javascript:Add_new_mailing_contact('.$this->newsletter_row[$index]["id"].')" style="cursor:pointer;"><img src="../image/icone/pen.png" style="width:18px; height:18px; cursor:pointer;" alt="aggiungi" title="Salva le modifiche." ><span style="position:relative; top:-4px;">&nbsp;Salva le modifiche</span></a>';
	}
	
	public function Show_mailing_contact_action($index=NULL){
		echo '<a target="_self" onclick="Javascript:Return_mailing_group()" style="cursor:pointer;"><img src="../image/icone/arrow-left.png" style="width:18px; height:18px; cursor:pointer;" alt="elimina" title="Torna alla visualizzazione contatti." ><span style="position:relative; top:-4px;">&nbsp;Indietro</span></a>&nbsp;&nbsp;';
		echo '<a target="_self" onclick="Javascript:Prepare_Mod_mailing_contact('.$index.')" style="cursor:pointer;"><img src="../image/icone/pen.png" style="width:18px; height:18px; cursor:pointer;" alt="aggiungi" title="Modifica il contatto." ><span style="position:relative; top:-4px;">&nbsp;Modifica il contatto</span></a>';
		echo '&nbsp;&nbsp;<a target="_self" onclick="Javascript:Delete_mailing_contact('.$index.')" style="cursor:pointer;"><img src="../image/icone/edit-delete.png" style="width:18px; height:18px; cursor:pointer;" alt="elimina" title="Elimina il contatto." ><span style="position:relative; top:-4px;">&nbsp;Elimina il contatto</span></a>&nbsp;&nbsp;';
	}
	public function Show_send_group_actions(){
		echo '<a target="_self" onclick="Javascript:Return_mailing_group()" style="cursor:pointer;"><img src="../image/icone/arrow-left.png" style="width:18px; height:18px; cursor:pointer;" alt="elimina" title="Torna alla visualizzazione contatti." ><span style="position:relative; top:-4px;">&nbsp;Indietro</span></a>&nbsp;&nbsp;';
		echo '<a target="_self" onclick="Javascript:Send_groups_email()" style="cursor:pointer;"><img src="../image/icone/mail_send.png" style="width:18px; height:18px; cursor:pointer;" alt="aggiungi" title="Modifica il contatto." ><span style="position:relative; top:-4px;">&nbsp;Invia il messaggio.</span></a>';
	}
	public function Show_move_mailing_contacts(){
		echo '<select name="move_contact" id="move_contact" class="move_contact" title="sposta contatti selezionati." onchange="Javasript:Move_selected_mailing_contact(this)">
				<option value="-1" selected="selected">Sposta selezionati</option>';
			  for($i=0;$i<count($this->newsletter_group);$i++){
					echo "<option value='".$i."'>".$this->newsletter_group[$i]["nome"]."</option>";  
			  }
		echo '</select>';
	}
	public function Show_mailing_groups($selected=NULL){
		echo '<table>';
			echo '<thead>
				<tr class="sorterbar">
				  <th id="nomegruppo_mailing_header" class="nomegruppo_mailing_header" scope="col">
		Gruppi 
				  </th>
				</tr>
			  </thead>
			  
			  <tbody>';
			  
			for($i=0; $i<count($this->newsletter_group); $i++){
				$colore="#FFF";
				$fontweight="700";
				
				if(($i%2)==0){
					$backcolor="#8b8b8b";	
				}else{
					$backcolor="#838383";
				}
				
				if(($i==$selected))
					$backcolor="#A8A8A8";
				//onclick="Javascript:Select_only_group(this)"
				if($i==0)
					$stylerichieste="border:1px solid #00;";
				 echo '<tr class="mailing_group_row" style="background-color:'.$backcolor.'; '.$stylerichieste.'" onclick="Show_mailing_group(this,\''.$i.'\')" >
						<td class="mailing_group_name">';
						
				   echo '<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.';" >'.$this->newsletter_group[$i]['nome'].'</a>';
				  echo '</td>
				  </tr>';
			}
			echo '</tbody>';
			echo '</table>';
			echo "<div id='add_new_group'></div>";
		if(count($this->newsletter_group)==0){
			echo '<div><span class="text14px;">Non sono presenti gruppi.</span></div>';
		}
		
		echo '<input id="mailing_groups_num" type="hidden" value="'.$i.'" />';
	}
	public function Show_mailing_contacts($index){
		echo '<table>';
			echo '<thead>
				<tr class="sorterbar">
				  <th class="col-select" id="message-select-header" scope="col">
					<input type="checkbox" title="seleziona tutti i contatti." alt="seleziona tutto" onchange="Javascript:Select_all_email_mailing_contact()"  class="chekbox_mailing_header" name="col_mailing_contact_select"/>
				  </th>
				  <th class="col-select" id="mailing_contact_new" scope="col">
		New
				  </th>
				  <th id="nomecontact_mailing_header" class="nomegruppo_mailing_header" scope="col">
		Nome 
				  </th>
				  <th id=cognomecontact_mailing_header" class="nomegruppo_mailing_header" scope="col">
		Cognome 
				  </th>
				  <th id="emailcontact_mailing_header" class="nomegruppo_mailing_header" scope="col">
		Email
				  </th>
				  <th id="azionicontact_mailing_header" class="nomegruppo_mailing_header" scope="col">
		Azioni
				  </th>
				</tr>
			  </thead>
			  
			  <tbody>';
			$j=0;
			for($i=0; $i<count($this->newsletter_rows); $i++){
				if($this->newsletter_rows[$i]["id_group"]==$this->newsletter_group[$index]["id"]){
					$colore="#FFF";
					$fontweight="700";
					
					if(($j%2)==0){
						$backcolor="#8b8b8b";	
					}else{
						$backcolor="#838383";
					}
					if($this->newsletter_rows[$i]["is_new"]!=0){
						$backcolor="#A8A8A8";
					}
					 echo '<tr class="mailing_contact_row" id="mailing_contact_row_'.$i.'"  style="background-color:'.$backcolor.'; cursor:pointer;">
					 	<td class="maling_contact_checkbox" scope="row">
							<input type="checkbox" value="'.$i.'" id="check_mailing_contact_'.$i.'" class="col-mailing-contact-select" ></input>
						</td>
						<td class="mailing_contact_new" onclick="Javascript:Show_mailing_contact_row('.$i.')">';
						   if($this->newsletter_rows[$i]["is_new"]!=0){
						   		echo '<img src="../image/icone/contact_new.png" style="width:20px;">';
						   }
						echo '
						</td>
						<td class="mailing_contact_name" onclick="Javascript:Show_mailing_contact_row('.$i.')">';
						echo '<input type="hidden" id="mailing_contact_name_'.$i.'" value="'.$this->newsletter_rows[$i]["nome"].'" />';
					   echo '<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.';" title='.$this->newsletter_rows[$i]["nome"].'>'.$this->limit_char($this->newsletter_rows[$i]["nome"]).'</a>';
						echo '
						</td>
						<td class="mailing_contact_surname"   onclick="Javascript:Show_mailing_contact_row('.$i.')">';
						echo '<input type="hidden" id="mailing_contact_surname_'.$i.'" value="'.$this->newsletter_rows[$i]["cognome"].'" />';
					   echo '<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.';" title='.$this->newsletter_rows[$i]["cognome"].'>'.$this->limit_char($this->newsletter_rows[$i]["cognome"]).'</a>';
						echo '
						</td>
						<td class="mailing_contact_email" onclick="Javascript:Show_mailing_contact_row('.$i.')">';
						echo '<input type="hidden" id="mailing_contact_row_value_'.$i.'" value="'.$this->newsletter_rows[$i]["row_value"].'" />';
					   echo '<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.';" title='.$this->newsletter_rows[$i]["row_value"].'>'.$this->limit_char($this->newsletter_rows[$i]["emails"][0]["row_value"]).'</a>';
						echo '
						</td>
						<td class="mailing_contact_cell" onclick="Javascript:Show_mailing_contact_row('.$i.')">';
						echo '<input type="hidden" id="mailing_contact_cell_'.$i.'" value="'.$this->newsletter_rows[$i]["cell"].'" />';
					   echo '<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.';" title="Visualizza i dettagli del contatto.">Visualizza Dettagli</a>';
					   
						echo '<input type="hidden" id="mailing_contact_id_'.$i.'" value="'.$this->newsletter_rows[$i]["id"].'" />';
						echo '
						</td>
						
					  </tr>';
					 $j++;
				}
			}
		echo '</tbody>';
		echo '</table>';
		echo '<div id="add_new_contact"></div>';
		
		if($j==0){
			echo '<div><span class="text14px;">Non sono presenti contatti.</span></div>';
		}
		
	}
	public function Show_mailing_contact_row($index){
		echo "<div style='position:absolute; top:10px; left:10px; text-align:center; width:660px;' class='text14px;'>";
			echo '<div style="width:630px; height:35px; position:absolute; top:0px;">';
				/*echo '<div class="mailing_contact_field" style="height:35px; position:absolute; top:0px; left:10px;" >';
					echo "<div class='personal_button' onclick='Javascript:Return_mailing_group();' style='text-align:center; width:85px;'>
					<span class='text14px' alt='Salva'>INDIETRO</span>
				</div>";
				echo '<div class="mailing_contact_field" style="height:35px; position:absolute; top:0px; left:95px;">';
					echo "<div class='personal_button' onclick='Javascript:Prepare_Mod_mailing_contact(".$index.");' style='text-align:center; width:155px;'>
					<span class='text14px' alt='Salva'>MODIFICA IL CONTATTO</span>
				</div>";
				echo '</div>';
			echo '</div>';*/
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:105px; position:absolute; top:0px;">';
				echo 'Informazioni Personali';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome:</span><br/>'.$this->newsletter_rows[$index]["nome"];
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:270px;" class="mailing_contact_field">';
				echo '<span class="text11px">Secondo Nome:</span><br/>'.$this->newsletter_rows[$index]["middle_name"];
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:490px;" class="mailing_contact_field">';
				echo '<span class="text11px">Cognome:</span><br/>'.$this->newsletter_rows[$index]["cognome"];
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:580px;" class="mailing_contact_field">';
				echo '<span class="text11px">Titolo:</span><br/>'.$this->newsletter_rows[$index]["addon"];
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome completo:</span><br/>'.$this->newsletter_rows[$index]["fn"];
				echo '</div>';
				if($this->newsletter_rows[$index]["nickname"]!=NULL&&$this->newsletter_rows[$index]["nickname"]!=""){
					echo '<div style="position:absolute; top:50px; left:430px;" class="mailing_contact_field">';
					echo '<span class="text11px">Nome alternativo:</span><br/>'.$this->newsletter_rows[$index]["nickname"];
					echo '</div>';
				}
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_home1"]!=NULL&&$this->newsletter_rows[$index]["tel_home1"]!="")
					echo '<span class="text11px">Telefono Abitazione:</span><br/>'.$this->newsletter_rows[$index]["tel_home1"];
				else
					echo '<span class="text11px">Telefono Abitazione:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:200px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["cell"]!=NULL&&$this->newsletter_rows[$index]["cell"]!="")
					echo '<span class="text11px">Cellulare Abitazione:</span><br/>'.$this->newsletter_rows[$index]["cell"];
				else
					echo '<span class="text11px">Cellulare Abitazione:</span><br/>---';
				echo '</div>';
				
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_work1"]!=NULL&&$this->newsletter_rows[$index]["tel_work1"]!="")
					echo '<span class="text11px">Telefono Ufficio:</span><br/>'.$this->newsletter_rows[$index]["tel_work1"];
				else
					echo '<span class="text11px">Telefono Ufficio:</span><br/>---';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:120px; width:630px; height:75px; ">';
				echo 'Posta Elettronica';
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:60px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field">';
					foreach($this->newsletter_rows[$index]["emails"] as $email){
						if($email["is_main"]==1){
							echo $email["row_value"]." (Email Predefinito)<br/>"; 
						}else{
							echo $email["row_value"]."<br/>"; 	
						}
					}
				echo '</div>';
			echo '</div>';
			
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:135px; position:absolute; top:210px;">';
				echo 'Abitazione';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["home_city"]!=NULL&&$this->newsletter_rows[$index]["home_city"]!="")
					echo '<span class="text11px">Citt&aacute;:</span><br/>'.$this->newsletter_rows[$index]["home_city"];
				else
					echo '<span class="text11px">Citt&aacute;:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:200px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["home_region"]!=NULL&&$this->newsletter_rows[$index]["home_region"]!="")
				echo '<span class="text11px">Provincia:</span><br/>'.$this->newsletter_rows[$index]["home_region"];
				else
					echo '<span class="text11px">Provincia:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:400px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["home_country"]!=NULL&&$this->newsletter_rows[$index]["home_country"]!="")
					echo '<span class="text11px">Paese:</span><br/>'.$this->newsletter_rows[$index]["home_country"];
				else
					echo '<span class="text11px">Paese:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:570px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["home_zip"]!=NULL&&$this->newsletter_rows[$index]["home_zip"]!="")
					echo '<span class="text11px">CAP:</span><br/>'.$this->newsletter_rows[$index]["home_zip"];
				else
					echo '<span class="text11px">CAP:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["home_street"]!=NULL&&$this->newsletter_rows[$index]["home_street"]!="")
					echo '<span class="text11px">Via e numero civico:</span><br/>'.$this->newsletter_rows[$index]["home_street"];
				else
					echo '<span class="text11px">Via e numero civico:</span><br/>---';
				echo '</div>';
				if($this->newsletter_rows[$index]["url_home"]!=NULL&&$this->newsletter_rows[$index]["url_home"]!=""){
					echo '<div style="position:absolute; top:50px; left:400px;" class="mailing_contact_field">';
					echo '<span class="text11px">Sito web:</span><br/>'.$this->newsletter_rows[$index]["url_home"];
					echo '</div>';
				}
				
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_home1"]!=NULL&&$this->newsletter_rows[$index]["tel_home1"]!="")
					echo '<span class="text11px">Telefono Abitazione:</span><br/>'.$this->newsletter_rows[$index]["tel_home1"];
				else
					echo '<span class="text11px">Telefono Abitazione:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:200px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["cell"]!=NULL&&$this->newsletter_rows[$index]["cell"]!="")
					echo '<span class="text11px">Cellulare Abitazione:</span><br/>'.$this->newsletter_rows[$index]["cell"];
				else
					echo '<span class="text11px">Cellulare Abitazione:</span><br/>---';
				echo '</div>';
				
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_home_fax"]!=NULL&&$this->newsletter_rows[$index]["tel_home_fax"]!="")
					echo '<span class="text11px">Fax Abitazione:</span><br/>'.$this->newsletter_rows[$index]["tel_home_fax"];
				else
					echo '<span class="text11px">Fax Abitazione:</span><br/>---';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_home2"]!=NULL&&$this->newsletter_rows[$index]["tel_home2"]!="")
					echo '<span class="text11px">Telefono 2 Abitazione:</span><br/>'.$this->newsletter_rows[$index]["tel_home2"];
				else
					echo '<span class="text11px">Telefono 2 Abitazione:</span><br/>---';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:200px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_car"]!=NULL&&$this->newsletter_rows[$index]["tel_car"]!="")
					echo '<span class="text11px">Telefono Automobile:</span><br/>'.$this->newsletter_rows[$index]["tel_car"];
				else
					echo '<span class="text11px">Telefono Automobile:</span><br/>---';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:400px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_additional"]!=NULL&&$this->newsletter_rows[$index]["tel_additional"]!="")
					echo '<span class="text11px">Telefono Alternativo:</span><br/>'.$this->newsletter_rows[$index]["tel_additional"];
				else
					echo '<span class="text11px">Telefono Alternativo:</span><br/>---';
				echo '</div>';
				
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:165px; position:absolute; top:360px;">';
				echo 'Ufficio';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["organisation"]!=NULL&&$this->newsletter_rows[$index]["organisation"]!="")
					echo '<span class="text11px">Societ&aacute;:</span><br/>'.$this->newsletter_rows[$index]["organisation"];
				else
					echo '<span class="text11px">Societ&aacute;:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:200px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["title"]!=NULL&&$this->newsletter_rows[$index]["title"]!="")
					echo '<span class="text11px">Posizione:</span><br/>'.$this->newsletter_rows[$index]["title"];
				else
					echo '<span class="text11px">Posizione:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:400px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["departement"]!=NULL&&$this->newsletter_rows[$index]["departement"]!="")
					echo '<span class="text11px">Reparto:</span><br/>'.$this->newsletter_rows[$index]["departement"];
				else
					echo '<span class="text11px">Reparto:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:570px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["company"]!=NULL&&$this->newsletter_rows[$index]["company"]!="")
					echo '<span class="text11px">Ufficio:</span><br/>'.$this->newsletter_rows[$index]["company"];
				else
					echo '<span class="text11px">Ufficio:</span><br/>---';
				echo '</div>';
					
					
									
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["work_city"]!=NULL&&$this->newsletter_rows[$index]["work_city"]!="")
					echo '<span class="text11px">Citt&aacute;:</span><br/>'.$this->newsletter_rows[$index]["work_city"];
				else
					echo '<span class="text11px">Citt&aacute;:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:200px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["work_region"]!=NULL&&$this->newsletter_rows[$index]["work_region"]!="")
					echo '<span class="text11px">Provincia:</span><br/>'.$this->newsletter_rows[$index]["work_region"];
				else
					echo '<span class="text11px">Provincia:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:400px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["work_country"]!=NULL&&$this->newsletter_rows[$index]["work_country"]!="")
					echo '<span class="text11px">Paese:</span><br/>'.$this->newsletter_rows[$index]["work_country"];
				else
					echo '<span class="text11px">Paese:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:570px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["work_zip"]!=NULL&&$this->newsletter_rows[$index]["work_zip"]!="")
					echo '<span class="text11px">CAP:</span><br/>'.$this->newsletter_rows[$index]["work_zip"];
				else
					echo '<span class="text11px">CAP:</span><br/>---';
				echo '</div>';
				
				
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["work_street"]!=NULL&&$this->newsletter_rows[$index]["work_street"]!="")
					echo '<span class="text11px">Via e numero civico:</span><br/>'.$this->newsletter_rows[$index]["work_street"];
				else
					echo '<span class="text11px">Via e numero civico:</span><br/>---';
				echo '</div>';
				if($this->newsletter_rows[$index]["url_work"]!=NULL&&$this->newsletter_rows[$index]["url_work"]!=""){
					echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
					echo '<span class="text11px">Sito web:</span><br/>'.$this->newsletter_rows[$index]["url_work"];
					echo '</div>';
				}
			
			echo '<div style="position:absolute; top:110px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_work1"]!=NULL&&$this->newsletter_rows[$index]["tel_work1"]!="")
					echo '<span class="text11px">Telefono Ufficio:</span><br/>'.$this->newsletter_rows[$index]["tel_work1"];
				else
					echo '<span class="text11px">Telefono Ufficio:</span><br/>---';
				echo '</div>';
				echo '<div style="position:absolute; top:110px; left:200px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_work2"]!=NULL&&$this->newsletter_rows[$index]["tel_work2"]!="")
					echo '<span class="text11px">Telefono 2 Ufficio:</span><br/>'.$this->newsletter_rows[$index]["tel_work2"];
				else
					echo '<span class="text11px">Telefono 2 Ufficio:</span><br/>---';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:400px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_work_fax"]!=NULL&&$this->newsletter_rows[$index]["tel_work_fax"]!="")
					echo '<span class="text11px">Fax Ufficio:</span><br/>'.$this->newsletter_rows[$index]["tel_work_fax"];
				else
					echo '<span class="text11px">Fax Ufficio:</span><br/>---';
				echo '</div>';
				
				echo '<div style="position:absolute; top:140px; left:10px;" class="mailing_contact_field">';
				if($this->newsletter_rows[$index]["tel_pager"]!=NULL&&$this->newsletter_rows[$index]["tel_pager"]!="")
					echo '<span class="text11px">Cercapersone:</span><br/>'.$this->newsletter_rows[$index]["tel_pager"];
				else
					echo '<span class="text11px">Cercapersone:</span><br/>---';
				echo '</div>';	
			
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:540px; width:630px; height:135px; ">';
				echo 'Ulteriori note:';
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:120px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field">';
					if($this->newsletter_rows[$index]["note"]!=NULL&&$this->newsletter_rows[$index]["note"]!="")
					echo $this->newsletter_rows[$index]["note"];
				else
					echo '---';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:690px; width:630px; height:75px; ">';
				echo 'Indirizzi:';
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:60px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field">';
					if(count($this->newsletter_rows[$index]["url"])){
						foreach($this->newsletter_rows[$index]["url"] as $url){
							if($url["is_main"]==1){
								echo $url["row_value"]." (Url Predefinito)<br/>"; 
							}else{
								echo $url["row_value"]."<br/>"; 	
							}
						}
					}
				echo '</div>';
			echo '</div>';
			
			echo '</div>';
		echo "</div>";
		
	}
	
	public function Add_mailing_contact_row($index,$id_group){
		echo "<div style='position:absolute; top:10px; left:10px; text-align:center; width:660px;' class='text14px;'>";
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:105px; position:absolute; top:0px;">';
				echo 'Informazioni Personali';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["nome"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_nome" style="width: 240px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:270px;" class="mailing_contact_field">';
				echo '<span class="text11px">Secondo Nome:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["middle_name"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_middle_name" style="width: 202px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:490px;" class="mailing_contact_field">';
				echo '<span class="text11px">Cognome:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["cognome"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_cognome" style="width: 135px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:580px;" class="mailing_contact_field">';
				echo '<span class="text11px">Titolo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["addon"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_addon" style="width: 40px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome completo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["fn"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_fn" style="width: 400px;" disabled></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:430px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome alternativo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["nickname"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_nickname" style="width: 134px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Telefono Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home1"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home1" style="width: 175px;"></input>';
				
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Cellulare Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["cell"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_cell" style="width: 190px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_work1"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work1" style="width: 190px;"></input>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:120px; width:630px; height:75px; ">';
				echo 'Posta Elettronica <input type="text" value="" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_emails_new_row" style="width: 190px;" onkeydown="Invio_om_Add_mailing_contacts_email(event);"></input>';
				echo "<div class='personal_button' onclick='Javascript:Add_mailing_contacts_email();' style='text-align:center; width:85px; height:15px; padding-top:0px;'>
					<span class='text12px' alt='Salva'>AGGIUNGI</span>
				</div>";
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:60px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field" id="mailing_contacts_emails_div">';
					$i=0;
					foreach($this->newsletter_rows[$index]["emails"] as $email){
						if($email["is_main"]==1){
							echo '<div id="mailing_contact_emails_div_'.$i.'"><input type="text" value="'.$email["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_emails_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript:  Hide_emails_contact(this)">Elimina</a></div>';
						}else{
							echo '<div id="mailing_contact_emails_div_'.$i.'"><input type="text" value="'.$email["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_emails_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>';	
						}
						$i++;
					}
					echo '<input type="hidden" value="'.$i.'" id="mod_mailing_contact_emails_num"></input>';
				echo '</div>';
			echo '</div>';
			
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:135px; position:absolute; top:210px;">';
				echo 'Abitazione';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Citt&aacute;:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_city"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_city" style="width: 180px;"></input>';
				
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:200px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Provincia:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_region"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_region" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:400px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Paese:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_country"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_country" style="width: 160px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:570px;" class="mailing_contact_field">';
				echo '<span class="text11px">CAP:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_zip"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_zip" style="width: 40px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Via e numero civico:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_street"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_street" style="width: 380px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:400px;" class="mailing_contact_field">';
					echo '<span class="text11px">Sito web:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["url_home"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_url_home" style="width: 211px;"></input>';
				echo '</div>';
				
				
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home1"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home1" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:200px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Cellulare Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["cell"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_cell" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Fax Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home_fax"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home_fax" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:110px; left:10px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Telefono 2 Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home2"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home2" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Automobile:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_car"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_car" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:400px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Telefono Alternativo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_additional"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_additional" style="width: 180px;"></input>';
				
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:165px; position:absolute; top:360px;">';
				echo 'Ufficio';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Societ&aacute;:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["organisation"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_organisation" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:20px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Posizione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["title"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_title" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:20px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Reparto:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["departement"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_departement" style="width: 160px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:20px; left:570px;" class="mailing_contact_field">';
				echo '<span class="text11px">Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["company"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_company" style="width: 40px;"></input>';
				echo '</div>';
					
					
									
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Citt&aacute;:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_city"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_city" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Provincia:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_region"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_region" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Paese:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_country"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_country" style="width: 160px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:570px;" class="mailing_contact_field">';
				echo '<span class="text11px">CAP:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_zip"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_zip" style="width: 40px;"></input>';
				echo '</div>';
				
				
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Via e numero civico:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_street"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_street" style="width: 370px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Sito web:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["url_work"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_url_work" style="width: 215px;"></input>';
				echo '</div>';
				
			
			echo '<div style="position:absolute; top:110px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home2"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work1" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:110px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono 2 Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_work2"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work2" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Fax Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_work_fax"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work_fax" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:140px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Cercapersone:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_pager"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_pager" style="width: 180px;"></input>';
				echo '</div>';	
			
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:540px; width:630px; height:135px; ">';
			$note = preg_replace('#<br\s*/?>#i', "\n", $this->newsletter_rows[$index]["note"]);
				echo 'Ulteriori note:';
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:120px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field">';
					echo '<textarea id="mod_mailing_contact_note" name="note" cols="71" rows="6">
'.$note.'
</textarea>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:690px; width:630px; height:75px;">';
				echo 'Indirizzi: <input type="text" value="" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_urls_new_row" style="width: 190px;" onkeydown="Invio_om_Add_mailing_contacts_url(event);"></input>';
				echo "<div class='personal_button' onclick='Javascript:Add_mailing_contacts_url();' style='text-align:center; width:85px; height:15px; padding-top:0px;'>
					<span class='text12px' alt='Salva'>AGGIUNGI</span>
				</div>";
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:60px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field" id="mailing_contacts_urls_div">';
					$i=0;
					foreach($this->newsletter_rows[$index]["url"] as $url){
						if($url["is_main"]==1){
							echo '<div id="mailing_contact_urls_div_'.$i.'"><input type="text" value="'.$url["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_urls_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>';
						}else{
							echo '<div id="mailing_contact_urls_div_'.$i.'"><input type="text" value="'.$url["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_urls_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>';	
						}
						$i++;
					}
					echo '<input type="hidden" value="'.$i.'" id="mod_mailing_contact_urls_num"></input>';
				echo '</div>';
			echo '</div>';
			
			echo '</div>';
		echo "</div>";
	}
	public function Mod_mailing_contact_row($index){
		echo "<div style='position:absolute; top:10px; left:10px; text-align:center; width:660px;' class='text14px;'>";
		
		
			echo '<div class="mailing_contact_field_group" style="width:630px; height:105px; position:absolute; top:0px;">';
				echo 'Informazioni Personali';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["nome"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_nome" style="width: 240px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:270px;" class="mailing_contact_field">';
				echo '<span class="text11px">Secondo Nome:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["middle_name"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_middle_name" style="width: 202px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:490px;" class="mailing_contact_field">';
				echo '<span class="text11px">Cognome:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["cognome"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_cognome" style="width: 135px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:580px;" class="mailing_contact_field">';
				echo '<span class="text11px">Titolo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["addon"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_addon" style="width: 40px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome completo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["fn"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_fn" style="width: 400px;" disabled></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:430px;" class="mailing_contact_field">';
				echo '<span class="text11px">Nome alternativo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["nickname"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_nickname" style="width: 134px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Telefono Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home1"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home1" style="width: 175px;"></input>';
				
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Cellulare Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["cell"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_cell" style="width: 190px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_work1"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work1" style="width: 190px;"></input>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:120px; width:630px; height:75px; ">';
				echo 'Posta Elettronica <input type="text" value="" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_emails_new_row" style="width: 190px;" onkeydown="Invio_om_Add_mailing_contacts_email(event);"></input>';
				echo "<div class='personal_button' onclick='Javascript:Add_mailing_contacts_email();' style='text-align:center; width:85px; height:15px; padding-top:0px;'>
					<span class='text12px' alt='Salva'>AGGIUNGI</span>
				</div>";
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:60px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field" id="mailing_contacts_emails_div">';
					$i=0;
					foreach($this->newsletter_rows[$index]["emails"] as $email){
						if($email["is_main"]==1){
							echo '<div id="mailing_contact_emails_div_'.$i.'"><input type="text" value="'.$email["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_emails_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript:  Hide_emails_contact(this)">Elimina</a></div>';
						}else{
							echo '<div id="mailing_contact_emails_div_'.$i.'"><input type="text" value="'.$email["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_emails_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>';	
						}
						$i++;
					}
					echo '<input type="hidden" value="'.$i.'" id="mod_mailing_contact_emails_num"></input>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:135px; position:absolute; top:210px;">';
				echo 'Abitazione';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Citt&aacute;:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_city"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_city" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Provincia:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_region"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_region" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Paese:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_country"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_country" style="width: 160px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:20px; left:570px;" class="mailing_contact_field">';
				echo '<span class="text11px">CAP:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_zip"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_zip" style="width: 40px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Via e numero civico:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["home_street"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_home_street" style="width: 380px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:400px;" class="mailing_contact_field">';
					echo '<span class="text11px">Sito web:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["url_home"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_url_home" style="width: 211px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home1"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home1" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:80px; left:200px;" class="mailing_contact_field">';
				
				echo '<span class="text11px">Cellulare Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["cell"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_cell" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Fax Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home_fax"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home_fax" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:110px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono 2 Abitazione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home2"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_home2" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Automobile:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_car"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_car" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Alternativo:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_additional"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_additional" style="width: 180px;"></input>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="width:630px; height:165px; position:absolute; top:360px;">';
				echo 'Ufficio';
				echo '<div style="position:absolute; top:20px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Societ&aacute;:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["organisation"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_organisation" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:20px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Posizione:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["title"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_title" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:20px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Reparto:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["departement"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_departement" style="width: 160px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:20px; left:570px;" class="mailing_contact_field">';
				echo '<span class="text11px">Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["company"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_company" style="width: 40px;"></input>';
				echo '</div>';
					
					
									
				echo '<div style="position:absolute; top:50px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Citt&aacute;:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_city"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_city" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Provincia:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_region"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_region" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Paese:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_country"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_country" style="width: 160px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:50px; left:570px;" class="mailing_contact_field">';
				echo '<span class="text11px">CAP:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_zip"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_zip" style="width: 40px;"></input>';
				echo '</div>';
				
				
				echo '<div style="position:absolute; top:80px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Via e numero civico:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["work_street"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_work_street" style="width: 370px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:80px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Sito web:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["url_work"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_url_work" style="width: 215px;"></input>';
				echo '</div>';
				
			
				echo '<div style="position:absolute; top:110px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_home2"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work1" style="width: 180px;"></input>';
				echo '</div>';
				echo '<div style="position:absolute; top:110px; left:200px;" class="mailing_contact_field">';
				echo '<span class="text11px">Telefono 2 Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_work2"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work2" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:110px; left:400px;" class="mailing_contact_field">';
				echo '<span class="text11px">Fax Ufficio:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_work_fax"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_work_fax" style="width: 180px;"></input>';
				echo '</div>';
				
				echo '<div style="position:absolute; top:140px; left:10px;" class="mailing_contact_field">';
				echo '<span class="text11px">Cercapersone:</span><br/><input type="text" value="'.$this->newsletter_rows[$index]["tel_pager"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_tel_pager" style="width: 180px;"></input>';
				echo '</div>';	
			
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:540px; width:630px; height:135px; ">';
			$note = preg_replace('#<br\s*/?>#i', "\n", $this->newsletter_rows[$index]["note"]);
				echo 'Ulteriori note:';
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:120px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field">';
					echo '<textarea id="mod_mailing_contact_note" name="note" cols="71" rows="6">
'.$note.'
</textarea>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="mailing_contact_field_group" style="position:absolute; top:690px; width:630px; height:75px;">';
				echo 'Indirizzi: <input type="text" value="" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_urls_new_row" style="width: 190px;" onkeydown="Invio_om_Add_mailing_contacts_url(event);"></input>';
				echo "<div class='personal_button' onclick='Javascript:Add_mailing_contacts_url();' style='text-align:center; width:85px; height:15px; padding-top:0px;'>
					<span class='text12px' alt='Salva'>AGGIUNGI</span>
				</div>";
				echo '<div style="position:relative; top:0px; left:10px; width:615px; height:60px; overflow-y:auto; overflow-x:hidden;" class="mailing_contact_field" id="mailing_contacts_urls_div">';
					$i=0;
					foreach($this->newsletter_rows[$index]["url"] as $url){
						if($url["is_main"]==1){
							echo '<div id="mailing_contact_urls_div_'.$i.'"><input type="text" value="'.$url["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_urls_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>';
						}else{
							echo '<div id="mailing_contact_urls_div_'.$i.'"><input type="text" value="'.$url["row_value"].'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_urls_'.$i.'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>';	
						}
						$i++;
					}
					echo '<input type="hidden" value="'.$i.'" id="mod_mailing_contact_urls_num"></input>';
				echo '</div>';
			echo '</div>';
			
		echo "</div>";
		
	}
	
	
	public function limit_char($string){
		if(strlen($string)>22){
			return substr($string,0,22)."...";
		}else{
			return $string;
		}
	}
	public function Show_personal_photo(){
		echo "<div id='tabdiv_btn_card_personal_photo' style='display:none;'>
		  <div class='personal_tab_center'>
				<div class='personal_tab_center_content' style='width:943px; padding:0px;' >";
				//echo "<iframe src='../card/php/photo.php?u=".$this->username."'width='934' height='425' frameborder='0' style='overflow-y:auto;'></iframe>";
			echo "</div>
		  </div>
		 
	  </div>";
	}
	
	/*  METHOD: Show_personal_card_dove_siamo()
		
		IN: -
		OUT: {on video print on video the user's card main section}
		DESCRIPTION: Print on video the user's card main section.
	*/
	public function Show_personal_card_dove_siamo(){
		echo '<div id="personal_card_dove_siamo" class="personal_card_dove_siamo" onclick="personal_tab_change(\'dove_siamo\')" >';
			echo "<img src='../../image/icone/gmaps.png' width='25px' height='25px'/><span style='position:relative; top:-7px; left:6px;' class='text12px'>MAPPA</span> ";
		echo '</div>';
	}
	
	/*  METHOD: Show_card_down()	
	IN: .
	OUT: . 
	DESCRIPTION: show card section down.
	*/
	public function Show_personal_card_down(){
		echo '<div class="personal_card_nav_buttons">';
		echo '
		  <a target="_self" style="text-decoration:none;" onclick="Javascript:personal_tab_change(\'fotodocumenti\')" >
				<div class="personal_card_nav_button">
					<div class="personal_card_nav_button_image">
						<img src="../image/icone/documenti.png" width="25" height="25" />
					</div>
					<div class="personal_card_nav_button_text">
						<span class="text12px">FOTO E DOCUMENTI</span>
					</div>
				</div>
		  </a>
		  <a target="_self" style="text-decoration:none;" onclick="Javascript:personal_tab_change(\'curriculum\')" >
				<div class="personal_card_nav_button">
					<div class="personal_card_nav_button_image">
						<img src="../image/icone/curriculum.png" width="25" height="25" />
					</div>
					<div class="personal_card_nav_button_text">
						<span class="text12px">STORIA E CURRICULUM</span>
					</div>
				</div>
		  </a>
		  <a target="_self" style="text-decoration:none;" onclick="Javascript:personal_tab_change(\'biglietto\')" >
				<div class="personal_card_nav_button">
					<div class="personal_card_nav_button_image">
						<img src="../image/icone/biglietto.png" width="25" height="25" />
					</div>
					<div class="personal_card_nav_button_text">
						<span class="text12px">BIGLIETTO DA VISITA</span>
					</div>
				</div>
		  </a>
		  <a target="_self" style="text-decoration:none;" onclick="Javascript:personal_tab_change(\'contatti\')" >
				<div class="personal_card_nav_button">
					<div class="personal_card_nav_button_image">
						<img src="../image/icone/contatti.png" width="25" height="25" />
					</div>
					<div class="personal_card_nav_button_text" style="position:relative; top:-7px;">
						<span class="text12px">CONTATTI</span>
					</div>
				</div>
		  </a>
		  <a target="_self" style="text-decoration:none;" onclick="Javascript:personal_tab_change(\'filebox\')" >
				<div class="personal_card_nav_button">
					<div class="personal_card_nav_button_image">
						<img src="../image/icone/filebox.png" width="25" height="25" />
					</div>
					<div class="personal_card_nav_button_text">
						<span class="text12px">CARTELLE SEGRETE</span>
					</div>
				</div>
		  </a>';
		echo '</div>';
		
	}
	
	/*  METHOD: Show_upload_file_in_evidenza()		
	IN: .
	OUT: . 
	DESCRIPTION: show the upload button for the attachments.
	*/
	public function Show_upload_file_in_evidenza($news_id,$mod=NULL){
		$uploader=new PhpUploader();    
		// Set a unique name to Uploader  
		$uploader->Name="upload_evidenza";    
		//Create a new file upload handler    
		$uploader->UploadUrl="evidenza_handler.php?u=".$this->username."&news_id=".$news_id."&mod=".$mod;
		//Step 4: Enable Multiple Files Upload.    
		$uploader->MultipleFilesUpload=false; 
		//Specify the maximum allowed size of the file using MaxSizeKB property  
		$uploader->MaxSizeKB=10240;
		//Allowed file extensions
		$uploader->AllowedFileExtensions=ALLOWEDEXTENSION;
		//File Too Large Msg
		$uploader->FileTooLargeMsg="{0} non può essere caricato!\n\nIl file ({1}) è troppo grande. La grandezza massima consentita è: {2}.";
		$uploader->FileTypeNotSupportMsg="L'estensione del file non è consentita! Estensioni consentite: '{0}'";  
		$uploader->CancelUploadMsg="Annulla Caricamento";
		$uploader->CancelButtonID="uploadercancelbutton";
		
		//Specify the ID of the control that will be used as progress bar panel.        
		$uploader->ProgressCtrlID="uploaderprogresspanel";        
		//Specify the ID of the control that will be used as progress text label.        
		$uploader->ProgressTextID="uploaderprogresstext";
		
		$uploader->InputboxCSSText="font-size: 12px;";
		
		$uploader->InsertButtonID="uploaderbutton";
		$uploader->ProgressTextTemplate="%F%..";
		//$uploader->SaveDirectory="/myfolder";
		$uploader->TempDirectory="../../tmp/tmp_evidenza";
		$uploader->UploadingMsg="Caricamento in corso..";
		
		return $uploader->Render();
	}
	
	public function Show_file_in_evidenza($news_id,$mod=NULL){
		$path ="../../".USERS_PATH.$this->username."/download_area/evidenza/news_".$news_id;
		if (!is_dir($path))
			mkdir($path, 0755);
		
		$conta=0;
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($dh)) != false) {
					if($file!= "." && $file!= ".." && $file!= "pdfconverted"){
						if(strlen($file)>40){
							$filename= substr($file,0,40);
							$filename.="...";
						}else{
							$filename = $file;
						}
						
						echo $this->Get_evidenza_desc($file,$filename);
						if($mod==NULL){
							echo " <a target='_self' onclick='Delete_evidenza_file();'><img src='../../image/filebox/icona_delete.png' alt='Elimina' style='vertical-align:middle; width:22px; height:22px; position:relative; top:-11px;' /></a>";
							echo "<input type='hidden' value='".$file."' id='in_evidenza_file'></input>";
						}else if($mod==1){
							echo " <a target='_self' onclick='Delete_evidenza_mod_file();'><img src='../../image/filebox/icona_delete.png' alt='Elimina' style='vertical-align:middle; width:22px; height:22px; position:relative; top:-11px;' /></a>";
							echo "<input type='hidden' value='".$file."' id='in_evidenza_mod_file'></input>";
						}else if($mod==2){
							echo " <a target='_self' onclick='Delete_evidenza_mod_now_file();'><img src='../../image/filebox/icona_delete.png' alt='Elimina' style='vertical-align:middle; width:22px; height:22px; position:relative; top:-11px;' /></a>";
							echo "<input type='hidden' value='".$file."' id='in_evidenza_mod_now_file'></input>";
						}
						$conta++;
					}
				}
				closedir($dh);
			}
		}
		if($conta==0){
			echo "<input type='hidden' value='' id='in_evidenza_file'></input>";
			echo "<input type='hidden' value='' id='in_evidenza_mod_file'></input>";
			echo "<input type='hidden' value='' id='in_evidenza_mod_now_file'></input>";
			$this->Show_upload_file_in_evidenza($news_id,$mod);	
			echo '<img id="uploaderbutton" style="cursor:pointer" alt="Upload" src="../../image/btn/btn_allega_file.png" />
				<img id="uploadercancelbutton" style="cursor:pointer;" alt="Cancel" src="../../image/btn/btn_cancella.png"/>
				
				<div id="uploaderprogresspanel" style="display:block;background-color:#33333;border: 2px gray;padding:4px; width:440px;" BorderColor="Grey" BorderStyle="dashed">        
				<span id="uploaderprogresstext" style="color:white"></span></div>';
		}	
	}
	public function Show_news_mod_mailing_list_groups($mod=NULL){
		for($i=0; $i<count($this->newsletter_group); $i++){
			  if(($i%2)==0){
				  $backcolor="#8b8b8b";	
			  }else{
				  $backcolor="#838383";
			  }
			  if($mod!=NULL)
			   	echo '<tr class="mailing_group_row" style="background-color:'.$backcolor.'; '.$stylerichieste.'" onclick="Select_mailing_group_mod(this,\''.$i.'\')">';
			   else
			  	 echo '<tr class="mailing_group_row" style="background-color:'.$backcolor.'; '.$stylerichieste.'" onclick="Select_mailing_group(this,\''.$i.'\')">';
			   echo '
					  <td class="mailing_group_name">';
				 echo $this->newsletter_group[$i]['nome'];
				 echo '<input type="hidden" value="'.$this->newsletter_group[$i]['id'].'" id="mailing_group_id_'.$i.'">';
				 echo '<input type="hidden" value="'.$this->newsletter_group[$i]['nome'].'" id="mailing_group_name_'.$i.'">';
				echo '</td>';
				 echo '<td class="mailing_group_row_arrow" style="background-color:'.$backcolor.'; '.$stylerichieste.'" onclick="Select_mailing_group(this,\''.$i.'\')">';
				 	echo '<img src="../../image/icone/arrow-right.png" style="width:15px; height:15px;">
					</td>';
				 echo '</tr>';
		  }
		  if(count($this->newsletter_group)==0){
			  echo '<div><span class="text14px;">Non sono presenti gruppi.</span></div>';
		  }	
	}
	public function Load_mod_saved_mailing_list_groups($news_id){
		for($i=0;$i<count($this->news_rows);$i++){
			if($this->news_rows[$i]["id"]==$news_id)
				$selected_index = $this->news_rows[$i]["sendto"];
		}
		//echo $selected_index;
		$j=0;
		$id=substr($selected_index,0,strpos($selected_index,","));
		while($id!=""){
			for($i=0;$i<count($this->newsletter_group);$i++){
				if($this->newsletter_group[$i]["id"]==$id){
				  if(($j%2)==0){
					  $backcolor="#8b8b8b";	
				  }else{
					  $backcolor="#838383";
				  }
				  echo "<tr style='background-color:".$backcolor."; cursor:pointer;'; onclick='Deselect_mailing_group(this,\"".$i."\")' id='selected_tr_".$i."'><td><img src='../../image/icone/arrow-left.png' style='width:15px; height:15px;'></td><td class='mailing_group_selected_cell'>".$this->newsletter_group[$i]['nome']."<input type='hidden' class='mailing_group_selected_id' value='".$this->newsletter_group[$i]['id']."'><input type='hidden' class='mailing_group_selected_name' value='".$this->newsletter_group[$i]['nome']."'></td></tr>";
				  
				  /*echo '<tr class="mailing_group_row" style="background-color:'.$backcolor.'; '.$stylerichieste.'" onclick="Deselect_mailing_group(this,\''.$i.'\')">
						  <td class="mailing_group_name">';
				  echo $this->newsletter_group[$i]['nome'];
				  echo '<input type="hidden" value="'.$this->newsletter_group[$i]['id'].'" id="mailing_group_id_'.$i.'">';
				  echo '<input type="hidden" value="'.$this->newsletter_group[$i]['nome'].'" id="mailing_group_name_'.$i.'">';
				  echo '</td>
				  </tr>';*/
				  $j++;
				}
			}
			$selected_index=substr($selected_index,strpos($selected_index,",")+1);
			$id=substr($selected_index,0,strpos($selected_index,","));
		}
		
	}
	public function Refresh_riepilogo_news(){
		for($i=0;$i<count($this->news_rows);$i++){
				$descrizione = preg_replace('#<br\s*/?>#i', "\n", $this->news_rows[$i]["descrizione"]);
				if(strlen($descrizione)>45){
					$descrizione = substr($descrizione, 0, 45)."...";
				}
                if(($i%2)==0){
                    $backcolor="#8b8b8b";	
                }else{
                    $backcolor="#838383";
                }
                
                $datacompleta = date('d/m/Y H:i',strtotime($this->news_rows[$i]["data"]));
                $date = $this->getmessagedata($this->news_rows[$i]["data"]);
                
                 echo '<tr class="news_row"  style="background-color:'.$backcolor.';" id="news_row_'.$i.'" >
                    <td class="news_checkbox" scope="row" onclick="Javascript:select_news_row(this,'.$i.')">
                        <input type="checkbox" value="'.$i.'" id="check_news_'.$i.'" class="col-news-select" onclick="Javascript:select_news_row(this,'.$i.')"></input>			
                    </td>
                    <td class="news_data" onclick="Show_news(\''.$i.'\')" style="cursor:pointer;">';
                       echo $this->news_rows[$i]["sottotitolo"];
                    echo '
                    </td>
                    <td class="news_titolo" onclick="Show_news(\''.$i.'\')" style="cursor:pointer;">';
                       echo '<span>'.$this->news_rows[$i]["titolo"].'</span>';
                    echo '
                    </td>
                    
                    <td class="news_descrizione" onclick="Show_news(\''.$i.'\')" style="cursor:pointer;">
                        <span>'.$descrizione.'</span>
                    </td>
					<td class="news_action" onclick="Show_news(\''.$i.'\')" style="cursor:pointer;">
                       <img src="../../image/icone/pen.png" style="width:15px; height:15px;" alt="modifica news" title="modifica news.">
				   </td>
				   <td class="news_action" onclick="Delete_news(\''.$i.'\')" style="cursor:pointer;">
					  <img src="../../image/icone/edit-delete.png" style="width:15px; height:15px;" alt="elimina news" title="elimina news.">
				   </td>
				   <td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_rows_up(\''.$i.'\',\''.$this->news_rows[$i]["row_num"].'\')"><img src="../../image/icone/icona_arrow_up.png" alt="Sposta contatto su."  title="sposta su." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>  
                    </td>
					
					<td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_rows_down(\''.$i.'\',\''.$this->news_rows[$i]["row_num"].'\')"><img src="../../image/icone/icona_arrow_down.png" alt="Sposta contatto giù." title="sposta giù." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>
				   </td>
                  </tr>';
        }
		if(count($this->news_rows)==0){
            echo '<tr><td colspan="4">Non sono presenti news.</td></tr>';
        }
	}
	public function Refresh_riepilogo_news_now(){
		if($this->evidenza["title"]!=""){
			$descrizione = preg_replace('#<br\s*/?>#i', "\n", $this->evidenza["description"]);
			if(strlen($descrizione)>45){
				$descrizione = substr($descrizione, 0, 45)."...";
			}
			$backcolor="#8b8b8b";
			$datacompleta = date('d/m/Y H:i',strtotime($this->evidenza[$i]["data"]));
			$date = $this->getmessagedata($this->evidenza["data"]);
	   
			echo '<tr class="news_row"  style="background-color:'.$backcolor.';" id="news_row_now">
				<td class="news_checkbox" scope="row" onclick="Javascript:select_news_now_row()">
				  <input type="checkbox" id="check_news_now" class="col-news-select-now
				  " onclick="Javascript:select_news_now_row()"></input>			
			   </td>
				<td class="news_data" onclick="Show_news_now()" style="cursor:pointer;">';
					echo '<span  title="'.$datacompleta.'">'.$this->evidenza["data"].'</span>';
			echo '
				</td>
				<td class="news_titolo" onclick="Show_news_now()" style="cursor:pointer;">';
				   echo '<span>'.$this->evidenza["title"].'</span>';
			echo '
				</td>
			
				<td class="news_descrizione" onclick="Show_news_now()" style="cursor:pointer;">
					<span>'.$descrizione.'</span>
				 </td>
				 <td class="news_action" onclick="Show_news_now()" style="cursor:pointer;">
					<img src="../../image/icone/pen.png" style="width:15px; height:15px;" alt="modifica news" title="modifica news.">
				 </td>
				 <td class="news_action" onclick="Delete_news_now()" style="cursor:pointer;">
					<img src="../../image/icone/edit-delete.png" style="width:15px; height:15px;" alt="elimina news" title="elimina news.">
				 </td>
			</tr>';
		}else{
			echo '<tr><td colspan="4">Non è stata ancora pubblicata una news.</td></tr>';
		}
	}
	
	/*  METHOD: Show_personal_curriculum()
		
		IN: -
		OUT: {on video print personal area section 'curriculum'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_curriculum(){
		echo "<div id='tabdiv_btn_card_personal_curriculum' style='display:none;' >";
			echo "<div class='personal_tab_center'>";
				echo "<div class='personal_tab_center_content'>";
					echo "<div align='center'>";
					if($this->opt_curr == 1)
							echo "<br/><span><input type='checkbox' id='change_opt_curr' checked='checked' onchange='Javascript:curr_save()'>";
						else
							echo "<br/><span><input type='checkbox' id='change_opt_curr' onchange='Javascript:curr_save()'>";
						echo "</input><span class='text14px'>Rendi pubblico il tuo Curriculum Europeo<br/> (potrà essere visualizzato da chiunque visiti la tua card)</span><br/><br/>";
						echo "<div id='opt_curr_saved' style='display:none; padding-bottom:6px;'><img src='../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' style='vertical-align:middle;' /> Informazioni Salvate.</div>";
					echo "<div class='personal_button' id='log_in_button' onclick='Javascript:personal_tab_change(\"interfaccia\")'>
						<span class='text14px'>INDIETRO</a>
					  </div>";
					echo "<div class='personal_button' style='width:300px' id='log_in_button' onclick='Javascript:personal_tab_change(\"curriculum_new\")'>
						<span class='text14px'>CREA O MODIFICA IL TUO CURRICULUM</a>
					  </div>";
					
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}
	public function Show_personal_curriculum_new(){
		echo "<div id='tabdiv_btn_card_personal_curriculum_new' style='display:none;'>
		  <div class='personal_tab_center'>
				<div class='personal_tab_center_content' >";
				echo "<iframe src='../card/php/crea_curriculum.php?u=".$this->username."' width='837' height='400' frameborder='0' style='overflow-y:auto;'></iframe>";
			echo "</div>
		  </div>
		 
	  </div>";
		
	}
	/*  METHOD: Show_all_curriculum_europeo_scritte_step1()
		
		IN: -
		OUT: {on video print text for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_scritte_step1(){
		echo "<div style='position:absolute; top:112px; width:200px;'>(1) Nome e Cognome:</div>";
		echo "<div style='position:absolute; top:112px; left:370px; width:200px; '>(2) Sesso:</div>";
		echo "<div style='position:absolute; top:162px; width:200px;'>(3) Cittadinanza:</div>";
		echo "<div style='position:absolute; top:212px; width:200px;'>(4) Data e luogo di nascita:</div>";
		echo "<div style='position:absolute; top:262px; width:200px;'>(5) Telefono:</div>";
		echo "<div style='position:absolute; top:262px; left:330px; width:200px;'>(6) e-mail:</div>";
		echo "<div style='position:absolute; top:312px; width:200px;'>(7) Indirizzo:</div>";
		
	}
	
	/*  METHOD: Show_all_curriculum_europeo_input_step1()
		
		IN: -
		OUT: {on video print input for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_input_step1(){
		$indirizzo = substr($this->curriculum_europeo_data['sottotitolo'],(strpos($this->curriculum_europeo_data['sottotitolo'],"<br/>")+5));
		$indirizzo = substr($indirizzo,0,strpos($indirizzo,"<br/>"));
		
		
		$telefono = substr($this->curriculum_europeo_data['sottotitolo'],(strpos($this->curriculum_europeo_data['sottotitolo'],"Tel: ")+5));
		$telefono = substr($telefono,0,strpos($telefono,"<br/>"));
		
		$email = substr($this->curriculum_europeo_data['sottotitolo'],(strpos($this->curriculum_europeo_data['sottotitolo'],"e-mail: ")+8));
		
		$nomecognome = str_replace("\\","",$this->curriculum_europeo_data['nomecognome']);
		echo "<div style='position:absolute; top:103px; left:142px; width:200px;' ><input type='text' class='textinput' id='ce_in_nome' value=\"".$nomecognome."\"></input></div>";
		$sesso = str_replace("\\","",$this->curriculum_europeo_data['sesso']);
		echo "<div style='position:absolute; top:103px; left:440px; width:200px;' ><input type='text' class='textinput' id='ce_in_sesso' value='".$sesso."'></input></div>";
		$cittadinanza = str_replace("\\","",$this->curriculum_europeo_data['cittadinanza']);
		echo "<div style='position:absolute; top:153px; left:112px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_cittadinanza' value=\"".$cittadinanza."\"></input></div>";
		$dataluogo = str_replace("\\","",$this->curriculum_europeo_data['dataluogo']);
		echo "<div style='position:absolute; top:203px; left:175px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_dataluogo' value=\"".$dataluogo."\"></input></div>";
		$telefono = str_replace("\\","",$telefono); 
		echo "<div style='position:absolute; top:253px; left:92px; width:200px;' ><input type='text' class='textinput' id='ce_in_telefono' value=\"".$telefono."\"></input></div>";
		$email =str_replace("\\","",$email); 
		echo "<div style='position:absolute; top:253px; left:400px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_email' value=\"".$email."\"></input></div>";
		$indirizzo =str_replace("\\","",$indirizzo); 
		echo "<div style='position:absolute; top:303px; left:88px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_indirizzo' value=\"".$indirizzo."\"></input></div>";
	}
	
	public function Show_crea_scritte_step0(){
		echo "<div style='position:absolute; top:44px; width:750px;'>Qualcosa su di me (Descrivi quello che fai, la tua storia, quello per cui ti vuoi promuovere utilizzando la tua card):</div>";
		
	}
	public function Show_crea_input_step0(){
		$sudime = str_replace("<br/>","\r\n",$this->sudime);
		echo "<div style='position:absolute; top:85px;' ><textarea class='textarea' rows='10' cols='85' id='ce_in_sudime' >".html_entity_decode($sudime)."</textarea></div>";
	}
	/*  METHOD: Show_all_curriculum_europeo_scritte_step1()
		
		IN: -
		OUT: {on video print text for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_crea_scritte_step1(){
		echo "<div style='position:absolute; top:51px; width:200px;'>(1)Nome e Cognome:</div>";
		echo "<div style='position:absolute; top:51px; left:370px; width:200px; '>(2) Sesso:</div>";
		echo "<div style='position:absolute; top:87px; width:200px;'>(3)Cittadinanza:</div>";
		echo "<div style='position:absolute; top:123px; width:200px;'>(4)Data e luogo di nascita:</div>";
		echo "<div style='position:absolute; top:159px; width:200px;'>(5)Telefono:</div>";
		echo "<div style='position:absolute; top:159px; left:330px; width:200px;'>(6) e-mail:</div>";
		echo "<div style='position:absolute; top:195px; width:200px;'>(7)Indirizzo:</div>";
	}
	
	/*  METHOD: Show_all_curriculum_europeo_input_step1()
		
		IN: -
		OUT: {on video print input for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_crea_input_step1(){
		$indirizzo = substr($this->curriculum_europeo_data['sottotitolo'],(strpos($this->curriculum_europeo_data['sottotitolo'],"<br/>")+5));
		$indirizzo = substr($indirizzo,0,strpos($indirizzo,"<br/>"));
		
		
		$telefono = substr($this->curriculum_europeo_data['sottotitolo'],(strpos($this->curriculum_europeo_data['sottotitolo'],"Tel: ")+5));
		$telefono = substr($telefono,0,strpos($telefono,"<br/>"));
		
		$email = substr($this->curriculum_europeo_data['sottotitolo'],(strpos($this->curriculum_europeo_data['sottotitolo'],"e-mail: ")+8));
		
		$nomecognome = str_replace("\\","",$this->curriculum_europeo_data['nomecognome']);
		echo "<div style='position:absolute; top:45px; left:155px; width:200px;' ><input type='text' class='textinput' id='ce_in_nome' value=\"".$nomecognome."\"></input></div>";
		$sesso = str_replace("\\","",$this->curriculum_europeo_data['sesso']);
		echo "<div style='position:absolute; top:45px; left:445px; width:200px;' ><input type='text' class='textinput' id='ce_in_sesso' value='".$sesso."'></input></div>";
		$cittadinanza = str_replace("\\","",$this->curriculum_europeo_data['cittadinanza']);
		echo "<div style='position:absolute; top:81px; left:115px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_cittadinanza' value=\"".$cittadinanza."\"></input></div>";
		$dataluogo = str_replace("\\","",$this->curriculum_europeo_data['dataluogo']);
		echo "<div style='position:absolute; top:117px; left:188px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_dataluogo' value=\"".$dataluogo."\"></input></div>";
		$telefono = str_replace("\\","",$telefono); 
		echo "<div style='position:absolute; top:153px; left:92px; width:200px;' ><input type='text' class='textinput' id='ce_in_telefono' value=\"".$telefono."\"></input></div>";
		$email =str_replace("\\","",$email); 
		echo "<div style='position:absolute; top:153px; left:407px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_email' value=\"".$email."\"></input></div>";
		$indirizzo =str_replace("\\","",$indirizzo); 
		echo "<div style='position:absolute; top:189px; left:88px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_indirizzo' value=\"".$indirizzo."\"></input></div>";
	}
	
	/*  METHOD: Show_all_curriculum_europeo_scritte_step2()
		
		IN: -
		OUT: {on video print text for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_scritte_step2(){
		echo "<div style='position:absolute; top:38px; width:350px;'>(8) Istruzione e Formazione:</div>";
		echo "<div style='position:absolute; top:167px;  width:350px; '>(9) Esperienza Lavorativa:</div>";
	}
	/*  METHOD: Show_all_curriculum_europeo_input_step2()
		
		IN: -
		OUT: {on video print input for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_input_step2(){
		$istruzformaz = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['istruzformaz']); 
		$istruzformaz = str_replace("\\","",$istruzformaz); 
		echo "<input type='hidden' id='ce_in_istr_hidden' value='".$istruzformaz."'>";
		echo "<div style='position:absolute; top:65px; ' ><textarea class='textarea' rows='5' cols='95' id='ce_in_istr' >".$istruzformaz."</textarea></div>";
		
		$esplavorativa = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['esplavorativa']);
		$esplavorativa = str_replace("\\","",$esplavorativa); 
		echo "<input type='hidden' id='ce_in_esp_hidden' value='".$esplavorativa."'>";
		echo "<div style='position:absolute; top:193px; ' ><textarea class='textarea' rows='5' cols='95' id='ce_in_esp'>".$esplavorativa."</textarea></div>";
	}
	
	/*  METHOD: Show_all_curriculum_europeo_scritte_step3()
		
		IN: -
		OUT: {on video print text for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_scritte_step3(){
		echo "<div style='position:absolute; top:44px; left:470px; width:200px;'>(10) Madrelingua:</div>";
		echo "<div style='position:absolute; top:44px; width:200px;'>(11) Lingue straniere:</div>";
		echo "<div style='position:absolute; top:75px; width:300px;'>(12) Capacità e competenze personali:</div>";
		echo "<div style='position:absolute; top:75px; left:435px; width:300px;'>(13) Capacità e competenze informatiche:</div>";
		echo "<div style='position:absolute; top:185px; width:350px;'>(14) Capacità e competenze relazionali/sociali:</div>";
		echo "<div style='position:absolute; top:185px; left:435px; width:300px;'>(15) Competenze Organizzative:</div>";
	}
	/*  METHOD: Show_all_curriculum_europeo_input_step3()
		
		IN: -
		OUT: {on video print input for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_input_step3(){
		$linguestraniere = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['linguestraniere']);
		echo "<div style='position:absolute; top:38px; left:153px; width:200px;' ><input type='text' class='textinput_long' id='ce_in_linguestraniere' value=\"".$linguestraniere."\"></input></div>";
		$madrelingua = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['madrelingua']);
		echo "<div style='position:absolute; top:38px; left:600px; width:200px;' ><input type='text' class='textinput' id='ce_in_madrelingua' value=\"".$madrelingua."\"></input></div>";
		
		$capacitacompet = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['capacitacompet']); 
		$capacitacompet = str_replace("\\","",$capacitacompet); 
		echo "<div style='position:absolute; top:95px;' ><textarea class='textarea' rows='4' cols='45' id='ce_in_capacitacompet' >".$capacitacompet."</textarea></div>";
		
		$compinformatiche = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['compinformatiche']); 
		$compinformatiche = str_replace("\\","",$compinformatiche); 
		echo "<div style='position:absolute; top:95px; left:435px;' ><textarea class='textarea' rows='4' cols='45' id='ce_in_compinformatiche' >".$compinformatiche."</textarea></div>";
		
		$comprelsoc = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['comprelsoc']);
		$comprelsoc = str_replace("\\","",$comprelsoc); 
		echo "<div style='position:absolute; top:205px;' ><textarea class='textarea' rows='4' cols='45' id='ce_in_comprelsoc' >".$comprelsoc."</textarea></div>";
		
		$comporganiz = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['comporganiz']); 
		$comporganiz = str_replace("\\","",$comporganiz); 
		echo "<div style='position:absolute; top:205px; left:435px;' ><textarea class='textarea' rows='4' cols='45' id='ce_in_comporganiz' >".$comporganiz."</textarea></div>";
		
	}
	
	/*  METHOD: Show_all_curriculum_europeo_scritte_step4()
		
		IN: -
		OUT: {on video print text for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_scritte_step4(){
		echo "<div style='position:absolute;  top:75px; width:300px;'>(16) Competenze artistiche:</div>";
		echo "<div style='position:absolute;  top:75px; left:435px; width:300px;'>(17) Competenze tecniche:</div>";
		echo "<div style='position:absolute;  top:185px; width:350px;'>(18) Competenze relative al lavoro per cui si candida:</div>";
		echo "<div style='position:absolute; top:185px; left:435px; width:350px;'>(19) Altre competenze ed interessi personali:</div>";
		
	}
	
	/*  METHOD: Show_all_curriculum_europeo_input_step4()
		
		IN: -
		OUT: {on video print input for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_input_step4(){
		$compartistiche = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['compartistiche']); 
		$compartistiche = str_replace("\\","",$compartistiche); 
		echo "<div style='position:absolute; top:95px;' ><textarea rows='4' cols='45' id='ce_in_compartistiche' class='textarea'>".$compartistiche."</textarea></div>";
		
		$comptecniche = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['comptecniche']); 
		$comptecniche = str_replace("\\","",$comptecniche); 
		echo "<div style='position:absolute; top:95px; left:435px;' ><textarea rows='4' cols='45' id='ce_in_comptecniche' class='textarea'>".$comptecniche."</textarea></div>";
		
		$comprelativeallav = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['comprelativeallav']); 
		$comprelativeallav = str_replace("\\","",$comprelativeallav); 
		echo "<div style='position:absolute; top:205px;' ><textarea rows='4' cols='45' id='ce_in_comprelativeallav' class='textarea'>".$comprelativeallav."</textarea></div>";
		
		$altrecompedinteressi = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['altrecompedinteressi']); 
		$altrecompedinteressi = str_replace("\\","",$altrecompedinteressi); 
		echo "<div style='position:absolute; top:205px; left:435px;' ><textarea rows='4' cols='45' id='ce_in_altrecompedinteressi' class='textarea'>".$altrecompedinteressi."</textarea></div>";
		
	}
	
	/*  METHOD: Show_all_curriculum_europeo_scritte_step5()
		
		IN: -
		OUT: {on video print text for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_scritte_step5(){
		echo "<div style='position:absolute; top:51px; width:200px;'>(20) Patente:</div>";
		echo "<div style='position:absolute; top:95px;  width:200px; '>(21) Ulteriori informazioni:</div>";
	}
	
	/*  METHOD: Show_all_curriculum_europeo_input_step5()
		
		IN: -
		OUT: {on video print input for editing european curriculum(page card/php/curriculum_europeo_edit.php)}
		DESCRIPTION: video printing function.
	*/
	public function Show_all_curriculum_europeo_input_step5(){
		$patente = str_replace("\\","",$this->curriculum_europeo_data['patente']); 
		echo "<div style='position:absolute; top:44px; left:100px; width:200px;' ><input type='text' class='textinput' id='ce_in_patente' value=\"".$patente."\"></input></div>";
		
		$ulteriori = str_replace("<br/>","\r\n",$this->curriculum_europeo_data['ulteriori']);
		$ulteriori = str_replace("\\","",$ulteriori); 
		echo "<input type='hidden' id='ce_in_ulteriori_hidden' value='".$ulteriori."'>";
		echo "<div style='position:absolute; top:133px; width:200px;' ><textarea class='textarea' rows='8' cols='95' id='ce_in_ulteriori'>".$ulteriori."</textarea></div>";
	}
	
	/*  METHOD: Show_personal_contact()
		
		IN: -
		OUT: {on video print personal area section 'contatti'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_contact(){
		/*echo "<div id='tabdiv_btn_card_personal_contatti' style='display:none;' >"; 
			echo "<div class='personal_tab_center'>";
				echo "<div class='personal_tab_center_content'>";
					echo "<br/>";
					echo "<span class='text14px'>Inserisci i tuoi contatti. Verranno visualizzati nella sezione \"CONTATTI\" della tua card.</span>";
					$this->Show_mod_contact();
					echo "<div class='personal_button' style='width:100px; height:25px;' onclick='personal_tab_change(\"interfaccia\")'>
						<span class='text14px' style='position:relative; top:-2px;'>INDIETRO</span>
					</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";*/
		
		echo "<div id='tabdiv_btn_card_personal_contatti' style='display:none;' >"; 
			echo "<div class='personal_social'>";
					echo '<div id="social_mod_div" class="social_mod_div">';		
					$this->Show_mod_contact();
					echo '</div>';
				echo "</div>";
		echo "</div>";	
	}
	
	/*  METHOD:  Show_mod_contact()
		
		IN: -
		OUT: {on video print contact_rows}
		DESCRIPTION: video printing function.
	*/
	public function Show_mod_contact(){
		echo '<div class="social_add_div">';
			echo '<p class="text14px">Inserisci i tuoi contatti. Verranno visualizzati nella sezione "CONTATTI" della tua card.</p>';
			echo '<form id="contact_form" onsubmit="return false;">';
			echo 'Contatto: <select name="contact_link_type" id="contact_link_type" class="select_social_link_type" onchange="contact_link_type_change((this.options[this.selectedIndex].value))">';
				echo '<option value="tel" selected="selected">Telefono</option>';
				echo '<option value="cell">Cellulare</option>';
				echo '<option value="fax">Fax</option>';
				echo '<option value="mail">E-mail</option>';
				echo '<option value="indirizzo">Indirizzo</option>';
			echo '</select>';
			
			echo '<input type="text" class="input_social" id="in_contact_value" name="in_contact_value" value="Inserisci il numero di telefono." onclick="this.value=\'\'" onkeydown="PressioneInvioContact(event);" required/>';
			echo '<br/>';
			echo "<div class='personal_button social_button'  onclick='Add_contact_element()' style='width:120px;'>
					<img src='../../image/icone/icona_add.png' width='12' height='12' />&nbsp;&nbsp;<span class='text14px' alt='Aggiungi elemento'>Aggiungi</span>
				</div>
				<div id='contact_ajax_panel' class='social_ajax_panel'></div>";
			echo '</form>';
			
		echo '</div>';
		echo '<div class="social_show_div" id="contact_show_div">';
			$this->Contact_show_div();
		echo '</div>';
		echo '<div id="personal_contact_save_rename_container" class="personal_social_save_rename_container"></div>';
		echo "<div class='personal_button social_button' onclick='personal_tab_change(\"interfaccia\")' style='width:220px; position:absolute; top:415px; left:0px;'>
					<img src='../../image/icone/arrow-left.png' width='12' height='12' />&nbsp;&nbsp;<span class='text14px' alt='Torna a modifica card.'>TORNA A MODIFICA CARD</span>
		</div>";
	}
	
	/*  METHOD: Show_mod_contact_rows()
		
		IN: -
		OUT: {on video print a contact row}
		DESCRIPTION: video printing function.
	*/
	public function Contact_show_div(){
		echo '<table>
                  <thead>
                    <tr class="sorterbar">
                      <th class="value_contact_header" scope="col">
            Contatto
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table_mod_contact_container">';
		  	for($i=0;$i<count($this->contact_rows);$i++){
			if(($this->contact_rows[$i]["type"]!="fb")&&($this->contact_rows[$i]["type"]!="tw")&&($this->contact_rows[$i]["type"]!="you")&&($this->contact_rows[$i]["type"]!="sk")){
                if(($i%2)==0){
                    $backcolor="#8b8b8b";	
                }else{
                    $backcolor="#838383";
                }
                
				 echo '<tr class="news_row" style="background-color:'.$backcolor.';" id="news_row_'.$i.'">
                    <td class="value_contact_header" scope="row">';
                        echo "<span id='contact_value_container_".$i."' style='cursor:pointer;' onclick='Javascript:Load_rename_contact_row(\"".$this->contact_rows[$i]['row_value']."\",\"".$this->contact_rows[$i]["type"]."\",\"".$i."\")'>";
					$this->Show_contact_type($this->contact_rows[$i]['type']);
					echo " ".$this->contact_rows[$i]['row_value'];
					echo "</span>";
					echo '</td>
                    <td class="contact_modifica" id="contact_modifica_'.$i.'" style="cursor:pointer;">
                       <img src="../image/icone/pen.png" id="contact_modifica_img_'.$i.'" alt="Modifica contatto." title="modifica." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;" onclick="Javascript:Load_rename_contact_row(\''.$this->contact_rows[$i]["row_value"].'\',\''.$this->contact_rows[$i]["type"].'\',\''.$i.'\')"/> 
                    </td>
                    <td class="contact_elimina" style="cursor:pointer;">
                       <img src="../image/icone/edit-delete.png" alt="Elimina contatto." title="elimina." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;" onclick="Javascript:Delete_contact_element(\''.$i.'\')"/> ';
                    echo '
                    </td>
                    
                    <td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_contact_up(\''.$i.'\',\''.$this->contact_rows[$i]['row_num'].'\')"><img src="../image/icone/icona_arrow_up.png" alt="Sposta contatto su."  title="sposta su." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>  
                    </td>
					<td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_contact_down(\''.$i.'\',\''.$this->contact_rows[$i]['row_num'].'\')"><img src="../image/icone/icona_arrow_down.png" alt="Sposta contatto giù." title="sposta giù." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>
				   </td>
				   
                  </tr>';
				}
				if(count($this->contact_rows)==0){
					echo '<tr><td colspan="4">Non sono presenti contatti.</td></tr>';
				}
			}
                    echo '</tbody>
               </table>
			   
		   <input type="hidden" id="contact_element_num" value="'.$i.'">';
	}
	
	public function Show_contact_type($type){
		switch($type){
			case 'tel':
				echo "<img src='../image/icone/icona_tel.png' alt='Telefono.' class='icona_contact'/>";
			break;
			case 'cell':
				echo "<img src='../image/icone/icona_cell.png' alt='Cellulare.' class='icona_contact'/>";
			break;	
			case 'fax':
				echo "<img src='../image/icone/icona_fax.png' alt='Fax.' class='icona_contact'/>";
			break;
			case 'mail':
				echo "<img src='../image/icone/icona_email.png' alt='E-mail.'  class='icona_contact'/>";
			break;
			case 'web-site':
				echo "<img src='../image/icone/icona_web.png' alt='Web-site.'  class='icona_contact'/>";
			break;
			case 'web-social':
				echo "<img src='../image/icone/icona_web.png' alt='Web-site.'  class='icona_contact'/>";
			break;
			case 'tw':
				echo "<img src='../image/icone/twitter.png' alt='E-mail.'  class='icona_contact'/>";
			break;
			case 'you':
				echo "<img src='../image/icone/youtube.png' alt='Youtube.'  class='icona_contact'/>";
			break;
			case 'fb':
				echo "<img src='../image/icone/FaceBook.png' alt='Facebook.'  class='icona_contact'/>";
			break;
			case 'sk':
				echo "<img src='../image/icone/skype.png' alt='Skype.'  class='icona_contact'/>";
			break;
			case 'indirizzo':
				echo "<img src='../image/icone/office-address.png' alt='Indirizzo.'  class='icona_contact'/>";
			break;
		}
	}
	
	/*  METHOD: Show_personal_social()
		
		IN: -
		OUT: {on video print personal area section 'social'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_social(){
		echo "<div id='tabdiv_btn_card_personal_social' style='display:none;' >"; 
			echo "<div class='personal_social'>";
					echo '<div id="social_mod_div" class="social_mod_div">';		
					$this->Show_mod_links();
					echo '</div>';
				echo "</div>";
		echo "</div>";	
	}
	
	/*  METHOD: Show_mod_links()
		
		IN: -
		OUT: {on video print social network's links}
		DESCRIPTION: video printing function.
	*/
	public function Show_mod_links(){
		echo '<div class="social_add_div">';
			echo '<p class="text14px">Inserisci un nuovo elemento (Sito Internet, Video Youtube, Account Social Network)</p>';
			echo '<form id="social_form">';
			echo 'Titolo: <input type="text" class="input_social" id="in_social_title" name="in_social_title" value="Inserisci il nome dell\'elemento." onclick="this.value=\'\'" onkeydown="PressioneInvioSocial(event);" required/>';
			echo '<br/>';
			echo 'Indirizzo: <select name="social_link_type" id="social_link_type" class="select_social_link_type" onchange="social_link_type_change((this.options[this.selectedIndex].value))">';
				echo '<option value="web" selected="selected">Sito Internet</option>';
				echo '<option value="vidyt">Video Youtube</option>';
				echo '<option value="accfb">Account Facebook</option>';
				echo '<option value="accsk">Account Skype</option>';
				echo '<option value="acctw">Account Twitter</option>';
				echo '<option value="accyt">Account Youtube</option>';	
			echo '</select>';
			echo '<input type="text" class="input_social" id="in_social_value" name="in_social_value" value="Inserisci l\'indirizzo del sito internet." onclick="this.value=\'\'" onkeydown="PressioneInvioSocial(event);" required/>';
			echo '<br/>';
			echo "<div class='personal_button social_button'  onclick='Add_social_element()' style='width:120px;'>
					<img src='../../image/icone/icona_add.png' width='12' height='12' />&nbsp;&nbsp;<span class='text14px' alt='Aggiungi elemento'>Aggiungi</span>
				</div>
				<div id='social_ajax_panel' class='social_ajax_panel'></div>";
			echo '</form>';
			
		echo '</div>';
		echo '<div class="social_show_div" id="social_show_div">';
			$this->Social_show_div();
		echo '</div>';
		echo '<div id="personal_social_save_rename_container" class="personal_social_save_rename_container"></div>';
		echo "<div class='personal_button social_button' onclick='personal_tab_change(\"interfaccia\")' style='width:220px; position:absolute; top:415px; left:0px;'>
					<img src='../../image/icone/arrow-left.png' width='12' height='12' />&nbsp;&nbsp;<span class='text14px' alt='Aggiungi elemento'>TORNA A MODIFICA CARD</span>
			  </div>";
	}
	
	public function Social_show_div(){
		echo '<table>
                  <thead>
                    <tr class="sorterbar">
					  <th class="action_contact_header" scope="col">
                      </th>
                      <th class="value_contact_header" scope="col">
            Titolo
                      </th>
					  <th class="value_contact_header" scope="col">
            Indirizzo
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                      <th class="action_contact_header" scope="col">
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table_mod_contact_container">';
		  	for($i=0;$i<count($this->social_rows);$i++){
                if(($i%2)==0){
                    $backcolor="#8b8b8b";	
                }else{
                    $backcolor="#838383";
                }
                
				 echo '<tr class="news_row" style="background-color:'.$backcolor.';" id="news_row_'.$i.'">'; 
				 
				 echo '<td class="news_action" style="cursor:pointer;">
                        <img src="'.$this->social_rows[$i]['favicon'].'" width="20" height="20"/>  
                    </td>';
					
				
				 echo '<td class="value_contact_header" scope="row">';
                    echo "<span id='social_title_container_".$i."' style='cursor:pointer;' onclick='Javascript:Load_rename_social_row(\"".$this->social_rows[$i]['title']."\",\"".$this->social_rows[$i]["value"]."\",\"".$this->social_rows[$i]["type"]."\",\"".$i."\")'>";
					echo $this->social_rows[$i]['title'];
					echo "</span>";
				 echo '</td>';
				 
				 echo '<td class="value_contact_header" scope="row">';
                    echo "<span id='social_value_container_".$i."' style='cursor:pointer;' onclick='Javascript:window.open(\"".$this->social_rows[$i]['value']."\")'>";
					echo $this->social_rows[$i]['value'];
					echo "</span>";
				 echo '</td>';
					
					
				 echo '
                    <td class="contact_modifica" id="social_modifica_'.$i.'" style="cursor:pointer;">
                       <img src="../image/icone/pen.png" id="social_modifica_img_'.$i.'" alt="Modifica contatto." title="modifica." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;" onclick="Javascript:Load_rename_social_row(\''.$this->social_rows[$i]['title'].'\',\''.$this->social_rows[$i]["value"].'\',\''.$this->social_rows[$i]["type"].'\',\''.$i.'\')"/> 
                    </td>
                    <td class="contact_elimina" style="cursor:pointer;">
                       <img src="../image/icone/edit-delete.png" alt="Elimina elemento." title="Elimina." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;" onclick="Javascript:Delete_social_element(\''.$i.'\')"/> ';
                    echo '
                    </td>
                    
                    <td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_social_up(\''.$i.'\',\''.$this->social_rows[$i]['row_num'].'\')"><img src="../image/icone/icona_arrow_up.png" alt="Sposta elemento su."  title="sposta su." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>  
                    </td>
					<td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_social_down(\''.$i.'\',\''.$this->social_rows[$i]['row_num'].'\')"><img src="../image/icone/icona_arrow_down.png" alt="Sposta elemento giù." title="sposta giù." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>
				   </td>
				   
                  </tr>';
				}
				if(count($this->social_rows)==0){
					echo '<tr><td colspan="4">Non sono presenti elementi.</td></tr>';
				}
				echo '</tbody>
           </table>
		   <input type="hidden" id="social_element_num" value="'.$i.'">
		   ';
	}
	
	
	public function Personal_upload_main_photo_mini(){
		$this->Show_upload_main_photo();
		echo '<img id="uploaderbutton" style="cursor:pointer" alt="Upload" src="../../image/btn/btn_change_photo_mini.png" style="cursor:pointer; vertical-align:middle;" />';
	}
	
	/*  METHOD: Show_upload_photo()
	IN: .
	OUT: . 
	DESCRIPTION: show the upload button for the attachments.
	*/
	public function Show_upload_main_photo(){
		$uploader=new PhpUploader();    
		// Set a unique name to Uploader  
		$uploader->Name="upload_photo";    
		//Create a new file upload handler  
		$upload_url = "../php/main_upload_handler.php?u=".$this->username;
		
		$uploader->UploadUrl=$upload_url;
		//Step 4: Enable Multiple Files Upload.    
		$uploader->MultipleFilesUpload=false; 
		//Specify the maximum allowed size of the file using MaxSizeKB property  
		$uploader->MaxSizeKB=10240;
		//Allowed file extensions
		$uploader->AllowedFileExtensions="jpeg,jpg,gif,png";
		//File Too Large Msg
		$uploader->FileTooLargeMsg="{0} non può essere caricato!\n\nIl file ({1}) è troppo grande. La grandezza massima consentita è: {2}.";
		$uploader->FileTypeNotSupportMsg="L'estensione del file non è consentita! Estensioni consentite: '{0}'";  
		$uploader->CancelUploadMsg="Annulla Caricamento";
		$uploader->CancelButtonID="uploadercancelbutton";
		
		//Specify the ID of the control that will be used as progress bar panel.        
		$uploader->ProgressCtrlID="uploaderprogresspanel";        
		//Specify the ID of the control that will be used as progress text label.        
		$uploader->ProgressTextID="uploaderprogresstext";
		
		$uploader->InputboxCSSText="font-size: 12px;";
		
		$uploader->InsertButtonID="uploaderbutton";
		$uploader->ProgressTextTemplate="%F%";
		//$uploader->TempDirectory="../tmp_allegati";
		$uploader->TempDirectory="../../tmp/tmp_photo/";
		$uploader->UploadingMsg="Caricamento in corso..";
		
		return $uploader->Render();
	}
	
	
	
	public function fix_upload(){
		$uploader=new PhpUploader();    
		// Set a unique name to Uploader  
		$uploader->Name="fix_upload";    
		//Create a new file upload handler    
		
		return $uploader->Render();	
	}
	
	/*  METHOD: Personal_upload_slide_photo()
		
		IN: $index.
		OUT: {on video print personal upload slide photo $index(in page card/php/slide.php)}
		DESCRIPTION: video printing function.
	*/
	public function Personal_upload_slide_photo($index,$new=NULL){
		$this->Show_upload_photo($index,$new);
		if($new!=NULL){
			echo '<img id="uploaderbuttonslide" style="position:absolute; top:5px; left:8px; cursor:pointer" alt="Upload" src="../../image/btn/btn_aggiungi.png" style="cursor:pointer; vertical-align:middle;" />';
		}else{
			echo '<img id="uploaderbuttonslidenew'.$index.'" style="position:relative; top:-38px; left:42px; cursor:pointer;" alt="Upload" src="../../image/btn/btn_change_photo_mini.png" style="cursor:pointer; vertical-align:middle;" />';	
		}
	}
	
	/*  METHOD: Show_personal_slide()
		
		IN: -
		OUT: {on video print personal slide}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_slide(){
		echo "<div id='tabdiv_btn_card_personal_slide' style='display:none;'>
		  <div class='personal_tab_center'>
				<div class='personal_tab_center_content' style='width:943px; padding:0px;'>";
				/*echo "<iframe src='../card/php/photo.php?u=".$this->username."' width='934' height='425' frameborder='0' style='overflow-y:auto;'></iframe>";*/
			echo "</div>
		  </div>
		 
	  </div>";
	}
	
	/*  METHOD: Show_personal_filebox()
		
		IN: -
		OUT: {on video print personal slide}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_filebox(){
		echo "<div id='tabdiv_btn_card_personal_filebox' style='display:none;'>
		  <div class='personal_tab_center'>
				<div class='personal_tab_center_content_filebox' >";
				echo "<iframe src='../card/php/filebox.php?u=".$this->username."' width='834' height='425' frameborder='0'></iframe>";
			echo "</div>
		  </div>
		 
	  </div>";
	}
	
	
	/*  METHOD: Show_personal_promoter()
		
		IN: -
		OUT: {on video print personal area section 'promoter'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_promoter(){
		echo "<div id='tabdiv_btn_card_personal_promoter' style='display:none;'>";
			echo "<div class='personal_tab_center'>";
				echo "<div class='personal_tab_center_content' id='personal_card_div_promoter' style='text-align:left; min-height:250px;'>";
						echo $this->Show_promoter();
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}

	
	/*  METHOD: Show_personal_impostazioni()
		
		IN: -
		OUT: {on video print personal area section 'impostazioni'}
		DESCRIPTION: video printing function.
	*/
	public function Show_personal_impostazioni(){
		echo "<div id='tabdiv_btn_card_personal_impostazioni' style='display:none;'>
				  <div class='personal_tab_center'  id='personal_tab_center_impostazioni'>
						<div class='personal_tab_center_content' id='personal_tab_center_impostazioni_content' style='height:310px;' >";
						$this->Show_mod_impostazioni();
					echo "</div>
				  </div>
				 
			  </div>";	
	}
	public function Show_mod_impostazioni(){
		echo "<div id='personal_password_ajax_panel' class='personal_password_ajax_panel text14px'></div>";
		echo "<span class='text14px'>Modifica password:</span><br/>
		<div style='position:absolute; top:70px; left:20px; text-align:right;'>
			<span class='text14px'>password corrente</span> <input class='input_pass personal_input_valid' type='password' id='input_pass_corrente' value=''><br/>";
			
			echo "<span class='text14px'>nuova password</span> <input class='input_pass personal_input_valid' type='password' id='input_nuova_pass' value=''><br/>";
			echo "<span class='text14px'>ripeti password</span> <input onKeyDown='Enter_on_Personal_password_save(event)' class='input_pass personal_input_valid' type='password' id='input_confirm_nuova_pass' value=''><br/>";
			echo "<div class='personal_button green_button' style='width:150px; position:relative; top:3px;' onclick='Personal_password_save()'><span class='text14px'>SALVA PASSWORD</span></div>";
		echo "</div>";
		echo "<div style='position:absolute; top:220px; left:20px;'>";
				echo "<div class='personal_button'  onclick='personal_tab_change(\"delete\")' style='width:150px;'>
					<span class='text14px' alt='Salva'>ELIMINA ACCOUNT</span>
				</div>";
		echo "</div>";
	}
	
	public function Show_personal_delete(){
		echo "<div id='tabdiv_btn_card_personal_delete' style='display:none;'>
				  <div class='personal_tab_center'  id='personal_tab_center_delete'>
						<div class='personal_tab_center_content' id='personal_tab_center_delete_content' style='height:310px;' >";
						$this->Show_mod_delete();
					echo "</div>
				  </div>
				 
			  </div>";	
	}
	
	public function Show_mod_delete(){
		echo "<div id='delete_loading' class='personal_tab_loading'><img src='../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>";
		echo "<div id='delete_saved' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Informazioni salvate<span></div>";
		echo "<div id='delete_error' class='personal_tab_loading'><img src='../image/icone/error.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Errore<span></div>";
		if($this->status==0){
		  echo "<div style='position:absolute; top:50px; left:25px;width:850px; text-align:left;'>";
			  echo "<span class='text14px'>Eliminazione immediata account: Se procedi la tua card e TUTTI i dati ad essa legata verranno eliminati dai nostri server entro 8 giorni. Verrà eliminato anche il tuo indirizzo e-mail e non sarai più membro di TOPMANAGERGROUP. Non potrai più ricevere inoltre le provvigioni derivate dalle persone che hanno indicato te come referente. Potrai annullare l'operazione di eliminazione entro il termine utile.</span><br/>";
			  echo "<div class='personal_button' onclick='Javascript:Set_account_deleted_now();' style='width:180px;'>
				  <span class='text14px' alt='Salva'>ELIMINA ACCOUNT ORA</span>
			  </div>";
		  echo "</div>";
		  
		  echo "<div style='position:absolute; top:170px; left:25px;width:850px; text-align:left;'>";
			  echo "<span class='text14px'>Eliminazione posticipata account: Se procedi la tua card e TUTTI i dati ad essa legata verranno eliminati dai nostri server alla scadenza della tua iscrizione (Essa non verrà rinnovata). Verrà eliminato anche il tuo indirizzo e-mail e non sarai più membro di TOPMANAGERGROUP. Non potrai più ricevere inoltre le provvigioni derivate dalle persone che hanno indicato te come referente. Potrai annullare l'operazione di eliminazione entro il termine utile.</span><br/>";
			  echo "<div class='personal_button' onclick='Javascript:Set_account_deleted();' style='width:180px;'>
				  <span class='text14px' alt='Salva'>ELIMINA ACCOUNT</span>
			  </div>";
		  echo "</div>";
	  }else if($this->status==1){
		  echo "<div style='position:absolute; top:50px; left:25px;width:850px; text-align:left;'>";
			  echo "<span class='text14px'>Hai impostato l'eliminazione della tua card. La tua card verrà eliminata in data ".$saved_data = date ( 'd/m/Y' ,strtotime($this->remove_data))." alle ore 08:00. </span>Puoi annullare l'eliminazione entro tale data.<br/>";
			  echo "<div class='personal_button' onclick='Javascript:Unset_account_deleted();' style='width:200px;'>
				  <span class='text14px' alt='Salva'>ANNULLA ELIMINAZIONE</span>
			  </div>";
		  echo "</div>";	
	  }else if($this->status==3){
		  echo "<div style='position:absolute; top:50px; left:25px;width:850px; text-align:left;'>";
			  echo "<span class='text14px'>Non hai ancora effettuato il pagamento di 96€. <br/><br/>
			  <b>Puoi pagare tramite un bonifico bancario</b><br/>
							Dati per effettuare il bonifico:<br/>
							NOME COGNOME INTESTATARIO: Exporeclam sas<br/>
							IBAN: IT96W0200850110000041182842<br/>
							CAUSALE: Iscrizione TopManagerGroup di ............. (indicare al posto dei puntini nome e cognome utilizzati nell'iscrizione al gruppo)<br/>
							Grazie<br/>
							Lo staff di TMG<br/>";
		  echo "</div>";	
	  }else if($this->status==4){
		  echo "<div style='position:absolute; top:50px; left:25px;width:850px; text-align:left;'>";
			  echo "<span class='text14px'>Il tuo account è stato impostato per essere eliminato in data ".$this->remove_data.". Questo può accadere nel caso tu non abbia rinnovato il pagamento della tua iscrizione annuale. Se pensi che il tuo account non debba essere eliminato o che ci sia stato un errore nei nostri sistemi contattaci all'indirizzo: info@topmanagergroup.com <br/>";
		  echo "</div>";	
	  }
	  echo "<div class='personal_button' onclick='Javascript:personal_tab_change(\"impostazioni\");' style='position:absolute; top:280px; left:440px; text-align:center; width:85px;'>
			<span class='text14px' alt='Salva'>INDIETRO</span>
		</div>";
	}
	public function Show_form_riscuoti(){
		echo "<div id='impostazioni_promoter_loading' class='personal_tab_loading'><img src='../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>";
		echo "<span class='text16px'>Inserisci le tue coordinate bancarie per la riscossione (il pagamento verrà effettuato tramite bonifico)</span><br/>";
		echo "<span class='text14px'>INTESTATARIO DEL CONTO:</span><br/>";
		echo '<input type="text" class="personal_area_mod_contact" id="personal_card_riscuoti_nomebeneficiario" value="'.$this->Get_nomeandcognome().'"/><br/>';
		echo "<span class='text14px'>IBAN:</span><br/>";
		echo '<input type="text" class="personal_area_mod_contact" id="personal_card_riscuoti_iban"/><br/>';
		echo "<span class='text14px'>CODICE FISCALE INTESTATARIO:</span><br/>";
		echo '<input type="text" class="personal_area_mod_contact" id="personal_card_riscuoti_codfis" value="'.$this->codfis.'"/><br/>';
		echo "<span class='text14px'>CODICE SWIFT (o codice BIC, se il conto è estero):</span><br/>";
		echo '<input type="text" class="personal_area_mod_contact" id="personal_card_riscuoti_swift"/><br/><br/>';
		echo "<span class='text12px'>ATTENZIONE! Richiedendo la riscossione, verrà stampata e quindi presa in ordine la ritenuta d'acconto. Se vuoi fatturare come società e quindi emettere fattura tramite la tua società contattaci via email a info@topmanagergroup.com</span><br/>";
		echo "<div class='personal_button' onclick='Javascript:personal_card_riscuoti();' style='width:200px;'>
			<span class='text14px'>RICHIEDI LA RISCOSSIONE</span>
		</div>";
	}
	public function Show_promoter(){
		$this->mysql_database->GetPromoterData($this->num_subuser,$this->total_ammount,$this->total_confirmed,$this->total_payed,$this->user_id);
		echo "<div id='impostazioni_promoter_loading' class='personal_tab_loading'><img src='../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>";
		echo "<div id='impostazioni_promoter_saved' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Impostazioni Salvate.<span></div>";
		echo "<div id='richiesta_promoter_done' class='personal_tab_loading'><img src='../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Richiesta effettuata.<span></div>";
		$data_ora = date("m.d.y, g:i a"); 
		echo "<br/>";
		echo "<span class='text14px'>";
		echo "In data ".$data_ora.":<br/>";
		echo "Lista utenti che hanno indicato te come promoter:";
		echo "<div class='lista_subuser'>";
		$this->Get_lista_subuser();
		echo "</div>";
		
		echo "<div class='saldo_contabile'>";
			echo '<table border="1">';
				echo '<thead>
				<tr class="sorterbar">
				  <th id="saldo_header" class="saldo_header" scope="col">
		Saldo contabile <a title="Saldo accumulato dalle provvigioni degli utenti che hanno indicato te come promoter. Dopo sette giorni (Diritto legale di recesso) esso diventa disponibile per essere riscosso." style="color:#000; cursor:pointer" target="_self">?</a>
				  </th>
				  <th id="valuta_header" class="saldo_header" scope="col">
		Valuta
				  </th>
				</tr>
			  </thead>
			  <tbody>';
				 echo '<tr class="message_row" style="background-color:'.$backcolor.';">
					<td class="mail_subject">';
					   echo $this->total_ammount;
					echo '
					</td>
					<td class="mail_data">';
					   echo '€';
					echo '
					</td>
				  </tr>';
			echo '</table>';
		echo "</div>";
		echo "<div class='saldo_promoter'>";
			echo '<table border="1">';
				echo '<thead>
				<tr class="sorterbar">
				  <th id="saldo_header" class="saldo_header" scope="col">
		Saldo disponibile <a title="Saldo disponibile per essere riscosso." style="cursor:pointer; color:#000;" target="_self">?</a>
				  </th>
				  <th id="valuta_header" class="saldo_header" scope="col">
		Valuta
				  </th>
				</tr>
			  </thead>
			  <tbody>';
				 echo '<tr class="message_row" style="background-color:'.$backcolor.';">
					<td class="mail_subject">';
					   echo $this->total_confirmed;
					echo '
					</td>
					<td class="mail_data">';
					   echo '€';
					echo '
					</td>
				  </tr>';
			echo '</table>';
		echo "</div>";
		echo "<div class='totale_pagato'>";
		echo '<table  border="1">';
				echo '<thead>
				<tr class="sorterbar">
				  <th id="totale_header" class="saldo_header" scope="col">
		Totale Pagato
				  </th>
				  <th id="totale_valuta" class="saldo_header" scope="col">
		Valuta
				  </th>
				</tr>
			  </thead>
			  <tbody>';
				 echo '<tr class="message_row" style="background-color:'.$backcolor.';">
					<td class="mail_subject">';
					   echo $this->total_payed;
					echo '
					</td>
					<td class="mail_data">';
					   echo '€';
					echo '
					</td>
				  </tr>';
			echo '</table>';
		echo "</div>";
		echo "<div class='riscuoti'>";
				echo "<div class='personal_button' onclick='Javascript:personal_card_ctrl_riscuoti();' style='width:80px;'>
							<span class='text14px'>RISCUOTI</span>
						</div>";
		echo "</div>";
	}
	public function Get_lista_subuser(){
		$utenti = $this->mysql_database->Get_lista_subuser($this->user_id);
		if(count($utenti)>0){
			echo '<table>';
				echo '<thead>
				<tr class="sorterbar">
				  <th id="lista_subuser_nome_header" class="lista_subuser_nome" scope="col">
		Nome utente
				  </th>
				  <th id="lista_subuser_data_header" class="lista_subuser_data" scope="col">
		Data iscrizione
				  </th>
				  <th id="lista_subuser_data_header" class="lista_subuser_data" scope="col">
		Giovane <a title="Se l\'utente è giovane, non riceverai la provvigione finche esso non raggiungerà il 25 anno di età." style="color:#000; cursor:pointer" target="_self">?</a>
				  </th>
				</tr>
			  </thead>
			  <tbody>';
			foreach($utenti as $utente){
				if(($i%2)==0){
					$backcolor="#8b8b8b";	
				}else{
					$backcolor="#838383";
				}
				
				$fontweight="700";
				$colore="#FFF";
				 echo '<tr class="message_row" style="background-color:'.$backcolor.';">
					<td class="lista_subuser_nome" onclick="Javascript:open_card(\''.$utente['username'].'\')">';
					   echo '<span target="_self"  style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.';" >'.$utente['username'].'</span>';
					echo '
					</td>
					<td class="lista_subuser_data" onclick="Javascript:open_card(\''.$utente['username'].'\')">';
					   echo '<span style="color:'.$colore.'; font-weight:'.$fontweight.';" >'.$this->getmessagedata($utente['data']).'</span>';
					echo '
					</td>
					<td class="lista_subuser_data" onclick="Javascript:open_card(\''.$utente['username'].'\')">';
					   if($utente['giovane']==1){
					   	   echo '<span style="color:'.$colore.'; font-weight:'.$fontweight.';" >SI</span>';
					   }else{
						   echo '<span style="color:'.$colore.'; font-weight:'.$fontweight.';" >NO</span>';
					   }
					echo '
					</td>
				  </tr>';
			}
			echo '</table>';
		}else{
			echo '<p>Non sono presenti utenti che hanno indicato te come promoter.</p>';	
		}
	}
	
	//##################################################################################
	//PERSONAL AREA FUNCTIONS END
	//##################################################################################
	
	/*  METHOD: Generate_european_cv()
		
		IN: -
		OUT: -
		DESCRIPTION: generate the PDF of the european curriculum.
	*/
	public function Generate_european_cv(){
		// initiate PDF 
		$pdf = new PDF_curriculum('P','mm','A4',true,'UTF-8',false,false); 
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($this->Get_nomeandcognome());
		$pdf->SetKeywords('Top, Manager, group, '.$this->Get_nome().', '.$this->Get_cognome().', curriculum europeo');
		$pdf->SetMargins(0, 0, 0); 
		$pdf->SetAutoPageBreak(true, 0); 
		$pdf->setFontSubsetting(false); 
		
		$pdf->AddPage(); 
		
		$this->Set_arraycurriculumeurop_titolo($array_curr_titolo);
		
		//titolo
		$pdf->SetFont("times", "", 16); 
		
		/*$pdf->MultiCell	(	$ 	w,
		$ 	h,
		$ 	txt,
		$ 	border = 0,
		$ 	align = 'J',
		$ 	fill = false,
		$ 	ln = 1,
		$ 	x = '',
		$ 	y = '',
		$ 	reseth = true,
		$ 	stretch = 0,
		$ 	ishtml = false,
		$ 	autopadding = true,
		$ 	maxh = 0,
		$ 	valign = 'T',
		$ 	fitcell = false 
		)*/
		$html = '<strong style="font-size: 65px;" >Curriculum Vitae</strong> di '.$array_curr_titolo['nomecognome'];
		$pdf->MultiCell(200,10,$html,0,J,false,1,9,10,true,0,true,true,0,'T',false);
		
		//foto
		$pdf->Image('../../'.$this->username.'/user_photo/'.$this->photo1_path, 162, 10, 36, 54, '', '', '', true, 150, '', false, false, 1, false, false, false);
		
		//sottotitolo
		$pdf->SetFont("helvetica", "B", 13);
		$html = '<p style="line-height:1.1; color:#494949;">'.$array_curr_titolo['sottotitolo'].'</p>';
		
		$pdf->MultiCell(200,50,$html,0,'J',false,1,10,30,true,0,true,true,50,'T',false);
		
		$this->Set_arraycurriculumeurop($array_curr,$array_curr_desc,$array_num_righe,$array_offset);
		$left_coloumn_font_size = 10;
		$right_coloumn_font_size = 10;
		$left_coloumn_cell_width = 45;
		$right_coloumn_cell_width = 160;
		$ycurrent = 72;
		
		foreach ($array_curr_desc as $key => $value) {
			if($array_curr[$key]!=NULL){
				//Data e Luogo di nascita
				$pdf->SetFont("helvetica", "", $left_coloumn_font_size);
				$html = '<div style="text-align:right;">'.$value.'</div>';
				$pdf->MultiCell($left_coloumn_cell_width,0,$html,0,'J',false,1,2,$ycurrent,true,0,true,true,50,'T',false);
				
				$pdf->SetFont("helvetica", "", $right_coloumn_font_size);
				$html = '<div style="text-align:left;">'.$array_curr[$key].'</div>';
				$ycurrent = $ycurrent + ($array_offset[$key] * 4.35);
				
				$pdf->MultiCell($right_coloumn_cell_width,0,$html,0,'J',false,1,50,$ycurrent,true,0,true,true,50,'T',false);
				
				$p_height = $pdf->getNumLines($html,$right_coloumn_cell_width);
				$ycurrent=$ycurrent+($array_num_righe[$key]*4.2);
			}
		}
			
		$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');
		
		$pdf->Output('../../'.$this->username.'/download_area/public/tmg_'.$this->username.'_curriculum_europeo.pdf', 'F');
	}
	
	
	/*  METHOD:  Generate_bv()
		
		IN: -
		OUT: -
		DESCRIPTION: generate the PDF of the visiting card.
	*/
	public function Generate_bv(){	
		// initiate PDF 
		$resolution= array(52,90);
		$pdf = new PDF_biglietto('L','mm',$resolution,true,'UTF-8',false,false); 
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($this->Get_nomeandcognome());
		$pdf->SetKeywords('Top, Manager, group, '.$this->Get_nome().', '.$this->Get_cognome().', biglietto da visita');
		$pdf->SetMargins(0, 0, 0); 
		$pdf->SetAutoPageBreak(true, 0); 
		$pdf->setFontSubsetting(false); 
		
		$pdf->AddPage(); 

		// get esternal file content 
		//$utf8text = file_get_contents("cache/utf8test.txt", true); 
		
		$pdf->SetFont("helvetica", "", 10); 
		// now write some text above the imported page 
		//$pdf->Write(5, "prova 123"); 
		$this->SetArrayBv($arraybv);
		
		
		$html = $this->Get_nome().' '.$this->Get_cognome().'<br/>';
		if($arraybv['p']!= NULL)
			$html .= $arraybv['p'].'<br/>';
		if($arraybv['cell']!= NULL)
			$html .= 'Cellulare: '.$arraybv['cell'].'<br/>';
		else
			$html .= '<br/>';
				
		$html .= '<br/><span style="font-size: 24px; font-size:smaller; color:4b5050; ">web: topmanagergroup.com/'.$this->username.'<br/>';
		
		
		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell($w=0, $h=0, $x='3', $y='23', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		
		$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');	
		
		$pdf->Output('../../'.USERS_PATH.$this->username.'/download_area/public/tmg_'.$this->username.'_biglietto.pdf', 'F');	
	}
	
	private function dirsize($dir) {
		$size = 0;
		if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object)
		if ($object != "." && $object != ".." && $object != 'index.php')
		if (filetype($dir."/".$object) == "dir")
		$size += $this->dirsize($dir."/".$object);
		else
		$size += filesize($dir."/".$object);
		reset($objects);
		}
		return $size;
	}
	public function Is_uploadable($path){
		$dir_path =  "../../".USERS_PATH.$this->username."/";
		$size = $this->dirsize($dir_path);
		$total_size = filesize($path)+$size;
		if($this->is_giovane==1){
			if($total_size < TOTAL_SIZE_GIOVANE)
				return $total_size;
			else
				return 1;
		}else{
			if($total_size < TOTAL_SIZE)
				return $total_size;
			else
				return 1;
		}
	}
	private function HumanReadableFilesize($size) {
 
		// Adapted from: http://www.php.net/manual/en/function.filesize.php
	 
		$mod = 1024;
	 
		$units = explode(' ','B KB MB GB TB PB');
		for ($i = 0; $size > $mod; $i++) {
			$size /= $mod;
		}
	 
		return round($size, 2) . ' ' . $units[$i];
	}
	public function Show_personal_card_size(){
		$dir_path =  "../../".USERS_PATH.$this->username."/";
		$size = $this->dirsize($dir_path);
		echo "<span style='font-size: 13px; font-weight:700;'>Spazio residuo nella card</span>";
		echo '<div class="personal_size_progressbar">
        <span></span>
		</div>';
		if($this->is_giovane==1){
			echo "Utilizzati: <span id='size_left_value'>".$this->HumanReadableFilesize($size)."</span> / ".$this->HumanReadableFilesize(TOTAL_SIZE_GIOVANE);
			echo "<br/>Quando raggiungerai 25 anni diventerai un membro pagante e il tuo spazio utilizzabile sarà di 2GB.";
		}else{
			echo "Utilizzati: <span id='size_left_value'>".$this->HumanReadableFilesize($size)."</span> / ".$this->HumanReadableFilesize(TOTAL_SIZE);
		}
	}
	
	public function Set_progress_size_bar(){
		$dir_path =  "../../".USERS_PATH.$this->username."/";
		$size = $this->dirsize($dir_path);
		$value = array();
		$value[0] = $this->HumanReadableFilesize($size);
		if($this->is_giovane==1){
			$value[1] = ($size*100)/TOTAL_SIZE_GIOVANE;
		}else{
			$value[1] = ($size*100)/TOTAL_SIZE;
		}
		return $value;
	}
	//-------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------
	/* OLD FUNCTION!! */
	function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
	  //cycle through each file
	  foreach($files as $file) {
		//make sure the file exists
		if(file_exists($file)) {
		  $valid_files[] = $file;
		}
	  }
	}
	//if we have good files...
	if(count($valid_files)) {
	  //create the archive
	  $zip = new ZipArchive();
	  if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
		return false;
	  }
	  //add the files
	  foreach($valid_files as $file) {
		$zip->addFile($file,$file);
	  }
	  //debug
	  //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
	  
	  //close the zip -- done!
	  $zip->close();
	  
	  //check to make sure the file exists
	  return file_exists($destination);
	}
	else
	{
	  return false;
	}
	}
	
	
	public function is_mobile(){
		$useragent=$_SERVER['HTTP_USER_AGENT'];

		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
				return true;
			else
				return false;
		
	}
	
}
?>