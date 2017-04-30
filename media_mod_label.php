<?php
/*
media_mod_label.php - Attilio Bongiorni - ottobrre 2013
esegue l'update del campo descrizione di un record della tabella mediabank
il chiamante è media_dett.php 
*/
session_start();
include_once("taberror.php");
$il_codice=$_SESSION['codice_md'];
$il_progres=$_SESSION['progr_md'];

include("db_conn_i.php");
include("cleanup_text.php");
include("my_to_dit.php");
define("GET",0);
define("SET",1);


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
			$la_query = "UPDATE mediabank".
			" SET descrizione	= '".mysqli_real_escape_string($handlecon,$_POST['descrizione']). 
			"' WHERE codice = ".$il_codice. " AND n_ord = ".$il_progres." LIMIT 1" ;
			// esegui l'upgrade
			$result = mysqli_query($handlecon,$la_query) or die ("Errore query ".$la_query);

			?>

			<BODY LANG="en-US" DIR="LTR">
			<P ALIGN=CENTER><FONT COLOR="#000080"><FONT SIZE=6 STYLE="font-size: 28pt">COMUNE
			di PECORARA (PC)</FONT></FONT></P>
			<HR>
			<P ALIGN=CENTER><IMG SRC="immagini/mrp266.jpg" NAME="Immagine1" ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>
			<P ALIGN=CENTER>Aggiornamento effettuato, fai click su <B><FONT SIZE=5><A HREF="index.php">AVANTI</A>
			</FONT></B>per continuare.</P>
			<P ALIGN=CENTER><BR><BR>
			</P>
			<?php
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
?>
</BODY>
</HTML>