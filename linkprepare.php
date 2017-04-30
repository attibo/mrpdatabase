<?php
/*
linkprepare.php - Marzo 2015 - Attilio Bongiorni
action del pulsante di impostazione di nuovo link di media_multilink.php
usa:
l'oggetto mrpRobj() per cercare i dati della scheda
l'oggetto 
procedura:
1) setta variabile di sessione linkstartlevel = 1
2) effettua la ricerca con il codice oppure visualizza messaggio di errore
3) setta variabili di sessione per visualizzazione in media multilink
*/
session_start();

if ($_SESSION["user_id_pattern"] == "bravo ragazzo" )
{ // sessione ok?

	define("TERROR", 1);
	define("TWARN",2);
	define("TINFO",3);
	include_once("mrpRobj.php");
	include_once("msgObj.php");
	include_once("db_conn_i.php");

		
	


	
	$objMex = new msgObj();

	$ha=db_conn_i();

	if(gettype($ha)=="boolean")
	{
 	$objMex->push_error(TERROR,"Errore connessione non riuscita"); 
 	$objMex->push_action("Torna al menu principale", "http://mrpdatabase.altervista.org");
 	$objMex->show();
 	$objMex->resetta();
 	//connessione fallita
	} else //connessione fallita (no) 
	{ // connessione fallita (no)
	
		/*sanifica il campo di input prima di creare l'oggetto mrpRobj
		purtroppo cleanup_text() dava un errore di include apparentemente
		senza senso e ho dovuto duplicare il codice qui non usando la funzione
		*/
		$codeOk = strip_tags($_POST['nlpost'], "");
		$codeOk = stripslashes($codeOk);
		$codeOk = htmlspecialchars($codeOk);
		$codeOk = str_replace("%", "", $codeOk);
		$codeOk = mysqli_real_escape_string($ha,$codeOk);
		
		$olinkrec = new mrpRobj($codeOk);
		$olinkrec->retrieve($ha);
		
		
		if($olinkrec->iserror()) 
		{ //errore retrieve
			$objMex->push_error(TERROR, "Errore! Codice ".$_SESSION['link_code_d']." inesistente");
			$objMex->push_action("Torna al menu principale","index.php");
			$objMex->push_action("Torna indietro ai link","media_multilink.php?p=".$_SESSION['link_prog_resetlink']);
			$objMex->show();
			$objMex->resetta();
			//media_multilink.php parte col pulsante cerca e non conferma link
			$_SESSION['linkstartlevel']=0;
		}else //errore retrieve (no)
		{ //errore retrieve
	 		$_SESSION['linkstartlevel']=1;
	 		//setto le variabili di sessione (tdnl=to do new link)
	 		$_SESSION['tdnl_code']=$olinkrec->codice(0,"");
	 		$_SESSION['tdnl_nome']=$olinkrec->nome(0,"");
	 		$_SESSION['tdnl_cogn']=$olinkrec->cognome(0,"");
	 		$_SESSION['tdnl_datn']=$olinkrec->data_nasc(0,"");
	 		$_SESSION['tdnl_patr']=$olinkrec->paternit(0,"");
	 		//e si riparte con media_multilink.php (per questo c'è l'include)
			include("media_multilink.php");	
	
		}//errore retrieve
	} // connessione fallita

} else 
{//sessione ok?
	echo "Preparazione link:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
} 

?>