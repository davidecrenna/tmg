<?php

class classe_login
    {
	private $mysql_database;
	
    public function __construct(){
	   $this->mysql_database = new MySqlDatabase();
   }


    public function __destruct(){
        exit;
    }


    // *****************************************************************
    // METODI PUBBLICI
    // *****************************************************************

    // invia_sfida(string username):
    // 1. crea una sfida (stringa casuale);
    // 2. salva le informazioni sulla sfida (relativa all'utente in fase di autenticazione *);
    // 3. ritorna la sfida stessa (o false in caso di errore).

    // (*) ATTENZIONE: particolari attacchi (flood non controllati) potrebbero portare ad un DoS temporaneo per l'utente.

    public function invia_sfida($user)
    {
        $sfida = $this->__crea_sfida();
		$this->mysql_database->invia_sfida($sfida,$user);
		return $sfida;
    }


    // verifica_login(strings):
    // Ritorna i dati da salvare nella sessione se login valido; false in caso contrario.
    // Algoritmo: utente autenticato se MD5(sfida + MD5(password_in_chiaro)) == password_utente;
    // poichè su db è salvato l'hash MD5 della password: utente autenticato se MD5(sfida + password_db) == password_utente.

    public function verifica_login($user,$password_utente,$sfida){
		$dati = $this->mysql_database->verifica_login($user,$password_utente,$sfida);
		//cancello la sfida dal DB
		$this->mysql_database->elimina_sfida($user);
		// Utente autenticato.
        if ($dati!=false){
            // Inserisco una pausa di 1 sec., ininfluente per l'utente, dannosissima per procedure automatizzate.
            sleep(1);
            return $dati;
        }
        // Utente non autenticato.
        else{
            sleep(1);
            return false;
        }
    }
	
	public function Set_cookie_resta_collegato($hash,$email){
		$this->mysql_database->Set_cookie_resta_collegato($hash,$email);
	}

    // *****************************************************************
    // METODI PRIVATI
    // *****************************************************************

    // __purifica(string stringa):
    // elimina ogni "pericolo" nelle stringhe in input per il db ed opera il corretto escape dei caratteri riservati.

    private function __purifica($dato){
        return mysql_real_escape_string(strip_tags(trim($dato)));
    }


    // __crea_sfida():
    // ritorna una stringa casuale.

    private function __crea_sfida(){
        return md5(uniqid(rand(), true));
    }


    // __stampa_errore():
    // stampa l'errore specificato a video (tramite requester JavaScript).

    private function __stampa_errore($descrizione_errore){ 
        ?>
        <script language="javascript">
            alert("ERRORE: <?=$descrizione_errore?> ");
        </script>
        <?php
    }

}
