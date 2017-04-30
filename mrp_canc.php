<?php

/*
Attilio Bongiorni - novembre 2013
cancellazione della scheda del partigiano e di tutti i files associati 
*/

	session_start();
	include("db_conn_i.php");
	include("extfile.php");
?>
<html>


<body>
<?php

if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{ // sessione

//variabili
$la_queryv="";
$coloredati="4B0082";
$colordisp = "#F0FFF0"; // colore riga pari
$colorpar = "#FFFFFF"; // colore riga dispari

?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
	<TITLE>Cancellazione scheda e files collegati</TITLE>
	<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
	<font size="2">
	<table>
	<tr>
		<td>
			<img src="immagini/mrp.jpg" align="middle" ><br clear="all" />
		</td>
		<td>
			 <font color="red" size="+1"> Cancellazione scheda e files collegati </font></strong>
		</td>
	</tr>
	</table>
	
	
	</font>
	</CENTER>
	
	
</HEAD>
<BODY LANG="en-US" DIR="LTR">

<?php
	$codice_up=$_SESSION['code_delete'];

 			$la_queryv="SELECT * FROM partigiani WHERE codice = '".$codice_up. "'";

		$handleCon = db_conn_i();
		$qrisult = mysqli_query($handleCon, $la_queryv);
		if (mysqli_num_rows($qrisult) == 1)
		{  // query ok
 			echo "<font color='black' size='1'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
			echo "Scheda richiesta codice: ";
			echo $codice_up;
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
						$_SESSION['cogn_delete']=$row[2];
						echo "</font>";
					echo "</td>";
					echo "<td>";
						echo "Nome:  ";
						echo "<font color='".$coloredati."'>";
						echo $row[1];
						$_SESSION['nom_delete']=$row[1];
						echo "</font>";
					echo "</td>";

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
			
				echo "</tr>";
			echo "</table>";
			// fine tabella
				
			// Query e visualizzazione tabella associata
			$queryDett= "SELECT * FROM partigiani LEFT JOIN mediabank ON partigiani.CODICE = mediabank.CODICE WHERE partigiani.CODICE=".$codice_up;

			$qrisult = mysqli_query($handleCon, $queryDett);
			$j=1;
			
				if (mysqli_num_rows($qrisult) == 0)
				{  // query dettaglio no
					echo "Nessun elemento multimediale associato alla scheda";
				} else // query dettaglio ok
				{
					echo "Elenco files gi&agrave; presenti:";
					echo "<hr align='left' width='70%' noshade='noshade' />";
					
					//inizio tabella esterna
					echo "<table>";
						echo "<tr>";
						echo "<td>";
							//inizio tabella nidificata
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
												echo $row[26];
											echo "</td>";
								
											echo "<td>";
												echo "<a href='media/".$row[27]."'>".$row[27]."</a>";
											echo "</td>";
								
											echo "<td>";
												echo $row[28];
											echo "</td>";
									
											/*
											sezione disattivata perchè troppo lenta la visualizzazione delle miniature
											echo "<td>";
												$estens= extfile($row[27]);
												if($estens=="jpg" or $estens=="png") 
												{
													echo "<a href='media/".$row[27]."'><img width='50' border='0' src='media/".$row[27]."'></a>";
												} else 
												{
													echo "<a href='text/".$row[27]."'><img width='50' border='0' src='immagini/doc_testo_ico_p.png'></a>";
												}										
											echo "</td>";
											*/
									
										echo "</tr>";
								
										$j++;
								} //while
						
								//fine tabella nidificata
								echo "</table>";
					
						echo "<td width='10%'>";
							//spazio vuoto
						echo "</td>";						
						echo "<td valign='top'>";
							echo "<img src='immagini/icona_punto_esclam.jpg'>";
						echo "</td>";
						echo "</td>";						
						echo "</tr>";
					echo "</table>"; //fine tabella esterna						
						
				} // query dettaglio (fine)	
			
?>

<font color='red' size="3">
<b>ATTENZIONE!!!<br />
Confermi la cancellazione della scheda <br />
e di tutti i files ad essa collegati ?</b><br>
</font>
<form name = "frmcancfile" enctype="multipart/form-data" action="canc_do.php" method="POST">
<input type="submit" value="Conferma la cancellazione" />
</form>
			
			
<?php				
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

<P>
<a href='index.php'>[Torna al menu principale]</a> <a href='javascript:history.go(-1)'>[Indietro al dettaglio scheda]</a>;

</P>

<?php

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
