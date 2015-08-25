<?php

class classe_login
    {
    // (C) emmebì, 2007/02.
	private $mysql_database;


    public function __construct()
   {
		$this->mysql_database = new AreaMySqlDatabase();
   }


    public function __destruct()
	{
		exit;
	}

    public function invia_sfida($email)
    {
        $sfida = $this->__crea_sfida();
		
		$this->mysql_database->invia_sfida_area($sfida,$email);
		return $sfida;
    }

    public function verifica_login($email,$password_utente,$sfida){
        $user = $this->mysql_database->verifica_login($email,$password_utente,$sfida);
		
		//cancello la sfida dal DB
		$this->mysql_database->Elimina_sfida($email);
		
        // Utente autenticato.
        if ($user!=false){
            // Inserisco una pausa di 1 sec., ininfluente per l'utente, dannosissima per procedure automatizzate.
            sleep(1);
            return $user;
        }
        // Utente non autenticato.
        else{
            sleep(1);
            return false;
        }
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
