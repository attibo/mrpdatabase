
<?php

/*
mrpExpoCvs.php - Attilio Bongiorni - Giugno 2014
Esporta i dati di una query (salvata in un cookie dal dal chiamante peDbSerach.php) in un file formato csv
Utilizza la funzione di php fputcsv($fp, $fields)

*/

// DOPO METTERE CONTROLO SESSIONE!!!!!

include("msgObj.php"); // gestione degli errori
include("db_conn_i.php");
define("TERROR", 1);
define("TWARN",2);
define("TINFO",3);
$oMsg= new msgObj();

session_start();
if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{ //sessione

?>

	<html>

	<table align="center" border="0">
		<TR>
			<TD width="70%">
			<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
			<font size="2">
			<strong>Database dei partigiani e degli elementi multimediali</strong>
			</font>
			</CENTER>
			</TD>
		
			<TD width="30%">
			<img align="top" src="immagini/mrp.jpg"><br>
			</TD>
		</TR>
	</table>

	</html>


<?php



	$oMsg= new msgObj();
	$esito = true;
	$whole_query=urldecode($_COOKIE['cok_qryp']);
	$la_query = strstr($whole_query, "WHERE");
	$la_query = "SELECT * FROM partigiani ".$la_query;


	$handleCon = db_conn_i();

	if(gettype($handleCon)=="boolean") //connessione andata male? 
	{												//connessione andata male?
		$esito=false;
		$oMsg->push_error(TERROR,"Connessione Mysql non riuscita");
	} else 										//connessione andata male?
	{												//connessione andata male?

		$qrisult = mysqli_query($handleCon, $la_query);
		$nTrovati =mysqli_num_rows($qrisult);

		if ($nTrovati == 0)
			{  		// nessun record
				$esito = false;
				$oMsg->push_error(TWARN, "La query non ha trovato alcun record, nulla da esportare");
			} else  // nessun record
			{		  // nessun record
				//NB il secondo parametro non è l'estensione del file
				$tmpFile = tempnam("tmp/", "mrp_");
				//cancella il file vuoto senza estensione
				unlink($tmpFile);
				$tmpFile = $tmpFile.".csv";
				$handleCsv = fopen($tmpFile, "w+");
					if(!$handleCsv)
					{				//fopen() ok?)
						$esito = false;
						$oMsg->push_error(TERROR,"Fallita apertura del file temporaneo ".$tmpFile);					
					} else 		//fopen() ok?
					{				//fopen() ok?
				
							$acampi = array(
													"CODICE",
													"NOME",
													"COGNOME",
													"PATERN",
													"DATA NASCITA",
													"LUOGO NASCITA",
													"FORMAZIONE",
													"QUALIFICA",
													"GRADO",
													"INIZIO ARRUOL.",
													"FINE ARRUOL",
													"NAZIONALITA'",
													"CADUTO",
													"LUOGO DI MORTE",
													"DATA DI MORTE",
													"EVENTO",
													"ASSOCIATO",
													"COMITATO",
													"COMMISSIONE",
													"FERITO",
													"MUTILATO",
													"NOTE",
													"PUBBLICA",
													"NOME DI BATTAGLIA",
													"TIPOLOGIA"
												);
							fputcsv($handleCsv, $acampi, ";" );
							while($row=mysqli_fetch_array($qrisult, MYSQL_ASSOC)) 
							//nota: se non viene messo il parametro MYSQL_ASSOC mysql_fetc_array() ritorna
							//due array, uno con indice numerico e uno con indice associativo
							//se si mette MYSQL_NUM ritorna l'array con indice numerico
							//soluzione indicata da Stefan Stojanovic via Facebook 
							{ //while
									fputcsv($handleCsv, $row, ";");
							} //while
	
							
							$messaggio_ok = "Operazione di esportazione effettuata<br />";
							$messaggio_ok = $messaggio_ok."esportati n. ";
							$messaggio_ok = $messaggio_ok.$nTrovati." records <br />";
							$messaggio_ok = $messaggio_ok."nome del file: ".basename($tmpFile);
							$messaggio_ok = $messaggio_ok."<br />Il file pu&ograve; essere letto da Excel o Libreoffice Calc";							
							$_SESSION["xcsv"]=$tmpFile;
							$oMsg->push_error(TINFO, $messaggio_ok);
							$oMsg->push_action("Scarica il file", "xdwn.php");
							$oMsg->push_action("Annulla e torna al menu principale", "index.php");
							$oMsg->push_action("Annulla e fa una nuova ricerca","cerca.php");
							fclose($handleCsv);

					}				//fopen() ok?
				
			}       // nessun record

	}												//connessione andata male?

	if($esito)
	{
		$oMsg->show();
	} else 
	{
		$oMsg->push_action("Torna al menu principale","index.php");
		$oMsg->push_action("Effettua una nuova ricerca","cerca.php");
		$oMsg->show();
	}	

} //sessione
else 
{ //sessione
	$oMsg->push_error(TERROR, "Connessione rifiutata, effettua il login prima di procedere");
	$oMsg->push_action("Torna alla pagina di login", "index.php");
}

?>