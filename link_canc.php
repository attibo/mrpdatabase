<?php

/*
Attilio Bongiorni - febbraio 2015
cancellazione di un collegamento media/scheda - finestra di richiesta di conferma
questo script viene chiamato da media_multilink.php e chiama canc_do_link.php
usa le variabili di sessione seguenti:
link_code_d
link_prog_d
link_file_d
*/

	session_start();
	include("db_conn_i.php");
	include("extfile.php");
	include ("mrpRobj.php");
	include_once("msgObj.php");
	
	define("TERROR", 1);
	define("TWARN",2);
	define("TINFO",3);
?>
<html>


<body>
<?php

if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{ // sessione

//variabili
$la_queryl="";
$coloredati="4B0082";
$colordisp = "#F0FFF0"; // colore riga pari
$colorpar = "#FFFFFF"; // colore riga dispari

$objMex = new msgObj();

/* il parametro c viene passato dal media_multilink.php quando si fa clic
  sulla x rossa di cancellazione da una riga della tabellina che elenca i link
 il c rappresenta il codice della scheda interessata dal link
 la variabile di sessione link_code_d viene sovrascritta dal parametro c
*/
$_SESSION['link_code_d']=$_REQUEST['c'];
$_SESSION['link_prog_d']=$_REQUEST['p'];

		$codice_up = $_REQUEST['c'];

?>	
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<HTML>
	<HEAD>
		<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
		<TITLE>Cancellazione collegamento media/scheda</TITLE>
		<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
		<font size="2">
		<table>
		<tr>
			<td>
				<img src="immagini/mrp.jpg" align="middle" ><br clear="all" />
			</td>
			<td>
				 <font color="red" size="+1"> Cancellazione associazione media/scheda anagrafica </font></strong>
			</td>
		</tr>
		</table>
	
	
		</font>
		</CENTER>
	
	
	</HEAD>
	<BODY LANG="en-US" DIR="LTR">

	<?php

			$handleCon = db_conn_i();
			$recPartObj = new mrpRobj($codice_up);
			$recPartObj->retrieve($handleCon);
			echo "<font color='black' size='1'face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";
			//visualizza in tabella
			echo "<table cellpadding='3' cellspacing='6' border='0' bgcolor='#FFFFFF' >";
				//1 riga
				echo "<tr bgcolor='#D3D3D3'>";
					echo "<td>";
						echo "Nome file:  ";
						echo "<font color='".$coloredati."'>";
						echo $_SESSION['link_file_d'];
						echo "<br />";
						echo "<img src='media/".$_SESSION['link_file_d']."' width='200'>";
						echo "</font>";
					echo "</td>";
					echo "<td bgcolor = '#ffffff'>";
						// immagine catena
						echo "<font color='".$coloredati."'>";
						echo "<img src = 'immagini/linkico.jpg'";
						echo "</font>";
					echo "</td>";
				
					echo "<td>";
						echo "Scheda collegata: <br /> ";
						echo "<font color='".$coloredati."'>";
						echo $_SESSION['link_code_d'];
						echo "<br />";
						echo $recPartObj->nome(0,"")." ";
						echo $recPartObj->cognome(0,""). "<br />";
						echo "Data di nascita: ";
						echo $recPartObj->data_nasc(0,"")."<br />";
						echo "Nato a: ";
						echo $recPartObj->luogonasci(0,"")."<br />";
						echo "Paternit&agrave;: ";
						echo $recPartObj->paternit(0,"");
						echo "<br />";
						echo "Formazione: ";
						echo $recPartObj->formazione(0,"");
						echo "<br />";
						echo "Grado: ";
						echo $recPartObj->grado(0,"");
						echo "<br />";
					
						echo "</font>";
					echo "</td>";
		
					echo "<td valign='top' align='center' bgcolor='#ffffff'>";
								echo "<img src='immagini/icona_punto_esclam.jpg'><br />";
								echo "Stai per cancellare l'associazione tra il file<br /> <b>";
								echo $_SESSION['link_file_d'];
								echo "</b> e la scheda n. <b>". $_SESSION['link_code_d']."</b>";
							echo "</td>";
					echo "</td>";
			
				echo "</tr>";
				echo "</table>";
				// fine tabella
							
			
	?>

	<font color='red' size="3">
	<b>ATTENZIONE!!!<br />
	Confermi la cancellazione del collegamento? <br />
	</font>
	<form name = "frmcanclink" enctype="multipart/form-data" action="canc_do_link.php" method="POST">
	<input type="submit" value="Conferma la cancellazione" />
	</form>
			
	</font>
			

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
