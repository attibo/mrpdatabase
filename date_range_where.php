<?php
/* funzione date_range_where() confronta le due date (da strtotime()) e ritorna la WHERE string
nella $wherestring il WHERE è già presente nei chiamanti
parametri: i primi due sono le due date in timestamp convertite da strtotime()
le altre due sono le date in input convertite in formato mysql
occorrono entrambi i formati perchè deve verificare che non siano blank (verifica testuale)
e confrontarle (verifica numerica - timestamp)
Problema: purtroppo nel secondo caso "solo data dal" la query sembra non funzionare apparentemente
senza motivo (almeno io non l'ho capito) quindi il caso è stato disattivato da pedbsearch
e non si verifica (richieste entrambe le date)
---------------------------------------
Attilio Bongiorni - luglio 2012
*/

function date_range_where($datauno, $datadue, $ddd, $aaa)
{

	if($datauno == $datadue) // date uguali
	{
		$wherestring = " (data_nasc = '".$ddd."')"; 
		
	}elseif($aaa=="") // solo data ...dal 
	{
		$wherestring = " (data_nasc >='".$ddd."')";
	}elseif($ddd=="") // solo data al...
	{
		$wherestring = " (data_nasc <='".$aaa."')";
		
	}elseif($datadue > $datauno) // situazione normale
	{
		$wherestring= " ('".$aaa."'>= data_nasc AND '".$ddd."' <= data_nasc)";
	}
	
	
	return $wherestring;

}


?>
