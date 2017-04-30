<?php
/*
link_reset.php - Maggio 2015 - Attilio Bongiorni
Script chiamato da media_multilink.php quando l'operatore attiva la funzione reset dopo che ha
già impostato un nuovo link ma non l'ha ancora confermato.
procedura:
1) setta variabile di sessione linkstartlevel = 0
2) resetta tutte le variabili di sessione tdnl_*
*/
session_start();
define("TERROR", 1);
define("TWARN",2);
define("TINFO",3);
include_once('msgObj.php');

if ($_SESSION["user_id_pattern"] == "bravo ragazzo" )
{ // sessione ok?

	$objMex= new msgObj();
	$_SESSION['linkstartlevel']= 0;
	unset($_SESSION['tdnl_code']);
	unset($_SESSION['tdnl_nome']);
	unset($_SESSION['tdnl_cogn']);
	unset($_SESSION['tdnl_datn']);
	unset($_SESSION['tdnl_patr']);
	$objMex->push_error(TINFO, "Operazione di creazione link annullata!");
	$objMex->push_action("Torna al menu principale","index.php");
	$objMex->push_action("Torna indietro ai link","media_multilink.php?p=".$_SESSION['link_prog_resetlink']);
	$objMex->show();
	$objMex->resetta();	
		
	
} else 
{//sessione ok?
	echo "Preparazione link:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
} 

?>