<?php
function msg_taberror($perror, $linka, $pmenu, $paction)
{
//-----------------------------------------
// file: taberror.php
// msg_taberror - Attilio Bongiorni - aggiornata all'Agosto 2012
// genera una pagina con messaggi di errore passati come parametri in un array ($perror)
// $pmenu e' un array che contiene le voci del menu da presentare in calce alla pagine  e $paction
// gli url colegati alle voci
// se $linka==1 visualizza i link di ritorno altrimenti non visualizza nulla

//variabili
$n = 0;
$nerr = count($perror);
$i = 0;
$nmenu = count($pmenu);


// codice Html ----------------------------------------------------------------------
?>

<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE></TITLE>
	<meta name="generator" content="Bluefish 2.2.4" >
	<META NAME="CREATED" CONTENT="20050411;23234500">
	<META NAME="CHANGED" CONTENT="20050417;22171100">
	<STYLE>
	<!--
		@page { size: 21cm 29.7cm; margin: 2cm }
		TD P { margin-bottom: 0.21cm }
		P { margin-bottom: 0.21cm }
	-->
	</STYLE>
</HEAD>
<BODY LANG="it-IT" DIR="LTR">
<DL>
	<DD>
	<center>
	<TABLE WIDTH=484 BORDER=1 BORDERCOLOR="#000000" CELLPADDING=4 CELLSPACING=0 STYLE="page-break-before: always">
		<COL WIDTH=474>
		<TR>
			<TD WIDTH=474 VALIGN=TOP BGCOLOR="#ff0000">
				<P ALIGN=CENTER><FONT COLOR="#ffffff"><FONT SIZE=4 STYLE="font-size: 16pt"><B>Errore
				!</B></FONT></FONT></P>
			</TD>
		</TR>
		<?php
		for ($n=0; $n<=($nerr-1); $n++)
		{
			echo "<TR>";
			echo "<TD WIDTH=474 VALIGN=TOP>";
			echo "<P ALIGN=LEFT>";
			echo $perror[$n];
			echo "</P>";
			echo "</TD>";
			echo "</TR>";
		}
		?>
	</TABLE>
</DL>
<br><br>
</P>
<P ALIGN=CENTER STYLE="margin-bottom: 0cm">

<?php
// menu in calce alla pagina

if($linka==1) 
{
for ($i=0; $i<=($nmenu-1); $i++)
	{
	echo "<a href='" ;
	echo $paction[$i];
	echo "'>";
	echo $pmenu[$i]. "     ";
	echo "</a>";
  	}
}
?>

</P>
</center>
</BODY>
</HTML>


<?php
// graffa di fine funzione
// fine codice html ------------------------------------------------------------------
}
?>
