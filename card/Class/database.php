<?php
define('DB_ERROR_LOG_FILE','../../config/db_log_file.txt');
interface Database
{
	function Get_from_db(&$username,&$user_id,&$Nome,&$Cognome,&$Professione,&$password,&$email,&$user_level,&$society,&$resta_collegato,&$id_referente,&$is_giovane,&$Category,&$status,&$remove_data,&$data_iscrizione,&$codfiscale,&$alternative_url,&$photo1_path,&$user_photo_slide_path,&$user_photo_slide_big_path,&$contact_rows,&$social_rows, &$newsletter_rows,&$user_newsletter_rows_count,&$newsletter_group,&$bv_cellulare,&$bv_email,&$bv_tmg_email,&$bv_web,&$bv_professione, &$curriculum_europeo_data, &$opt_curr,&$folders,&$cellulare,&$email_bv_value, &$alt_professione,&$colore_card,&$flagnameshowed,&$sudime,&$news_rows,&$empty_news_rows,&$user_news_rows_count,&$email_messages,&$email_messages_sent,&$email_messages_trash,&$address_via,&$address_citta,&$address_desc,&$address_on,&$job_categories,&$num_subuser,&$total_ammount,&$total_confirmed,&$total_payed);

	function Update_curriculum($text, $user_id);

	function Insert_contact_rows($value,$type,$user_id);
	
	function Add_newsletter_row($row_value,$nome,$cognome,$cell,$id_group,$user_id);
	
	function Add_newsletter_import_group($user_id);
	function Update_mailing_contact_row($id_row,$nome,$middle_name,$addon,$cognome,$fn,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note,$user_id);
	
	function Add_new_mailing_contact_row($id_group,$nome,$middle_name,$addon,$cognome,$fn,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note,$user_id);
	
	function Store_vcard($nome, $cognome, $middle_name, $addon, $fn, $nickname, $sort_string, $organisation, $departement, $title, $note, $url_home, $url_work, $tel_home1, $tel_home2, $tel_work1, $tel_work2, $tel_car, $tel_additional, $tel_pager, $tel_home_fax, $tel_work_fax, $tel_isdn, $tel_preferred, $company, $work_street, $work_city, $work_region, $work_zip, $work_country, $home_street, $home_city, $home_region, $home_zip, $home_country, $postal_street, $postal_city, $postal_region, $postal_zip, $postal_country, $role, $bday, $mailer, $cell, $key, $anniversary, $caladruri, $caluri, $categories, $clientpidmap, $fburl, $gender, $geo, $impp, $kind, $logo, $member, $photo, $prodid, $related, $sound, $source, $tz, $uid, $xml, $id_group, $user_id);
	
	function Delete_all_mailing_emails($user_id,$id_row);
	
	
	function Delete_all_mailing_urls($user_id,$id_row);
	
	function Store_vcard_emails($user_id,$id_group,$inserted_id,$email,$is_main);
	
	function Store_vcard_url($user_id,$id_group,$inserted_id,$url,$is_main);
	
	function Mod_newsletter_row($row_value,$nome,$cognome,$cell,$id_row);
	
	function Add_newsletter_group($nome,$user_id);
	
	function Delete_newsletter_row($id ,$user_id);
	
	function Move_newsletter_row($id ,$id_group,$user_id);
	
	function Delete_newsletter_group($id ,$user_id);
	
	function Rename_newsletter_group($name ,$group_id,$user_id);
	
	function Set_mailing_contacts_old($user_id);
	
	function Move_contact_up($row_id,$row_num,$user_id);
	
	function Move_contact_down($row_id,$row_num,$user_id);
	
	function Add_social_element($value,$type,$title,$favicon,$user_id);
	
	function Update_social_element($value,$type,$favicon,$title,$index,$user_id);
	
	function Move_social_up($row_id,$row_num,$user_id);
	
	function Move_social_down($row_id,$row_num,$user_id);
	
	function Delete_social_element($row_num,$index_delete,$user_id);
	
	function Update_profilo($user_id, $new_profilo_professione, $new_profilo_cellulare,$new_profilo_email,&$professione,&$cellulare,$new_bv_professione,$new_bv_cellulare,$new_bv_email,&$bv_cellulare,&$bv_professione);
	
	
	function Evidenza_save_row($user_id,$id_row, $title,$subtitle,$desc,$file);
	
	function Move_rows_up($row_id,$row_num,$user_id);
	
	function Move_rows_down($row_id,$row_num,$user_id);
	
	function Create_new_news($user_id,$user_news_rows_count);
	
	function Delete_single_news($index_delete,$row_num,$user_id);
	
	function Evidenza_save_data($id_row,$data,$sendto,$check_alt,$user_id);
	
	function Update_evidenza_sent($news_id,$user_id);
	
	function Delete_not_completed_news($user_id);
	
	function Evidenza_delete_post_pubblica($user_id);
	
	function Update_main_photo($photo_name, $user_id, &$photo1_path);
	
	function Update_slide_photo($photo_name,$photo_big_name, $user_id, $index);
	
	function Add_slide_photo($photo_name, $user_id , $photo_path, &$user_photo_slide_path,$index);
	
	function Recreate_photo_slide( $user_id , $user_photo_slide_path,$user_photo_slide_big_path);
	
	function IsUsername($user);
	
	function Update_bv($user_id,$bv_check_cellulare,$bv_check_email,$bv_check_tmg_email,$bv_check_professione,$bv_cellulare,$bv_email,$bv_professione,$personal_in_bv_web);
	
	function Update_europ_cv_step1($nomecognome, $sottotitolo, $sesso, $cittadinanza, $dataluogo, $user_id);
	
	function Update_europ_cv_step2($istruzformaz, $esplavorativa, $user_id);
	
	function Update_europ_cv_step3($linguestraniere, $madrelingua, $capacitacompet, $compinformatiche, $comprelsoc, $comporganiz, $user_id);
	
	function Update_europ_cv_step4($compartistiche, $comptecniche, $comprelativeallav, $altrecompedinteressi, $user_id);
	
	function Update_impostazioni_password($user_id,$new_pass = NULL);
	
	function Change_card_colour($colour, $user_id);
	
	function Update_impostazioni_curr($user_id,$change_opt_curr);
	
	function Update_europ_cv_step5($patente, $ulteriori, $user_id);
	
	function Update_professione($professione,$category,$nameshowed, $user_id);

	function Update_dove_siamo($address_via,$address_citta,$address_desc,$address_on,$user_id);
	
	function Add_private_folder($folder_name,$folder_pass,$user_id);
	
	function Get_from_temp(&$username,&$nome,&$cognome,&$email,&$password,&$id_referente,&$society,&$is_giovane,&$codfiscale,$idTransazione,&$alternative_url);
	function Create_new_user($username,$email,$password,$nome,$cognome,$professione,$id_referente,$idTransazione,$level,$sfida_corrente,$paypal_email,$data,$society,$is_giovane,$codfiscale,$status,$alternative_url);
	
	function Get_user_referente(&$user_referente,&$email_referente,&$nome_referente,&$cognome_referente,$id_referente);
	
	function Delete_temp_user($idTransazione);
	
	function Set_user_table($user_id,$email,$username);
	
  	function delete_me($user_id,$id_referente,$status,$eliminazione_immediata,$username);
	
	function Change_password($password,$user_id);
	
	function Change_folder_password($folder_name,$folder_pass,$user_id);
	
	function delete_folder($name,$user_id);
	
	function Rename_folder($name,$new_name,$user_id);
	
	function invia_sfida($sfida,$user);
	
	function elimina_sfida($user);
	
	function verifica_login($user,$password_utente,$sfida);

	function Get_stmt_login();

    function Get_stmt_logged();

	function Check_brute($user_id);

	function Insert_login_attempt($user_id,$now);
	
	function Set_cookie_resta_collegato($hash,$email);
	
	function Get_user_id($email);
	
	function GetPromoterData(&$num_subuser,&$total_ammount,&$total_confirmed,&$total_payed,$user_id);
	
	function Update_promoter($id_referente,$is_giovane,$preview);
	
	function Update_sub_user($username,$data_iscrizione,$is_giovane,$id_referente);
	
	function Get_lista_subuser($user_id);
	
	function delete_contact_row($row_num,$index_delete,$user_id);
	
	function update_contact_row($index,$new_row_value,$new_row_type,$user_id);
	
	function Get_username_from_cookie($cod_cookie);
	
	function Show_error($error_msg);
	
	function UpdateLog ( $string , $logfile );

	function Evidenza_delete_all($user_id);
	
	function Add_friend($nome,$cognome,$id_group,$cell,$friend_note,$user_id);
	
	function Save_assistenza($email,$textarea,$ip);
	
	function Save_abuso($email,$type,$textarea,$ip,$username);
	
	function Set_account_deleted_now($user_id);
	
	function Set_account_deleted($user_id,$data_iscrizione);
	
	function Unset_account_deleted($user_id);
}

class MySqlDatabase implements Database{
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
   
   public function Get_from_temp(&$username,&$nome,&$cognome,&$email,&$password,&$id_referente,&$society,&$is_giovane,&$codfiscale,$idTransazione,&$alternative_url){
		$query = "SELECT * FROM ".USER_TEMP_TABLE." WHERE idTransazione= ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('s',$username);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
			
		   if($row==NULL){
			$this->Show_error("Non esistono Membri TMG con username:".$username);
			}else{   
				$username = $row["Username"];
				$nome =  $row["Nome"];
				$cognome =  $row["Cognome"];
				$email = $row["Email"];
				$password = $row["Password"];
				$id_referente = $row["ID_Referente"];
				$society = $row["society"];
				$is_giovane = $row["is_giovane"];
				$codfiscale = $row["codfiscale"];
				$alternative_url = $row["alternative_url"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
	}
	public function Get_from_db(&$username, &$user_id, &$Nome, &$Cognome, &$Professione, &$password, &$email, &$user_level,&$society,&$resta_collegato,&$id_referente,&$is_giovane,&$Category,&$status,&$remove_data,&$data_iscrizione,&$codfiscale,&$alternative_url,&$photo1_path, &$user_photo_slide_path,&$user_photo_slide_big_path, &$contact_rows, &$social_rows, &$newsletter_rows,&$user_newsletter_rows_count,&$newsletter_group,&$bv_cellulare,&$bv_email,&$bv_tmg_email,&$bv_web,&$bv_professione,&$curriculum_europeo_data, &$opt_curr,&$folders,&$cellulare,&$email_bv_value, &$alt_professione,&$colore_card,&$flagnameshowed,&$sudime,&$news_rows,&$empty_news_rows,&$user_news_rows_count,&$email_messages,&$email_messages_sent,&$email_messages_trash,&$address_via,&$address_citta,&$address_desc,&$address_on,&$job_categories,&$num_subuser,&$total_ammount,&$total_confirmed,&$total_payed){
		
		$query = "SELECT * FROM ".USER_TABLE." WHERE Username= ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('s',$username);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
			
		   if($row==NULL){
			$this->Show_error("Non esistono Membri TMG con username:".$username);
			}else{   
				$user_id = $row["ID"];
				$Nome =  $row["Nome"];
				$Cognome =  $row["Cognome"];
				$Professione = $row["Professione"];
				$password = $row["Password"];
				$email = $row["Email"];
				$user_level = $row["Level"];
				$resta_collegato = $row["cod_cookie"];
				$society = $row["society"];
				$id_referente = $row["ID_Referente"];
				$is_giovane = $row["is_giovane"];
				$Category = $row["Category"];
				$status = $row["status"];
				$remove_data = $row["remove_date"];
				$data_iscrizione = $row["data"];
				$codfiscale = $row["codfiscale"];
				$alternative_url = $row["alternative_url"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		$query = "SELECT * FROM ".USER_DATA_TABLE." WHERE id_user = ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_DATA -- USERNAME: ".$username);
			}else{   
				$photo1_path = $row["photo_1"];
				$curriculum = $row["curriculum"];
				$opt_curr = $row["curr"];
				$cellulare = $row["cellulare"];
				$email_bv_value = $row["email_bv"];
				$alt_professione = $row["alt_professione"];
				$colore_card = $row["colore_card"];
				if($row["colore_card"]=='')
					$colore_card='brown';
				$flagnameshowed= $row["nameshowed"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		$query = "SELECT * FROM ".USER_POSITION_TABLE." WHERE id_user = ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_POSITION -- USERNAME: ".$username);
			}else{
				$address_via= $row["address_via"];
				$address_citta= $row["address_citta"];
				$address_desc= $row["address_desc"];
				$address_on= $row["address_on"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		
		$query = "SELECT * FROM ".USER_SLIDE_TABLE." WHERE id_user = ? ORDER BY id_photo_num";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			for($i=0;$stmt->fetch();$i++){
				$user_photo_slide_path[$i]= $row["path_photo"];
				$user_photo_slide_big_path[$i] = $row["path_photo_hd"];
			}
		   $stmt->free_result();
		   $stmt->close();
		}
		
		$query = "SELECT * FROM ".USER_CONTACT_TABLE." WHERE id_user = ? ORDER BY row_num";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			for($i=0;$stmt->fetch();$i++){
				$contact_rows[$i]["row_value"]= $row["row_value"];
				$contact_rows[$i]["type"]= $row["type"];
				$contact_rows[$i]["row_num"]= $row["row_num"];
				$contact_rows[$i]["id"]= $row["idusercontact"];
			}
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		$query = "SELECT * FROM ".USER_SOCIAL_TABLE." WHERE id_user = ? ORDER BY row_num";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			for($i=0;$stmt->fetch();$i++){
				$social_rows[$i]["id"]= $row["idusersocial"];
				$social_rows[$i]["value"]= $row["value"];
				$social_rows[$i]["type"]= $row["type"];
				$social_rows[$i]["title"]= $row["title"];
				$social_rows[$i]["row_num"]= $row["row_num"];
				$social_rows[$i]["favicon"]= $row["favicon"];
			}
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		
		
		
		
		
		
		$query = "SELECT * FROM ".USER_NEWSLETTER_TABLE." WHERE id_user = ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			for($i=0;$stmt->fetch();$i++){
				$newsletter_rows[$i]= $row;
				$query = "SELECT * FROM ".USER_NEWSLETTER_EMAIL_TABLE." WHERE id_user = ? AND rel_id= ? ORDER BY is_main DESC";
				if($emailstmt = $this->sec_mysqli->prepare($query)){
					$emailstmt->bind_param('ii',$user_id,$newsletter_rows[$i]["idusernewsletter"]);
					$emailstmt->execute();
					$emailstmt->store_result();
					$emailrow = array();
					$this->stmt_bind_assoc($emailstmt, $emailrow);
					
					for($j=0;$emailstmt->fetch();$j++){
						$newsletter_rows[$i]["emails"][$j] = $emailrow;
					}
				   $emailstmt->free_result();
				   $emailstmt->close();
				}
				
				$query = "SELECT * FROM ".USER_NEWSLETTER_URL_TABLE." WHERE id_user = ? AND rel_id= ? ORDER BY is_main DESC";
				if($urlstmt = $this->sec_mysqli->prepare($query)){
					$urlstmt->bind_param('ii',$user_id,$newsletter_rows[$i]["idusernewsletter"]);
					$urlstmt->execute();
					$urlstmt->store_result();
					$urlrow = array();
					$this->stmt_bind_assoc($urlstmt, $urlrow);
					
					for($k=0;$urlstmt->fetch();$k++){
						$newsletter_rows[$i]["url"][$k] = $urlrow;
					}
				   $urlstmt->free_result();
				   $urlstmt->close();
				}
			}
		   $stmt->free_result();
		   $stmt->close();
		}
		$user_newsletter_rows_count = $i--;
		
		
		$query = "SELECT * FROM ".USER_NEWSLETTER_GROUP_TABLE." WHERE id_user = ? ORDER BY idusernewslettergroup";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			for($i=0;$stmt->fetch();$i++){
				$newsletter_group[$i]["id"]= $row["idusernewslettergroup"];
				$newsletter_group[$i]["nome"]= $row["name"];
				$newsletter_group[$i]["blocked"]= $row["blocked"];
			}
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		$query = "SELECT * FROM ".USER_EVIDENZA_TABLE." WHERE id_user = ? ORDER BY row_num";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			for($i=0;$stmt->fetch();$i++){
				if($row["done"]!=0){
					$news_rows[$i]["titolo"]= $row["title"];
					$news_rows[$i]["sottotitolo"]= $row["subtitle"];
					$news_rows[$i]["descrizione"]= $row["description"];
					$news_rows[$i]["file"]= $row["file"];
					$news_rows[$i]["data"]= $row["data"];
					$news_rows[$i]["id"]= $row["iduser_evidenza"];
					$news_rows[$i]["sendto"]= $row["sendto"];
					$news_rows[$i]["row_num"]= $row["row_num"];
					$news_rows[$i]["sent"]= $row["sent"];
					$i++;
				}else{
					$empty_news_rows[$k]["titolo"]= $row["title"];
					$empty_news_rows[$k]["sottotitolo"]= $row["subtitle"];
					$empty_news_rows[$k]["descrizione"]= $row["description"];
					$empty_news_rows[$k]["file"]= $row["file"];
					$empty_news_rows[$k]["data"]= $row["data"];
					$empty_news_rows[$k]["id"]= $row["iduser_evidenza"];
					$empty_news_rows[$k]["sendto"]= $row["sendto"];
					$k++;	
				}
			}
			$user_news_rows_count = $i--;
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		$query = "SELECT * FROM ".USER_BV_TABLE." WHERE id_user = ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_BV_TABLE -- USERNAME: ".$username);
			}else{
				$bv_cellulare = $row["cellulare"];
				$bv_professione = $row["professione"];
				$bv_web = $row["web"];
				$bv_email = $row["email"];
				$bv_tmg_email = $row["email_tmg"];
		
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		
		$query = "SELECT * FROM ".USER_CURREUROP_TABLE." WHERE id_user = ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_CURREUROP_TABLE -- USERNAME: ".$username);
			}else{
				$curriculum_europeo_data["nomecognome"] = ($row["nomecognome"]);
				$curriculum_europeo_data["sottotitolo"] = ($row["sottotitolo"]);
				$curriculum_europeo_data["dataluogo"] = $row["dataluogo"];
				$curriculum_europeo_data["sesso"] = ($row["sesso"]);
				$curriculum_europeo_data["cittadinanza"] = ($row["cittadinanza"]);
				$curriculum_europeo_data["istruzformaz"] = ($row["istruzformaz"]);
				$curriculum_europeo_data["esplavorativa"] = ($row["esplavorativa"]);
				$curriculum_europeo_data["capacitacompet"] = ($row["capacitacompet"]);
				$curriculum_europeo_data["madrelingua"] = ($row["madrelingua"]);
				$curriculum_europeo_data["linguestraniere"] = ($row["linguestraniere"]);
				$curriculum_europeo_data["compinformatiche"] = ($row["compinformatiche"]);
				$curriculum_europeo_data["comprelsoc"] = ($row["comprelsoc"]);
				$curriculum_europeo_data["comporganiz"] = ($row["comporganiz"]);
				$curriculum_europeo_data["compartistiche"] = ($row["compartistiche"]);
				$curriculum_europeo_data["comptecniche"] = ($row["comptecniche"]);
				$curriculum_europeo_data["comprelativeallav"] = ($row["comprelativeallav"]);
				$curriculum_europeo_data["altrecompedinteressi"] = ($row["altrecompedinteressi"]);
				$curriculum_europeo_data["patente"] = ($row["patente"]);
				$curriculum_europeo_data["ulteriori"] = ($row["ulteriori"]);
		
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		$query = "SELECT * FROM ".USER_FILEBOX_TABLE." WHERE id_user = ? ";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$this->stmt_bind_assoc($stmt, $row);
			
			for($i=0;$stmt->fetch();$i++){
				$folders[$row['folder_name']]['folder_pass']= $row["folder_pass"];
				$folders[$row['folder_name']]['folder_name']= $row["folder_name"];
			}
			
			$user_news_rows_count = $i--;
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		$query = "SELECT * FROM ".USER_SIMPLE_CURR_TABLE." WHERE id_user = ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_SIMPLE_CURR_TABLE -- USERNAME: ".$username);
			}else{
				$sudime= $row["sudime"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		
		$query = "SELECT * FROM ".USER_JOB_CATEGORIES;
		$result = $this->sec_mysqli->query($query);
		
		for($i=1;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
			$job_categories[$i] = $row;
		}
		
		
		
	}	
	
	function Update_curriculum($text, $user_id){
		
			if($text!=NULL){
				$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_SIMPLE_CURR_TABLE." SET sudime=? WHERE id_user=?");
				$stmt->bind_param("si",$text,$user_id);
				$stmt->execute();
			}
			$stmt->close();
	}
	public function Insert_contact_rows($value,$type,$user_id){
		  $query="INSERT INTO ".USER_CONTACT_TABLE." (id_user,row_num,row_value,type) VALUES(?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $row_num++;
		  $stmt->bind_param("iiss",$user_id,$row_num,$value,$type);
		  $stmt->execute();
		  
		  $stmt->close();
	}
	public function Add_newsletter_row($row_value,$nome,$cognome,$cell,$id_group,$user_id){
		
		  $query="INSERT INTO ".USER_NEWSLETTER_TABLE." (id_user,nome,cognome,cell,row_value,type,id_group) VALUES(?,?,?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		  $type="email";
		  $stmt->bind_param("isssssi",$user_id,$nome,$cognome,$cell,$row_value,$type,$id_group);
		  $stmt->execute();
		  $stmt->close();
	}
	
	public function Update_mailing_contact_row($id_row,$nome,$middle_name,$addon,$cognome,$fn,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note,$user_id){
		
		
		//creo la vcard e inserisco i campi: id_user, nome, cognome, middle_name, addon, fn, sort_string, nickname, type, id_group, cell
		  $query="UPDATE ".USER_NEWSLETTER_TABLE." SET id_user=?, nome=?, cognome=?, middle_name=?, addon=?, fn=?, nickname=?, cell=?, note=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
		  
		  $type="vcard";
		  
		  $stmt->bind_param("issssssssi",$user_id, $nome, $cognome, $middle_name, $addon, $fn, $nickname, $cell, $note, $id_row);
		  
		  $stmt->execute();
		  
		   //inserisco nella vcard i campi: organisation, departement, title, note, row_value, url_home, url_work, tel_home1, tel_home2, tel_work1, tel_work2, tel_car, tel_additional, tel_pager, tel_home_fax, tel_work_fax, tel_isdn, tel_preferred
		  $query="UPDATE ".USER_NEWSLETTER_TABLE." SET organisation=?, departement=?, title=?, note=?, url_home=?, url_work=?, tel_home1=?, tel_home2=?, tel_work1=?, tel_work2=?, tel_car=?, tel_additional=?, tel_pager=?, tel_home_fax=?, tel_work_fax=?, tel_preferred=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("ssssssssssssssssi",$organisation, $departement, $title, $note, $url_home, $url_work, $tel_home1, $tel_home2, $tel_work1, $tel_work2, $tel_car, $tel_additional, $tel_pager, $tel_home_fax, $tel_work_fax, $tel_preferred, $id_row);
		  
		  $stmt->execute();
		  
		  
		  //inserisco nella vcard i campi: company, work_street, work_city, work_region, work_zip, work_country, home_street, home_city, home_region, home_zip, home_country, postal_street, postal_city, postal_region, postal_zip, postal_country, role, bday, mailer
		   $query="UPDATE ".USER_NEWSLETTER_TABLE." SET company=?, work_street=?, work_city=?, work_region=?, work_zip=?, work_country=?, home_street=?, home_city=?, home_region=?, home_zip=?, home_country=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("sssssssssssi",$company, $work_street, $work_city, $work_region, $work_zip, $work_country, $home_street, $home_city, $home_region, $home_zip, $home_country, $id_row);
		  
		  $stmt->execute();
		  
		  $query="OPTIMIZE TABLE ".USER_NEWSLETTER_TABLE;
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
		  
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	
	public function Add_new_mailing_contact_row($id_group,$nome,$middle_name,$addon,$cognome,$fn,$nickname,$tel_home1,$tel_home2,$tel_work1,$tel_work2,$cell,$tel_work_fax,$tel_home_fax,$tel_pager,$tel_additional,$tel_car,$home_city,$home_region,$home_country,$home_zip,$home_street,$url_home,$organisation,$title,$departement,$company,$work_city,$work_region,$work_country,$work_zip,$work_street,$url_work,$note,$user_id){
		
		
		//creo la vcard e inserisco i campi: id_user, nome, cognome, middle_name, addon, fn, sort_string, nickname, type, id_group, cell
		  $query="INSERT INTO ".USER_NEWSLETTER_TABLE." (id_user, nome, cognome, middle_name, addon, fn, nickname, type, id_group, cell, note) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
		  
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
		  
		  $type="vcard";
		  
		  $stmt->bind_param("isssssssiss",$user_id, $nome, $cognome, $middle_name, $addon, $fn, $nickname, $type, $id_group, $cell, $note);
		  
		  $stmt->execute();
		  
		  
		  $inserted_id = $this->sec_mysqli->insert_id;
		  
		   //inserisco nella vcard i campi: organisation, departement, title, note, row_value, url_home, url_work, tel_home1, tel_home2, tel_work1, tel_work2, tel_car, tel_additional, tel_pager, tel_home_fax, tel_work_fax, tel_isdn, tel_preferred
		  $query="UPDATE ".USER_NEWSLETTER_TABLE." SET organisation=?, departement=?, title=?, note=?, url_home=?, url_work=?, tel_home1=?, tel_home2=?, tel_work1=?, tel_work2=?, tel_car=?, tel_additional=?, tel_pager=?, tel_home_fax=?, tel_work_fax=?, tel_preferred=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("ssssssssssssssssi",$organisation, $departement, $title, $note, $url_home, $url_work, $tel_home1, $tel_home2, $tel_work1, $tel_work2, $tel_car, $tel_additional, $tel_pager, $tel_home_fax, $tel_work_fax, $tel_preferred, $inserted_id);
		  
		  $stmt->execute();
		  
		  
		  //inserisco nella vcard i campi: company, work_street, work_city, work_region, work_zip, work_country, home_street, home_city, home_region, home_zip, home_country, postal_street, postal_city, postal_region, postal_zip, postal_country, role, bday, mailer
		   $query="UPDATE ".USER_NEWSLETTER_TABLE." SET company=?, work_street=?, work_city=?, work_region=?, work_zip=?, work_country=?, home_street=?, home_city=?, home_region=?, home_zip=?, home_country=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("sssssssssssi",$company, $work_street, $work_city, $work_region, $work_zip, $work_country, $home_street, $home_city, $home_region, $home_zip, $home_country, $inserted_id);
		  
		  $stmt->execute();
		  
		  $query="OPTIMIZE TABLE ".USER_NEWSLETTER_TABLE;
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
		  
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
		  return $inserted_id;
	}
	
	
	public function Store_vcard($nome, $cognome, $middle_name, $addon, $fn, $nickname, $sort_string, $organisation, $departement, $title, $note, $url_home, $url_work, $tel_home1, $tel_home2, $tel_work1, $tel_work2, $tel_car, $tel_additional, $tel_pager, $tel_home_fax, $tel_work_fax, $tel_isdn, $tel_preferred, $company, $work_street, $work_city, $work_region, $work_zip, $work_country, $home_street, $home_city, $home_region, $home_zip, $home_country, $postal_street, $postal_city, $postal_region, $postal_zip, $postal_country, $role, $bday, $mailer, $cell,$key,$anniversary, $caladruri, $caluri, $categories, $clientpidmap, $fburl, $gender, $geo, $impp, $kind, $logo, $member, $photo, $prodid, $related, $sound, $source, $tz, $uid, $xml, $id_group, $user_id){
		
		
		//creo la vcard e inserisco i campi: id_user, nome, cognome, middle_name, addon, fn, sort_string, nickname, type, id_group, cell
		  $query="INSERT INTO ".USER_NEWSLETTER_TABLE." (id_user, nome, cognome, middle_name, addon, fn, sort_string, nickname, type, id_group, cell) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
		  
		  $type="vcard";
		  
		  $stmt->bind_param("issssssssis",$user_id, $nome, $cognome, $middle_name, $addon, $fn, $sort_string, $nickname, $type, $id_group, $cell);
		  
		  $stmt->execute();
		  
		  $inserted_id = $this->sec_mysqli->insert_id;
		  
		   //inserisco nella vcard i campi: organisation, departement, title, note, row_value, url_home, url_work, tel_home1, tel_home2, tel_work1, tel_work2, tel_car, tel_additional, tel_pager, tel_home_fax, tel_work_fax, tel_isdn, tel_preferred
		  $query="UPDATE ".USER_NEWSLETTER_TABLE." SET organisation=?, departement=?, title=?, note=?, url_home=?, url_work=?, tel_home1=?, tel_home2=?, tel_work1=?, tel_work2=?, tel_car=?, tel_additional=?, tel_pager=?, tel_home_fax=?, tel_work_fax=?, tel_isdn=?, tel_preferred=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("sssssssssssssssssi",$organisation, $departement, $title, $note, $url_home, $url_work, $tel_home1, $tel_home2, $tel_work1, $tel_work2, $tel_car, $tel_additional, $tel_pager, $tel_home_fax, $tel_work_fax, $tel_isdn, $tel_preferred, $inserted_id);
		  
		  $stmt->execute();
		  
		  
		  //inserisco nella vcard i campi: company, work_street, work_city, work_region, work_zip, work_country, home_street, home_city, home_region, home_zip, home_country, postal_street, postal_city, postal_region, postal_zip, postal_country, role, bday, mailer
		   $query="UPDATE ".USER_NEWSLETTER_TABLE." SET company=?, work_street=?, work_city=?, work_region=?, work_zip=?, work_country=?, home_street=?, home_city=?, home_region=?, home_zip=?, home_country=?, postal_street=?, postal_city=?, postal_region=?, postal_zip=?, postal_country=?, role=?, bday=?, mailer=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("sssssssssssssssssssi",$company, $work_street, $work_city, $work_region, $work_zip, $work_country, $home_street, $home_city, $home_region, $home_zip, $home_country, $postal_street, $postal_city, $postal_region, $postal_zip, $postal_country, $role, $bday, $mailer, $inserted_id);
		  
		  $stmt->execute();
		  
		  //inserisco nella vcard i campi: key
		  $query="UPDATE ".USER_NEWSLETTER_TABLE." SET varkey=?, anniversary=?, caladruri=?, caluri=?, categories=?, clientpidmap=?, fburl=?, gender=?, geo=?, impp=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("ssssssssssi",$key,$anniversary, $caladruri, $caluri, $categories, $clientpidmap, $fburl, $gender, $geo, $impp, $inserted_id);
		  
		  $stmt->execute();
		  
		  //inserisco kind, logo, member, photo, prodid, related, sound, source, tz, uid, xml,
		  $query="UPDATE ".USER_NEWSLETTER_TABLE." SET kind=?, logo=?, member=?, photo=?, prodid=?, related=?, sound=?, source=?, tz=?, uid=?, xml=? WHERE idusernewsletter=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
			
		  $stmt->bind_param("sssssssssssi",$kind, $logo, $member, $photo, $prodid, $related, $sound, $source, $tz, $uid, $xml, $inserted_id);
		  
		  $stmt->execute();
		  
		  
		  $query="OPTIMIZE TABLE ".USER_NEWSLETTER_TABLE;
		  $stmt = $this->sec_mysqli->prepare($query);
		  
		  
		  
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
		  
		  return $inserted_id;
	}
	
	public function Delete_all_mailing_urls($user_id,$id_row){
		$query="DELETE FROM ".USER_NEWSLETTER_URL_TABLE." WHERE id_user=? AND rel_id=?";
		  $stmt = $this->mysqli->prepare($query);
		  $stmt->bind_param("ii",$user_id, $id_row);
		  $stmt->execute();
	}
	
	public function Delete_all_mailing_emails($user_id,$id_row){
		$query="DELETE FROM ".USER_NEWSLETTER_EMAIL_TABLE." WHERE id_user=? AND rel_id=?";
		  $stmt = $this->mysqli->prepare($query);
		  $stmt->bind_param("ii",$user_id, $id_row);
		  $stmt->execute();
	}
	
	public function Store_vcard_urls($user_id,$id_group,$inserted_id,$url,$is_main){
		$query="INSERT INTO ".USER_NEWSLETTER_URL_TABLE." (id_user, id_group, rel_id, is_main, row_value) VALUES(?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		  $stmt->bind_param("iiiis",$user_id, $id_group, $inserted_id, $is_main, $url);
		  
		  $stmt->execute();
	}
	
	public function Store_vcard_emails($user_id,$id_group,$inserted_id,$email,$is_main){
		$query="INSERT INTO ".USER_NEWSLETTER_EMAIL_TABLE." (id_user, id_group, rel_id, is_main, row_value) VALUES(?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		  $stmt->bind_param("iiiis",$user_id, $id_group, $inserted_id, $is_main, $email);
		  $stmt->execute();
	}
	
	public function Store_vcard_url($user_id,$id_group,$inserted_id,$url,$is_main){
		$query="INSERT INTO ".USER_NEWSLETTER_URL_TABLE." (id_user, id_group, rel_id, is_main, row_value) VALUES(?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		  $stmt->bind_param("iiiis",$user_id,$id_group, $inserted_id, $is_main, $url);
		  $stmt->execute();
	}
	
	public function Mod_newsletter_row($row_value,$nome,$cognome,$cell,$id_row){
		
		  $stmt = $this->sec_mysqli->prepare("UPDATE ".USER_NEWSLETTER_TABLE." SET nome=?, cognome=?, cell =?, row_value =?, type =?  WHERE  idusernewsletter=?");
		  $type="email";
		  $stmt->bind_param("sssssi",$nome,$cognome,$cell,$row_value,$type,$id_row);
		  $stmt->execute();
		  $stmt->close();
	}
	
	public function Add_newsletter_import_group($user_id){
		  $query="INSERT INTO ".USER_NEWSLETTER_GROUP_TABLE." (id_user,name) VALUES(?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		  $nome = "contatti importati ".date("d/m/Y H:i:s");
		  $stmt->bind_param("is",$user_id,$nome);
		  $stmt->execute();
		  $inserted_id = $this->sec_mysqli->insert_id;
		  $stmt->close();
		  return $inserted_id;
	}
	public function Add_newsletter_group($nome,$user_id){
		  $query="INSERT INTO ".USER_NEWSLETTER_GROUP_TABLE." (id_user,name) VALUES(?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("is",$user_id,$nome);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	public function Delete_newsletter_row($id ,$user_id){
		
		  $query="DELETE FROM ".USER_NEWSLETTER_TABLE." WHERE idusernewsletter = ? AND id_user= ?";
		  $stmt = $this->mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("ii",$id,$user_id);
		  
		  $stmt->execute();
		  $query="DELETE FROM ".USER_NEWSLETTER_EMAIL_TABLE." WHERE rel_id = ? AND id_user= ?";
		  $stmt = $this->mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("ii",$id,$user_id);
		  
		  $stmt->execute();
		  
		   $query="DELETE FROM ".USER_NEWSLETTER_URL_TABLE." WHERE rel_id = ? AND id_user= ?";
		  $stmt = $this->mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("ii",$id,$user_id);
		  
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	public function Move_newsletter_row($id ,$id_group,$user_id){
			$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_NEWSLETTER_TABLE." SET id_group=? WHERE idusernewsletter=?");
			$stmt->bind_param("ii",$id_group,$id);
			$stmt->execute();
			$stmt->close();
	}
	public function Delete_newsletter_group($id ,$user_id){
		
		  $query="DELETE FROM ".USER_NEWSLETTER_GROUP_TABLE." WHERE idusernewslettergroup = ? AND id_user= ?";
		  $stmt = $this->mysqli->prepare($query);
		  $stmt->bind_param("ii",$id,$user_id);
		  $stmt->execute();

		  $query="DELETE FROM ".USER_NEWSLETTER_TABLE." WHERE id_group = ? AND id_user= ?";
		  $stmt = $this->mysqli->prepare($query);
		  $stmt->bind_param("ii",$id,$user_id);
		  $stmt->execute();
		  
		  
		  $query="DELETE FROM ".USER_NEWSLETTER_EMAIL_TABLE." WHERE id_group = ? AND id_user= ?";
		  $stmt = $this->mysqli->prepare($query);
		  $stmt->bind_param("ii",$id,$user_id);
		  
		  $stmt->execute();
		  
		  $query="DELETE FROM ".USER_NEWSLETTER_URL_TABLE." WHERE id_group = ? AND id_user= ?";
		  $stmt = $this->mysqli->prepare($query);
		  $stmt->bind_param("ii",$id,$user_id);
		  
		  $stmt->execute();

		  
		  $stmt->close();
		  
		  
	}
	public function Rename_newsletter_group($name ,$group_id,$user_id){
		$query="UPDATE ".USER_NEWSLETTER_GROUP_TABLE." SET name = ? WHERE idusernewslettergroup = ? AND id_user=?";
		$stmt = $this->sec_mysqli->prepare($query);
		$stmt->bind_param("sii",$name,$group_id,$user_id);
		$stmt->execute();
		$stmt->close();
	}
	public function Set_mailing_contacts_old($user_id){
		$query="UPDATE ".USER_NEWSLETTER_TABLE." SET is_new = 0 WHERE id_user=?";
		$stmt = $this->sec_mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		$stmt->close();
	}
	
	public function Move_rows_up($row_id,$row_num,$user_id){
		  $query="UPDATE ".USER_EVIDENZA_TABLE." SET row_num = ? WHERE row_num = ? AND id_user=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		  $old_row_num=$row_num;
		  $new_row_num=$row_num-1;
		  $stmt->bind_param("iii",$old_row_num,$new_row_num,$user_id);
		  $stmt->execute();
		  
		  $query="UPDATE ".USER_EVIDENZA_TABLE." SET row_num = ? WHERE iduser_evidenza = ? ";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("ii",$new_row_num,$row_id);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	
	public function Move_rows_down($row_id,$row_num,$user_id){
		  $query="UPDATE ".USER_EVIDENZA_TABLE." SET row_num = ? WHERE row_num = ? AND id_user=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $old_row_num=$row_num;
		  $new_row_num=$row_num+1;
		  $stmt->bind_param("iii",$old_row_num,$new_row_num,$user_id);
		  $stmt->execute();
		  
		  $query="UPDATE ".USER_EVIDENZA_TABLE." SET row_num = ? WHERE iduser_evidenza = ?";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("ii",$new_row_num,$row_id);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	
	public function Move_contact_up($row_id,$row_num,$user_id){
		  $query="UPDATE ".USER_CONTACT_TABLE." SET row_num = ? WHERE row_num = ? AND id_user=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $old_row_num=$row_num;
		  $new_row_num=$row_num-1;
		  $stmt->bind_param("iii",$old_row_num,$new_row_num,$user_id);
		  $stmt->execute();
		  
		  $query="UPDATE ".USER_CONTACT_TABLE." SET row_num = ? WHERE idusercontact = ? AND id_user=?  ";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("iii",$new_row_num,$row_id,$user_id);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	public function Move_contact_down($row_id,$row_num,$user_id){
		  $query="UPDATE ".USER_CONTACT_TABLE." SET row_num = ? WHERE row_num = ? AND id_user=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $old_row_num=$row_num;
		  $new_row_num=$row_num+1;
		  $stmt->bind_param("iii",$old_row_num,$new_row_num,$user_id);
		  $stmt->execute();
		  
		  $query="UPDATE ".USER_CONTACT_TABLE." SET row_num = ? WHERE idusercontact = ? AND id_user=?  ";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("iii",$new_row_num,$row_id,$user_id);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	
	public function delete_contact_row($row_num,$index_delete,$user_id){
		$query="DELETE FROM ".USER_CONTACT_TABLE." WHERE id_user=? AND idusercontact = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("ii",$user_id,$index_delete);
		$stmt->execute();
		
		
		$query = "SELECT COUNT(row_value) as conta FROM ".USER_CONTACT_TABLE." WHERE id_user=?";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
			
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_CONTACT_TABLE -- USER ID: ".$user_id);
			}else{   
				$conta = $row["conta"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		$row_num++;
		if($row_num<($conta+1)){
			$row_num++;
			//rownum 2
			for($i=$row_num;$i<=($conta+1);$i++){
				$query="UPDATE ".USER_CONTACT_TABLE." SET row_num=? WHERE row_num=? AND id_user = ?";
				$stmt = $this->sec_mysqli->prepare($query);
				
			   
				
				$j=$i-1;
				$stmt->bind_param("iii",$j,$i,$user_id);
				$stmt->execute();
			}
		}
		
		$stmt->close();
		
		
	}
	public function update_contact_row($index,$new_row_value,$new_row_type,$user_id){
		$query="UPDATE ".USER_CONTACT_TABLE." SET row_value=?,type=? WHERE id_user=? AND idusercontact = ?";
		$stmt = $this->sec_mysqli->prepare($query);
		
	   
		
		$stmt->bind_param("ssii",$new_row_value,$new_row_type,$user_id,$index);
		$stmt->execute();
		$stmt->close();
		
		
	}
	
	
	public function Add_social_element($value,$type,$favicon,$title,$user_id){
		  $query = "SELECT COUNT(value) as conta FROM ".USER_SOCIAL_TABLE." WHERE id_user=?";
		  if($stmt = $this->sec_mysqli->prepare($query)){
			  $stmt->bind_param('i',$user_id);
			  $row = $this->Execute_and_fetch_data_assoc($stmt);
				
			  if($row==NULL){
					$this->Show_error("Problema TABELLA USER_SOCIAL_TABLE -- USER ID: ".$user_id);
			  }else{   
					$row_num = $row["conta"];
			  }
				 $stmt->free_result();
				 $stmt->close();
		  }
		  
		  $query="INSERT INTO ".USER_SOCIAL_TABLE." (id_user,row_num,value,type,title,favicon) VALUES(?,?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $row_num++;
		  $stmt->bind_param("iissss",$user_id,$row_num,$value,$type,$title,$favicon);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	
	public function Update_social_element($value,$type,$favicon,$title,$index,$user_id){
		$query="UPDATE ".USER_SOCIAL_TABLE." SET value=?,type=?,favicon=?,title=? WHERE id_user = ? AND idusersocial=?";
		$stmt = $this->sec_mysqli->prepare($query);
		
	   
		
		$stmt->bind_param("ssssii",$value,$type,$favicon,$title,$user_id,$index);
		$stmt->execute();
		  
		$stmt->close();
		
		
	}
	
	public function Delete_social_element($row_num,$index_delete,$user_id){
		$query="DELETE FROM ".USER_SOCIAL_TABLE." WHERE id_user=? AND idusersocial = ?";
		$stmt = $this->mysqli->prepare($query);
		
		
		$stmt->bind_param("ii",$user_id,$index_delete);
		$stmt->execute();
		
		$query = "SELECT COUNT(value) as conta FROM ".USER_SOCIAL_TABLE." WHERE id_user=?";
		  if($stmt = $this->sec_mysqli->prepare($query)){
			  $stmt->bind_param('i',$user_id);
			  $row = $this->Execute_and_fetch_data_assoc($stmt);
				
			  if($row==NULL){
					$this->Show_error("Problema TABELLA USER_SOCIAL_TABLE -- USER ID: ".$user_id);
			  }else{   
					$conta = $row["conta"];
			  }
			  $stmt->free_result();
			  $stmt->close();
		  }
		
		$row_num++;
		if($row_num<($conta+1)){
			$row_num++;
			//rownum 2
			for($i=$row_num;$i<=($conta+1);$i++){
				$query="UPDATE ".USER_SOCIAL_TABLE." SET row_num=? WHERE row_num=? AND id_user = ?";
				$stmt = $this->sec_mysqli->prepare($query);
				$j=$i-1;
				$stmt->bind_param("iii",$j,$i,$user_id);
				$stmt->execute();
			}
		}
		
		$stmt->close();
		
		
		
		
	}
	
	public function Move_social_up($row_id,$row_num,$user_id){
		
		  $query="UPDATE ".USER_SOCIAL_TABLE." SET row_num = ? WHERE row_num = ? AND id_user=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $old_row_num=$row_num;
		  $new_row_num=$row_num-1;
		  $stmt->bind_param("iii",$old_row_num,$new_row_num,$user_id);
		  $stmt->execute();
		  
		  $query="UPDATE ".USER_SOCIAL_TABLE." SET row_num = ? WHERE idusersocial = ? AND id_user=?  ";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("iii",$new_row_num,$row_id,$user_id);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	
	public function Move_social_down($row_id,$row_num,$user_id){
		
		  $query="UPDATE ".USER_SOCIAL_TABLE." SET row_num = ? WHERE row_num = ? AND id_user=?";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $old_row_num=$row_num;
		  $new_row_num=$row_num+1;
		  $stmt->bind_param("iii",$old_row_num,$new_row_num,$user_id);
		  $stmt->execute();
		  
		  $query="UPDATE ".USER_SOCIAL_TABLE." SET row_num = ? WHERE idusersocial = ? AND id_user=?  ";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $stmt->bind_param("iii",$new_row_num,$row_id,$user_id);
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	
	public function Update_profilo($user_id, $new_profilo_professione, $new_profilo_cellulare,$new_profilo_email,&$professione,&$cellulare,$new_bv_professione,$new_bv_cellulare,$new_bv_email,&$bv_cellulare,&$bv_professione){
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET Professione=? WHERE ".USER_TABLE_ID."=?");
		
		$stmt->bind_param("si", $new_profilo_professione, $user_id);
		
		$stmt->execute();
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_DATA_TABLE." SET cellulare=?,email_bv=? WHERE id_user=?");
	
		
		$stmt->bind_param("sssi", $new_profilo_cellulare,$new_profilo_email,$new_profilo_email, $user_id);
		
		$stmt->execute();
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_BV_TABLE." SET cellulare=?,email=?,professione=? WHERE id_user=?");
		
		$stmt->bind_param("iiii", $new_bv_cellulare,$new_bv_email, $new_bv_professione, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
		$professione = $new_profilo_professione;
		$cellulare = $new_profilo_cellulare;
		$bv_professione = $new_bv_professione;
		$bv_cellulare = $new_bv_cellulare;
	}
	
	public function Evidenza_save_row($user_id,$id_row, $title,$subtitle,$desc,$file){
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_EVIDENZA_TABLE." SET title=?,subtitle=?,description=?,file=? WHERE id_user=? AND iduser_evidenza = ?");
	
		
		$stmt->bind_param("ssssii", $title,$subtitle,$desc,$file, $user_id,$id_row);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Delete_single_news($index_delete,$row_num,$user_id){
		$query="DELETE FROM ".USER_EVIDENZA_TABLE." WHERE iduser_evidenza=?";
		$stmt = $this->mysqli->prepare($query);
		
		$stmt->bind_param("i",$index_delete);
		$stmt->execute();
		
		
		$query = "SELECT COUNT(title) as conta FROM ".USER_EVIDENZA_TABLE." WHERE id_user=?";
		if($stmt = $this->sec_mysqli->prepare($query)){
			  $stmt->bind_param('i',$user_id);
			  $row = $this->Execute_and_fetch_data_assoc($stmt);
				
			  if($row==NULL){
					$this->Show_error("Problema TABELLA USER_EVIDENZA_TABLE -- USER ID: ".$user_id);
			  }else{   
					$conta = $row["conta"];
			  }
			  $stmt->free_result();
			  $stmt->close();
		  }
		
		
		if($row_num<($conta+1)){
			$row_num++;
			
			for($i=$row_num;$i<=($conta+1);$i++){
				$query="UPDATE ".USER_EVIDENZA_TABLE." SET row_num=? WHERE row_num=? AND id_user = ?";
				$stmt = $this->sec_mysqli->prepare($query);
				
			   
				
				$j=$i-1;
				$stmt->bind_param("iii",$j,$i,$user_id);
				$stmt->execute();
			}
		}
				
		
		
		$stmt->close();
		
		
		
	}
	
	public function Create_new_news($user_id,$user_news_rows_count){
		$query="INSERT INTO ".USER_EVIDENZA_TABLE." (id_user,row_num) VALUES(?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		$stmt->bind_param("ii",$user_id,$user_news_rows_count);
		$stmt->execute();
		$new_news_id = $this->sec_mysqli->insert_id;
		$stmt->close();
		return $new_news_id;
	}
	public function Delete_not_completed_news($user_id){
		$query="DELETE FROM ".USER_EVIDENZA_TABLE." WHERE done=0 AND id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Evidenza_save_data($id_row,$data,$sendto,$check_alt,$user_id){
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_EVIDENZA_TABLE." SET data=?,sendto=?,check_alt=?,done=1 WHERE id_user=? AND iduser_evidenza = ?");
		
		$stmt->bind_param("ssiii",$data,$sendto,$check_alt,$user_id,$id_row);
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Update_evidenza_sent($news_id,$user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_EVIDENZA_TABLE." SET sent=1 WHERE iduser_evidenza=?");
		$stmt->bind_param("i",$news_id);
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Evidenza_delete_post_pubblica($user_id){
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_EVIDENZA_TABLE." SET data=? WHERE id_user=?");
		
		$data="";
		
		$stmt->bind_param("si",$data,$user_id);
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	public function Evidenza_delete_all($user_id){
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_EVIDENZA_TABLE." SET title=?,description=?,file=?,data=? WHERE id_user=?");
		$title="";
		$description="";
		$file="";
		$data="";
		
		$stmt->bind_param("ssssi",$title,$description,$file,$data,$user_id);
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Update_main_photo($photo_name, $user_id, &$photo1_path){
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_DATA_TABLE." SET photo_1=? WHERE id_user=?");
		
		
		$stmt->bind_param("si",$photo_name, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
		//aggiorno i dati della scheda
		$photo1_path = $photo_name;
	}
	
	public function Update_slide_photo($photo_name,$photo_big_name, $user_id, $index){
		$query = "SELECT path_photo FROM ".USER_SLIDE_TABLE." WHERE id_user= ? AND id_photo_num=?";
		if($stmt = $this->sec_mysqli->prepare($query)){
			  $stmt->bind_param('ii',$user_id,$index);
			  $res = $this->Execute_and_fetch_data_assoc($stmt);
			
			  $stmt->free_result();
			  $stmt->close();
		  }
		
		if($res!=NULL){
			$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_SLIDE_TABLE." SET path_photo=?,path_photo_hd=? WHERE id_user=? AND id_photo_num=?");
			
			
			$stmt->bind_param("ssii",$photo_name,$photo_big_name, $user_id, $index);
			
			$result = $stmt->execute();
		}
		else{
			$query="INSERT INTO ".USER_SLIDE_TABLE." (id_user,id_photo_num,path_photo,path_photo_hd) VALUES(?,?,?,?)";
			$stmt = $this->sec_mysqli->prepare($query);
			
			$stmt->bind_param("iiss",$user_id,$index,$photo_name,$photo_big_name);
			$stmt->execute();
		}
		$stmt->close();
		
		
	}
	public function Add_slide_photo($photo_name, $user_id , $photo_path, &$user_photo_slide_path , $index){
		
		$query="INSERT INTO ".USER_SLIDE_TABLE." (id_user,id_photo_num,path_photo) VALUES(?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		
		$stmt->bind_param("iis",$user_id,$index,$photo_name);
		$stmt->execute();
		
		
		$stmt->close();
		
		
		
		//aggiorno i dati della card
		$user_photo_slide_path[$index] = $photo_path;
		
	}
	public function Recreate_photo_slide( $user_id , $user_photo_slide_path,$user_photo_slide_big_path){
		
		$query="DELETE FROM ".USER_SLIDE_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		
	   
		
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		 for($i=0;$i<(count($user_photo_slide_path)-1);$i++){
			  $query="INSERT INTO ".USER_SLIDE_TABLE." (id_user,id_photo_num,path_photo,path_photo_hd) VALUES(?,?,?,?)";
			  $stmt = $this->sec_mysqli->prepare($query);
			  
			  $stmt->bind_param("iiss",$user_id,$i,$user_photo_slide_path[$i],$user_photo_slide_big_path[$i]);
			  $stmt->execute();
			  
		  }
		  
		  $stmt->close();
		  
		  
		  
	}
	
	public function Isusername($user){
		
		$query = "SELECT ".USER_TABLE_ID." FROM ".USER_TABLE." WHERE Username= ?";
		
		
		if(!$stmt = $this->sec_mysqli->prepare($query))
		{
			print "Failed to prepare statement\n";
		}
		else
		{
			$stmt->bind_param("s", $user);
			$stmt->execute();
			$result = $stmt->bind_result($id);
			$stmt->fetch();
			if($id==NULL){
				$stmt->close();
				
				return 1;
			}else{
				$stmt->close();
				
				return 0;
			}	
			
			
		}
	}
	
	public function Update_bv($user_id,$bv_check_cellulare,$bv_check_email,$bv_check_tmg_email,$bv_check_professione,$bv_cellulare,$bv_email,$bv_professione,$personal_in_bv_web){
		
		if($bv_check_cellulare  == 'true'){
			$bv_check_cellulare=1;	
		}else{
			$bv_check_cellulare=0;
		}
		if($bv_check_email  == 'true'){
			$bv_check_email=1;	
		}else{
			$bv_check_email=0;
		}
		if($bv_check_tmg_email  == 'true'){
			$bv_check_tmg_email=1;	
		}else{
			$bv_check_tmg_email=0;
		}
		if($bv_check_professione  == 'true'){
			$bv_check_professione=1;	
		}else{
			$bv_check_professione=0;
		}
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_BV_TABLE." SET cellulare=?,email=?,email_tmg=?, professione=?, web=?  WHERE id_user=?");
		
		
		$stmt->bind_param("iiiiii",$bv_check_cellulare,$bv_check_email,$bv_check_tmg_email,$bv_check_professione,$personal_in_bv_web, $user_id);
		
		$stmt->execute();
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_DATA_TABLE." SET cellulare=?, email_bv=?, alt_professione=?  WHERE id_user=?");
		
		
		$stmt->bind_param("sssi",$bv_cellulare,$bv_email,$bv_professione,$user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Update_europ_cv_step1($nomecognome, $sottotitolo, $sesso, $cittadinanza, $dataluogo, $user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_CURREUROP_TABLE." SET nomecognome=?, sottotitolo=?, sesso=?, cittadinanza=?, dataluogo=? WHERE id_user=?");
		
		$stmt->bind_param("sssssi", $nomecognome,  $sottotitolo,  $sesso,  $cittadinanza, $dataluogo, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Update_europ_cv_step2($istruzformaz, $esplavorativa, $user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_CURREUROP_TABLE." SET istruzformaz=?, esplavorativa=? WHERE id_user=?");
		
		
		$stmt->bind_param("ssi",$istruzformaz, $esplavorativa,$user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	public function Update_europ_cv_step3($linguestraniere, $madrelingua, $capacitacompet, $compinformatiche, $comprelsoc, $comporganiz, $user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_CURREUROP_TABLE." SET linguestraniere=?, madrelingua=?, capacitacompet=?, compinformatiche=?, comprelsoc=?, comporganiz=? WHERE id_user=?");
		
		
		
		$stmt->bind_param("ssssssi",$linguestraniere, $madrelingua, $capacitacompet, $compinformatiche, $comprelsoc, $comporganiz, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
		
	}
	public function Update_europ_cv_step4($compartistiche, $comptecniche, $comprelativeallav, $altrecompedinteressi, $user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_CURREUROP_TABLE." SET compartistiche=?, comptecniche=?, comprelativeallav=?, altrecompedinteressi=? WHERE id_user=?");
		
		
		$stmt->bind_param("ssssi",$compartistiche, $comptecniche, $comprelativeallav, $altrecompedinteressi, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Update_europ_cv_step5($patente, $ulteriori, $user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_CURREUROP_TABLE." SET patente=?, ulteriori=? WHERE id_user=?");
		
		
		$stmt->bind_param("ssi",$patente, $ulteriori, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Update_impostazioni_password( $user_id,$new_pass = NULL){
		
		if($new_pass!=NULL){
			$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET Password=? WHERE ".USER_TABLE_ID."=?");
			
			$stmt->bind_param("si",md5($new_pass), $user_id);
			
			$stmt->execute();	
		}
		$stmt->close();
		
	}
	public function Update_impostazioni_curr($user_id,$change_opt_curr){
		
		if($change_opt_curr=="true")
			$change_opt_curr=1;
		else
			$change_opt_curr=0;
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_DATA_TABLE." SET curr=? WHERE id_user=?");
		
		$stmt->bind_param("ii",$change_opt_curr, $user_id);
			
		$stmt->execute();
		
		$stmt->close();
		
	}
	
	
	public function Change_card_colour($colour, $user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_DATA_TABLE." SET colore_card=? WHERE id_user=?");
		
		
		$stmt->bind_param("si", $colour, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
	}
	
	
	public function Add_private_folder($folder_name,$folder_pass,$user_id){
		
		$query="INSERT INTO ".USER_FILEBOX_TABLE." (folder_name,folder_pass,id_user) VALUES(?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		
		$stmt->bind_param("ssi",$folder_name,$folder_pass,$user_id);
		$stmt->execute();
		
		
		$stmt->close();
		
		
	}
	public function delete_folder($name,$user_id){
		
		$query="DELETE FROM ".USER_FILEBOX_TABLE." WHERE id_user=? AND folder_name=?";
		$stmt = $this->mysqli->prepare($query);
		
		
		
		$stmt->bind_param("is",$user_id,$name);
		$stmt->execute();
		
		
		$stmt->close();
		
		
	}
	public function Rename_folder($name,$new_name,$user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_FILEBOX_TABLE." SET folder_name=? WHERE id_user=? AND folder_name=?");
		
		$stmt->bind_param("sis",$new_name, $user_id,$name);
		$stmt->execute();
		$stmt->close();
		
		
		$stmt->close();
		
		
	}
	public function Create_new_user($username,$email,$password,$nome,$cognome,$professione,$id_referente,$idTransazione,$level,$sfida_corrente,$paypal_email,$data,$society,$is_giovane,$codfiscale,$status,$alternative_url){
		
		$query="INSERT INTO ".USER_TABLE." (Username, Email, Password, Nome, Cognome, Professione, ID_Referente, idTransazione, Level, sfida_corrente, paypal_email,data,society,is_giovane,codfiscale,status,alternative_url) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		$stmt->bind_param("ssssssssisssiisis",$username,$email,$password,$nome,$cognome,$professione,$id_referente,$idTransazione,$level,$sfida_corrente,$paypal_email,$data,$society,$is_giovane,$codfiscale,$status,$alternative_url);
		$stmt->execute();
		$user_id = $this->sec_mysqli->insert_id;
		
		$stmt->close();
		
		
		return $user_id;
	}
	
	public function Get_user_referente(&$user_referente,&$email_referente,&$nome_referente,&$cognome_referente,$id_referente){
		
		$query = "SELECT * FROM ".USER_TABLE." WHERE ".USER_TABLE_ID."= ?";
		if($stmt = $this->sec_mysqli->prepare($query)){
			  $stmt->bind_param('i',$id_referente);
			  $row = $this->Execute_and_fetch_data_assoc($stmt);
				
			  if($row==NULL){
					$this->Show_error("Problema TABELLA USER_TABLE");
			  }else{   
					$user_referente = $row["Username"];
					$email_referente = $row["Email"];
					$nome_referente = $row["Nome"];
					$cognome_referente = $row["Cognome"];
			  }
			  $stmt->free_result();
			  $stmt->close();
		  }
	}
	
	public function Delete_temp_user($idTransazione){
		
		$query="DELETE FROM ".USER_TEMP_TABLE." WHERE idTransazione=?";
		$stmt = $this->mysqli->prepare($query);
		
		
		
		$stmt->bind_param("s",$idTransazione);
		$stmt->execute();
		
		
		$stmt->close();
		
		
	}
	public function Set_user_table($user_id,$email,$username){
		
		//TABLE DATA
		$query="INSERT INTO ".USER_DATA_TABLE." (id_user, photo_1, curriculum,curr,colore_card) VALUES(?,?,?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		$photo_1 = "../image/default_photo/main.png";
		$curriculum = "";
		$curr=1;
		$colore_card = "brown";
		
		$stmt->bind_param("issis",$user_id,$photo_1, $curriculum,$curr,$colore_card);
		$stmt->execute();
		
		//TABLE SLIDE
		for($i=0;$i<4;$i++){
			$query="INSERT INTO ".USER_SLIDE_TABLE." (id_user, path_photo, id_photo_num) VALUES(?,?,?)";
			$stmt = $this->sec_mysqli->prepare($query);
			
			$path_photo = "../../image/default_photo/foto_slide_".($i+1).".png";
			$id_photo_num = $i;
	
			
			$stmt->bind_param("iss",$user_id,$path_photo, $id_photo_num);
			$stmt->execute();
		}
		
		//TABLE BV
		$query="INSERT INTO ".USER_BV_TABLE." (id_user, cellulare, professione) VALUES(?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		$nome_cognome = 0;
		$cellulare = 0;
		$professione = 1;
		
		$stmt->bind_param("iii",$user_id,$cellulare, $professione);
		$stmt->execute();
		
		//TABLE CURREUROP
		$query="INSERT INTO ".USER_CURREUROP_TABLE." (id_user) VALUES(?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		
		
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		
		//TABLE SIMPLE CURRICULUM
		$query="INSERT INTO ".USER_SIMPLE_CURR_TABLE." (id_user) VALUES(?)";
		$stmt = $this->sec_mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		
	    $query="INSERT INTO ".USER_CONTACT_TABLE." (id_user,row_num,row_value,type) VALUES(?,?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		
		$row_num = 1;
		$value = $username."@topmanagergroup.com";
		$type = 'mail';
		$stmt->bind_param("iiss",$user_id,$row_num,$value,$type);
		$stmt->execute();
		
		$query="INSERT INTO ".USER_NEWSLETTER_GROUP_TABLE." (id_user,name,blocked) VALUES(?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		$name = "richieste di contatto";
		$blocked = 1;
		$stmt->bind_param("isi",$user_id,$name,$blocked);
		$stmt->execute();
		
		$query="INSERT INTO ".USER_NEWSLETTER_GROUP_TABLE." (id_user,name,blocked) VALUES(?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		$name = "contatti";
		$blocked = 0;
		$stmt->bind_param("isi",$user_id,$name,$blocked);
		$stmt->execute();
		
		$stmt->close();
		
		$query="INSERT INTO ".USER_PROMOTER_TABLE." (id_user) VALUES(?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		
		
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="INSERT INTO ".USER_POSITION_TABLE." (id_user) VALUES(?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		
		
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		
	}
	public function Change_password($password,$user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET Password=? WHERE ".USER_TABLE_ID."=?");
		
		$stmt->bind_param("si",md5($password), $user_id);
		$stmt->execute();
		$stmt->close();
		
	}
	
	public function delete_me($user_id,$id_referente,$status,$eliminazione_immediata,$username){
		if($user_id==0||$user_id==NULL||$user_id==""){
			return;	
		}
		
		$query="DELETE FROM ".USER_TABLE." WHERE ".USER_TABLE_ID."=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_DATA_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_SLIDE_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_BV_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_CONTACT_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_CURREUROP_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_SIMPLE_CURR_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_FILEBOX_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_PROMOTER_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_NEWSLETTER_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_NEWSLETTER_GROUP_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		$query="DELETE FROM ".USER_EVIDENZA_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();

		
		$query="DELETE FROM ".USER_POSITION_TABLE." WHERE id_user=?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i",$user_id);
		$stmt->execute();
		
		//Qui quando eliminavo l'utente decrementavo i sub_user del referente ma essi verranno decrementati dopo un'anno dall'ultima iscrizione dell'utente
		
		
		//Quando elimino un utente che ha status == 3 quindi "NON PAGATO" oppure se lo elimino in modo immediato dal pannello amministrazione, elimino anche da tabella SUB_USER e decremento la colonna sub_user dalla tabella PROMOTER del referente
		if($status == 3 || $eliminazione_immediata!=NULL){
			if($status == 3){
				echo "Eliminazione immediata dell'utente con status NON PAGATO";
			}else if($eliminazione_immediata!=NULL){
				echo "Eliminazione immediata dell'utente";
			}
			
			//elimino dalla tabella SUB_USER
			$query="DELETE FROM ".SUB_USER_TABLE." WHERE username=?";
			$stmt = $this->mysqli->prepare($query);
			
			$stmt->bind_param("s",$username);
			$stmt->execute();
			
			
			//prendo il numero dei sub_user del referente
			$query = "SELECT * FROM ".USER_PROMOTER_TABLE." WHERE id_user= ? ";
			if($stmt = $this->sec_mysqli->prepare($query)){
				$stmt->bind_param('i',$id_referente);
				$row = $this->Execute_and_fetch_data_assoc($stmt);
			   if($row==NULL){
				$this->Show_error("Problema USER_PROMOTER_TABLE ");
				}else{
					$num_subuser = $row["num_subuser"];
			
			   }
			   $stmt->free_result();
			   $stmt->close();
			}
			//decremento il numero dei sub_user del referente
			if($num_subuser!=0){
				$num_subuser--;
			}
			
			
			$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_PROMOTER_TABLE." SET num_subuser=? WHERE id_user=?");
			
			
			$stmt->bind_param("ii", $num_subuser, $id_referente);
			
			$stmt->execute();
			$stmt->close();
			
			
		}
	}
	public function Change_folder_password($folder_name,$folder_pass,$user_id){
		
		  $stmt = $this->sec_mysqli->prepare("UPDATE ".USER_FILEBOX_TABLE." SET folder_pass=? WHERE folder_name=? AND id_user=?");
		  
		  $stmt->bind_param("ssi",$folder_pass,$folder_name,$user_id);
		  
		  $stmt->execute();
		  
		  $stmt->close();
		  
		  
	}
	public function invia_sfida($sfida,$user){
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET sfida_corrente=? WHERE Username=?");
		$stmt->bind_param("ss",$sfida,$user);
		$stmt->execute();
		$stmt->close();
	}
	public function elimina_sfida($user){
		$this->sec_mysqli = new mysqli($this->db_host, $this->sec_db_user , $this->sec_db_password, $this->db_database);
        $this->sec_mysqli->set_charset('utf8');
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET sfida_corrente=NULL WHERE Username=?");
		
		$stmt->bind_param("s",$user);
		
		$stmt->execute();
		
		$stmt->close();
	}
	public function Get_stmt_login(){
		$query = "SELECT ID, Username, Password, Salt FROM ".USER_TABLE." WHERE Username = ? AND sfida_corrente=? LIMIT 1";
		return $this->sec_mysqli->prepare($query);
	}
    public function Get_stmt_logged(){
        $query = "SELECT Password FROM ".USER_TABLE." WHERE ".USER_TABLE_ID." = ? LIMIT 1";
        return $this->sec_mysqli->prepare($query);
    }
	public function Check_brute($user_id){
		// Recupero il timestamp
		$now = time();
		// Vengono analizzati tutti i tentativi di login a partire dalle ultime due ore.
		$valid_attempts = $now - (2 * 60 * 60);
		if ($stmt = $this->sec_mysqli->prepare("SELECT time FROM ".LOGIN_ATTEMPTS." WHERE user_id = ? AND time > '$valid_attempts'")) {
			$stmt->bind_param('i', $user_id);
			// Eseguo la query creata.
			$stmt->execute();
			$stmt->store_result();
			// Verifico l'esistenza di più di 5 tentativi di login falliti.
			if($stmt->num_rows > 5) {
				return true;
			} else {
				return false;
			}
		}
	}
	public function Insert_login_attempt($user_id,$now){
		$stmt = $this->sec_mysqli->prepare("INSERT INTO ".LOGIN_ATTEMPTS." (user_id, time) VALUES (?, ?)");

		$stmt->bind_param("ss", $user_id, $now);

		$stmt->execute();

		$stmt->close();
	}
	public function verifica_login($user,$password_utente,$sfida){
		
		$query = "SELECT ".USER_TABLE_ID.",Cognome,Username FROM ".USER_TABLE." WHERE Username=? AND sfida_corrente=? AND MD5(CONCAT(?,Password))=?";
		if($stmt = $this->sec_mysqli->prepare($query)){
			   $stmt->bind_param('ssss',$user,$sfida,$sfida,$password_utente);
			    $row = $this->Execute_and_fetch_data_assoc($stmt);
			   $stmt->free_result();
			   $stmt->close();
		}
		if($row["ID"]== "" || $row["Cognome"] == "" || $row["Username"] == ""){
			return false;
		}else{
			return array("ID" => $row["ID"],"Cognome" => $cognome = $row["Cognome"],"Username" => $row["Username"]);
		}
	}
	public function Set_cookie_resta_collegato($hash,$user){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET cod_cookie=? WHERE Username=?");
		
		$stmt->bind_param("ss",$hash,$user);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	public function Get_username_from_cookie($cod_cookie){
		$stmt = $this->sec_mysqli->prepare("SELECT Username FROM ".USER_TABLE." WHERE cod_cookie=?");
		
		$stmt->bind_param("s",$cod_cookie);
		
		$stmt->execute();
		
		$result = $stmt->bind_result($username);
		$stmt->fetch();
		if($username==NULL){
			$stmt->close();
			
			return false;
		}else{
			$stmt->close();
			
			return $username;
		}
		
		$stmt->close();
		
		
	}

	public function Get_user_id($email){
		
		$query = "SELECT ".USER_TABLE_ID." FROM ".USER_TABLE." WHERE Email= ?";

		if(!$stmt = $this->sec_mysqli->prepare($query))
		{
			print "Failed to prepare statement\n";
		}
		else
		{
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$result = $stmt->bind_result($id);
			$stmt->fetch();
			if($id==NULL){
				$stmt->close();
				
				return false;
			}else{
				$stmt->close();
				
				return $id;
			}
		}
	}
	
	function GetPromoterData(&$num_subuser,&$total_ammount,&$total_confirmed,&$total_payed,$user_id){
		
		$query = "SELECT * FROM ".USER_PROMOTER_TABLE." WHERE id_user= '".$user_id."'";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$user_id);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_PROMOTER_TABLE -- USER ID: ".$user_id);
			}else{
				$num_subuser = $row["num_subuser"];
				$total_ammount = $row["total_ammount"];
				$total_payed = $row["total_payed"];
				$total_confirmed = $row["total_confirmed"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
	}
	function Update_promoter($id_referente,$is_giovane,$preview){
		
		$query = "SELECT * FROM ".USER_PROMOTER_TABLE." WHERE id_user= '".$id_referente."'";
		if($stmt = $this->sec_mysqli->prepare($query)){
		    $stmt->bind_param('i',$id_referente);
			$row = $this->Execute_and_fetch_data_assoc($stmt);
		   if($row==NULL){
			$this->Show_error("Problema TABELLA USER_PROMOTER_TABLE");
			}else{
				$num_subuser = $row["num_subuser"];
				$total_ammount = $row["total_ammount"];
		   }
		   $stmt->free_result();
		   $stmt->close();
		}
		
		//Numero dei sub_user nella tabella PROMOTER viene incrementato
		$num_subuser++;
		
		
		//se l'utente iscritto non è giovane e non è iscritto tramite bonifico incremento total_ammount di 25
		if($is_giovane==0&&$preview==NULL){
			$total_ammount=$total_ammount+25;
		}
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_PROMOTER_TABLE." SET num_subuser=?, total_ammount=? WHERE id_user=?");
		
		
		$stmt->bind_param("iii", $num_subuser, $total_ammount, $id_referente);
		
		$stmt->execute();
		
		$stmt->close();
		
	}
	
	function Update_sub_user($username,$data_iscrizione,$is_giovane,$id_referente){
		
		$query="INSERT INTO ".SUB_USER_TABLE." (username,data,is_giovane,id_referente) VALUES(?,?,?,?)";
		$stmt = $this->sec_mysqli->prepare($query);
		
		
		
		$stmt->bind_param("ssii",$username,$data_iscrizione,$is_giovane,$id_referente);
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
  function Update_professione($professione,$category,$nameshowed,$user_id){
	  
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET Professione=?,Category=? WHERE ".USER_TABLE_ID."=?");
		
		
		$stmt->bind_param("sii", $professione,$category, $user_id);
		
		$stmt->execute();
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_DATA_TABLE." SET nameshowed=? WHERE id_user=?");
		
		
		$stmt->bind_param("ii", $nameshowed, $user_id);
		
		$stmt->execute();

		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_BV_TABLE." SET professione=? WHERE id_user=?");
		
		
		$stmt->bind_param("ii",$professione, $user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	function Update_dove_siamo($address_via,$address_citta,$address_desc,$address_on, $user_id){
		
		if($address_on  == 'true'){
			$address_on=1;	
		}else{
			$address_on=0;
		}
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_POSITION_TABLE." SET address_via=?,address_citta=?,address_desc=?,address_on=? WHERE id_user=?");
		
		$stmt->bind_param("sssii",$address_via,$address_citta, $address_desc,$address_on,$user_id);
		
		$stmt->execute();
		
		$stmt->close();
		
		
	}
	
	public function Get_lista_subuser($user_id){
		
		$query = "SELECT * FROM ".SUB_USER_TABLE." WHERE ID_referente= '".$user_id."'";
		$result = $this->sec_mysqli->query($query);
		

		
		for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC);$i++){
			$utenti[$i]['username'] = $row["username"];
			$utenti[$i]['data'] = $row["data"];
			$utenti[$i]['giovane'] = $row["is_giovane"];
		}
		
		return $utenti;
	}
	
	
	public function Add_friend($nome,$cognome,$id_group,$cell,$friend_note,$user_id){
		
		  $query="INSERT INTO ".USER_NEWSLETTER_TABLE." (id_user,nome,cognome,type,id_group,cell,note,is_new) VALUES(?,?,?,?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  $type="vcard";
		  $uno=1;
		  
		  $stmt->bind_param("isssissi",$user_id,$nome,$cognome,$type,$id_group,$cell,$friend_note,$uno);
		  $stmt->execute();
		  $inserted_id = $this->sec_mysqli->insert_id;
		  $stmt->close();
		  
		  
		  return $inserted_id;
	}
	function Save_assistenza($email,$textarea,$ip){
		  $query="INSERT INTO ".USER_ASSISTENZA_TABLE." (email,text,ip,datetime) VALUES(?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $datetime =date("Y/m/d").' '.date('H:i:s') ;
		  
		  
		  $stmt->bind_param("ssss",$email,$textarea,$ip,$datetime);
		  $stmt->execute();
		  
		  $stmt->close();
		  $id = $this->sec_mysqli->insert_id;
		  
		  
		  return $id;
	}
	public function Save_abuso($email,$type,$textarea,$ip,$username){
		
		  $query="INSERT INTO ".USER_ABUSE_TABLE." (email,type,text,ip,username,datetime) VALUES(?,?,?,?,?,?)";
		  $stmt = $this->sec_mysqli->prepare($query);
		 
		  
		  $datetime =date("Y/m/d").' '.date('H:i:s') ;
		  
		  $stmt->bind_param("ssssss",$email,$type,$textarea,$ip,$username,$datetime);
		  $stmt->execute();
		  
		  $stmt->close();
		  $id = $this->sec_mysqli->insert_id;
		  
		  
		  return $id;
	}
	
	public function Set_account_deleted_now($user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET `status`=? , `remove_date`=? WHERE `".USER_TABLE_ID."`=?");
		$status = 1;
		$today = date("Y/m/d");
		
		$date_added = strtotime('+8 day',strtotime($today));
		$date_added = date ( 'Y/m/d' , $date_added );
					
		$datetime = $date_added.' '.date('H:i:s') ;
		
		$stmt->bind_param("isi",$status,$datetime,$user_id);
		$stmt->execute();
	
		$stmt->close();
		
		
	}
	
	public function Set_account_deleted($user_id,$data_iscrizione){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET `status`=? , `remove_date`=? WHERE `".USER_TABLE_ID."`=?");
		$status = 1;
		$data_iscrizione = date("Y/m/d",strtotime($data_iscrizione));
		$date_added = strtotime('+1 year',strtotime($data_iscrizione));
		$date_added = date ( 'Y/m/d' , $date_added );
					
		$datetime = $date_added.' '.date('H:i:s') ;
		
		$stmt->bind_param("isi",$status,$datetime,$user_id);
		$stmt->execute();
	
		$stmt->close();
		
		
	}
	
	public function Unset_account_deleted($user_id){
		
		$stmt = $this->sec_mysqli->prepare("UPDATE ".USER_TABLE." SET `status`=? , `remove_date`=? WHERE `".USER_TABLE_ID."`=?");
		$status = 0;
		$datetime = NULL;
		
		$stmt->bind_param("isi",$status,$datetime,$user_id);
		$stmt->execute();
	
		$stmt->close();
		
		
	}
	function Show_error($error_msg){
		echo $error_msg;
	}
	function UpdateLog ( $string , $logfile )  { 
	   $fh = fopen ( $logfile , 'a' ); 
	   fwrite ( $fh ,"\r\n".strftime('%Y-%m-%d %H:%M:%S')." ".$string."\n"); 
	   fclose ( $fh ); 
	}
	function Execute_and_fetch_data_assoc($stmt){
		$stmt->execute();
		$stmt->store_result();
		
		$meta = $stmt->result_metadata();
			
		while ($column = $meta->fetch_field()) {
		   $bindVarsArray[] = &$row[$column->name];
		}        
		call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);
					
		$stmt->fetch();
		return $row;	
	}
	function stmt_bind_assoc (&$stmt, &$out) {
		$data = mysqli_stmt_result_metadata($stmt);
		$fields = array();
		$out = array();
	
		$fields[0] = $stmt;
		$count = 1;
	
		while($field = mysqli_fetch_field($data)) {
			$fields[$count] = &$out[$field->name];
			$count++;
		}    
		call_user_func_array(mysqli_stmt_bind_result, $fields);
	}
}
?>