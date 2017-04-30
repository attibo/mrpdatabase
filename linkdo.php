<?php
/*
linkdo.php - Marzo 2015 - Attilio Bongiorni
action del pulsante di conferma di nuovo link di media_multilink.php
procedura:
controllo previo inserimento, non deve esistere un altro record che soddisfa:
codice = $_SESSION['tdnl_code']
file = $_SESSION['link_file_d']
query insert che aggiunge un record nella tabella mediabank così composto
codice	= $_SESSION['tdnl_code']
n_ord = (max della colonna)
file = $_SESSION['link_file_d']
descrizione = “Link creato il [data]”
*/
session_start();

if ($_SESSION["user_id_pattern"] == "bravo ragazzo" )
{ // sessione ok?

	define("TERROR", 1);
	define("TWARN",2);
	define("TINFO",3);
	define("DUPKEY",1062);
	include_once("mrpRobj.php");
	include_once("msgObj.php");
	include_once("db_conn_i.php");
	include_once("mediaMrpKeygen.php");
	include_once("writelog.php");

	$esito = true;	
	//$queryfind = "query che controlla i duplicati -  DA FARE!";
	//$querypush = "query di inserimento";
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
		/*
		per prima cosa vediamo se c'è un altro record che soddisfa la condizione
		codice = $_SESSION['tdnl_code']
		file = $_SESSION['link_file_d']
		*/
		$queryKeyDouble = "SELECT * FROM mediabank WHERE `codice` =". $_SESSION['tdnl_code']." AND file = '". $_SESSION['link_file_d']."'";
		$result = mysqli_query($ha, $queryKeyDouble);
		$trovati = mysqli_num_rows($result);
		//non ci devono essere altri record con stessi valori di campi file e codice
		if($trovati > 0) //record doppio?
		{
			$objMex->push_error(TERROR,"Errore file: ".$_SESSION['link_file_d']." gi&agrave; collegato!"); 
			$objMex->push_action("Torna al menu principale","index.php");
 			$objMex->push_action("Torna indietro ai link","media_multilink.php?p=".$_SESSION['link_prog_resetlink']);
 			$objMex->show();
 			$objMex->resetta();
		} else 			// record doppio?
		{					// record doppio?
			
				$progr_media=mediaMrpKeygen($ha);
				$la_query = build_query_media_ins($_SESSION['tdnl_code'], $progr_media, $_SESSION['link_file_d']);				
				$retry=true;

				while (!mysqli_query($ha,$la_query) and $retry)
				{
					if(mysqli_errno($handlecon)==DUPKEY) 
					{
						$progr_media=mediaMrpKeyGen($ha);
						$la_query = build_query_media_ins($_SESSION['tdnl_code'], $progr_media, $_SESSION['tdnl_file']);
						$retry=true;				

					} else //non è un duplicate key ma qualcosaltro
					{
						$objMex->push_error(TERROR,"Errore! Operazione di inserimento non riuscita"); 
						$objMex->push_action("Torna indietro ai link","media_multilink.php?p=".$_SESSION['link_prog_resetlink']);
 						$objMex->push_action("Torna al menu principale", "index.php");
 						$objMex->show();
 						$objMex->resetta();						
						$retry=false;
						$esito=false;
					}				
				} //endwhile
				
				if($esito) 
				{
					$mexok= "Collegamento effettuato tra la scheda n. ".$_SESSION['tdnl_code'];
					$mexok=$mexok." ed il file ".$_SESSION['link_file_d'];
					$objMex->push_error(TINFO,$mexok); 
					$objMex->push_action("Torna indietro ai link","media_multilink.php?p=".$_SESSION['link_prog_resetlink']);
					$objMex->push_action("Vai al dettaglio della scheda n.  ".$_SESSION['tdnl_code'],"mrp_dett.php?c=".$_SESSION['tdnl_code']);
					$objMex->push_action("Vai dettaglio del file ".$_SESSION['link_file_d'],"media_dett.php?p=".$_SESSION['link_prog_d']);
 					$objMex->push_action("Torna al menu principale", "http://mrpdatabase.altervista.org");
 					$objMex->show();
 					$objMex->resetta();	
 					writelog("mrpdblog.txt","Link scheda n.".$_SESSION['tdnl_code']."-->File:".$_SESSION['link_file_d']." Utente ".$_SESSION['who']);
				}
			
		}					// record doppio?
		
		
	} // connessione fallita ?

} else 
{//sessione ok?
	echo "Preparazione link:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
} 

?>