<?php

/*
Attilio Bongiorni - luglio-agosto 2012
Form di visualizzazione del dettaglio dei record
della scheda del partigiano.
La connessione al database viene aperta perché pager.php si conclude quindi è stata chiusa in precedenza
*/

	session_start();
	include("db_conn_i.php");
	include("extfile.php");
	include("firstphoto.php");
?>
<html>


<body>
<?php

if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{ // sessione

//variabili
$la_queryv="";
$coloredati="8B0000";
$colordisp = "#F0FFF0"; // colore riga pari
$colorpar = "#FFFFFF"; // colore riga dispari

	$codice_up=$_REQUEST['c'];
	/*
	Salvo il codice in una variabile di sessione che poi serve per la cancellazione
	del record 
	*/
	$_SESSION['code_delete'] = $codice_up;

 			$la_queryv="SELECT * FROM partigiani WHERE codice = '".$codice_up. "'";

		$handleCon = db_conn_i();
		$fotoscheda=firstphoto($handleCon,$codice_up);
		
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
	<TITLE>Visualizzazione dettaglio scheda</TITLE>
	<table>
		<tr>
			<td>
			<?php
				echo "<img src=".$fotoscheda." border='1' height='150'>";
			?>
			</td>
			<td>
				<h2>Museo della Resistenza Piacentina di Sperongia</h2>
					<font size="2">
   				<font color="#FF8928" size="+1"> Visualizzazione dettaglio scheda e files collegati</font></strong>
					</font>
			</td>

		</tr>
	</table>
	
</HEAD>
<BODY LANG="en-US" DIR="LTR">

<?php
					
		$qrisult = mysqli_query($handleCon, $la_queryv);
		if (mysqli_num_rows($qrisult) == 1)
		{  // query ok
 			echo "<font color='black' size='1'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
			echo "Scheda richiesta codice: ";
			echo $_REQUEST['c'];
			echo "<br><br>";
			$row=mysqli_fetch_array($qrisult);
			//visualizza in tabella
			echo "<table cellpadding='3' cellspacing='6' border='0' bgcolor='#FFFFFF' >";
				//1 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Cognome:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[2];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Nome:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[1];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Paternit&agrave;:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[3];
						echo "</font>";
					echo "</td>";
				echo "</tr>";
				
					//2 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Data di nascita:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[4];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Luogo di nascita:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[5];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Formazione:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[6];
						echo "</font>";
					echo "</td>";
				echo "</tr>";
				
				//3 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Qualifica:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[7];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Grado:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[8];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Data inizio arruolamento:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[9];
						echo "</font>";
					echo "</td>";
						echo "<td>";
						echo "Data fine arruolamento:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[10];
						echo "</font>";
					echo "</td>";
					
				//4 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Nazionalit &agrave;:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[11];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Caduto in battaglia:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[12];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Luogo di Morte:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[13];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Data di morte:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[14];
						echo "</font>";
					echo "</td>";
				echo "</tr>";
				
				//5 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Evento:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[15];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Associato:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[16];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Comitato pr.:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[17];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Commissione:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[18];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Ferito:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[19];
						echo "</font>";
					echo "</td>";
						echo "<td>";
						echo "Mutilato:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[20];
						echo "</font>";
					echo "</td>";
					
				echo "</tr>";

				//6 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Pubblica:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[22];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Nome di battaglia:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[23];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Tipologia iscrizione:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[24];
						echo "</font>";
					echo "</td>";
				echo "</tr>";

				//7 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Note:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[21];
						echo "</font>";
					echo "</td>";
				echo "<td>";
						echo "<a href='mrp_mod.php?cod=".$codice_up."'><img src='immagini/modifica_azzurr.jpg' alt='Modifica l'anagrafica' border='0'></a>";
						echo "<a href='mrp_canc.php'><img src='immagini/canc_giallo.jpg' alt='Cancella l'intera scheda' border='0'></a>";
						echo "</a>";	
					echo "</td>";							
				echo "</tr>";

			echo "</table>";
			// fine tabella
			
			//salvo i dati basilari in variabili di sessione
			//per poi visualizzarli in media_dett.php
			$_SESSION['codice_md']=$codice_up;
			$_SESSION['cognome_md']=$row[2];			
			$_SESSION['nome_md']=$row[1];
			$_SESSION['datanasc_md']=$row[4];
			$_SESSION['luogonasc_md']=$row[5];

			// Query e visualizzazione tabella associata
			$queryDett= "SELECT * FROM partigiani LEFT JOIN mediabank ON partigiani.CODICE = mediabank.CODICE WHERE partigiani.CODICE=".$codice_up;

			$qrisult = mysqli_query($handleCon, $queryDett);
			$j=1;
			
				if (mysqli_num_rows($qrisult) == 0)
				{  // query dettaglio no
					echo "Nessun elemento multimediale associato alla scheda";
				} else // query dettaglio ok
				{
					echo "Dettaglio documenti multimediali associati:";
					echo "<hr align='left' width='70%' noshade='noshade' />";
					//inizio tabella
					echo "<table cellpadding='3' cellspacing='6' border='0' bgcolor='#FFFFFF' >";
					while ($row=mysqli_fetch_array($qrisult))
						{ // while
							if ($j%2==1)
							{
								$colore=$colordisp;
							}else
							{
								$colore=$colorpar;
							}					

								$n=mysqli_num_rows($qrisult);
								
								echo "<tr bgcolor='".$colore."'>";
								
									echo "<td>";			
										if(intval($row[26])>0) 
										{					
											echo "<a href='media_dett.php?p=".$row[26]."'><img src='immagini/matitina.png'></a>";
										}
									echo "</td>";
									
									echo "<td>";								
										echo $row[26];
									echo "</td>";
								
									echo "<td>";
										$estensione=extfile($row[27]);
										switch($estensione) 
										{
											case "jpg":
												echo "<a href='media/".$row[27]."'>".$row[27]."</a>";
												break;
											case "png" :
												echo "<a href='media/".$row[27]."'>".$row[27]."</a>";
												break;
											case "pdf":
												echo "<a href='text/".$row[27]."'>".$row[27]."</a>";
												break;
											case "odt":
												echo "<a href='text/".$row[27]."'>".$row[27]."</a>";
												break;
											case "doc":
												echo "<a href='text/".$row[27]."'>".$row[27]."</a>";
												break;
											case "docx":
												echo "<a href='text/".$row[27]."'>".$row[27]."</a>";
												break;											
										}
									echo "</td>";
								
									echo "<td>";
										echo $row[28];
									echo "</td>";

								echo "</tr>";
								
								$j++;
						} //while
						
						//fine tabella
						echo "</table>";
						
				} // query dettaglio (fine)	
			
				
				echo "</font>";
			
		} else // query ok (no) 
		{      // query ok (no)
		
			echo "<br />Errore! - Record non individuato <br />";

			if(mysqli_num_rows($qrisult) > 1) 
				{
				echo "Individuati codici doppi (non univoci) contattare l'amministratore di sistema";
				mysqli_free_result($qrisult);
				mysqli_close();
				}	
		}      // query ok (fine)
?>

<br>
</font>

<P STYLE="text-indent: 0.1cm; margin-bottom: 0cm">



<?php

echo"<P>";
echo "<a href='index.php'>Torna al menu principale</a>";
echo " | ";
echo "<a href='mrp_add_media.php?c=".$codice_up."'>Aggiungi un file multimediale</a>";
echo " | ";
echo "<a href='peDbSearch.php'>Lista trovati</a>";
echo"</P>";

} else //sessione
{
	echo "Dettaglio scheda:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
} // sessione


?>

</body>
</html>
