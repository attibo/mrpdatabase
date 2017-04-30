<?php

/*
Attilio Bongiorni - novembre 2013
inserimento di un nuovo elemento multimediale alla scheda del partigiano
action di questa form: ins_mediamrp.php
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
	<TITLE>Inserimento nuovo file</TITLE>
	<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
	<font size="2">
	<table>
	<tr>
		<td>
			<img src="immagini/mrp.jpg" align="middle" ><br clear="all" />
		</td>
		<td>
			 <font color="#4B0082" size="+1"> Aggiunta nuovo file dal collegare alla scheda </font></strong>
		</td>
	</tr>
	</table>
	
	
	</font>
	</CENTER>
	
	
</HEAD>
<BODY LANG="en-US" DIR="LTR">

<?php
	$codice_up=$_REQUEST['c'];
	//questa var. di sessione serve per mrp_add_media.php
	$_SESSION['codice_md']=$codice_up;

 			$la_queryv="SELECT * FROM partigiani WHERE codice = '".$codice_up. "'";

		$handleCon = db_conn_i();
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
							echo "&Egrave; possibile archiviare i files: <br />";
							echo "pdf, doc, docx, odt, jpg, png<br />";
							echo "sono ammessi files di dimensione max di 3 Mb.<br />";
							echo "<img src='immagini/iconaodt.jpg'>";
							echo "<img src='immagini/iconaword.png'>";
							echo "<img src='immagini/iconajpg.jpg'>";							
						echo "</td>";
						echo "</td>";						
						echo "</tr>";
					echo "</table>"; //fne tabella esterna						
						
				} // query dettaglio (fine)	
			
?>
			
<!--ATTENZIONE enctype SERVE PER IL TEST DI UPLOAD FILE-->
<!--javascript per filtro *.pdf-->
<SCRIPT language=JavaScript type=text/javascript><!--
function Controlla(testoVuoto)
{
 var ext = document.frmaddfile.userfile.value;
 if(ext.length != 0)
 {
  ext = ext.substring(ext.length-3,ext.length);
  ext = ext.toLowerCase();
 	 
 	 	switch(ext)
  		{
  			case "pdf":
  			esito = true;
  			break;
  			
  			case "odt":
  			esito = true;
  			break;
  			
  			case "doc":
  			esito = true;
  			break;
  			
  			case "docx":
  			esito = true;
  			break;
  			
  			case "jpg":
  			esito = true;
  			break;
  			
  			case "png":
  			esito = true;
  			break;
  		
  			default:
  			alert('Hai selezionato un file .'+ ext +
   		' ma sono accettati solo i file doc, docx, pdf, jpg, png!');
   		esito = false;
   		break;
  		}

 }
 else if(testoVuoto)
 {
  alert('Non hai selezionato alcun documento');
  // nella versione originale c'era il return false
  //return false;
  esito = false;
 }
 
 return esito;
}
//--></SCRIPT>
<!--javascript per filtro *.pdf-->

<!-- Tipo di codifica dei dati, DEVE essere specificato come segue -->
<form name = "frmaddfile" enctype="multipart/form-data" onsubmit="return Controlla(true)" action="ins_mediamrp.php" method="POST">
    <!-- MAX_FILE_SIZE deve precedere campo di input del nome file -->
    <input type="hidden" name="MAX_FILE_SIZE" value="15000000" />
    <!-- Il nome dell'elemento di input determina il nome nell'array $_FILES -->
    Archivia questo file: <input name="userfile" type="file" />
    <input type="submit" value="Aggiungi file" />
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
