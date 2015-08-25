<?
	require_once "headerbasic.php";
	require_once 'header.php';
	if(isset($_POST["idTransazione"]))
		$idTransazione = $_POST["idTransazione"];
	if($idTransazione!=""){
		$iscrizione = new Iscrizione($idTransazione,"");
		$iscrizione->Create_new_user();
		$iscrizione->Create_user_folder();
		$iscrizione->send_mail();
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
                      		<p style="position:absolute; top:150px; width:900px; font-size:18px; font-family:Arial, Helvetica, sans-serif;" ><img src="image/icone/ok.png" style="height:25px; width:30px; vertical-align:middle;"/>Complimenti ora sei iscritto a TopManagerGroup.com!<br/>
								  A breve ti verrà inviata una mail contenente le istruzioni per completare la tua iscrizione ed iniziare ad utilizzare subito tutti i servizi offerti da TMG.<br/>
								  Grazie<br/>
								  Lo staff di TMG<br/></p>
                      
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