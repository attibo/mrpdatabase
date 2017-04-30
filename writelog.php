<?php
{	
//writelog(nomefile, testo) - questa funzione scrive un messaggio di log nel file di testo (param. 1))
//il file di default per mrp è mrpdblog.txt
	function writelog($nomefile, $testo)
	{
		$now = getdate();
		$infoagg=$now["mday"]."/".$now["month"]."/".$now["year"]."-".$now["hours"].":".$now["minutes"].":".$now["seconds"]." ";
		 if (!$handle = fopen($nomefile, 'a+')) 
			{
         			echo "Errore di apertura file log";
        		} else
			{
				fwrite($handle, $infoagg.$testo." \n");
				fclose($handle);
			}
}
}