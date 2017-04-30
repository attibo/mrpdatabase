<?php
/*
media_del_do.php - Attilio Bongiorni - ottobre 2013
esegue la cancellazione di un record della tabella mediabank e del relativo file
il chiamante è media_dett.php 
*/
session_start();
$esito=true;
include_once("taberror.php");
include_once("extfile.php");
include('writelog.php');
/*
Vengono controllate le variabili di sessione in modo da impedire chiamate illegali a
questo script.
*/
if(isset($_SESSION['codice_del']) and isset($_SESSION['progr_del'])) 
{
$il_codice=$_SESSION['codice_del'];
$il_progres=$_SESSION['progr_del'];
} else 
{
	echo "<font color='red'>";
	echo "<br />Errore! Esecuzione non permessa";
	echo "</font>";
	$esito = false;
}
if($esito) 
{
//cancello le variabili di sessione che servono solo per la cancellazione
unset($_SESSION['codice_del']);
unset($_SESSION['progr_del']);

//DA MODFICARE SE E' UN FILE DI TESTO NON E' IN /media !!!
$ipath="media/";
$tpath="text/";
$estens=extfile($_SESSION['mediafile_md']);
if($estens=="jpg" or $estens=="png") 
{
	$path_e_file = "media/".$_SESSION['mediafile_md'];
} else 
{
	$path_e_file = "text/".$_SESSION['mediafile_md'];
}

include("db_conn_i.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE></TITLE>
	<meta name="generator" content="Bluefish 2.2.4" >
	<META NAME="CREATED" CONTENT="20050522;15550400">
	<META NAME="CHANGED" CONTENT="20050522;16443900">
</HEAD>

<?php
if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{
		// connessione
		$handlecon = db_conn_i();
		
		if (gettype($handlecon)!="boolean") //vuol dire che la connessione è riuscita
		{
			$la_query = "DELETE FROM mediabank".
			" WHERE codice = ".$il_codice. " AND n_ord = ".$il_progres." LIMIT 1" ;
			// esegui l'upgrade
			$result = mysqli_query($handlecon,$la_query) or die ("Errore query ".$la_query);

			if(is_file($path_e_file)) 
			{
				if(unlink($path_e_file)) 
				{
					$cancok=true;		
				}	else 
				{
					$cancok=false;
					echo "<br /><font color='red'>";
					echo "<b>Cancellazione del file non riuscita</b>";
					echo "</font>";
				}
			} else 
			{
					$cancok=false;
					echo "<br /><font color='red'>";
					echo "<b>Il file era gi&agrave; stato cancellato</b><br />";
					echo "</font>";
			}

			
			writelog("mrpdblog.txt","Eliminato file: ".$_SESSION['mediafile_md']." utente: ".$_SESSION['who']);
			echo"<BODY LANG='en-US' DIR='LTR'";
			echo "<P ALIGN=CENTER><FONT COLOR='#000080'><FONT SIZE=6 STYLE='font-size: 28pt'>COMUNE di PECORARA (PC)</FONT></FONT></P>";
			echo "<HR>";
			echo "<P ALIGN=CENTER><IMG SRC='immagini/mrp266.jpg' NAME='Immagine1' ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>";
			echo "<P ALIGN=CENTER>Il record &egrave; stato eliminato, fai click su <B><FONT SIZE=5><A HREF='mrp_dett.php?c=".$il_codice."'>AVANTI</A>";
			echo "</FONT></B>per continuare.</P>";
			echo "<P ALIGN=CENTER><BR><BR>";
			echo "</P>";
			
			
		} else 
		{
			echo "Errore, connessione alla base dati non effettuata<br>";
			echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
		}
		
	//} forse questa non serve più
		
	
} else //sessione ok ?
{
	echo "Errore, connessione non effettuata<br>";
	echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
}
}//esito (variabili di sessione di controllo)
?>
</BODY>
</HTML>