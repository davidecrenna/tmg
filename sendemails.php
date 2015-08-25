<?php
	require_once("headerbasic.php");
	require_once 'header.php';
	//Send_email("minoli.luigi@gmail.com");
	//Send_email("dvdcrenna@gmail.com");
	$urls="80K_email_privati_IT.txt";
	$page = join("",file("$urls"));
	$kw = explode("\n", $page);
	 
	for($i=2000;$i<2500;$i++){
		echo "SENDING TO ".$kw[$i]."...<br/>";
		Send_email($kw[$i]);
		echo $kw[$i]."INVIATO <br/>";
		echo "email numero ".$i."<br/>";
	}
	function Send_email($address){
		$mail = new PHPMailer(true);
		$email = $address;
		try { 
		  $mail->AddAddress($address);
		  $mail->SetFrom("davide.crenna@topmanagergroup.com","Davide crenna");
				  
		  $oggetto = "TopManagerGroup un modo per presentarti.";
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
			
				</style>
					<body>
						<div align='center'>
							
							<div align='center'id='corpomail'> 
								Ciao!<br/>
								Ti voglio rubare solo qualche minuto, mi presento sono Davide Crenna, sono un chitarrista classico, acustico ed elettrico che cerca di farsi conoscere. Studio al conservatorio di Como e abito a Gorla Minore.<br/>
								<strong>Cosa voglio dirti con questa email?</strong><br/>
								Voglio farti scoprire un sito che ti pu&oacute; dare la possibilit&aacute; di presentarti in maniera efficace e professionale e diventare una fonte di guadagno.<br/>
								<strong>Che cos'&eacute;?</strong><br/>
								&Eacute; un sito di web identity card, ovvero pagine personali tramite le quali potrai far conoscere alle persone a cui darai il tuo contatto quello che fai nella vita e quello per cui ti promuovi oppure iscrivendoti come azienda potrai far conoscere la tua attivit&aacute;.<br/>
								<strong>Va bene, ma quali servizi mi offre?</strong><br/>
								Con l'iscrizione al gruppo avrai la tua pagina personale completamente AUTOGESTIBILE come qualsiasi profilo social network, un indirizzo email, un biglietto da visita professionale, un posto dove caricare file fino a 2GB, una mailing list e molto altro..<br/>
								<strong>OK. Ma come posso guadagnare e quanto costa?</strong><br/>
								Partiamo dalla &ldquo;nota dolente&rdquo;. Se hai pi&uacute; di 25 anni il costo dell'iscrizione &eacute; 96 euro annuali, altrimenti &eacute; gratuito!<br/>
								Potrai guadagnare 25 euro a persona per ogni membro adulto che indicher&aacute; te come referente!<br/><br/>								
								<strong>Ora se vuoi visionare la mia web identity card ti riporto qui sotto il link:</strong>
								<a href='http://www.topmanagergroup.com/davide.crenna'>www.topmanagergroup.com/davide.crenna</a><br/>
								
								Non dovrai scaricare niente, non ci sono virus, &eacute; semplicemente uno strumento utile per farti conoscere e potrebbe trasformarsi in una tua fonte di guadagno. Per qualsiasi altra informazione contattami o visita la home del sito (<a href='http://www.topmanagergroup.com'>www.topmanagergroup.com</a>). <br/>
								Grazie!<br/><br/>
								
								Davide Crenna<br/>
								davidecrenna@tomanagergroup.com

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
?>