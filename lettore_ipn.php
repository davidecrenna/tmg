<?
session_start();
require_once "lang/Globals_lang_it.php";
require_once "config/config_all.php";

include("config/db_config.inc.php");

require_once "tcpdf_min/tcpdf.php";
require_once "fpdi/fpdi.php";

//require_once "tcpdf/config/lang/eng.php";
require_once "card/Class/main.php";
require_once "area/Class/main.php";
require_once "card/Class/iscrizione.php";
require_once('PHPMailer/class.phpmailer.php');
require_once('httpsocket/httpsocket.php');


	
abstract class IPNListener
{
    private function isVerifiedIPN()
    {
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value){
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
 
        //Modificando la costante SIMULATION nel file di configurazione
        //è possibile passare dall'ambiente di simulazione a quello di produzione
        if(SIMULATION==1)
        {
            $url = SIMULATION_URL;
        }
        else
        {
            $url = PRODUCTION_URL;
        }
 
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Host: $url:443\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
 
        $fp = fsockopen ("ssl://$url", 443, $errno, $errstr, 30);
 
        if (!$fp)
        {
            // HTTP ERROR
            // $errstr - $errno
            $this->sendReport();
            return FALSE;
        }
        else
        {
            fputs ($fp, $header . $req);
            while (!feof($fp))
            {
                $res = fgets ($fp, 1024);
                if (strcmp($res, "VERIFIED") == 0)
                {
                    fclose ($fp);
                    return TRUE;
                }
                else if (strcmp ($res, "INVALID") == 0)
                {
                    //se la procedura non è legittima invia un email all'amministratore
                    $this->sendReport();
                    fclose ($fp);
                    return FALSE;
                }
            }
        }
    }
 
    private function sendReport()
    {
        if(SIMULATION==1)
        {
            $add = "- SIMULAZIONE -";
        }
        else
        {
            $add = "";
        }
        //messaggio all'amministratore
        $subject = "$add Problema IPN";
        $message = "Si è verificato un problema nella seguente transazione:\r\n\r\n";
        $message .= "Nome: " . $_POST['first_name'] . ' ' . $_POST['last_name'] . "\r\n";
        $message .= "email: " . $_POST['payer_email'] . "\r\n";
        $message .= "id transazione: " . $_POST['txn_id'] . "\r\n";
		$message .= "id transazione tmg: " . $_POST['custom'] . "\r\n";
        $message .= "oggetto: " . $_POST['transaction_subject'];
 
        mail(ADMIN_MAIL,$subject,$message,"From: " . NO_REPLY);
        return;
    }
 
    private function isCompleted()
    {
        if(trim($_POST['payment_status']) === "Completed")
        {
            return TRUE;
        }
        return FALSE;
    }
 
    private function isPrimaryPayPalEmail()
    {
			
 
        if(SIMULATION==1)
        {
            $email = PRIMARY_SANDBOX_EMAIL;
        }
        else
        {
            $email = PRIMARY_PAYPAL_EMAIL;
        }
 		
        if(trim($_POST['receiver_email']) === $email)
        {
            return TRUE;
        }
        return FALSE;
    }
 
    abstract protected function isVerifiedAmmount();
    abstract protected function isNotProcessed();
 
    protected function isReadyTransaction()
    {
        if(
			$this->isVerifiedIPN()
           && $this->isPrimaryPayPalEmail()
           && $this->isNotProcessed()
           && $this->isVerifiedAmmount()
        // && $this->isCompleted()
		){
               return TRUE;
           }
        return FALSE;
		//return true;
    }
}
 
class YIIListener extends IPNListener
{
    protected $conn;
	public $txt;
	private $idTransazione;
	private $iscrizione;

	protected function isVerifiedAmmount()
	{	
		if($_POST['mc_gross'] == AMMOUNT)
		{
			return TRUE;
		}

		return FALSE;
	}

	protected function isNotProcessed()
	{
		$this->dbConnect();
		$sql = "SELECT * FROM ".USER_TABLE." WHERE idTransazione='".$this->idTransazione."'";
		$res = mysql_query($sql, $this->conn);
		if(mysql_num_rows($res))
		{
			return FALSE;
		}
		return TRUE;
	}

	protected function dbConnect()
	{
		$this->conn = @mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) OR die();
		@mysql_select_db(DB_DATABASE,$this->conn) OR die();
	}

	public function insertNewUser()
	{
		$this->idTransazione = $_POST['custom'];
		
		//l'utente ha pagato e può essere iscritto
		if($this->isReadyTransaction())
		{
			//inizializzo la classe iscrizione
			$this->iscrizione = new Iscrizione($this->idTransazione,$_POST['payer_email']);
			//creo l'utente nella tabella USER
			$this->iscrizione->Create_new_user();
			//creo la cartella dell'utente
			$this->iscrizione->Create_user_folder();
			//invio la mail di benvenuto
			$this->iscrizione->send_mail();
		}
	}
}
$ipn = new YIIListener();
$ipn->insertNewUser();

?>


