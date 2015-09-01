<?php
class Login
{

	public function Show_login($in_login=NULL,$password=NULL,$error_messsage=NULL,$login_attempt=NULL,$sfida=NULL){

		
		echo '<div id="personal_login_container">';
		echo '<div class="personal_login">';
			echo "<div class='login_loading' id='login_loading'><img src='image/icone/ajax_small.gif' alt='loading'></div>";
			echo " <input type='hidden' name='copia_sfida' id='copia_sfida'>";
			if($error_messsage){
				echo "<div style='position:absolute; top:150px; left:20px;'>";
				echo $error_messsage;
				echo "<a style='color:#000; cursor:pointer;' target='_self' onclick='Javascript:show_recupero_password()' style='cursor:pointer;'>Hai dimenticato la password?</a><br/>";
				echo "</div>";
			}
			
			if(isset($_COOKIE["tmguser"]))
				$in_login = $_COOKIE["tmguser"];
			if($in_login!=NULL)
				echo '<input class="login_input_email" type="text" name="user" id="user" value="'.$in_login.'" OnChange="comunicazione_ajax(\'card/php/card_handler.php?__user\',this.name,this.value)" style="color:#FFF;" />';
			else
				echo '<input class="login_input_email" type="text" name="user" id="user" value="nome.cognome o nomesocietà" onclick="javascript: forminput_login_click();" OnChange="comunicazione_ajax(\'card/php/card_handler.php?__user\',this.name,this.value)" style="color:#FFF;" />';
	
			echo '
					<input class="login_input_pass" type="password" name="pwd" id="pwd" onkeydown="intercettaPressioneTastoInvio(event);" value="'.$password.'" style="color:#FFF;"/>
				 <span class="login_domain_container">@topmanagergroup.com</span>
				 <input type="hidden" name="user_id" id="user_id" value="'.$this->user_id.'" />
				 <input type="hidden" name="pwd_codified" id="pwd_codified" value="" />
					
				
				<input type="hidden" name="login_attempt_num" id="login_attempt_num" value="'.$login_attempt.'" />';
			echo "<div style='position:absolute; top: 154px; left:200px; color:#000;' >";
				echo "<input type='checkbox' name='resta_collegato' id='resta_collegato' style='border:0px;  vertical-align:middle;'/> resta collegato";
			echo "</div>";
			echo "<div style='position:absolute; top: 180px; left:220px;'>";
			echo $this->Show_login_button();
			echo "</div>";
			echo "<input id='user_logged' type='hidden' value='0'></input>";
			echo "</div>";
		echo "</div>";
	}
	public function Show_login_home_banner($in_login=NULL,$password=NULL,$error_messsage=NULL,$login_attempt=NULL,$sfida=NULL){
			echo "<div class='login_loading' id='login_loading'><img src='image/icone/ajax_small.gif' alt='loading'></div>";
			echo " <input type='hidden' name='copia_sfida' id='copia_sfida'>";
			if($error_messsage){
				echo "<div style='position:absolute; top:76px; left:910px; font-size:11px;'>";
				echo $error_messsage;
				echo "<br/><a style='color:#FFF; cursor:pointer;' target='_self' onclick='Javascript:show_recupero_password()' style='cursor:pointer; '>Hai dimenticato la password?</a>";
				echo "</div>";
			}
			
			if(isset($_COOKIE["tmguser"]))
				$in_login = $_COOKIE["tmguser"];
			if($in_login!=NULL)
				echo 'User <input class="login_input_email_home" type="text" name="user" id="user" value="'.$in_login.'" OnChange="comunicazione_ajax(\'card/php/card_handler.php?__user\',this.name,this.value)" style="color:#FFF;" />';
			else
				echo 'User <input class="login_input_email_home" type="text" name="user" id="user" value="nome.cognome o nomesocietà" onclick="javascript: forminput_login_click();" OnChange="comunicazione_ajax(\'card/php/card_handler.php?__user\',this.name,this.value)" style="color:#FFF;" />';
			
			echo '<br/>Password <input class="login_input_pass_home" type="password" name="pwd" id="pwd" onkeydown="intercettaPressioneTastoInvio(event);" value="'.$password.'" style="color:#FFF;"/>
				 <input type="hidden" name="user_id" id="user_id" value="'.$this->user_id.'" />
				 <input type="hidden" name="pwd_codified" id="pwd_codified" value="" />
					
				
				<input type="hidden" name="login_attempt_num" id="login_attempt_num" value="'.$login_attempt.'" />';
			/*echo "<div style='position:relative; top: 154px; left:200px; color:#000;' >";
				echo "<input type='checkbox' name='resta_collegato' id='resta_collegato' style='border:0px;  vertical-align:middle;'/> resta collegato";
			echo "</div>";*/
			echo "<br/>";
			
			echo "<div class='buttonhome brown' id='log_in_button' style='margin-top:5px; margin-left:155px;' onclick='Javascript:Login()'>
			      <span class='text12px'>ENTRA</a>
			  </div>";
			echo "<input id='user_logged' type='hidden' value='0'></input>";
	}
	public function Show_logout_button(){
		echo "<img src='../image/btn/btn_logout.png' alt='Logout.' id='log_out_button' name='log_out_button' style='vertical-align:middle;' class='img_button' onclick='Javascript:Logout()' onmouseover='Javascript:this.src=\"../image/btn/btn_logout_over.png\"' onmouseout='Javascript:this.src=\"../image/btn/btn_logout.png\"' />";	
	}
	
	
	/*public function Show_login_button(){
		echo "<img src='image/login/btn/btn_login.png' alt='Login.' id='log_in_button' name='log_in_button' style='vertical-align:middle;' class='img_button' onclick='Javascript:Login()' />";
		
	}*/
	public function Show_login_button(){
		echo "<div class='styledbutton brown' id='log_in_button' onclick='Javascript:Login()'>
			      <span class='text14px'>ENTRA</a>
			  </div>";
	}

}
?>