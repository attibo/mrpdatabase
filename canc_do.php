<?php
/*
canc_do.php - Attilio Bongiorni - novembre 2013
esegue la cancellazione di un record della delle schede dei partigiani e di tutti i record 
della tabella mediabank relazionati
ultima versione Maggio 2015 - modifiche:
non cancella subito il file, ma prima controlla che esso non sia collegato ad altre schede
anagrafiche. In questo caso non lo cancella e presenta il messaggio dei files non cancellati

*/
session_start();
define("TERROR", 1);
define("TWARN",2);
define("TINFO",3);
$esito=true;
$multilink=false; //serve per vedere se ci sono file con link multipli
include_once("taberror.php");
include_once("extfile.php");
include("writelog.php");
include_once("msgObj.php");

$objMex = new msgObj();
/*
Vengono controllate le variabili di sessione in modo da impedire chiamate illegali a
questo script.
*/
if(isset($_SESSION['code_delete'])) 
{
$il_codice=$_SESSION['code_delete'];
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
unset($_SESSION['code_delete']);

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
			$query1 = "SELECT file FROM mediabank".
			" WHERE codice = ".$il_codice;
			// rileva i nomi dei files
			$result = mysqli_query($handlecon,$query1) or die ("Errore query ".$la_query);
			while ($row=mysqli_fetch_array($result))
			{ //while
				
				$estensione= extfile($row[0]);
					switch($estensione) 
					{
						case "pdf":
							$wholefilename = "text/".$row[0];
							break;
						case "odt":
							$wholefilename = "text/".$row[0];
							break;
						case "doc":
							$wholefilename = "text/".$row[0];
							break;
						case "docx":
							$wholefilename = "text/".$row[0];
							break;
						case "jpg":
							$wholefilename = "media/".$row[0];
							break;		
						case "png":
							$wholefilename = "text/".$row[0];
							break;
					}

						if(is_file($wholefilename)) 
						{
								//qui, testare se il file è collegato ad altre schede
								//ricerca link multipli (il file collegato a più schede)
								$query_multilink = "SELECT codice FROM mediabank WHERE file='".$row[0]."'";
								$reslink = mysqli_query($handleCon,$query_multilink);
								$find_multi = mysqli_num_rows($reslink);
								if($find_multi==1) //è un multilink? (no)
								{
									//questo blocco cancella fisicamente il file
									if(!unlink($wholefilename))
									{
										echo "Errore di sistema! Non &egrave; stato possibile cancellare il file ".$row[0];
										$esito = false;
									}
									$cancellati[]=basename($wholefilename);
									//questo blocco cancella fisicamente il file (fine)
									
								 }	else // è un multilink? 
								 {		  // é un multilink? (si)
								 	$multilink=true;
									$objMex->push_error(TWARN, "Attenzione! Il file <b>". $row[0]." </b>non e` stato cancellato perche` collegato ad altre schede.");
								 }		  // è un multilink?					
								
								mysqli_free_result($reslink);							
								
						} else // isfile()
						{	// isfile()
							echo "<br /><font color='red'>";
							echo "<b>Il file era gi&agrave; stato cancellato</b><br />";
							echo "</font>";

						} // isfile())
					
			} //endwhile

			//ora procediamo a cancellare i record			
			if($esito) 
			{ //esito
				$query2 = "DELETE FROM mediabank WHERE codice =".$il_codice;
				mysqli_query($handlecon,$query2);
				$deleted_media = mysqli_affected_rows($handlecon);
				$query3 = "DELETE FROM partigiani WHERE codice =".$il_codice." LIMIT 1" ;
				mysqli_query($handlecon,$query3);
				$deleted_part = mysqli_affected_rows($handlecon);
				writelog("mrpdblog.txt", "Cancellata scheda: ".$_SESSION['cogn_delete']." - codice: ".$il_codice." - ".$_SESSION['nom_delete']." - "."utente: ".$_SESSION['who']);
				if(isset($cancellati)) 
				{
					foreach($cancellati as $vcanc )
					{
						writelog("mrpdblog.txt", "Cancellato il file: ".$vcanc." - "."utente: ".$_SESSION['who']);
					}
				} //isset cancellati?
				unset($_SESSION['cogn_delete']);
				unset($_SESSION['nom_delete']);		
				
				if($multilink) 
				{
					$objMex->push_action("Torna al menu principale","http://mrpdatabase.altervista.org");
					$objMex->show();
					$objMex->resetta();
				}	
				
				echo"<BODY LANG='en-US' DIR='LTR'";
				echo "<CENTER>";
				echo "<P ALIGN=CENTER><FONT COLOR='#000080'><FONT SIZE=6 STYLE='font-size: 28pt'>MUSEO DELLA RESISTENZA DI SPERONGIA</FONT></FONT></P>";
				echo "</CENTER>";
				echo "<HR>";
				echo "<P ALIGN=CENTER><IMG SRC='immagini/mrp266.jpg' NAME='Immagine1' ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>";
				echo "<P ALIGN=CENTER>Record eliminati n. ".$deleted_part." dalla tabella principale e ";
				echo " n.".$deleted_media." dalla tabella dei files<br />";
				echo "Fai click su <B><FONT SIZE=5><A HREF='index.php'> AVANTI</A>";
				echo "</FONT></B>per continuare.</P>";
				echo "<P ALIGN=CENTER><BR><BR>";
				echo "</P>";
							
			} //esito
			
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