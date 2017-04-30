<?php
// atti_connect.php di Attilio Bongiorni - 2005
// modifiche del dicembre 2008 - atticom_new
// connette al database degli atti (MySql)
// setta una sessione, variabilli di sessione:
// user_id_pattern = "bravo ragazzo" connessione ok
// whois -> user id
// hispw -> password
// hispc -> host
//-------------------------


session_start();
include("php_resource32.php");
include("writelog.php");
include("cleanup_text.php");
include_once("config.php");
$pp_user=cleanup_text($_POST["usr_goread"],"",0);
$pp_pwd=cleanup_text($_POST["pwd_goread"],"",0);
$nwho=0;
$connessione=false;
$selezione=false;

if(in_array($pp_user, $uk, $strict = null)) 
{

	$nwho=array_search($pp_user, $uk, $strict = null);
	
	if($pp_pwd==$pk[$nwho]) 
	{

		$connessione = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or
			die("Connessione sql fallita ! ");
		// tolto mysql_error() in fase di produzione. Sorg. originale:
		// die("Connessione sql fallita ! " . mysql_error());
		$selezione = mysql_select_db(DB_NAME) or
			die("Connessione al database degli atti fallita !");
			writelog("mrpdblog.txt", "Login utente ".$uk[$nwho]);
	}	else 
	{
				echo "User/password errata, utente ". $nwho." in caso di problemi contatta l'amministratore di sistema";
				//debug
				echo DB_HOST;
				echo DB_USER;
				echo DB_PASSWORD;
				echo DB_NAME;
				//debug
	}
} else 
{
	echo "User/password errata, in caso di problemi contatta l'amministratore di sistema";
}



if ($connessione == True and $selezione == True)
{
	$_SESSION["user_id_pattern"] = "bravo ragazzo";
	$_SESSION["whois"] = "username";
	$_SESSION["hispw"] = "password";
	$_SESSION["hispc"] = "localhost";
	$_SESSION["who"]   = $uk[$nwho];
	//con questo Include si ritorna all'Index
	include("index.php");
} else
{
	session_destroy();
}

?>
