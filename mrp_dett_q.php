<?php
/*
mrp_dett_q() - Attilio Bongiorni - settembre 2013
Riceve come parametri il codice della scheda da visualizzare e il link di connessione ed effettua le 2 queries necessarie 
per visualizzare il dettaglio del record del partigiano con i dati anagrafici e la tabella degli elementi multimediali
associati.
Contiene 2 funzioni che eseguono le 2 queries, le funzioni ritornano $qrisult
Visualizzano errori in caso di fallimento delle queries
*/

function mrp_dett_ana($pcod, $plink)
{
	$la_queryv="SELECT * FROM partigiani WHERE codice = '".$pcod. "'";
	$qrisult = mysqli_query($la_queryv, $plink);
		if (mysqli_num_rows($qrisult) == 1)
		{		  // query ok (si)
		
			echo "Ok";
			
		} else // query ok (no) 
		{      // query ok (no)
		
			echo "<br />Errore! - Record non individuato <br />";

		}

    return $qrisult;
}

function mrp_dett_media($la_querym, $plink)
{
	$queryMedia= "SELECT * FROM partigiani LEFT JOIN mediabank ON partigiani.CODICE = mediabank.CODICE WHERE partigiani.CODICE=".$pcod;
	$qrisultM = mysqli_query($queryMedia);

}

 ?>