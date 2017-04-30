<?php
/*
media_multilink.php - Attilio Bongiorni - luglio 2014
Pagina utilizzata per collegare un elemento multimediale a più di una scheda.
La pagina visualizza i collegamenti già esistenti per quell'elemento e consente di collegarlo
ad un'altra scheda.
Chiamante= media_dett.php
Usa la variabile di sessione $_SESSION['mediafile_md'] settata da media_dett.php
*/

	session_start();

//setcookie("cooknmod",$_REQUEST['cod'],0);

?>
<html>
<body>
<?php

include('cleanup_text.php');
include_once("db_conn_i.php");
include("extfile.php");
$isImage = True;

//variabile di sessione per pulsante link (cerca/conferma)
if(!isset($_SESSION['linkstartlevel'])) 
{
	//visualizza pulsante di ricerca con il codice
	$_SESSION['linkstartlevel']=0;
}

if($_SESSION['linkstartlevel']==0) 
{
	//il progressivo viene passato comunque come parametro, serve 
	// per le funzioni del menu a fondo pagina
	// se invece questo script viene richiatato da linkprepare.php
	// allora questa parte non serve (linkstartlevel==0)
	$progr_media=$_REQUEST['p'];
	//salvo il progressivo in una variabile di sessione 
	//che serve per far funzionare canc_do_link.php
	$_SESSION['link_prog_d']=$progr_media;
	//e questa sotto serve a fa funzionare link_reset.php
	$_SESSION['link_prog_resetlink']=$progr_media;
}else 
{
	$progr_media = $_SESSION['link_prog_d'];
}


if ($_SESSION["user_id_pattern"] == "bravo ragazzo" )
{
	$handleCon = db_conn_i();
	$nomeMediaFile = $_SESSION['mediafile_md'];
	//anche questa variabile di sessione serve per canc_do_link.php
	$_SESSION['link_file_d'] = $nomeMediaFile;
	//ed anche questa che viene copiata dall'altra variabile di sessione
	//settata da media_dett.php nella variabile appositamente creata 
	$_SESSION['link_code_d'] = $_SESSION['codice_md'];

	

	// ricerca del record media
	$theQuery =  "SELECT mediabank.file, mediabank.n_ord, partigiani.codice, partigiani.cognome, partigiani.nome, partigiani.data_nasc,";
	$theQuery = $theQuery." partigiani.luogonasci, partigiani.formazione";
	$theQuery = $theQuery." FROM mediabank INNER JOIN partigiani ON mediabank.codice = partigiani.codice";
	$theQuery = $theQuery." WHERE mediabank.file = '".$nomeMediaFile."'";
	
	$result = mysqli_query($handleCon,$theQuery); 
	$trovati = mysqli_num_rows($result);

	?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<HTML>
	<HEAD>
		<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
		<TITLE>Gestione collegamenti a pi&ugrave; schede</TITLE>
		<table border="0">
			<tr>
				<td width="25%">
				<!-- colonna spazio vuoto -->
				</td>
				<td>
					<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
					<font size="2">
							Gestione dei collegamenti di un elemento a pi&ugrave; schede:<br />
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

	<table align="top">
		<tr>
		<td width="25">
				<!-- colonna vuota -->
		</td>
		
		<td width="100" valign="top">
			<font color='black' size='3'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>

				<img src="immagini/collegamenti50.jpg" alt="collegamenti" border="0" >
				<?php
					$estensione = extfile($nomeMediaFile);
					echo "<br />";
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
						// 3a colonna - form richiesta codice (o nome/data nascita?)
						echo "<td>";
						
						if($_SESSION['linkstartlevel']==0) //cerca
						{						
							echo "<font color='black' size='3'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
								echo "<center>";	
								echo "Ricerca il codice della scheda da collegare:";		
								echo "<FORM name='frmmodlabel' ACTION='linkprepare.php' METHOD='POST'>";
								echo"<p><INPUT type='text' size='15' maxlenght='50' name='nlpost'></p>";
								echo "<P><INPUT TYPE='SUBMIT' NAME='Prepare' VALUE='Imposta nuovo link'><br><br />";
							echo "</font>";
							echo "</td>";
						}elseif($_SESSION['linkstartlevel']==1) //conferma
						{
							$_SESSION['linkstartlevel']=0;
							echo "<font color='black' size='3'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
								echo "<center>";	
								echo "Scheda da collegare:";	
								echo "<br />";	
								echo "<font color='#32CD32' size='2'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
								echo "<img src='immagini/linkanim.gif', border='0'>";
								echo "Codice= ";
								echo $_SESSION['tdnl_code'];
								echo "<br /><b>";
								echo $_SESSION['tdnl_nome'];
								echo " ";
								echo $_SESSION['tdnl_cogn'];
								echo "</b><br />";
								echo "Data nasc. ";
								echo $_SESSION['tdnl_datn'];
								echo " Paternit&agrave; ";
								echo $_SESSION['tdnl_patr'];
								echo "</font>";
								echo "<FORM name='frmmodlabel' ACTION='linkdo.php' METHOD='POST'>";
								echo "<P><INPUT TYPE='SUBMIT' NAME='Confirm' VALUE='Conferma nuovo link'><br /><br />";
								echo "<a href='link_reset.php'>[Reset]</a>";
							echo "</font>";
							echo "</td>";
						}						
						echo "<td width='40%' valign='top'>";
							echo "<font color='grey' size='2'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
							echo "Collegamento di un unica foto o elemento a più schede:<br /> In alcuni casi, ";
							echo "ad esempio per le foto di gruppo, una fotografia interessa più partigiani. In questo caso ";
							echo "non &egrave; opportuno caricare pi&ugrave; volte la fotografia per associarla alle schede ";
							echo "anagrafiche dei partigiani interessati, perch&egrave; in questo modo viene sprecato inutilmente";
							echo " lo spazio a disposizione sul nostro web server. Per evitare il problema &egrave; possibile caricare ";
							echo "la foto associandola ad uno dei partigiani interessati, annotare i codici delle altre schede" ;
							echo " anagrafiche inerenti la fotografia (o il testo), quindi accedere a questa pagina. Digitare ";
							echo "il codice da associare nel campo <b>Ricerca il codice della scheda da collegare </b> e con il pulsante";
							echo "<b> Imposta nuovo link</b> effettuare la ricerca. Se il nome che compare scritto in caratteri ";
							echo "verdi  &egrave; corretto confermare con il tasto   <b>Conferma nuovo link</b>. Effettuate queste ";
							echo " operazioni la foto visualizzata in questa pagina risulter&agrave; associata anche alla scheda ";
							echo "anagrafica appena confermata. Il file sar&agrave; unico ma verr&agrave; presentato richiamando ";
							echo "entrambe le schede anagrafiche coinvolte nell'operazione.";
						echo "</td>";
					echo "</tr>";
	echo "</table>";

   // questa tabella serve solo a visualizzare la scritta "L'immagine è collegata... ecc.
	echo "<table>";

		echo "<tr>";
				echo "<td width='25' bgcolor='white'>";
					//spazio vuoto
				echo "</td>";
				echo "<td>";
					echo "<font color='#FF4500'>";
					echo "L'immagine &egrave; collegata alle seguenti schede anagrafiche: ";
					echo "</font>";
				echo "</td>";
			echo "</tr>";	
	
	echo "</table>";
	// (FINE) questa tabella serve solo a visualizzare la scritta "L'immagine è collegata... ecc.
	
		$n=0;
		
			echo "<font color='black' size='3'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
			
			echo "<table bgcolor='#FFFFFF'>";
					//intestazioni:					
					echo "<tr bgcolor = 'grey'>";
						echo "<td width='25' bgcolor='white'>";
							//spazio vuoto
						echo "</td>";
						echo "<td width='20'>";
						//colonna vuota per ico cancellazione
						echo "</td>";
						echo "<td>";
							echo "PROGRESSIVO";
						echo "</td>";
						echo "<td>";
							echo "CODICE SCHEDA";
						echo "</td>";
						echo "<td>";
							echo "COGNOME";
						echo "</td>";						
						echo "<td>";
							echo "NOME";
						echo "</td>";
						echo "<td>";
							echo "DATA NASCITA";
						echo "</td>";
						echo "<td>";
							echo "LUOGO NASCITA";
						echo "</td>";
						echo "<td>";
							echo "FORMAZIONE";
						echo "</td>";
				
					while($rowm=mysqli_fetch_array($result, MYSQLI_NUM))
			{
				//visualizzazione tabella collegamenti già presenti
					//dati					
					echo "</tr>";					
					
					echo "<tr>";
						echo "<td width='25'>";
							//spazio vuoto
						echo "</td>";
						echo "<td>";
							//link a pagina che effettua la cancellazione previo settaggio
							//di variabili di sessione che verranno azzerate dopo la cancellazione (da fare))
							if($trovati >1) 	
							{ //num. collegamenti > 1
									echo "<a href='link_canc.php?c=".$rowm[2]."&p=".$rowm[1]."'><img src='immagini/cancellino.png'></a>";
							} else
							{	//num. collegamenti > 1
									// qui non occorrono link ma solo un messaggio
									echo "<img src='immagini/divieto.png'";
							}  //num. collegamenti > 1
						echo "</td>";
						echo "<td>";
							echo $rowm[1];
						echo "</td>";
						echo "<td>";
							echo $rowm[2];
						echo "</td>";	
						echo "<td>";
							echo $rowm[3];
						echo "</td>";						
						echo "<td>";
							echo $rowm[4];
						echo "</td>";
						echo "<td>";
							echo $rowm[5];
						echo "</td>";						
						echo "<td>";
							echo $rowm[6];
						echo "</td>";						
						echo "<td>";
							echo $rowm[7];
						echo "</td>";						
					echo "</tr>";
			}	//endwhile
			$n++;	
			echo "</table>";
			echo "</font>";

		?>
		
		<table>
			<tr>
				<td width="5%">
					<!-- spazio vuoto -->
				</td>
				
				<td>
				<a href='index.php'>[Torna al menu principale]</a>
				</td>
				
				<td width="5%">
					<!-- spazio vuoto -->
				</td>
				
				<td width="5%">
					<!-- spazio vuoto -->
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
	
				
			</tr>
		</table>		
		</P>

	</center> <!-- chiusura center titolo e n. scheda -->
	<br>


		<?php


} else // connessione?
{ //connessione ?

	echo "Gestione collegamenti:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
	
} //connessione ?

?>
</body>
</html>
