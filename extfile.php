<?php
/*extfile() - Attilio Bongiorni - ottobre 2013
la funzione prende una nome di file come parametro e restituisce la sua estensione
in caso di errore restituisce ""
*/
function extfile ($nf) 
{
	$nf = strtolower(chop($nf));
	$extdot = strrchr($nf, ".");
	$lungh = strlen($extdot);
	
	if($lungh>3) 
	{
		$ext = strtolower(substr($extdot, 1));
	} else 
	{
		//errore dev'essere almeno 3 caratteri + 1
		$ext = "";
	}

	return $ext;
}
?>