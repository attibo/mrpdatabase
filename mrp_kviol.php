<?php
/* mrp_kviol($pnome, $pcognome, $pdata_nascita, $pconnessione)
Attilio Bongiorni - settembre 2012
verifica che non vengano inseriti record doppi (controllo prima che avvenga una violazione di chiave)
ritorno true = nessuna violazione / false = key violation
utilizzato con il database mrpdatabase con la seguente struttura
codice 	bigint(20) 	No  	  	 
nome 	varchar(40) 	No  	  	 
cognome 	varchar(40) 	No  	  	 
paternit 	varchar(40) 	No  	  	 
data_nasc 	date 	No  	  	 
luogonasci 	varchar(35) 	No  	  	 
formazione 	varchar(50) 	No  	  	 
qualifica 	varchar(40) 	No  	  	 
grado 	varchar(30) 	No  	  	 
inizio_arruol 	date 	Yes  	NULL  	 
fine_arruol 	date 	No  	  	 
nazionalit 	varchar(30) 	No  	  	 
caduto 	varchar(2) 	No  	no  	 
luogomorte 	varchar(50) 	No  	  	 
data_morte 	date 	No  	  	 
evento 	varchar(50) 	No  	  	 
associato 	varchar(2) 	No  	no  	 
comitatopr 	varchar(2) 	Yes  	no  	 
commission 	varchar(2) 	No  	no  	 
ferito 	varchar(2) 	No  	no  	 
mutilato 	varchar(2) 	No  	no  	 
note 	text 	No  	  	 
pubblica 	varchar(2) 	No  	no  	 
nome_batt 	varchar(35) 	No  	  	 
tipologia 	int(11) 	No  	  	 

//	usa l'array globale di sessione perche' la start_session() e' gia' stata fatta dal chiamante
*/ anzi: LA SESSIONE DEVE ESSERE REGISTRATA DAL CHIAMANTE !!!

function mrp_kviol($pnome, $pcognome, $pdata_nascita, $pconnessione)
{
	include("atti_connect_only.php");

	if (atti_connect_only($_SESSION["hispc"], $_SESSION["whois"], $_SESSION["hispw"]))
	{
		$qkviol = mysql_query("SELECT numero, anno, data, tipo, oggetto FROM atti WHERE numero= '$pnum' AND anno = '$pann' AND tipo='$ptipo'");
		if (mysql_num_rows($qkviol) > 0)
		{

//-------------------------inizio HTML ------------------------------------------------------
		?>
	
	<HTML>
	<HEAD>
		<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
		<TITLE></TITLE>
		<meta name="generator" content="Bluefish 2.2.4" >
		<META NAME="CREATED" CONTENT="20050418;22491000">
		<META NAME="CHANGED" CONTENT="20050418;23241600">
		<STYLE>
		<!--
			@page { size: 21cm 29.7cm; margin: 2cm }
			TD P { margin-bottom: 0.21cm }
			P { margin-bottom: 0.21cm }
		-->
		</STYLE>
	</HEAD>
	<BODY LANG="it-IT" DIR="LTR">
	<P ALIGN=CENTER><FONT COLOR="#000080"><FONT SIZE=4><B>Atto gi&agrave;
	esistente in archivio:</B></FONT></FONT></P><br>
	<TABLE WIDTH=100% BORDER=1 BORDERCOLOR="#ffffff" CELLPADDING=4 CELLSPACING=0>
		<COL WIDTH=27*>
		<COL WIDTH=21*>
		<COL WIDTH=24*>
		<COL WIDTH=21*>
		<COL WIDTH=90*>
		<COL WIDTH=35*>
		<COL WIDTH=37*>
		<TR VALIGN=TOP>
			<TD WIDTH=11% BGCOLOR="#ccccff">
				<P ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2><B>num_atto</B></FONT></FONT></P>
			</TD>
			<TD WIDTH=8% BGCOLOR="#ccccff">
				<P ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2><B>anno</B></FONT></FONT></P>
			</TD>
			<TD WIDTH=9% BGCOLOR="#ccccff">
				<P ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2><B>data</B></FONT></FONT></P>
			</TD>
			<TD WIDTH=8% BGCOLOR="#ccccff">
				<P ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2><B>tipo</B></FONT></FONT></P>
			</TD>
			<TD WIDTH=35% BGCOLOR="#ccccff">
				<P ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2><B>oggetto</B></FONT></FONT></P>
			</TD>
		</TR>
		<!-- FINE intestazione tabella-->

		<!-- Riga -->
		<?php

		while ($rigakv = mysql_fetch_row($qkviol))
		{
			echo "<TR VALIGN=TOP>";
				echo "<TD WIDTH=11% BGCOLOR='#cccccc'>";
					echo "<P><FONT SIZE=2>";
					echo $rigakv[0];
					echo "</FONT></P>";
				echo "</TD>";
				echo "<TD WIDTH=8% BGCOLOR='#cccccc'>";
					echo "<P><FONT SIZE=2>";
					echo $rigakv[1];
					echo "</FONT></P>";
				echo "</TD>";
				echo "<TD WIDTH=9% BGCOLOR='#cccccc'>";
					echo "<P><FONT SIZE=2>";
					echo $rigakv[2];
					echo "</FONT></P>";
				echo "</TD>";
				echo "<TD WIDTH=8% BGCOLOR='#cccccc'>";
					echo "<P><FONT SIZE=2>";
					echo $rigakv[3];
					echo "</FONT></P>";
				echo "</TD>";
				echo "<TD WIDTH=35% BGCOLOR='#cccccc'>";
					echo "<P><FONT SIZE=2>";
					echo htmlentities($rigakv[4], ENT_QUOTES);
					echo "</FONT></P>";
				echo "</TD>";
			echo "</TR>";
		}
		?>

	</TABLE>
	<P STYLE="margin-bottom: 0cm"><BR>
	</P>
	</P>
	<P ALIGN=CENTER><a href="index.php">[Torna al menu principale]   </a>
	<a href="atti_insert.php">   [Inserisci un nuovo atto]</a></P>

	</BODY>
	</HTML>

		<?php
//-------------------------fine HTML --------------------------------------------------------
			$vret = false;
		} else
		{
			$vret = true;
		}
	} else
	{
		$vret = false;
	}

	return $vret;
}
?>
