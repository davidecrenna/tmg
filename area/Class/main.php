 <?
include("database.php");
class PDF_fattura extends FPDI { 
   
     //"Remembers" the template id of the imported page
    
    var $_tplIdx; 
	var $path_blank = 'fattura_blank.pdf';
	
	
 	//include a background template for every page
	 
    function Header() { 
        if (is_null($this->_tplIdx)) { 
			$this->setSourceFile($this->path_blank);
            $this->_tplIdx = $this->importPage(1); 
        } 
        $this->useTemplate($this->_tplIdx); 
        
    }
	function Footer() {} 
}
//##############################################################################################
//##############################################################################################
/*
	Class Area
	DESCRIPTION: handles all TMG PANEL function
	AUTHOR: Davide Crenna
	COPYRIGHT: TOP MANAGER GROUP 2012
*/
//##############################################################################################
//##############################################################################################
class Area {
	public $admin = array();
	
	public $users = array();
	
	public $logs = array();
	
	public $transactions = array();
	
	public $assistenza = array();
	
	public $abuso = array();
	
	public $user;
	
	public $control_email = array();
	
	//DB configuration
	public	$db_host = DB_HOST;
	public $db_user = DB_USER;
	public $db_password = DB_PASSWORD;
	public $db_database = DB_DATABASE;
	private $mysql_database;
	
	function Area(){
		$this->mysql_database = new AreaMySqlDatabase();
		$this->mysql_database->Get_admin_data($this->admin);
		$this->mysql_database->Get_control_mail($this->control_email);
		if($this->Get_all_users()==NULL)
			return NULL;
	}
	
	public function Get_all_users(){
		$this->mysql_database->Get_all_users($this->users);
	}
	
	public function Insert_new_panel_log($type, $fromID,$toID, $email,$id){
		$log_id = $this->mysql_database->Insert_new_panel_log($type, $fromID,$toID, $email,$id);
		$this->Send_mail_panel_log($log_id);
	}
	
	public function Get_panel_logs($num){
		$this->mysql_database->Get_panel_logs($this->logs,$num);
	}
	
	
	public function Insert_new_user_transaction($type, $value, $fromID, $toID,$nomebeneficiario="", $iban="",$codfis="", $swift=""){
	
		$transaction_id = $this->mysql_database->Insert_new_user_transaction($type, $value, $fromID, $toID,$nomebeneficiario, $iban,$codfis, $swift);
		
		
		//invio la mail di inserimento transazione all'admin
		$this->Send_mail_new_transaction($transaction_id);
		
		//inserisco la transazione nei log del pannello di amministrazione e invio mail all'admin
		$this->Insert_new_panel_log($type,$fromID,$toID,"",$transaction_id);
		
		return $transaction;
	}
	
	public function Update_promoter_table($value,$user_id){
		$this->mysql_database->Update_promoter_table($value,$user_id);
	}
	
	
	public function Get_users_transactions($num){
		$this->mysql_database->Get_users_transactions($this->transactions,$num);
	}
	
	public function Get_users_assistenza($num){
		$this->mysql_database->Get_users_assistenza($this->assistenza,$num);
	}
	
	public function Get_users_abuso($num){
		$this->mysql_database->Get_users_abuso($this->abuso,$num);
	}
	
	public function Get_user_data(){
		$this->mysql_database->Get_user_data($this->user_data);
	}
	
	//cambio dello status utente
	public function Change_user_status($userindex,$status){
		//prendo l'id dell'utente
		$user_id = $this->users[$userindex]["ID"];
		
		
		switch($status){
			case 0: //settaggio dello status "ATTIVO"
			
				//se l'utente è nello status "NON PAGATO" devo creare la transazione di PROVVIGIONE euro e incrementare di PROVVIGIONE la colonna total_ammount nella tabella PROMOTER del referente
				if($this->users[$userindex]["status"]==3){
					
					//incremento di PROVVIGIONE la colonna total_ammount nella tabella PROMOTER del referente
					$this->Update_promoter_table(PROVVIGIONE,$this->users[$userindex]["ID_Referente"]);
					
					//inserisco la transazione di PROVVIGIONE, invio mail e inserisco il log
					$transaction_id = $this->Insert_new_user_transaction(1,PROVVIGIONE,$user_id,$this->users[$userindex]["ID_Referente"]);
					
					$this->Create_fattura_iscrizione($this->users[$userindex]["Username"],$this->users[$userindex]["data"]);
					
				}
				
				//settaggio dello status "ATTIVO"
				$this->mysql_database->Change_user_status($user_id,$status);
			break;
			case 2:case 3: //settaggio 2--> "BLOCCATO" 3--> "NON PAGATO"
				$this->mysql_database->Change_user_status($user_id,$status);
			break;
			case 1: //settaggio dello status ELIMINAZION DA CARD
				$card = new Card(NULL,$this->users[$userindex]["Username"]);
				$card->Set_account_deleted_now();
			break;
			case 4: //settaggio dello status ELIMINAZIONE DA ADMIN
				$this->mysql_database->Set_account_deleted_from_admin($user_id);
			break;
		}
	}
	public function Get_all_sub_users(){
		return $this->mysql_database->Get_all_sub_users();
	}
	public function Get_sub_users($user_id){
		return $this->mysql_database->Get_sub_users($user_id);
	}
	public function Get_promoter_table($user_id){
		return $this->mysql_database->Get_promoter_table($user_id);
	}
	
	public function Show_area_login(){
	  //se l'utente è loggato
	  if($this->is_user_logged()){
		  //visualizzo il pannello
		 $this->Show_area();
	  }else{//altrimenti
		  //visualizzo il login
		 $this->Show_login();
	  }
	}
	
	public function is_user_logged(){
		if(isset($_COOKIE["resta_collegato"])){
			if($_COOKIE["resta_collegato"]==$this->resta_collegato){
				return true;
			}
		}
		if(isset($_SESSION['ID'])&&isset($_SESSION['Cognome'])){
			foreach($this->admin as $admin){
				if($_SESSION['ID']==$admin["id"]&&$_SESSION['Cognome']==$admin["cognome"]){
					return true;
				}
			}
			return false;
		}else{
			return false;
		}
	}
	
	public function Show_login($error_messsage=NULL,$login_attempt=NULL,$sfida=NULL){
		if($error_messsage)
					echo $error_messsage;
				echo '<label>
					   <p class="login_header">Email </p>';
					echo '<p class="login_header"><input class="forminput_login" type="text" name="email" id="email" value="Inserisci la tua email..." onclick="javascript:forminput_login_click()" OnChange="comunicazione_ajax(\'php/area_handler.php?__user\',this.name,this.value)" /></p>';
				 echo '
					</label>
					<label>
						<p class="login_header">Password</p>
						<p  class="login_header"><input class="forminput_login" type="password" name="pwd" id="pwd" /></p>
					</label>
					
					<input type="hidden" name="login_attempt_num" id="login_attempt_num" value="'.$login_attempt.'" />';	
				echo $this->Show_login_button();
				echo "<input id='user_logged' type='hidden' value='0'></input>";
				echo "<input type='hidden' name='copia_sfida' id='copia_sfida'  value='".$sfida."'></input>";
				echo "<input type='hidden' name='pwd_codified' id='pwd_codified'></input>";
	}
	
	public function Show_logout_button(){
		echo "<img src='../image/btn/btn_logout.png' alt='Logout.' id='log_out_button' name='log_out_button' style='vertical-align:middle;' class='img_button' onclick='Javascript:Logout()' />";	
	}
	
	public function Show_login_button(){
		echo "<img src='../image/btn/btn_login.png' alt='Logout.' id='log_in_button' name='log_in_button' style='vertical-align:middle;' class='img_button' onclick='Javascript:Login()'/>";	
	}
	
	
	public function Show_area(){
		echo "<div id='area_loading' class='area_loading'><img src='../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>";
		echo "<div class='area_main_container' id='area_main_container'>";
			echo "<div class='area_menu_container' id='area_menu_container'>";
				$this->Show_menu_list();
			echo "</div>";
			echo "<div class='area_content_container' id='area_content_container'>";
				$this->Show_user_list();
			echo "</div>";
		echo "</div>";
	}
	public function Show_menu_list(){
		echo "
		<div class='area_menu_item' onclick='Show_area_user_list()'>Lista Utenti</div>
		<div class='area_menu_item' onclick='Show_area_logs()'>Riepilogo Avvisi</div>
		<div class='area_menu_item' onclick='Show_users_transactions()'>Riepilogo Transazioni</div>
		<div class='area_menu_item' onclick='Show_area_create_user()'>Crea nuovo utente</div>
		<div class='area_menu_item' onclick='Show_area_configurazioni()'>Configurazioni</div>
		<div class='area_menu_item' onclick='Logout()'>Logout</div>";
	}
	public function Show_user_list(){
		$giovani = 0;
		$paganti = 0;
		echo "Totale utenti: ".count($this->users);
		foreach($this->users as $utente){
			if($utente["is_giovane"]==1){
				$giovani++;	
			}else{
				$paganti++;	
			}
		}
		echo "<br/>Totale utenti Giovani non paganti: ".$giovani;
		echo "<br/>Totale utenti Paganti: ".$paganti;
		echo '<table>';
				echo '<thead>
				<tr class="sorterbar">
				
				  <th class="Dettagli_utente_header" scope="col">
		ID
				  </th>
				  <th class="Nome_utente_header" scope="col">
		Nome Utente
				  </th>
				  <th class="Data_utente_header" scope="col">
		Data Iscrizione
				  </th>
				  <th class="Dettagli_utente_header" scope="col">
		Dettagli
				  </th>
				  <th class="Dettagli_utente_header" scope="col">
		Link
				  </th>
				  <th class="Dettagli_utente_header" scope="col">
		Elimina
				  </th>
				  <th class="status_utente_header" scope="col">
		Stato
				  </th>
				  <th class="Data_utente_header" scope="col">
		Data eliminazione
				  </th>
				</tr>
			  </thead>
			  
			  <tbody>';
			
			for($i=0;$i<count($this->users);$i++){
				if(($i%2)==0){
					$backcolor="#8b8b8b";	
				}else{
					$backcolor="#838383";
				}
				 echo '<tr class="message_row"  style="background-color:'.$backcolor.';" id="message_row_'.$i.'">
				 	<td class="message_data" onclick="Show_user_details(\''.$i.'\')">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->users[$i]["ID"].'</span>
					</td>
					<td class="message_from" onclick="Show_user_details(\''.$i.'\')">';
				   
				   echo '<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.';">'.$this->users[$i]["Username"].'</a>';
				
					echo '
					</td>
					
					<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->users[$i]["data"].'</span>
					</td>
					<td class="user_list_details" onclick="Show_user_details(\''.$i.'\')">
						<img src="../image/icone/view_details.png" class="user_list_icon">
					</td>
					<td class="user_list_details" onclick="Go_to_the_card(\''.$this->users[$i]["Username"].'\')">
						<img src="../image/icone/icona_web.png" class="user_list_icon">
					</td>
					<td class="user_list_details" onclick="Delete_user(\''.$i.'\')">
						<img src="../image/icone/edit-delete.png" class="user_list_icon">
					</td>';
					switch($this->users[$i]["status"]){
						case "0":
							/*echo '<td class="user_list_details" style="background-color:#378517;">
									<span style="color:#FFF">ATTIVO</span>
								</td>';*/
							echo '<td class="user_list_details" style="background-color:#378517;">
									<select onchange="Javascript:Change_user_status(\''.$i.'\',this)">
									  <option style="background-color:#378517;" selected="selected" value="0">ATTIVO</option>
									  <option style="background-color:#93060F;" value="1">ELIMIN. da card</option>
									  <option style="background-color:#FFBA00;" value="2">BLOCCATO</option>
									  <option style="background-color:#FFBA00;" value="3">NON PAGATO</option>
									  <option style="background-color:#93060F;" value="4">ELIMIN. da admin</option>
									</select>
								</td>';
						break;
						case "1":
							/*echo '<td class="user_list_details" style="background-color:#93060F;">
									<span style="color:#FFF">ELIMINAZIONE</span>
								</td>';*/
							echo '<td class="user_list_details" style="background-color:#93060F;">
									<select onchange="Javascript:Change_user_status(\''.$i.'\',this)">
									  <option style="background-color:#378517;" value="0">ATTIVO</option>
									  <option style="background-color:#93060F;" selected="selected" value="1">ELIMIN. da card</option>
									  <option style="background-color:#FFBA00;" value="2">BLOCCATO</option>
									  <option style="background-color:#FFBA00;" value="3">NON PAGATO</option>
									  <option style="background-color:#93060F;" value="4">ELIMIN. da admin</option>
									</select>
								</td>';
						break;
						case "2":
							/*echo '<td class="user_list_details" style="background-color:#FFBA00;">
									<span style="color:#FFF">BLOCCATO</span>
								</td>';*/
							echo '<td class="user_list_details" style="background-color:#FFBA00;">
									<select onchange="Javascript:Change_user_status(\''.$i.'\',this)">
									  <option style="background-color:#378517;" value="0">ATTIVO</option>
									  <option style="background-color:#93060F;" value="1">ELIMINAZIONE</option>
									  <option style="background-color:#FFBA00;" selected="selected" value="2">BLOCCATO</option>
									  <option style="background-color:#FFBA00;" value="3">NON PAGATO</option>
									  <option style="background-color:#93060F;" value="4">ELIMIN. da admin</option>
									</select>
								</td>';
						break;
						case "3":
							/*echo '<td class="user_list_details" style="background-color:#FFBA00;">
									<span style="color:#FFF">NON PAGATO</span>
								</td>';*/
							echo '<td class="user_list_details" style="background-color:#FFBA00;">
									<select onchange="Javascript:Change_user_status(\''.$i.'\',this)">
									  <option style="background-color:#378517;" value="0">ATTIVO</option>
									  <option style="background-color:#93060F;" value="1">ELIMIN. da card</option>
									  <option style="background-color:#FFBA00;" value="2">BLOCCATO</option>
									  <option style="background-color:#FFBA00;" selected="selected" value="3">NON PAGATO</option>
									  <option style="background-color:#93060F;" value="4">ELIMIN. da admin</option>
									</select>
								</td>';
						break;
						case "4":
							/*echo '<td class="user_list_details" style="background-color:#FFBA00;">
									<span style="color:#FFF">NON PAGATO</span>
								</td>';*/
							echo '<td class="user_list_details" style="background-color:#93060F;">
									<select onchange="Javascript:Change_user_status(\''.$i.'\',this)">
									  <option style="background-color:#378517;" value="0">ATTIVO</option>
									  <option style="background-color:#93060F;" value="1">ELIMIN. da card</option>
									  <option style="background-color:#FFBA00;" value="2">BLOCCATO</option>
									  <option style="background-color:#FFBA00;" value="3">NON PAGATO</option>
									  <option style="background-color:#93060F;" selected="selected" value="4">ELIMIN. da admin</option>					  
									</select>
								</td>';
						break;					
					}
					
						
					if($this->users[$i]["remove_date"]){
						echo '<td class="user_list_details" onclick="Delete_user(\''.$i.'\')">
									'.$this->users[$i]["remove_date"].'
								</td>';
					}else{
						echo '<td class="user_list_details" onclick="Delete_user(\''.$i.'\')">
									n.d.
								</td>';
					}
					
					echo '
				  </tr>';
			}
			echo '</tbody>';
			echo '</table>';
	}
	
	public function Show_area_logs(){
		$this->Get_panel_logs(50);
		echo "BENVENUTO ADMIN<br/>";
		echo "Avvisi:<br/>";
		echo '<table>';
				echo '<thead>
				<tr class="sorterbar">
				<th class="id_utente_header" scope="col">
		ID
				  </th>
				  <th class="Nome_utente_header" scope="col">
		Data
				  </th>
				  <th class="Data_utente_header" scope="col">
		Tipo
				  </th>
				</tr>
			  </thead>
			  
			  <tbody>';
			
			for($i=0;$i<count($this->logs);$i++){
				if(($i%2)==0){
					$backcolor="#8b8b8b";	
				}else{
					$backcolor="#838383";
				}
				switch($this->logs[$i]["type"]){
				case 1:
				 echo '<tr class="message_row"  style="background-color:#378517; cursor:pointer;" onclick="Show_log_details(\''.$i.'\')">
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["ID"].'</span>
					</td>
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["data"].'</span>
					</td>
					<td class="message_from">';
				   		echo 'Iscrizione nuovo utente';
					echo '
					</td>
					
				  </tr>';
				  break;
				  case 2:
				 echo '<tr class="message_row"  style="background-color:#FFBA00; cursor:pointer;"  onclick="Show_log_details(\''.$i.'\')">
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["ID"].'</span>
					</td>
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["data"].'</span>
					</td>
					<td class="message_from">';
				   		echo 'Richiesta riscossione';
					echo '
					</td>
					
				  </tr>';
				  break;
				  case 3:
				 echo '<tr class="message_row"  style="background-color:#93060F; cursor:pointer;"  onclick="Show_log_details(\''.$i.'\')">
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["ID"].'</span>
					</td>
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["data"].'</span>
					</td>
					<td class="message_from" onclick="Show_log_details(\''.$i.'\')">';
				   		echo 'Richiesta assistenza';
					echo '
					</td>
					
				  </tr>';
				  break;
				  case 4:
				 echo '<tr class="message_row"  style="background-color:#93060F; cursor:pointer;" onclick="Show_log_details(\''.$i.'\')">
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["ID"].'</span>
					</td>
					<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->logs[$i]["data"].'</span>
					</td>
					<td class="message_from">';
				   		echo 'Segnalazione abuso';
					echo '
					</td>
					
				  </tr>';
				  break;
				}
			}
			echo '</tbody>';
			echo '</table>';
	}
	
	
	public function Show_users_transactions(){
		$this->Get_users_transactions(50);
		if(count($this->transactions)==0){
			echo "NON SONO PRESENTI TRANSAZIONI";
			return;	
		}
		echo "Transazioni utenti:<br/>";
		echo '<table>';
				echo '<thead>
				<tr class="sorterbar">
				  <th class="id_utente_header" scope="col">
		ID
				  </th>
				  <th class="Nome_utente_header" scope="col">
		Data
				  </th>
				  <th class="Data_utente_header" scope="col">
		Tipo
				  </th>
				  <th class="Data_utente_header" scope="col">
		Stato
				  </th>
				</tr>
			  </thead>
			  
			  <tbody>';
			
			for($i=0;$i<count($this->transactions);$i++){
				if(($i%2)==0){
					$backcolor="#8b8b8b";	
				}else{
					$backcolor="#838383";
				}
				switch($this->transactions[$i]["type"]){
				case 1:
				 echo '<tr class="message_row"  style="background-color:#378517; cursor:pointer;" onclick="Show_transaction_details(\''.$i.'\')">
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->transactions[$i]["ID"].'</span>
					</td>
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->transactions[$i]["datetime"].'</span>
					</td>
					<td class="message_from">';
				   		echo 'Provvigione Iscrizione';
					echo '
					</td>';
				  break;
				  case 2:
				 	echo '<tr class="message_row"  style="background-color:#378517; cursor:pointer;" onclick="Show_transaction_details(\''.$i.'\')">
					<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->transactions[$i]["ID"].'</span>
					</td>
				 	<td class="message_data">
						<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->transactions[$i]["datetime"].'</span>
					</td>
					<td class="message_from">';
				   		echo 'Richiesta Riscossione';
					echo '
					</td>';
				  break;
				}
				switch($this->transactions[$i]["processed"]){
					case "0":
						echo '<td class="user_list_details" style="background-color:#93060F;">
								<span style="color:#FFF">NON PROCESSATO</span>
							</td>';
					break;
					case "1":
						echo '<td class="user_list_details" style="background-color:#378517;">
								<span style="color:#FFF">PROCESSATO</span>
							</td>';
					break;
				}
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
	}
	
	public function Show_user_details($index){
		$this->user = new Card(NULL,$this->users[$index]["Username"]);
		$this->users[$index]["sub_user"] = $this->Get_sub_users($this->users[$index]["ID"]);
		$this->users[$index]["promoter"] = $this->Get_promoter_table($this->users[$index]["ID"]);
		echo "<div class='user_details_main_photo'>";
			$this->user->Show_main_photo(210,315,"../");
		echo "</div>";
		
		
		echo "<div class='user_details_information'>";
		
			echo "<p class='text14px'>INFORMAZIONI SULL'UTENTE</p>";
			echo "Nome utente: ".$this->users[$index]["Username"]."<br/>";
			echo "Tipo: ";
			if($this->users[$index]["society"]==0){
				echo "Persona fisica";
			}else if($this->users[$index]["society"]==1){
				echo "Società";
			}
			echo "<br/>";
			if($this->users[$index]["is_giovane"]==1){
				echo "Giovane: Si<br/>";
				echo "Codice Fiscale: ".$this->users[$index]["codfiscale"]."<br/>";
			}else if($this->users[$index]["is_giovane"]==1){
				echo "Giovane: No<br/>";
			}
			echo "Email: ".$this->users[$index]["Email"]."<br/>";
			echo "Data iscrizione: ".$this->users[$index]["data"]."<br/>";
			echo "Nome: ".$this->users[$index]["Nome"]."<br/>";
			echo "Cognome: ".$this->users[$index]["Cognome"]."<br/>";
			echo "Professione: ".$this->users[$index]["Professione"]."<br/>";
			echo "Email paypal: ".$this->users[$index]["paypal_email"]."<br/>";
			echo "Email tmg: ".$this->users[$index]["Username"]."@topmanagergroup.com"."<br/>";
			echo "ID Referente: ".$this->users[$index]["ID_Referente"]."<br/>";
			if($this->users[$index]["ID_Referente"]==0){
				echo "Username referente: TOPMANAGERGROUP";
			}else{
				foreach($this->users as $utente){
					if($utente["ID"]==$this->users[$index]["ID_Referente"]){
						echo "Username referente: ".$utente["Username"];
					}
				}
			}
			//visualizzo lo stato promoter manager
			echo "<p class='text14px'>STATO PROMOTER MANAGER</p>";
			echo "TOTALE GENERATO: ".$this->users[$index]["promoter"]["total_ammount"]."<br/>";
			echo "TOTALE CONFERMATO: ".$this->users[$index]["promoter"]["total_confirmed"]."<br/>";
			echo "TOTALE PAGATO: ".$this->users[$index]["promoter"]["total_payed"]."<br/>";
			echo "numero di SUB USER: ".$this->users[$index]["promoter"]["num_subuser"]."<br/>";
			
			//visualizzo username che hanno indicato l'utente come promoter
			echo "Utenti che hanno indicato  ".$this->users[$index]["Username"]." come promoter (SUB USER): <br/>";
			if(count($this->users[$index]["sub_user"]>0)){
				for($i=0;$i<count($this->users[$index]["sub_user"]);$i++){
					echo ($i+1)." <strong>".$this->users[$index]["sub_user"][$i]["username"]."</strong> in data: ".$this->users[$index]["sub_user"][$i]["data"]." è giovane: ";
					if($this->users[$index]["sub_user"][$i]["is_giovane"]==0){
						echo "NO";
					}else{
						echo "SI";	
					}
					echo "<br/>";
				}
			}else{
				echo "NESSUNO.<br/>";
			}
			
			echo "<br/><br/>";
			
			
		echo "</div>";
		
		//visualizzo le foto dello slide show caricate dall'utente
		echo "<div class='user_slide_photo_information'>";
			echo "<p class='text14px'>FOTO DELLO SLIDE </p>";
			foreach($this->user->user_photo_slide_path as $photo){
				echo "<img src='../../".USERS_PATH.$this->user->username."/user_photo/".$photo."' />";	
			}
		echo "</div>";
		
	}
	
	public function Show_log_details($index){
		$this->Get_panel_logs(50);
		echo "<p> DETTAGLIO LOG ID: ".$this->logs[$index]["ID"]."</p>";
		echo "DATA LOG: ".$this->logs[$index]["data"]."<br/>";
		echo "TIPO LOG: ";
		switch($this->logs[$index]["type"]){
			case 1: 
				echo "Iscrizione utente<br/>";
				echo "ID nuovo utente: ".$this->logs[$index]["user_id"]."<br/>";
				$i=0;
				foreach($this->users as $utente){
					if($utente["ID"]==$this->logs[$index]["from_id"]){
						echo "Username nuovo utente: ".$utente["Username"]."<br/>";
						echo '<a target="_self" onclick="Show_user_details(\''.$i.'\')" style="cursor:pointer;">Visualizza dettagli nuovo utente</a><br/>';
					}
					$i++;
				}
				echo "<br/>";
				if($this->logs[$index]["refer_id"]!=-1&&$this->logs[$index]["refer_id"]!=NULL){
					echo "ID TRANSAZIONE: ".$this->logs[$index]["refer_id"]."<br/>";
					$this->Get_users_transactions(50);
					$i=0;
					foreach($this->transactions as $transazione){
						if($transazione["ID"]==$this->logs[$index]["refer_id"]){
							echo '<a target="_self" onclick="Show_transaction_details(\''.$i.'\')" style="cursor:pointer;">Visualizza dettagli transazione</a><br/>';
						}
						$i++;
					}
				}
			break;
			case 2: 
				echo "Richiesta riscossione<br/>";
				echo "ID utente richiedente: ".$this->logs[$index]["to_id"]."<br/>";
				$i=0;
				foreach($this->users as $utente){
					if($utente["ID"]==$this->logs[$index]["to_id"]){
						echo "Username utente richiedente: ".$utente["Username"]."<br/>";
						echo '<a target="_self" onclick="Show_user_details(\''.$i.'\')" style="cursor:pointer;">Visualizza dettagli utente richiedente</a><br/>';
					}
					$i++;
				}
				echo "ID TRANSAZIONE: ".$this->logs[$index]["refer_id"]."<br/>";
				$this->Get_users_transactions(50);
				$i=0;
				foreach($this->transactions as $transazione){
					if($transazione["ID"]==$this->logs[$index]["refer_id"]){
						echo '<a target="_self" onclick="Show_transaction_details(\''.$i.'\')" style="cursor:pointer;">Visualizza dettagli transazione</a><br/>';
					}
					$i++;
				}
				
			break;
			case 3: 
				echo "Richiesta assistenza<br/>";
				echo "Email associata alla richiesta: ".$this->logs[$index]["email"]."<br/>";
				$this->Get_users_assistenza(50);
				$i=0;
				foreach($this->assistenza as $assistenza){
					if($assistenza["ID"]==$this->logs[$index]["refer_id"]){
						echo '<a target="_self" onclick="Show_assistenza_details(\''.$i.'\')" style="cursor:pointer;">Visualizza dettagli assistenza</a><br/>';
					}
					$i++;
				}
			break;
			case 4: 
				echo "Segnalazione abuso<br/>";
				echo "Email associata alla segnalazione: ".$this->logs[$index]["email"]."<br/>";
				$this->Get_users_abuso(50);
				foreach($this->abuso as $abuso){
					if($abuso["ID"]==$this->logs[$index]["refer_id"]){
						echo '<a target="_self" onclick="Show_abuso_details(\''.$i.'\')" style="cursor:pointer;">Visualizza dettagli segnalazione</a><br/>';
					}
					$i++;
				}
			break;
		}
	}
	
	public function Show_transaction_details($index){
		$this->Get_users_transactions(50);
		echo "<p> DETTAGLIO TRANSAZIONE ID: ".$this->transactions[$index]["ID"]."</p>";
		echo "DATA TRANSAZIONE: ".$this->transactions[$index]["datetime"]."<br/>";
		echo "TIPO TRANSAZIONE: ";
		switch($this->transactions[$index]["type"]){
			case 1: 
				echo "Iscrizione utente<br/>";
				echo "ID nuovo utente: ".$this->transactions[$index]["fromID"]."<br/>";
				echo "ID referente: ".$this->transactions[$index]["toID"]."<br/>";
				echo "Importo transazione: ".$this->transactions[$index]["value"]." ".VALUTA."<br/>";
			break;
			case 2: 
				echo "Richiesta riscossione<br/>";
				echo "ID utente richiedente: ".$this->transactions[$index]["toID"]."<br/>";
				$i=0;
				foreach($this->users as $utente){
					if($utente["ID"]==$this->logs[$index]["user_id"]){
						echo "Username utente richiedente: ".$utente["Username"]."<br/>";
						echo '<a target="_self" onclick="Show_user_details(\''.$i.'\')" style="cursor:pointer;">Visualizza dettagli utente richiedente</a><br/>';
					}
					$i++;
				}
				echo "Dati relativi alla riscossione tramite bonifico:<br/> ";
				echo "BENEFICIARIO: ".$this->transactions[$index]["nomebeneficiario"]."<br/>";
				echo "IBAN: ".$this->transactions[$index]["iban"]."<br/>";
				echo "SWIFT: ".$this->transactions[$index]["swift"]."<br/>";
				echo "Importo transazione: ".$this->transactions[$index]["value"]."<br/>";
				
				echo "<br/>";			
				if($this->transactions[$index]["processed"]!=1){
					echo "Clicca sul pulsante sottostante se è stato effettuato il bonifico.";
					echo "<div class='personal_button' onclick='Javascript:Personal_area_riscuoti_effettuato(".$this->transactions[$index]["ID"].");' style='width:200px;'>
							<span class='text14px'>PAGAMENTO EFFETTUATO</span>
						</div>";
				}
			break;
		}
	}
	
	public function Show_assistenza_details($index){
		$this->Get_users_assistenza(50);
		echo "<p> DETTAGLIO RICHISTA ASSISTENZA ID: ".$this->assistenza[$index]["ID"]."</p>";
		echo "DATA RICHISTA: ".$this->assistenza[$index]["datetime"]."<br/>";
		echo "EMAIL ASSOCIATA ALLA RICHIESTA: ".$this->assistenza[$index]["email"]."<br/>";
		echo "IP ASSOCIATO ALLA RICHIESTA: ".$this->assistenza[$index]["ip"]."<br/>";
		echo "CORPO DELLA RICHIESTA: <br/>";
		echo $this->assistenza[$index]["text"];
	}
	
	public function Show_abuso_details($index){
		$this->Get_users_aabuso(50);
		echo "<p> DETTAGLIO SEGNALAZIONE ABUSO ID: ".$this->abuso[$index]["ID"]."</p>";
		echo "DATA SEGNALAZIONE: ".$this->abuso[$index]["datetime"]."<br/>";
		echo "EMAIL ASSOCIATA ALLA SEGNALAZIONE: ".$this->abuso[$index]["email"]."<br/>";
		echo "IP ASSOCIATO ALLA SEGNALAZIONE: ".$this->abuso[$index]["ip"]."<br/>";
		echo "CARD ASSOCIATA ALLA SEGNALAZIONE: ".$this->abuso[$index]["username"]."<br/>";
		echo "CODICE ABUSO: ".$this->abuso[$index]["abuso"]."<br/>";
		if($this->abuso[$index]["abuso"]=="altro"){
			echo "CORPO DELLA SEGNALAZIONE: <br/>";
			echo $this->abuso[$index]["text"];
		}
	}
	
	public function Show_area_create_user(){
		echo "Crea un nuovo utente:<br/>";
		
		echo 'Nome <input type="text" required class="forminput" name="_nome" id="_nome" maxlength="25" tabindex="1" value="" onchange="Update_info_nickname()"/><br/><br/>';
		
		echo 'Cognome <input type="text" required class="forminput" name="_cognome" id="_cognome" maxlength="25" tabindex="2" onchange="Update_info_nickname()"/><br/><br/>';
		
		echo 'Nickname <input type="text" required class="forminput" name="_nickname" id="_nickname" maxlength="35" tabindex="2" onchange="Update_info_nickname()"/><br/><br/>';
		
		echo 'L\'indirizzo sarà: www.topmanagergroup.com/<span id="info_nickname">nomecognome</span><br/>';
		echo 'E\' società: <input name="is_society" id="is_society" type="checkbox" value="0" /><br/>';
		echo '<input name="is_giovane" id="is_giovane" type="hidden" value="0" /><br/>';
		
		echo 'Cod Fiscale <input type="text" class="forminput" value="" name="_codfiscale" id="_codfiscale" title="<? echo TOOLTIP_CODICE_FISCALE; ?>" tabindex="4" onchange="Javascript: CtrlCodFiscale();" /><span id="info_codfiscale"></span><br/><br/>';
		
		echo 'Referente TMG <input class="forminput" name="_id_referente" id="_id_referente" title="<? echo TOOLTIP_REFERENTE; ?>" tabindex="4" onChange="Javascript:CtrlReferente()" /><span id="info_referente"></span><br/><br/>';
		echo 'Email <input type="email" class="forminput" name="_email" id="_email" required tabindex="5" /><br/><br/>';
		echo 'Conferma email <input type="email" class="forminput" name="_confirm_email" id="_confirm_email" required tabindex="6" /><br/><br/>';
		echo 'Password <input type="password" class="forminput" name="_password" id="_password" tabindex="7" maxlength="20" required /><br/><br/>';
		
		echo 'Url Alternativo<br/><select id="_alt_url_select">
				<option value="www.federcard.com">www.federcard.com</option>
				<option value="www.federartist.com">www.federartist.com</option>
				<option value="www.federsport.com">www.federsport.com</option>
				<option value="www.federdance.com">www.federdance.com</option>
				<option value="www.federfashion.com">www.federfashion.com</option>
				<option value="www.federmusic.com">www.federmusic.com</option>
			</select>

			<br/><br/>';
		
		echo 'E\' una card gratuita (seleziona se la card non verrà pagata): <input name="iscardfree" id="iscardfree" type="checkbox" value="0" /><br/>';
		echo '<input type="button" value="Crea utente" onclick="Javascript:Crea_nuovo_utente()">';
	}
	public function Delete_user($index,$eliminazione_immediata=NULL){
		$card = new Card(NULL,$this->users[$index]["Username"]);
		//delete_me($path,$eliminazione_immediata)
		$card->delete_me("../../",$eliminazione_immediata);
		echo "Utente eliminato con successo.";
	}
	
	public function Block_user($index){
		$this->mysql_database->Block_user($this->users[$index]["ID"]);
		echo "UTENTE ".$this->users[$index]["Username"]." BLOCCATO";
	}
	public function Unblock_user($index){
		$this->mysql_database->Unblock_user($this->users[$index]["ID"]);
		echo "UTENTE ".$this->users[$index]["Username"]." SBLOCCATO";
	}
	
	public function Create_temp_user($username,$nome_utente,$cognome_utente,$password,$email,$id_referente,$idTransazione,$is_society,$is_giovane,$codfiscale,$alt_url){
		$this->mysql_database->Create_temp_user($username,$nome_utente,$cognome_utente,$password,$email,$id_referente,$idTransazione,$is_society,$is_giovane,$codfiscale,$alt_url);
	}
	
	
	function Ctrlusernotexists($username){
		return $this->mysql_database->Ctrlusernotexists($username);
	}
	
	function Ctrlemailnotexists($email){
		return $this->mysql_database->Ctrlemailnotexists($email);
	}
	function Getidreferente($username_referente){
		return $this->mysql_database->Getidreferente($username_referente);
	}
	
	public function Create_new_user($idTransazione,$iscardfree=NULL){
		echo "id transazione: ".$idTransazione."      ";
		if(!empty($idTransazione)){
			$iscrizione = new Iscrizione($idTransazione,"none");
			$iscrizione->Create_new_user(NULL,$iscardfree);
			$iscrizione->send_mail();
			$iscrizione->Create_user_folder("../../");
			echo "L'utente è stato creato con successo.";
		}else{
			echo "problema nella creazione dell'utente";
		}
		
	}
	public function Send_mail_new_transaction($transaction_id){
		$this->Get_users_transactions(50);
		$i=0;
		foreach($this->transactions as $transazione){
			if($transazione["ID"]==$transaction_id){
				$index=$i;
			}
			$i++;
		}
		
		
			$mail = new PHPMailer(true);
			try { 
			  foreach($this->control_email as $ctrl_email){
			  	$mail->AddAddress($ctrl_email["email"]);
		      }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "INSERITA NUOVA TRANSAZIONE ".$transaction["data"];
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
							&Eacute; STATA INSERITA UNA NUOVA TRANSAZIONE:<br/>
							DETTAGLI TRANSAZIONE:<br/>
							ID TRANSAZIONE: ".$this->transactions[$index]["ID"]."<br/>";
							switch($this->transactions[$index]["type"]){
								case 1://nel caso sia type=1 è una nuova iscrizione
								$messaggio.="
								Iscrizione utente<br/>
								ID nuovo utente: ".$this->transactions[$index]["fromID"]."<br/>
								ID referente: ".$this->transactions[$index]["toID"]."<br/>
								Importo transazione: ".$this->transactions[$index]["value"]." ".VALUTA."<br/>";
								break;
								case 2://nel caso sia type=2 è una richiesta riscossione
								$messaggio.="
								Richiesta riscossione<br/>
								ID utente richiedente: ".$this->transactions[$index]["toID"]."<br/>";
								$i=0;
								foreach($this->users as $utente){
									if($utente["ID"]==$this->transactions[$index]["toID"]){
										$utente_richiedente = $utente["Username"];
										$messaggio.="Username utente richiedente: ".$utente_richiedente."<br/>";
									}
									$i++;
								}
								$messaggio.="Dati relativi alla riscossione tramite bonifico:<br/>BENEFICIARIO: ".$this->transactions[$index]["nomebeneficiario"]."<br/>IBAN: ".$this->transactions[$index]["iban"]." <br/>SWIFT: ".$this->transactions[$index]["swift"]."<br/>Importo transazione: ".$this->transactions[$index]["value"]." ".VALUTA."<br/>";
								$mail->AddAttachment("../../ritenute/RA ".$utente_richiedente." ".date("d-m-Y",strtotime($this->transactions[$index]["datetime"])).".pdf");
								break;
			 					
							}
							$messaggio.="
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
	
	public function Send_mail_new_iscrizione($data,$user_id,$username,$id_referente,$username_referente,$giovane,$pagato){
		
			$mail = new PHPMailer(true);
			try {
			  foreach($this->control_email as $ctrl_email){
			     $mail->AddAddress($ctrl_email["email"]);
			  }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "ISCRITTO NUOVO UTENTE ".$data;
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
							ISCRITTO NUOVO UTENTE:<br/>";
								$messaggio.="
								ID nuovo utente: ".$user_id."<br/>
								Username nuovo utente: ".$username."<br/>
								ID referente: ".$id_referente."<br/>
								Username referente: ".$username_referente."<br/>
								&Eacute; GIOVANE: ".$giovane."<br/>";
								if($pagato == 0)
									$messaggio .="PAGATO: SI<br/>";
								else if($pagato == 3)
									$messaggio .="PAGATO: NO<br/>";
								
							$messaggio.="
						</body>
					</html>
					";
					/*if($pagato==0){
						$mail->AddAttachment("fatture/fattura ".$username." ".date("d-m-Y",$data).".pdf");	
					}*/
					
				  $mail->MsgHTML($messaggio);
				  
				  $mail->Send();
			} catch (phpmailerException $e) {
				  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				  echo $e->getMessage(); //Boring error messages from anything else!
			}
	}
	
	public function Send_mail_panel_log($log_id){
		$log = $this->mysql_database->Get_panel_log($log_id);
		
			$mail = new PHPMailer(true);
			try { 
			  foreach($this->control_email as $ctrl_email){
			  	$mail->AddAddress($ctrl_email["email"]);
			  }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "TMG DB LOG ".$this->Get_readable_datetime($log["data"]);
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
							TYPE: ".$log["type"]."<br/> FROM_ID: ".$log["from_id"]."<br/> TO_ID: ".$log["to_id"]."<br/> EMAIL: ".$log["email"]."<br/>
							DATA: ".$log["data"]." 
							<br/>
							<br/>
							TYPE:<br/>
							1 -> Nuova Iscrizione
							2 -> Richiesta Riscossione
							3 -> Richiesta Assistenza
							4 -> Segnalazione Abuso
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
	
	public function Send_mail_user_preview($user_id){
		
			$mail = new PHPMailer(true);
			try { 
			  foreach($this->control_email as $ctrl_email){
			  	$mail->AddAddress($ctrl_email["email"]);
			  }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "TMG ELIMINAZIONE UTENTE";
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
							L&rsquo;UTENTE CON ID $user_id VIENE MESSO IN ELIMINAZIONE POICHE NON HA EFFETTUATO IL PAGAMENTO DELL&rsquo;ISCRIZIONE NEL TEMPO CONSENTITO (UTENTI CHE HANNO SCELTO PAGAMENTO VIA BONIFICO).
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
	
	public function Send_mail_user_deleted($user_id){
		
			$mail = new PHPMailer(true);
			try {
			  foreach($this->control_email as $ctrl_email){
			  	$mail->AddAddress($ctrl_email["email"]);
			  }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "TMG ELIMINATO UTENTE";
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
							L&rsquo;UTENTE CON ID $user_id &Eacute; STATO ELIMINATO POICH&Eacute; NON HA EFFETTUATO IL PAGAMENTO DELL&rsquo;ISCRIZIONE NEL TEMPO CONSENTITO (UTENTI CHE HANNO SCELTO PAGAMENTO VIA BONIFICO).
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
	
	
	public function Send_mail_user_deleted_from_admin($user_id){
		
			$mail = new PHPMailer(true);
			try { 
			  foreach($this->control_email as $ctrl_email){
			  	$mail->AddAddress($ctrl_email["email"]);
			  }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "TMG ELIMINATO UTENTE";
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
							L&rsquo;UTENTE CON ID $user_id &Eacute; STATO ELIMINATO DOPO CHE &Eacute; STATO IMPOSTATO DA ELIMAZIONE DA ADMIN.
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
	
	
	public function Send_mail_fattura($username,$nome_file_fattura,$nomeandcognome,$from_ipn=NULL){
			$mail = new PHPMailer(true);
			try { 
			  foreach($this->control_email as $ctrl_email){
			  	$mail->AddAddress($ctrl_email["email"]);
			  }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "FATTURA NUOVA ISCRIZIONE";
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
							FATTURA ISCRIZIONE DELL'UTENTE ".$username."<br/>
							NOME COGNOME UTENTE: ".$nomeandcognome."
						</body>
					</html>
					";
				  $mail->MsgHTML($messaggio);
				  if($from_ipn!=NULL){
				  	$mail->AddAttachment('fatture/'.$nome_file_fattura);  
				  }else{
				  	$mail->AddAttachment('../../fatture/'.$nome_file_fattura);
				  }
				  $mail->Send();
			} catch (phpmailerException $e) {
				  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				  echo $e->getMessage(); //Boring error messages from anything else!
			}
		
		
		
		
		//invio mail fattura all'utente
		$card= new Card($username);
		$mail2 = new PHPMailer(true);
			try { 
			  $mail2->AddAddress($card->email);
			  $mail2->AddAddress($card->Get_member_email());
			  $mail2->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "Ecco la fattura relativa alla tua iscrizione a Topmanagergroup.com";
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
									<p id='titolo'>".$username.",la tua fattura TopManagerGroup.com</p>
									
									<b>In allegato puoi trovare la fattura relativa alla tua iscrizione a Topmanagergroup.com</b><br/>
									
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
				  $mail2->MsgHTML($messaggio);
				  
				  $mail2->AddAttachment('../../fatture/'.$nome_file_fattura);
				  $mail2->Send();
			} catch (phpmailerException $e) {
				  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				  echo $e->getMessage(); //Boring error messages from anything else!
			}
		
		
	
	}
	public function Send_mail_transazione_avvenuta($transaction){
		
			$mail = new PHPMailer(true);
			try { 
			  foreach($this->control_email as $ctrl_email){
			  	$mail->AddAddress($ctrl_email["email"]);
			  }
			  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
					  
			  $oggetto = "TRANSAZIONE PROCESSATA";
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
							LA TRANSAZIONE CON ID ".$transaction['value']." E ID ".$transaction['ID']." &Eacute; STATA PROCESSATA. LA TRANSAZIONE &Eacute; STATA ESEGUITA SULL'UTENTE CON ID ".$transaction["toID"]."
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
	
	/*  METHOD: Send_mail_preavviso_pagamento()
		
		IN: $email,$username,$giorni_left,$data_eliminazione
		OUT: -
		DESCRIPTION: Invia la mail di preavviso quando non viene pagato un'iscrizione entro 7 giorni.
	*/
	public function Send_mail_preavviso_pagamento($email,$username,$giorni_left,$data_eliminazione){
		$mail = new PHPMailer(true);
		try { 
		  $mail->AddAddress($email,$username);
		  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
				  
		  $oggetto = $username.", Hai ancora $giorni_left giorni per effettuare il pagamento di TopManagerGroup.com.";
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
							<p id='titolo'>".$username.",il tuo account su TopManagerGroup.com scade in data: $data_eliminazione</p>
							<b>Hai $giorni_left giorni per effettuare il pagamento di &euro;96.</b><br>
							
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
	
	
	/*  METHOD: Send_mail_pagamento_effettuato()
		
		IN: $email,$username
		OUT: -
		DESCRIPTION: Invia la mail di pagamento riscossione effettuato.
	*/
	public function Send_mail_pagamento_effettuato($email,$username,$importo,$nomebeneficiario,$iban,$swift){
		$mail = new PHPMailer(true);
		try { 
		  $mail->AddAddress($email,$username);
		  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
		  
		  $oggetto = $username.", inserito il bonifico da TopManagerGroup.com.";
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
							<p id='titolo'>".$username.", il bonifico di ".$importo."&euro; &eacute; stato inserito da TopManagerGroup.com</p><br/>
							
							<b>Riepilogo dei dati bonifico bancario</b><br/>
							NOME COGNOME INTESTATARIO: ".$nomebeneficiario."<br/>
							IBAN: ".$iban."<br/>
							IMPORTO: ".$importo."<br/>
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
	

	/*  METHOD: Send_mail_preavviso_eliminazione()
	
		IN: $email,$username,$giorni_left,$data_eliminazione
		OUT: -
		DESCRIPTION: Invia la mail di preavviso quando l'account viene messo in eliminazione.
	*/
	public function Send_mail_preavviso_eliminazione($email,$username,$giorni_left,$data_eliminazione){
		$mail = new PHPMailer(true);
		try { 
		  $mail->AddAddress($email,$username);
		  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
				  
		  $oggetto = $username.", Il tuo account verrà eliminato da TopManagerGroup.com.";
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
							<p id='titolo'>".$username.", la tua card sta per essere eliminata dai nostri server.</p>
							<b>Il tuo account &egrave; stato impostato per l'eliminazione entro $giorni_left giorni.</b><br>
							Il tuo account verr&agrave; eliminato in data: $data_eliminazione alle ore 08:00<br>
							
						
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
	
	/*  METHOD: Send_mail_eliminazione_avvenuta()
	
		IN: $email,$username,$data_eliminazione
		OUT: -
		DESCRIPTION: Invia la mail di avvenuta eliminazione.
	*/
	public function Send_mail_eliminazione_avvenuta($email,$username,$data_eliminazione){
		$mail = new PHPMailer(true);
		try { 
		  $mail->AddAddress($email,$username);
		  $mail->SetFrom("no-reply@topmanagergroup.com","TopManagerGroup.com");
				  
		  $oggetto = $username.", la tua card TopManagerGroup.com.";
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
							<p id='titolo'>".$username.", la tua card &eacute; stata eliminata dai nostri server.</p>
							<b>Il tuo account &egrave; stato eliminato in data: $data_eliminazione.</b><br>
							Speriamo di rivederti presto tra noi!<br>
							
						
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
	
	function Get_readable_datetime($datetime){
		$saved_data = strtotime($datetime);
		$saved_minutes = idate('i',$saved_data);
		$saved_hours = idate('H',$saved_data);
		$saved_month = idate('m',$saved_data);
		$saved_day = idate('d',$saved_data);
		$saved_year = idate('Y',$saved_data);
		return $saved_hours.":".$saved_minutes." ".$saved_day."/".$saved_month."/".$saved_year;
	}
	public function Ctrl_riscossione_inserted($user_id){
		$this->Get_users_transactions(50);
		if(count($this->transactions)==0){
			return array("result"=>false);	
		}
		foreach($this->transactions as $transaction){
			if($transaction["toID"]==$user_id&&$transaction["type"]==2&&$transaction["processed"]==0)
				return array("result"=>true,"nomebeneficiario"=>$transaction["nomebeneficiario"],"iban"=>$transaction["iban"],"codfis"=>$transaction["codfis"],"swift"=>$transaction["swift"],"datetime"=>$transaction["datetime"]);
		}
		return array("result"=>false);
	}
	public function Process_users_transactions(){
		
		$this->Get_users_transactions(50);
		if(count($this->transactions)==0){
			return;	
		}
		for($i=0;$i<count($this->transactions);$i++){
			switch($this->transactions[$i]["type"]){
			case 1://transazione di iscrizione utente
				if($this->transactions[$i]["processed"]==0){
					//prendo la data di oggi
					$today = date("Y/m/d");
					
					//recupero la data salvata e aggiungo 8 giorni perchè ogni transazione viene processata dopo 8 giorni
					$saved_data = strtotime('+8 day',strtotime($this->transactions[$i]["datetime"]));
					$saved_data = date ( 'Y/m/d' , $saved_data );
					
					//se sono passati 8 giorni dalla creazione della transazione
					if($today==$saved_data){
						//Decremento total_ammount di $this->transactions[$i]["value"], Incremento total_confirmed di $this->transactions[$i]["value"], setto processed a 1
						$this->mysql_database->Do_process_users_transaction($this->transactions[$i]);
						$this->Send_mail_transazione_avvenuta($this->transactions[$i]);
					}
				}
			  break;
			  case 2:
				/*echo '<tr class="message_row"  style="background-color:#378517; cursor:pointer;" onclick="Show_transaction_details(\''.$i.'\')">
				<td class="message_data">
					<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->transactions[$i]["ID"].'</span>
				</td>
				<td class="message_data">
					<span style="cursor:pointer; color:'.$colore.'; font-weight:'.$fontweight.'; float:left;">'.$this->transactions[$i]["datetime"].'</span>
				</td>
				<td class="message_from">';
					echo 'Richiesta Riscossione';
				echo '
				</td>
				
			  </tr>';*/
			  break;
			}
		}
	}
	public function Personal_area_riscuoti_effettuato($id){
		
		$this->Get_users_transactions(50);
		
		
		foreach($this->transactions as $transaction)
			if($transaction["ID"]==$id){
				foreach($this->users as $user){
					if($user["ID"]==$transaction["toID"]){
						$usercard = new Card(NULL,$user["Username"]);		
						$this->Send_mail_pagamento_effettuato($usercard->Get_member_email(),$usercard->Getnameshowed(),$transaction["value"],$transaction["nomebeneficiario"],$transaction["iban"],$transaction["swift"]);
					}
				}
				$this->mysql_database->Do_process_users_transaction($transaction);
				return;
			}
			
		echo "Riscossione effettuata. Mail inviata all'utente. OK";
	}
	
	public function Process_users_news(){
		//processo tutti gli utenti iscritti per verificare se hanno news da pubblicare
		for($i=0;$i<count($this->users);$i++){
			$card = new Card(NULL,$this->users[$i]["Username"]);
			//per ogni news dell'utente controllo e pubblico
			for($j=0;$j<count($card->news_rows);$j++){
				$card->pubblica_news($card->news_rows[$j]["id"]);
			}
			  
		}
	}
	public function fix_users_news(){
		//processo tutti gli utenti iscritti per verificare se hanno news da pubblicare
		for($i=0;$i<count($this->users);$i++){
			echo "---------------------------------------------<br/>";
			echo "Utente: ".$this->users[$i]["Username"]."<br/>";
			$card = new Card(NULL,$this->users[$i]["Username"]);
			foreach($card->newsletter_rows as $row){
				
				$card->Store_vcard_emails($row["id_group"],$row["idusernewsletter"],$row["row_value"],1);
				echo "Newsletter row value: ".$row["row_value"]."<br/>";
				echo "Newsletter row ID: ".$row["idusernewsletter"]."<br/>";
				echo "Newsletter row id_group: ".$row["id_group"]."<br/>";
			}
			echo "---------------------------------------------<br/>"; 
		}
	}
	public function Process_users_in_preview(){
		//processo tutti gli utenti iscritti in base al loro status
		for($i=0;$i<count($this->users);$i++){
			switch($this->users[$i]["status"]){
			  case 0:case 2://se user attivo o bloccato non faccio niente
			  break;
			  case 1://se user è impostato per eliminazione da card
			  	//prendo la data di oggi
			  	$today = date("Y/m/d");
				//recupero la data di eliminazione
				$data_eliminazione = date ( 'Y/m/d' ,strtotime($this->users[$i]["remove_date"]) );
				
				//imposto la data di preavviso un giorno ptima
				$data_preavviso = date ( 'Y/m/d' , strtotime('-3 day',strtotime($data_eliminazione)));
					
				//calcolo i giorni rimanenti all'eliminazione
				$datetime1 = new DateTime($data_eliminazione);
				$datetime2 = new DateTime($today);
				$interval = $datetime1->diff($datetime2);
				
				$giorni_left = $interval->format('%a');
				//se $today è uguale alla data di preavviso
				if(strtotime($today)==strtotime($data_preavviso)){
					//invio la mail di preavviso eliminazione
					$this->Send_mail_preavviso_eliminazione($this->users[$i]["Email"],$this->users[$i]["Username"],$giorni_left,date ( 'd/m/Y' ,strtotime($data_eliminazione)));
				}
				
				
				//se $today è uguale alla data di eliminazione
				if(strtotime($today)==strtotime($data_eliminazione)){
					//elimino l'utente come se fosse un eliminazione immediata quindi elimino anche dalla tabella sub_user e decremento la colonna sub_user dalla tabella promoter del referente
					$this->Delete_user($i,1);
				}
				
			  break;
			  case 3://se user non ha pagato e sono passati 8 giorni
			  	
				//prendo la data di oggi
				$today = date("Y/m/d");
				//recupero la data eliminazione
				$data_iscrizione = date ( 'Y/m/d' ,strtotime($this->users[$i]["data"]) );
				
				//recupero la data di eliminazione che sarà 8 giorni dopo l'iscrizione
				$data_eliminazione = date ( 'Y/m/d' , strtotime('+8 day',strtotime($this->users[$i]["data"])));
				//recupero la data di preavviso che sarà 5 giorni dopo quindi 3 giorni prima l'eliminazione
				$data_preavviso = date ( 'Y/m/d' , strtotime('+5 day',strtotime($this->users[$i]["data"])));
				//recupero la data di preavviso per l'admin che sarà 7 giorni dopo quindi 1 giorni prima l'eliminazione
				$data_preavviso_admin = date ( 'Y/m/d' , strtotime('+7 day',strtotime($this->users[$i]["data"])));
				$datetime1 = new DateTime($data_eliminazione);
				$datetime2 = new DateTime($today);
				$interval = $datetime1->diff($datetime2);
				$giorni_left = $interval->format('%a');
				
				//negli ultimi 3 giorni viene inviata la mail di preavviso pagamento
				if(strtotime($today)>=strtotime($data_preavviso)&&strtotime($today)<strtotime($data_eliminazione)){
					$this->Send_mail_preavviso_pagamento($this->users[$i]["Email"],$this->users[$i]["Username"],$giorni_left,date ( 'd/m/Y' ,strtotime($data_eliminazione)));
				}
				
				//l'ultimo giorno viene inviata la mail di avviso non pagato all'admin
				if(strtotime($today)==strtotime($data_preavviso_admin)){
					$this->Send_mail_user_preview($this->users[$i]["ID"]);
				}
				
				if(strtotime($today)>=strtotime($data_eliminazione)){
					//elimino l'utente come se fosse un eliminazione immediata quindi elimino anche dalla tabella sub_user e decremento la colonna sub_user dalla tabella promoter del referente
					$this->Delete_user($i,1);
					//invio email eliminazione avvenuta a admin
					$this->Send_mail_user_deleted($this->users[$i]["ID"]);
					//invio mail eliminazione avvenuta ad utente
					$this->Send_mail_eliminazione_avvenuta($this->users[$i]["Email"],$this->users[$i]["Username"],date ( 'd/m/Y' ,strtotime($data_eliminazione)));
				}
			  	break;
				case 4://se user è impostato per eliminazione da admin
					//prendo la data di oggi
					$today = date("Y/m/d");
					
					//recupero la data di eliminazione che sarà 8 giorni dopo l'iscrizione
					$data_eliminazione = date ( 'Y/m/d' ,strtotime($this->users[$i]["remove_date"]) );
					
					if(strtotime($today)>=strtotime($data_eliminazione)){
						//elimino l'utente come se fosse un eliminazione immediata quindi elimino anche dalla tabella sub_user e decremento la colonna sub_user dalla tabella promoter del referente
						$this->Delete_user($i,1);
						//invio email eliminazione avvenuta a admin
						$this->Send_mail_user_deleted_from_admin($this->users[$i]["ID"]);
					}
			  	break;
			}
		}
	}
	
	function datediff($tipo, $partenza, $fine)
    {
        switch ($tipo)
        {
            case "A" : $tipo = 365;
            break;
            case "M" : $tipo = (365 / 12);
            break;
            case "S" : $tipo = (365 / 52);
            break;
            case "G" : $tipo = 1;
            break;
        }
        $arr_partenza = explode("/", $partenza);
        $partenza_gg = $arr_partenza[0];
        $partenza_mm = $arr_partenza[1];
        $partenza_aa = $arr_partenza[2];
        $arr_fine = explode("/", $fine);
        $fine_gg = $arr_fine[0];
        $fine_mm = $arr_fine[1];
        $fine_aa = $arr_fine[2];
        $date_diff = mktime(12, 0, 0, $fine_mm, $fine_gg, $fine_aa) - mktime(12, 0, 0, $partenza_mm, $partenza_gg, $partenza_aa);
        $date_diff  = floor(($date_diff / 60 / 60 / 24) / $tipo);
        return $date_diff;
    }
	public function Process_sub_users(){
		//prendo tutto dalla tabella sub_user
		$sub_users = $this->Get_all_sub_users();
		
		if(count($sub_users)==0){
			return;	
		}
		
		for($i=0;$i<count($sub_users);$i++){
				$ctrl=0;
				for($j=0; $j<count($this->users);$j++){
					if($sub_users[$i]["username"] == $this->users[$j]["Username"])
						$ctrl=1;
				}
				
				//se l'utente non è più presente
				if($ctrl==0){
					$today = date("Y/m/d");
					$saved_data = strtotime('+1 year',strtotime($sub_users[$i]["data"]));
					$saved_data = date ( 'Y/m/d' , $saved_data );
					
					//se è passato un'anno dall'iscrizione
					if($today>$saved_data){
						//elimino la riga della tabella sub_user
						$this->mysql_database->Do_delete_sub_user($sub_users[$i]["username"]);
					}
				}
		}
		
	}
	
	public function Create_fattura_iscrizione($username,$data,$from_ipn=NULL){
		//error_log("Create fattura iscrizione START");
		$data = date("d-m-Y",strtotime($data));
		$card= new Card($username);
		
		$idfattura = $this->mysql_database->Insert_new_fattura($card->user_id,$data,AMMOUNT);
		//error_log("Fattura Salvata nel DB");
		
		// initiate PDF 
		$pdf = new PDF_fattura(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//error_log("Inizializzo fattura");
		
		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(false);
			
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($card->Get_nomeandcognome());
		$pdf->SetKeywords('Top, Manager, group, fattura iscrizione');
		
		$pdf->SetMargins(0, 0, 0); 
		$pdf->SetAutoPageBreak(true, 0); 
		$pdf->setFontSubsetting(false); 
	
		$pdf->AddPage(); 
		
		//Dati cliente
		$pdf->SetFont("Helvetica", "", 8); 
		$dati_cliente = $card->Get_nomeandcognome()."<br/>";
		if($card->society==1){
			$dati_cliente .= "P.I. : ". $card->codfis."<br/>";	
		}else{
			$dati_cliente .= "C.F. : ". $card->codfis."<br/>";
		}
		$pdf->MultiCell(80,10,$dati_cliente,0,J,false,1,18,87,true,0,true,true,0,'T',false);
	
		//Servizio card
		$pdf->SetFont("Helvetica", "", 9); 
		$servizio = "Servizio Card ".date("m/Y",strtotime($data))."<br/>";
		$pdf->MultiCell(60,100,$servizio,0,J,false,1,20,107,true,0,true,true,0,'T',false);
		
		//Data Fattura
		$pdf->SetFont("Helvetica", "", 9); 
		$datafattura = date("d/m/Y",strtotime($data));
		$pdf->MultiCell(60,100,$datafattura,0,J,false,1,150,50,true,0,true,true,0,'T',false);
		
		//Numero Fattura
		$pdf->SetFont("Helvetica", "", 9); 
		$numerofattura = $idfattura."/T";
		$pdf->MultiCell(60,100,$numerofattura,0,J,false,1,150,43,true,0,true,true,0,'T',false);
		
		$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');
		
		$nome_file_fattura = "fattura ".$card->username." ".$data.".pdf";
		//error_log("Terminata la scrittura della fattura");
		
		if($from_ipn!=NULL){
			//error_log("Salvataggio file fattura");
			$pdf->Output('fatture/'.$nome_file_fattura, 'F');
		}else{
			$pdf->Output('../../fatture/'.$nome_file_fattura, 'F');
		}
		
		$this->Send_mail_fattura($card->username,$nome_file_fattura,$card->Get_nomeandcognome(),$from_ipn);
		
	}
	
	
	public function Create_ritenuta_acconto($total_confirmed,$username,$nomebeneficiario,$iban,$codfis,$swift,$data){
		$card= new Card($username);

		// initiate PDF 
		$pdf = new FPDI('P','mm','A4',true, 'UTF-8',false); 
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
			
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($card->Get_nomeandcognome());
		$pdf->SetKeywords('Top, Manager, group, ritenuta acconto');
		
		 
		$pdf->SetMargins(0, 0, 0); 
		$pdf->SetAutoPageBreak(true, 0); 
		$pdf->setFontSubsetting(false); 
	
		$pdf->AddPage(); 
		
		//Dati cliente
		$pdf->SetFont("times", "", 12); 
		$dati_cliente = "Spett.le<br/>";
		$dati_cliente .= $nomebeneficiario."<br/>";
		$dati_cliente .= "C.F. : ".$codfis."<br/>";
		$dati_cliente .= "Nome utente topmanagergroup: ".$card->username."<br/>";
		$pdf->MultiCell(80,10,$dati_cliente,0,J,false,1,10,10,true,0,true,true,0,'T',false);
	
	
		//Dati cliente
		$pdf->SetFont("times", "", 12); 
		$dati_tmg = "Spett.le<br/>";
		$dati_tmg .= "EXPORECLAM S.A.S.<br/>";
		$dati_tmg .= "Via Marconi 23<br/>";
		$dati_tmg .= "21012 Cassano Magnago (VA)<br/>";
		$dati_tmg .= "P.IVA : 02346940022<br/>";
		$dati_tmg .= "C.F. : MNSLNA80H21L682V<br/>";
		$pdf->MultiCell(60,100,$dati_tmg,0,J,false,1,140,10,true,0,true,true,0,'T',false);
		
		
		$ra20 = ($total_confirmed*20)/100;
		$netto = $total_confirmed - $ra20;
		//Corpo ritenuta
		$pdf->SetFont("times", "", 12); 
		$corpo = "Cassano Magnago, ".$data."<br/><br/><br/>";
		$corpo .= "Compenso per prestazione occasionale per promozione prodotto<br/>";
		$corpo .= "Imponibile:    € ".$total_confirmed."<br/>";
		$corpo .= "R.A. 20%:      € ".$ra20."<br/>";
		$corpo .= "Netto a pagare: € ".$netto."<br/>";
		$pdf->MultiCell(200,100,$corpo,0,J,false,1,10,60,true,0,true,true,0,'T',false);
	
		//Corpo ritenuta
		$pdf->SetFont("times", "", 12); 
		$corpo = "Pagamento B/B 15 Giorni dalla data di fatturazione.<br/>";
		$corpo .= "IBAN: ".$iban."<br/>";
		$corpo .= "Compenso non soggetto a IVA ai sensi dell'art. 5 DPR 26/10/72 n°633 e successive modificazioni.<br/>";
		$pdf->MultiCell(200,100,$corpo,0,J,false,100,10,140,true,0,true,true,0,'T',false);
	
		
		$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');
		
		
		$pdf->Output('../../ritenute/RA '.$card->username.' '.$data.'.pdf', 'F');
	}
	
}
?>