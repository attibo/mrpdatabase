<?php
/*
media_del.php - Attilio Bongiorni - ottobre 2013
Visualizza il file e chiede conferma per la sua cancellazione
La pagina utilizza delle variabili di sessione salvate da mrp_dett.php che individuano
nome, cognome, data nascita, codice della scheda, mentre il progressivo del file multimediale
viene ricavato dalla variabile post "p"
ultima versione - maggio 2015 - modifiche:
prima di cancellare controlla che il file non sia multilink
*/

	session_start();

//setcookie("cooknmod",$_REQUEST['cod'],0);

?>
<html>
<body>
<?php

define("TERROR", 1);
define("TWARN",2);
define("TINFO",3);
include('cleanup_text.php');
include("db_conn_i.php");
include("extfile.php");
include_once("msgObj.php");

$objMex = new msgObj();
$progr_media=$_REQUEST['p'];
//salvo il progressivo in una variabile di sessione perchè adesso è 
//conosciuto in quanto questa pagina gestisce un record per volta
//serve per media_mod_label.php
 
$_SESSION['progr_md']=$progr_media;

/*salvo codice e progressivo in due variabili di sessione ad hoc solo per lo script di
cancellazione media_del_do.php così vengono utilizzate solo da questo script e poi subito
cancellate per evitare che una eventuale chiamata dello script di cancellazione direttamente dall'url
possa fare casini e cancellare cose non dovute
*/
$_SESSION['progr_del'] = $progr_media;
$_SESSION['codice_del'] = $_SESSION['codice_md'];


if ($_SESSION["user_id_pattern"] == "bravo ragazzo" )
{
	$handleCon = db_conn_i();
	//ricerca link multipli (il file collegato a più schede)
	$query_multilink = "SELECT codice FROM mediabank WHERE file='".$_SESSION['mediafile_md']."'";
	$reslink = mysqli_query($handleCon,$query_multilink);
	$find_multi = mysqli_num_rows($reslink);
	if($find_multi==1) 
	{ //trovati link multipli

			mysqli_free_result($reslink);
			// ricerca del record media
			$theQuery =  "SELECT file, descrizione FROM mediabank WHERE codice=".$_SESSION['codice_md']." AND n_ord=".$progr_media;
			$result = mysqli_query($handleCon,$theQuery); 
			$trovati = mysqli_num_rows($result);
			if ($trovati==1) // deve trovarne uno solo!
			{ // n. record trovati = 1?
						$rowm=mysqli_fetch_array($result);
						// le due righe successive sono inutili perchè la variabile
						// di sessione mediafile_md è già settata da media_dett.php
						// eventualmente eliminare
	   				$nomeMediaFile = $rowm[0];
	   				$_SESSION['mediafile_md'] = $nomeMediaFile;
	   				$descFile = $rowm[1];
	   				//salvo anche la descrizione nella var. di sessione
	   				$_SESSION['desc_md']=$descFile;
	   				mysqli_free_result($result);

					?>
						<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
						<HTML>
					<HEAD>
						<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
						<TITLE>Gestione files multimediali</TITLE>
						<table border="0">
							<tr>
								<td width="25%">
								<!-- colonna spazio vuoto -->
								</td>
								<td>
									<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
									<font size="2">
										Cancellazione dei files collegati alla scheda del partigiano:<br />
									</font>
									</CENTER>
								</td>
								<td>
	 								<img align="top" src="immagini/mrp.jpg"><br>
								</td>
							</tr>
						</table>
									</font>
						</HEAD>

					<table>
						<tr>
							<td width="40%">
								<!-- colonna vuota -->
							</td>
							<td bgcolor="red">
							<font color='black' size='3'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>

								<?php
									$estensione = extfile($nomeMediaFile);
									echo "<br />";
									echo "CODICE SCHEDA / CODICE FILE :<b>".$_SESSION['codice_md']."</b> / <b>".$progr_media."</b><br /><br />";
									echo "COGNOME: <b>".$_SESSION['cognome_md']."</b><br />";
									echo "NOME: <b>".$_SESSION['nome_md']."</b><br />";
									echo "DATA NASCITA: <b>".$_SESSION['datanasc_md']."</b><br />";
									echo "LUOGO NASCITA: <b>".$_SESSION['luogonasc_md']."</b><br />";
									echo "NOME FILE: <b>".$nomeMediaFile."</b><br />";
										echo "</font>";
										echo "</td>";
										echo "<td>";
										if($estensione == "jpg" or $estensione == "png") 
										{ // è un'immagine?
											echo "<a href='media/".$nomeMediaFile."'><img src='media/".$nomeMediaFile."' border='0' width='200'></a>";
										} else // è un'immagine?
										{
											echo "<a href='text/".$nomeMediaFile."'><img src='immagini/doc_testo_ico.png' border='0'></a><br clear='all' />";
										}					
										echo "</td>";
									echo "</tr>";
									echo "</table>";
									echo "<br />";
	
					echo "<center><br />";
					echo "Descrizione: ".$descFile."<br />";
					echo "<font color='red'><b>ATTENZIONE! Stai per cancellare questo file</b></font><br />";
					echo "Puoi salvare il file sul tuo computer prima di procedere alla sua eliminazione";
					echo " facendo click sull'immagine.";		
					echo "<center>";			
					echo "<FORM name='frmdellabel' ACTION='media_del_do.php' METHOD='POST'>";
					echo "</center>";	
	
				?>


						<P STYLE="text-indent: 0.1cm; margin-bottom: 0cm">

						<P><INPUT TYPE=SUBMIT NAME="Cancella" VALUE="Cancella il file"><br><br />
						<table>
							<tr>
								<td width="10%">
									<!-- spazio vuoto -->
								</td>
				
								<td>
								<a href='index.php'>[Torna al menu principale]</a>
								</td>
				
								<td width="10%">
									<!-- spazio vuoto -->
								</td>
				
								<td>
									<a href='javascript:history.go(-1)'>[Torna indietro]</a>
								</td>
				
								<td width="10%">
									<!-- spazio vuoto -->
								</td>			

							</tr>
						</table>		
						</P>

					</center><!-- chiusura center titolo e n. scheda -->
					<br>
					</body>
					</html>


						<?php


			} else //n. record > 1? 
			{ //n. record > 1
				echo "<br />";
				echo "Record non individuato correttamente, problemi negli indici o nei record del database";
				echo "<a href='index.php'>Torna al menu principale</a>";
			} //n. record > 1 ?

	} else 
	{ // trovati link multipli
		
			echo "<center>";
			$estensione = extfile($_SESSION['mediafile_md']);
			if($estensione == "jpg" or $estensione == "png") 
			{ // è un'immagine? si
				echo "<img src='media/".$_SESSION['mediafile_md']."' border='0' width='80'> ";
			} else // è un'immagine? no
			{
			  echo "<img src='immagini/doc_testo_ico.png' border='0' width='80'> ";
			}	
			
			echo "</center>";
			echo "<br clear='all' />";
			$msgErrMulti = "Attenzione! Il file ".$_SESSION['mediafile_md']." &egrave; collegato";
			$msgErrMulti = $msgErrMulti. " a pi&ugrave; di una scheda. Accedi al dettaglio del file e utilizza";
			$msgErrMulti = $msgErrMulti. " la funzione [Gestisci i collegamenti] per vedere a quali schede il file";
			$msgErrMulti = $msgErrMulti. " &egrave; associato ed eventualmente cancella uno o pi&ugrave; link ";
			$msgErrMulti = $msgErrMulti. "fino a che non ne resta uno solo";
			$msgErrMulti = $msgErrMulti. " &Egrave; possibile cancellare il file solo quando esso &egrave; collegato ad una sola scheda ";
			$objMex->push_error(TERROR, $msgErrMulti);
			$objMex->push_action("Torna al menu principale","http://mrpdatabase.altervista.org");
			$objMex->push_action("Torna indietro al dettaglio file","javascript:history.back()");
			$objMex->show();
			$objMex->resetta();
			
	} //trovati link multipli


} else // connessione?
{ //connessione ?

	echo "Modifica scheda:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";

} //connessione ?


?>