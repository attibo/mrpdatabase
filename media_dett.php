<?php
/*
media_dett.php - Attilio Bongiorni - ottobre 2013
Pagina utilizzata per gestire un record degli elementi multimediali associati alla scheda
La pagina utilizza delle variabili di sessione salvare da mrp_dett.php che individuano
nome, cognome, data nascita, codice della scheda, mentre il progressivo del file multimediale
viene ricavato dalla variabile post "p"
*/

	session_start();

//setcookie("cooknmod",$_REQUEST['cod'],0);

?>
<html>
<body>
<?php

include('cleanup_text.php');
include("db_conn_i.php");
include("extfile.php");
$isImage = True;
$progr_media=$_REQUEST['p'];
//salvo il progressivo in una variabile di sessione perchè adesso è 
//conosciuto in quanto questa pagina gestisce un record per volta
//serve per media_mod_label.php
$_SESSION['progr_md']=$progr_media;

if ($_SESSION["user_id_pattern"] == "bravo ragazzo" )
{
	$handleCon = db_conn_i();


	// ricerca del record media
	$theQuery =  "SELECT file, descrizione FROM mediabank WHERE codice=".$_SESSION['codice_md']." AND n_ord=".$progr_media;
	$result = mysqli_query($handleCon,$theQuery); 
	$trovati = mysqli_num_rows($result);
	if ($trovati==1) // deve trovarne uno solo!
	{ // n. record trovati = 1?
		$rowm=mysqli_fetch_array($result);
	   $nomeMediaFile = $rowm[0];
	   $_SESSION['mediafile_md'] = $nomeMediaFile;
	   $descFile = $rowm[1];
	   //salvo anche la descrizione nella var. di sessione
	   $_SESSION['desc_md']=$descFile;

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
							Gestione dei files collegati alla scheda del partigiano:<br />
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
			<td bgcolor="grey">
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
							$isImage = True;
							echo "<a href='media/".$nomeMediaFile."'><img src='media/".$nomeMediaFile."' border='0' width='200'></a>";
						} else // è un'immagine?
						{
							$isImage = False;
							echo "<a href='text/".$nomeMediaFile."'><img src='immagini/doc_testo_ico.png' border='0'></a><br clear='all' />";
						}					
						echo "</td>";
					echo "</tr>";
					echo "</table>";
					
	echo "<center>";			
	echo "<FORM name='frmmodlabel' ACTION='media_mod_label.php' METHOD='POST'>";
	echo"<p><INPUT type='text' size='50' maxlenght='50' name='descrizione' value='".$descFile."'></p>";
	
?>


		<P STYLE="text-indent: 0.1cm; margin-bottom: 0cm">

		<P><INPUT TYPE=SUBMIT NAME="Salva" VALUE="Salva nuova descrizione"><br><br />
		<table>
			<tr>
				
				<td>
				<a href='index.php'>[Torna al menu principale]</a>
				</td>
				
				<td width="5%">
					<!-- spazio vuoto -->
				</td>
				
				<td>
					<a href='javascript:history.go(-1)'>[Torna al dettaglio scheda]</a>
				</td>
				
				<td width="5%">
					<!-- spazio vuoto -->
				</td>			
				
				<td>
					<?php
					echo "<a href='media_del.php?p=".$progr_media."'>[Cancella il file]</a>";
					?>
				</td>
				
				<td width="5%">
					<!-- spazio vuoto -->
				</td>		
				
				<td>
					<?php
					if($isImage) 
					{
						echo "<a href='docgenpdf0.php?cp=".$_SESSION['codice_md']."&oi=".$progr_media."'>[Stampa attestato]</a>";
					} else 
					{
						echo "[Stampa attestato]";
					}
					?>
				</td>
				


				<td width="5%">
					<!-- spazio vuoto -->
				</td>		

				<td>
					<?php
					echo "<a href='media_multilink.php?p=".$progr_media."'>[Gestisci i collegamenti]</a>";
					?>
				</td>

				
	
				
			</tr>
		</table>		
		</P>

	</center> <!-- chiusura center titolo e n. scheda -->
	<br>


		<?php



	} else //n. record > 1? 
	{ //n. record > 1
		echo "<br />";
		echo "Record non individuato correttamente, problemi negli indici o nei record del database";
		echo "<a href='index.php'>Torna al menu principale</a>";
	} //n. record > 1 ?

} else // connessione?
{ //connessione ?
	echo "Modifica scheda:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
} //connessione ?

?>
</body>
</html>
