<?
	require_once "headerbasic.php";
	require_once 'header.php';
	if(isset($_POST["idTransazione"]))
		$idTransazione = $_POST["idTransazione"];
	if($idTransazione!=""){
		$iscrizione = new Iscrizione($idTransazione,"");
		
		//preview = 1 significa che verrà settato lo status = 3 quindi l'utente sarà nello status "NON PAGATO"
		$preview = 1;
		$iscrizione->Create_new_user($preview);
		
		//creo la cartella dell'utente
		$iscrizione->Create_user_folder();
		
		//invio la mail di benvenuto
		$iscrizione->send_mail();
		
		//invio la mail di pagamento
		$iscrizione->send_mail_bonifico();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Iscrizione - Top Manager Group</title>
</head>
<body>

<link rel="stylesheet" type="text/css" href="thank-you/css/thank-you.css"/>
<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>

</head>

<body>

	<div align="center"><a href="index.php"><img src="image/banner/banner_scaled.png" border="0"/></a></div>
	<div align="center">
          <div class="cols" id="scheda1">
                      <div style="" class="col">
                      		<p style="position:absolute; left:50px; top:20px; width:500px; font-size:18px; font-family:Arial, Helvetica, sans-serif;"><img style="height:25px; width:30px; vertical-align:middle;" src="image/icone/ok.png">Complimenti ora sei iscritto a TopManagerGroup.com!<br>
								  <b>Hai 7 giorni per effettuare il pagamento di €96.</b><br></p>
                                  
                                  <div style='position:absolute; left:50px; top:90px; width:800px; font-size:18px; font-family:Arial, Helvetica, sans-serif; '>
                                  	<b>Puoi pagare tramite un bonifico bancario</b><br/>
                                    NOME COGNOME INTESTATARIO: Exporeclam sas<br/>
									IBAN: IT96W0200850110000041182842<br/>
                                    
									CAUSALE: Iscrizione TopManagerGroup di ............. (indicare al posto dei puntini nome e cognome utilizzati nell'iscrizione al gruppo)<br/>
                                  	Conserva queste informazioni che ti sono state inviate anche al tuo indirizzo e-mail.
                                    <br/><br/>
								  	Grazie<br/>
								  	Lo staff di TMG<br/>
                                  </div>
                      
                      </div>
                  
                      <div style="left: 280px;" class="col2">
                       
                       </div>
                      
                      
                      <div style="left: 760px;" class="col3">
                    </div>
               </div>
               
                  
               <div id="card_down">
                <a href="index.php"><img src="image/btn/btn_torna_alla_home.png" onmouseover="Javascript:this.src='image/btn/btn_torna_alla_home_over.png'" onmouseout="Javascript:this.src='image/btn/btn_torna_alla_home.png'" style="cursor:pointer; padding-top:30px;"/></a>
               </div>
           
          </div>

</body>
</html>