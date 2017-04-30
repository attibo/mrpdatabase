<?php
/*
db_conn_i() - Attilio Bongiorni - settembre 2013
Effettua la connessione ad un database, i parametri di connessione sono nelle variabili iniziali
Nuova funzione che dovrebbe sostiture tutte le altre e mettere ordine nel sorgente.
Questa funzione utilizza le extended version di PHP 5 perchè le classiche funzione mysl_connect() 
sono deprecate in PHP 5 e danno problemi.
Ritorna l'handle di connessione
*/

function db_conn_i()
{
	//parametri di connessione
	$dbHost 		= "localhost";
	$dbUser 		= "username";
	$dbPassword = "password";
	$dbName		= "mrpdatabase";
	//parametri di connessione - fine
	
    $conn = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName);
    //check connection
    if(mysqli_connect_errno()) 
    {
    	echo "Connessione rifiutata<br />";
    	$conn=false;
    }
 
    return $conn;
}

 ?>