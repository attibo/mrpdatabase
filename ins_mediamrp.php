<?php
/*
ins_mediamrp.php - Attilio Bongiorni - novembre 2013
action della form di mrp_add_media.php
riceve un file caricato dall'operatore mediante la form mrp_add_media.php lo controlla e 
poi lo sposta dalla directory temporanea di php nel posto giusto, dopo aver creato il 
record apposito nela tabella mediabank
*/
session_start();
include_once("taberror.php");
include("mediaMrpKeygen.php");
include("writelog.php");
//la costante che segue è il codice di errore MySql di duplicate key entry
define("DUPKEY",1062);
$il_codice=$_SESSION['codice_md'];
//questo non serve perchè il progressivo viene generato non lo deve ricordare!
//$il_progres=$_SESSION['progr_md'];
unset($_SESSION['codice_md']);
//unset($_SESSION['progr_md']);

include("db_conn_i.php");
include("cleanup_text.php");
include("extfile.php");
$esito = true;


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
	


		$file_sent = $_FILES['userfile']['name'];

		$ext_fs = extfile($file_sent);

		
		switch ($ext_fs) 
		{
    		case "jpg":
        		$dir_arch = "media/";
        		break;		
        	case "png":
        		$dir_arch = "media/";
        		break;
        	case "odt":
        		$dir_arch = "text/";
        		break;
        	case "doc":
        		$dir_arch = "text/";
        		break;
        	case "docx":
        		$dir_arch = "text/";
        		break;
        	case "pdf":
        		$dir_arch = "text/";
		}		
		
		//test file temporaneo
		//come prefisso mettiamo il codice scheda + undescore _
		$prefix_file = $il_codice."_";
		$tmp_php = tempnam($dir_arch, $prefix_file);
		$tmp_phpe = $tmp_php.".".$ext_fs;
		
		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			move_uploaded_file($_FILES['userfile']['tmp_name'], $tmp_phpe);
			//genera un altro file senza estensione non si sa il motivo ???
			//quindi bisogna cancellarlo
			if(is_file($tmp_php)) 
			{
				unlink($tmp_php);
			}
		
			//e qui si inizia con le query per creare il record
	
			$handlecon = db_conn_i();
			//qui si ricava il progressivo nuovo
			$progr_media=mediaMrpKeygen($handlecon);
		
			if (gettype($handlecon)!="boolean") //vuol dire che la connessione è riuscita
			{
				$la_query = build_query_media_ins($il_codice, $progr_media, $tmp_phpe);				
				$retry=true;

				while (!mysqli_query($handlecon,$la_query) and $retry)
				{
					if(mysqli_errno($handlecon)==DUPKEY) 
					{
						$progr_media=mediaMrpKeyGen($handlecon);

						$la_query = build_query_media_ins($il_codice, $progr_media, $tmp_phpe);
						$retry=true;				

					} else //non è un duplicate key ma qualcosaltro
					{
						echo "Errore! Operazione di inserimento non riuscita ".mysqli_errno($handlecon); 
						echo "<a href='index.php'>Torna al menu principale</a>";
						$retry=false;
						$esito=false;
					}				
				} //endwhile
				
	
				echo "<BODY LANG='en-US' DIR='LTR'>";
				echo "<P ALIGN=CENTER><FONT COLOR='#000080'><FONT SIZE=6 STYLE='font-size: 28pt'>";
				echo "MUSEO DELLA RESISTENZA PIACENTINA</FONT></FONT></P>";
				echo "<HR>";
					if($esito) 
					{
	
						echo "<table>";
							echo "<tr>";
							echo "<td>";
								echo "ARCHIVIAZIONE FILE EFFETTUATA CORRETTAMENTE<br />";
								echo "<br />File utente selezionato per l'archiviazione: ";
								echo basename($file_sent);			
								echo "<br />dimensioni del file: ";
								echo $_FILES['userfile']['size'];
							echo "</td>";
						
							echo "<td>";
								echo "<img src='immagini/ingcopia.gif'>";
							echo "</td>";
						
							echo "<td>";
								echo "<br />il File &egrave; stato archiviato in: ";
								echo basename($tmp_phpe);
							echo "</td>";
						
						
							echo "</tr>";						
						echo "</table>";
					} //esito=true
				
				echo "<P ALIGN=CENTER><IMG SRC='immagini/mrp266.jpg' NAME='Immagine1' ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>";
				echo "<P ALIGN=CENTER>Inserimento effettuato, fai click su <B><FONT SIZE=5><A HREF='mrp_dett.php"."?c=".$il_codice."'>AVANTI</A>";
				echo "</FONT></B>per continuare.</P>";
				echo "<P ALIGN=CENTER><BR><BR>";
				echo "</P>";
				writelog("mrpdblog.txt","Archiviato file: ".basename($tmp_phpe)." utente: ".$_SESSION['who']);
	
			} else 
			{
				echo "<center><br />";
				echo "<img src='immagini/errorico.png'><br clear='all' />";
				echo "Errore, connessione alla base dati non effettuata<br>";
				echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
				echo "</center>";
			}			
			
			
		} else 
		{
			echo "<center><br />";
			echo "<img src='immagini/errorico.png'><br clear='all' />";			
			echo "Errore! Impossibile archiviare il file - controllare che le dimensioni del file non siano > 3 Mb<br />";
			echo "<A HREF='mrp_dett.php?c=".$il_codice."'>Torna indietro </A></P>";
			echo "</center>";
		}
		 
		//test funzionamento
		// connessione

		
	//} forse questa non serve più
		
	
} else //sessione ok ?
{
	echo "Errore, connessione non effettuata<br>";
	echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
}
?>
</BODY>
</HTML>