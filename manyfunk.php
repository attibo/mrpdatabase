<?php
// manyfunk.php - Attilio Bongiorni - 2005
// funzioni diverse PHP
// ---------------------------------------

function build_nfa($numero, $tipo, $anno, $ext)
// build_nfa($numero, $tipo, $anno) - costruisce il nome di file per l'archiviazione
// nel campo del database mysql mette sempre l'estensione pdf perchè serve per la successiva pubblicazione in internet
// mentre per l'archiviazione sul server del comune utilizza altre estensioni permesse. (doc, odt, ecc.) 
{
$tipom = strtoupper($tipo);
$filename = $anno."_".$tipom.$numero.".".$ext;
return $filename;
}
// dit_to_my($pdataitaliana) - riceve una stringa di data italiana (gg/mm/aaaa) e restituisce
// una stringa di data adatta per un campo data mysql aaaa/mm/gg
// se l'argomento non e' corretto restituisce "e"


// ---------------------------------------
function dit_to_my($pdataitaliana)
{

// variabili:
$adata = array();
$anno_num = 0;
$dreturn = "";



if (substr_count($pdataitaliana, "/") <> 2)
//se non ci sono almeno 2 barre la data non è valida
{
	$dreturn = date("00/00/0000");
} else 
{
	$adata = explode("/", $pdataitaliana);
	
  	if (checkdate(intval($adata[1]), intval($adata[0]), intval($adata[2])))
  	{
  		$dreturn = $adata[2]."/".$adata[1]."/".$adata[0];
  	} else
  	{
  		$dreturn = date("00/00/0000");
  	}

}
  return $dreturn;

}

/*nozero_my_date($mydata) - elimina gli zeri iniziali dalle date in 
formato mysql 
esempio 2001-10-06 ---> 2001-10-6
serve per il confronto fra date per mezzo della funzione strtotime() che non 
*/
function nozero_my_date($mydata, $sep) 
{
	if (!isset($sep))
	{
		$adt = explode("/", $mydata);
	} else 
	{
		$adt = explode($sep, $mydata);
	}
$asize = count($adt);
if($asize=3) 
{
	if(substr($adt[1], 0, 1)=="0") 
	{
		$mese = substr($adt[1], 1,1);
	}else 
	{
		$mese = $adt[1];
	}

	if(substr($adt[2], 0, 1)=="0") 
	{
		$giorno = substr($adt[2], 1,1);
	}else 
	{
		$giorno = $adt[2];
	}
	// e adesso ricompone
	$nozerodata = $adt[0]."-".$mese."-".$giorno;
}else 
{
	$nozerodata = "";	
}	
return $nozerodata;

}

//-----------------------------------------
// msg_ok_insert - Attilio Bongiorni - 2005
// genera una pagine di ok se l'atto e' stato inserito correttamente
// e visualizza i dati dell'atto appena inserito in una tabella
?>

<?php

function msg_ok_insert($pnum, $pann, $pdata, $ptipo, $pogg)
{

?>
<!--codice html --------------------------- -->
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE></TITLE>
	<meta name="generator" content="Bluefish 2.2.4" >
	<META NAME="CREATED" CONTENT="20050414;20134200">
	<META NAME="CHANGED" CONTENT="16010101;0">
</HEAD>
<BODY LANG="it-IT" DIR="LTR">
<P>
</P>
	<CENTER><font color='#ff8c00' size="5">Comune di Pecorara (PC)</font>

<TABLE WIDTH=50% BORDER=1 CELLPADDING=4 CELLSPACING=0 background="immagini/cieloparcellara80.jpg">
	<TR>
		<TD WIDTH=100% VALIGN=TOP STYLE="background: url(bg_sf_azzurrino.gif) repeat scroll">
			<P ALIGN=CENTER><B>Atto inserito correttamente:</B></P>
		</TD>
	</TR>
</TABLE>
<TABLE WIDTH=50% BORDER=1 CELLPADDING=4 CELLSPACING=0 background="immagini/cieloparcellara80.jpg">
	<TR VALIGN=TOP>
		<TD WIDTH=19%>
			<P>Atto n&deg;</P>
		</TD>
		<TD WIDTH=81%>
			<?php
			echo "<P>$pnum</P>"
			?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=19%>
			<P>Anno</P>
		</TD>
		<TD WIDTH=81%>
			<?php
			echo "<P>$pann</P>"
			?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=19%>
			<P>Data dell'atto</P>
		</TD>
		<TD WIDTH=81%>
			<?php
			echo "<P>$pdata</P>"
			?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=19%>
			<P>Tipo</P>
		</TD>
		<TD WIDTH=81%>
			<?php
			echo "<P>$ptipo</P>"
			?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=19%>
			<P>Oggetto:</P>
		</TD>
		<TD WIDTH=81%>
			<?php
			echo "<P>";
			echo stripslashes($pogg);
			echo "</P>";
			?>
		</TD>
	</TR>
</TABLE>
<P ALIGN=CENTER><BR><BR>
</P>
<P ALIGN=CENTER>
<a href="index.php">[Torna al menu principale]   </a>
<a href="atti_insert.php">   [Inserisci un nuovo atto e ricorda i dati precedenti]</a>
<a href="reset_atticom_fld_ins.php">   [Inserisci un nuovo atto]</a>
</P>
</BODY>
</HTML>
<!-- fine codice html --------------------------- -->
<?php
}
?>
