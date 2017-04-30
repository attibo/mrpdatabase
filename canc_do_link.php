<?php
/*
canc_do_link.php - Attilio Bongiorni - genn-febbraio 2015
esegue la cancellazione di un record link nella tabella mediabank
in pratica fa l'azione di cancellazione comandata da media_multilink.php
utilizza le variabili di sessione:
link_code_d 	= codice della scheda collegata
link_prog_d  	= progressivo
link_file_d 	= nome del file
le variabili di sessione sono settate da media_multilink.php
*/
define("TERROR", 1);
define("TWARN",2);
define("TINFO",3);

session_start();
$esito=true;
include_once("msgObj.php");
include_once("extfile.php");
include("writelog.php");

/*
Vengono controllate le variabili di sessione in modo da impedire chiamate illegali a
questo script.
*/
$oggettoMsg = new msgObj();
if( isset($_SESSION['link_file_d']) AND isset($_SESSION['link_code_d']) AND isset($_SESSION['link_prog_d']) ) 
{
$il_codice	= $_SESSION['link_code_d'];
$il_progr	= $_SESSION['link_prog_d'];
$il_file		= $_SESSION['link_file_d'];

} else 
{
	$oggettoMsg->push_error(TERROR,"Esecuzione non permessa!");
	$oggettoMsg->push_action("Torna al menu principale", "index.php");
	$oggettoMsg->show();
	$oggettoMsg->resetta();
	unset($_SESSION['link_code_d']);
	unset($_SESSION['link_prog_d']);
	unset($_SESSION['link_file_d']);
	$esito = false;
}
if($esito) 
{
//cancello le variabili di sessione che servono solo per la cancellazione
unset($_SESSION['link_code_d']);
unset($_SESSION['link_prog_d']);
unset($_SESSION['link_file_d']);

// continuare


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

			//ora procediamo a cancellare i record			
			if($esito) 
			{ //esito
			

				$query2 = "DELETE FROM mediabank WHERE codice = ".$il_codice." AND file = '".$il_file. "' AND n_ord = ".$il_progr;

				mysqli_query($handlecon,$query2);
				$deleted_media = mysqli_affected_rows($handlecon);
				if($deleted_media>0) 
				{
					writelog("mrpdblog.txt", "Cancellato link: ".$il_codice." -> ".$il_file." progressivo: ".$il_progr);
					
					echo"<BODY LANG='en-US' DIR='LTR'";
					echo "<CENTER>";
					echo "<P ALIGN=CENTER><FONT COLOR='#000080'><FONT SIZE=6 STYLE='font-size: 28pt'>MUSEO DELLA RESISTENZA DI SPERONGIA</FONT></FONT></P>";
					echo "</CENTER>";
					echo "<HR>";
					echo "<P ALIGN=CENTER><IMG SRC='immagini/mrp266.jpg' NAME='Immagine1' ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>";
					echo "<P ALIGN=CENTER>Eliminato link scheda<b> ".$il_codice."</b> -> <b>".$il_file."</b> progressivo: <b> ".$il_progr ."</b>";
					echo " Fai click su <B><FONT SIZE=5><A HREF='media_multilink.php?p=".$_SESSION['link_prog_resetlink']."'> AVANTI</A> ";
					echo "</FONT></B>per continuare.</P>";
					echo "<P ALIGN=CENTER><BR><BR>";
					echo "</P>";
					writelog("mrpdblog.txt","Utente ".$_SESSION['who']." Eliminato link scheda ".$il_codice." -> file ".$il_file." progressivo: ".$il_progr);
				} else 
				{
					$oggettoMsg->push_error(TERROR, "Cancellazione del link non riuscita");
					$oggettoMsg->push_action("Torna indietro", "index.php");
					$oggettoMsg->show();
					$oggettoMsg->resetta();
				}
							
			} //esito
			
		} else 
		{
			echo "Errore, connessione alla base dati non effettuata<br>";
			echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
		}
		
		
	
} else //sessione ok ?
{
	echo "Errore, connessione non effettuata<br>";
	echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
}
}//esito (variabili di sessione di controllo)
?>
</BODY>
</HTML>