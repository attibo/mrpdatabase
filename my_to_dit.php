<?php
// Attilio Bongiorni - 2008
// ---------------------------------------
// my_to_dit($pdatamy) - riceve una data mysql (aaaa/mm/gg) e restituisce
// una stringa di data italiana (gg/mm/aaaa)
// se l'argomento non e' corretto restituisce una stringa vuota

// ---------------------------------------
function my_to_dit($pdatamy)
{

// variabili:
$adata = array();
$anno_num = 0;
$dreturn = "";
$psDatamy = "";
$psDatamy = strval($pdatamy);

$adata = explode("-", $psDatamy);

  if (checkdate(intval($adata[1]), intval($adata[2]), intval($adata[0])))
  {
  	$dreturn = $adata[2]."/".$adata[1]."/".$adata[0];
  } else
  {
  	$dreturn = "00/00/0000";
  }

  return $dreturn;
}
?>

