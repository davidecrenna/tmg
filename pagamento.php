<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php 
	require_once("headerbasic.php");
	include("header.php");
	include("lang/Globals_lang_it.php");
	
	//prelevo le variabili del form
	$nome_utente = $_POST["nome"];
	$cognome_utente = $_POST["cognome"];
	$nickname = $_POST["nickname"];
	$is_society = $_POST["is_society"];
	$is_giovane = $_POST["is_giovane"];
	$codfiscale = $_POST["codfiscale"];
	$alternative_url = $_POST["alternative_url"];
	
	//Se è società non può essere giovane
	if($is_society==1)
		$is_giovane==0;
	
	if($is_society==0&&$nickname=="")
		$username = correggi($nome_utente).correggi($cognome_utente);
	else
		$username = correggi($nickname);
	
	$username = strtolower($username);
	$email =  strtolower($_POST["email"]);
	$username_referente = $_POST["username_referente"];
	$password = $_POST["pass"];
	
	$result = Ctrlusernotexists($username);
	
	if($result==false){
		$error_message= "Esiste già un membro con Username: ".$username.", ripeti la registrazione cambiando Username.";
	}else{
		if($username_referente!="tmg"){
			$id_referente = Getidreferente($username_referente);
		}else{
			$id_referente = 0;
			$username_referente = "TOPMANAGERGROUP";
		}
	}
	
	/*$result = Ctrlemailnotexists($email);
	if($result==false)
		$error_message = "<br/>Esiste già un membro con email: ".$email.", ripeti la registrazione cambiando Email.";
	
	
	if($is_giovane==1){
		$result = Ctrlcodfisnotexists($codfiscale);
		if($result==false){
			$error_message = "<br/>Esiste già un membro con Cod fiscale: ".$codfiscale.", Puoi creare solo una card associata ad un unico codice fiscale.";
		}
	}*/
	
	if($error_message==""){
		if(($username!= "")&&($email != "") && ($password != "") ){
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		
			/* check connection */
			if (mysqli_connect_errno()) {
				$error_message= ERR_DB_CONNECTION;
			}
            //$md5password = md5($password);
			$idTransazione =  Generate_IDT();
			/* create a prepared statement */
			$stmt = $mysqli->prepare("INSERT INTO ".USER_TEMP_TABLE." (Username,Nome,Cognome,Password,Email,ID_Referente,idTransazione,society,is_giovane,codfiscale,alternative_url) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
			/* bind parameters for markers */
			$stmt->bind_param("sssssisiiss",$username,$nome_utente,$cognome_utente,$password,$email,$id_referente,$idTransazione,$is_society,$is_giovane,$codfiscale,$alternative_url);
			$stmt->execute();
			$stmt->close();
			/* close connection */
			$mysqli->close();
		}
		else{
			$error_message=ERR_REGISTRATION_DATA;
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
	
	function Getidreferente($username_referente){
		//controllo che l'utente non sia già presente nel DB
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	
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

?>


<title>Pagamento - Top Manager Group</title>
<link rel="stylesheet" type="text/css" href="step2/css/step2.css"/>
<link rel="stylesheet" type="text/css" href="css/common.css"/>
<link rel="stylesheet" type="text/css" href="common/css/text.css"/>
<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>

</head>

<body>

	<div align="center"><a href="index.php"><img src="image/banner/banner_scaled.png" border="0"/></a></div>
	<div align="center">
          <div class="cols">
                      <div style="" class="col">
                      	<?php if($error_message=="" && $is_giovane==0){?>
                                
                            <div align="center" style="text-align:center; margin-top:20px;">
                            	<p class="text14px">Il costo dell'iscrizione annuale a top manager group e' di € 96 annuali incluso i.v.a.</p>
                                  <p class="titolo2">Paga tramite Carta di credito:</p>
                                
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="XH65Z8MJHNJ5S">
                                    <input type="image" src="image/icone/logo_carte_credito.png" border="0" name="submit" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare.">
                                    <input type="hidden" name="custom" value="<?php echo $idTransazione; ?>">
								</form>                               
                                
                                
                              <!--Sandbox account tmg
                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                <input type="hidden" name="cmd" value="_s-xclick">
                                <input type="hidden" name="hosted_button_id" value="C9KUDKV8CFBRQ">
                                <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                <input type="hidden" name="custom" value="<?php echo $idTransazione; ?>">
                                </form>-->
                                 <br/>
                                <p class="titolo2">Paga tramite Paypal:</p>
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="XH65Z8MJHNJ5S">
                                    <input type="image" src="https://www.paypalobjects.com/webstatic/mktg/logo-center/logo_paypal_sicuro.png" border="0" name="submit" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare.">                                 <br/>
                                    <a href="https://www.paypal.com/it/webapps/mpp/why" target="_blank"><font size="2" face="Arial" color="#0079CD"><strong>Come funziona PayPal</strong></font></a>
                                    <input type="hidden" name="custom" value="<?php echo $idTransazione; ?>">
								</form>
                                 <br/>
                                <p class="titolo2">Paga tramite bonifico bancario:</p>
                                <form action="creabonifico.php" method="post" name="formbonifico">
                                    <input type="hidden" name="idTransazione" value="<?php echo $idTransazione; ?>">
                                    <input type="image" src="image/pagamento/btn/btn_bonifico.png" border="0" name="submit" alt="Paga tramite bonifico."> 
                                    <!--<input type="submit" value="Procedi"/>-->
                                
                            	</form>
                            </div>
                       
                       <?php }
					   else if($error_message=="" && $is_giovane==1){?>
						     <div align="center" style="text-align:center; margin-top:100px;">
                            	<p class="text14px">Complimenti, Hai un'età compresa tra 18 e 24 anni! Puoi usufruire dell'offerta Top Manager Group: La card ti verrà fornita gratuitamente, conferma l'iscrizione: </p>                                <form action="creagiovane.php" method="post">
                            	<input type="hidden" name="idTransazione" value="<?php echo $idTransazione; ?>">
                                <input type="submit" value="Procedi"/>
                            	</form>                  
                                <br/>
                            </div>
                            
					  <? }else{?>
							<div align="center" style="text-align:center; margin-top:150px;">
                            	<p class="titolo2"><? echo $error_message; ?></p>    
                            </div>
					   <?php 
					   }?>
                       </div>
                      <div style="left: 280px;" class="col2">
                       
                       </div>
                      
                      
                      <div style="left: 760px;" class="col3">
                    </div>
               </div>
               
                  
               <div id="card_down">
                  <div style="margin-left:19px;">
                	 <button class="prev" name="submit" type="button" onclick="location.href='index.php?tab=iscrizione'"></button> 
                  </div>
               </div>
           
          </div>

</body>
</html>