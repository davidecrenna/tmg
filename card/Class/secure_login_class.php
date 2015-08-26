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

    /*public function verifica_login($user,$password_utente,$sfida){
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
    }*/

    /**
     * @param $email
     * @param $password
     * @param $sfida
     * @return bool
     */
    function verifica_login($username, $password, $sfida) {
        // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
        if ($stmt = $this->mysql_database->Get_stmt_login()){
            $stmt->bind_param('ss', $username,$sfida); // esegue il bind del parametro '$email'.
            $stmt->execute(); // esegue la query appena creata.
            $stmt->store_result();
            $stmt->bind_result($user_id, $db_username, $db_password, $salt); // recupera il risultato della query e lo memorizza nelle relative variabili.
            $stmt->fetch();
            $password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.
            $num_rows = $stmt->num_rows;
            $this->mysql_database->elimina_sfida($username);
            if($num_rows == 1) { // se l'utente esiste
                // verifichiamo che non sia disabilitato in seguito all'esecuzione di troppi tentativi di accesso errati.
                if($this->Check_brute($user_id) == true) {
                    // Account disabilitato
                    // Invia un e-mail all'utente avvisandolo che il suo account è stato disabilitato.
                    return false;
                } else {
                    if($db_password == $password) { // Verifica che la password memorizzata nel database corrisponda alla password fornita dall'utente.
                        // Password corretta!
                        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.

                        $user_id = preg_replace("/[^0-9]+/", "", $user_id); // ci proteggiamo da un attacco XSS
                        $_SESSION['user_id'] = $user_id;
                        $db_username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $db_username); // ci proteggiamo da un attacco XSS
                        $_SESSION['username'] = $db_username;
                        $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                        // Login eseguito con successo.
                        sleep(1);
                        return true;
                    } else {
                        // Password incorretta.
                        // Registriamo il tentativo fallito nel database.
                        $now = time();
                        $this->mysql_database->Insert_login_attempt($user_id,$now);
                        sleep(1);
                        return false;
                    }
                }
            } else {
                // L'utente inserito non esiste.
                return false;
            }
        }
    }
    function Check_brute($user_id) {
        return $this->mysql_database->Check_brute($user_id);
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
