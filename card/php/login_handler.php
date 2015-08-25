<?php
	require_once("../../headerbasic.php");
	include("../../header.php");
	if (isset($_GET['__user']))
    {
		if (trim($_POST['email'])!="")
		{
			// Ritorna al client la sfida.
			$login = new classe_login($db_conn);
			echo $login->invia_sfida($_POST['email']);
		}
		exit;
    }
	
	if (isset($_GET['__submit']))
    {
		$login_obj = new Login();
    	if ((trim($_POST['user'])!="" && trim($_POST['pwd'])!="" && trim($_POST['copia_sfida'])!=""))
        {
			
			$login = new classe_login($db_conn);
			if ($dati = $login->verifica_login($_POST['user'],$_POST['pwd'],$_POST['copia_sfida']))
			{
				// Utente valido: inserisco i dati contenuti nel db nella sessione.
				session_regenerate_id();
				
				$_SESSION['ID'] = $dati['ID'];
            	$_SESSION['Cognome'] = $dati['Cognome'];
				
				if($_POST['resta_collegato']=="true"){
					$cookie_value = md5($dati['ID'].$dati['Cognome'].uniqid());
					setcookie("resta_collegato", $cookie_value,time()+60*60*24*30,"/");
					$login->Set_cookie_resta_collegato($cookie_value,$_POST['user']);
					
				}
				if(!isset($_COOKIE["tmguser"]))
					setcookie("tmguser",$dati['Username'],time()+60*60*24*30,"/");
				echo "<input id='user_logged' type='hidden' value='1' />";
				echo "<input id='username' type='hidden' value='".$dati['Username']."' />";
			}
			else{
				$login_obj->Show_login_home_banner(NULL,NULL,'<span style="color:red; font-size:10px;"><img src="image/icone/error.png" width="10" height="10" alt="Errore nel login"> Controlla i tuoi dati.</span>',NULL,$_POST['copia_sfida']);
			}
			exit;
        }
		else{
				$login_obj->Show_login_home_banner(NULL,NULL,'<span style="color:red;  font-size:10px;"><img src="image/icone/error.png" width="10" height="10" alt="Errore nel login"> Controlla i tuoi dati.</span>',NULL,$_POST['copia_sfida']);
		}
    //altrimenti ri-visualizza il form di login.
    }
?>