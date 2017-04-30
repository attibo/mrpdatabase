<?php
/*dit_to_time() - Attilio Bongiorni - settembre 2012
la funzione prende una data italiana come parametro e restituisce una
Unix Timestamp
in caso di errore restituisce 0 
accetta solo date mysql
*/
function dit_to_time ($dit) 
{
	$ardit = explode("-", $dit);
	$nc = count($ardit);	

//esempio data my 1919-10-07
//                0    1  2
// ordine checkdate:  mese,giorno,anno

	if (checkdate(intval($ardit[1]), intval($ardit[2]), intval($ardit[0])))
	{	
	
		if($nc=2) 
		{
			$rts = mktime(0,0,0, $ardit[1], $ardit[0], $ardit[2]); 
		} else 
		{
			$rts = 0;
		}
	
	} else 
	{
		$rts = 0;
	}
	
	return $rts;
}
?>