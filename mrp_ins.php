<?php
/*
mrp_ins.php - Attilio Bongiorni - ottobre 2013
Pagina utilizzata per inserire un record delle schede dei partigiani
la pagina effettua la connessione con db_conn_i.php
*/

	session_start();

//setcookie("cooknmod",$_REQUEST['cod'],0);

?>
<html>
<body>
<?php

include('cleanup_text.php');
include("db_conn_i.php");
include("mrpRobj.php");
include("my_to_dit.php");
define("GET",0);
define("SET",1);

if ($_SESSION["user_id_pattern"] == "bravo ragazzo" )
{
$handlecon = db_conn_i();

?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
	<TITLE>Inserimento scheda del partigiano</TITLE>
	<table border="0">
		<tr>
			<td width="23%">
			<!-- colonna spazio vuoto -->
			</td>
			<td>
				<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
				<font size="2">
				</font>
				</CENTER>
			</td>
			<td>
	 			<img align="top" src="immagini/mrp.jpg"><br>
			</td>
		</tr>
	</table>
	
</HEAD>
<BODY LANG="en-US" DIR="LTR">


<!--javascript per controllo oggetto vuoto-->
<SCRIPT language=JavaScript type=text/javascript><!--
function Controlla(testoVuoto)
{
 var ogg = document.frmmodobj.fld_oggetto.value;
 if(ogg.length == 0)
 {
   alert('Il campo oggetto non deve essere vuoto!');
   return false;
 }
  else if(testovuoto)
 {
   return true;
 }
}
//--></SCRIPT>
<!--javascript per controllo oggetto vuoto-->

<FORM name="frmmodobj" ACTION="ins.php" METHOD="POST">
<center>

</font>

<P STYLE="text-indent: 0.1cm; margin-bottom: 0cm">
<table>

	<?php
	echo "</center>"; //chiusura center titolo e n° scheda
	echo "<br>";
	// inizio tabella campi input
	echo "<tr>";

		// prima colonna	
		echo "<td>";
		echo "Cognome: ";
		echo "<INPUT type='text' size='30' maxlenght='40' name='cognome'";
		echo "'>";
		echo "<br>";

		echo "Nome:";
		echo "<INPUT type='text' size='30' maxlenght='40' name='nome'";
		echo "'>";
		echo "<br />";
		
		echo "Paternit&agrave;:";
		echo "<INPUT type='text' size='30' maxlenght='40' name='paternit'";
		echo "'>";
		echo "<br />";
		
		echo "Data di nascita:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='data_nascita'";
		echo "'>";
		echo "<br />";
		
		echo "Luogo di nascita:";
		echo "<INPUT type='text' size='20' maxlenght='35' name='luogonasci'";
		echo "'>";
		echo "<br />";
		
		echo "Formazione:";
		echo "<INPUT type='text' size='30' maxlenght='50' name='formazione'";
		echo "'>";
		echo "<br />";
		
		echo "Qualifica:";
		echo "<INPUT type='text' size='30' maxlenght='40' name='qualifica'";
		echo "'>";
		echo "<br />";	
		
		echo "Grado:";
		echo "<INPUT type='text' size='30' maxlenght='30' name='grado'";
		echo "'>";
		echo "<br />";
		
		echo "Inizio arruolamento:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='inizio_arruol'";
		echo "'>";
		echo "<br />";
		
		echo "Fine arruolamento:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='fine_arruol'";
		echo "'>";
		echo "<br />";		
		
		echo "Nazionalit&agrave;:";
		echo "<INPUT type='text' size='20' maxlenght='50' name='nazionalit'";
		echo "'>";
		echo "<br />";

		echo "Caduto:";
		echo "<INPUT type='radio' name='caduto' value='si'>si";
		echo "<INPUT type='radio' name='caduto' value='no' checked>no";
		echo "<br />";
		
		echo "Luogo di morte:";
		echo "<INPUT type='text' size='30' maxlenght='50' name='luogo_morte'";
		echo "'>";
		echo "<br />";
		
		echo "Data di morte:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='data_morte'";
		echo "'>";
		echo "<br />";
		
		echo "</td>"; //fine prima colonna
		
		//seconda colonna
		echo "<td>";
		echo "Evento:";
		echo "<INPUT type='text' size='50' maxlenght='50' name='evento'";
		echo "'>";
		echo "<br />";
		
		echo "Associato:";
		echo "<INPUT type='radio' name='associato' value='si'>si";
		echo "<INPUT type='radio' name='associato' value='no' checked>no";	
		echo "<br />";

		echo "Comitato pr.:";
		echo "<INPUT type='radio' name='comitatopr' value='si'>si";
		echo "<INPUT type='radio' name='comitatopr' value='no' checked>no";			
		echo "<br />";		
		
		echo "Commissione: ";
		echo "<INPUT type='radio' name='commission' value='si'>si";
		echo "<INPUT type='radio' name='commission' value='no' checked>no";
		echo "<br />";		
		
		echo "Ferito:";
		echo "<INPUT type='radio' name='ferito' value='si'>si";
		echo "<INPUT type='radio' name='ferito' value='no' checked>no";
		echo "<br />";
	
		echo "Mutilato:";	
		echo "<INPUT type='radio' name='mutilato' value='si'>si";
		echo "<INPUT type='radio' name='mutilato' value='no' checked>no";
		echo "<br />";		


		echo "Pubblica:";		
		echo "<INPUT type='radio' name='pubblica' value='si'>si";
		echo "<INPUT type='radio' name='pubblica' value='no' checked>no";
		echo "<br />";
		
		echo "Tipologia:";
		echo "<INPUT type='text' size='4' maxlenght='2' name='tipologia'";
		echo "'>";
		echo "<br />";

		echo "Nome di battaglia:";
		echo "<INPUT type='text' size='40' maxlenght='35' name='nome_batt'";
		echo "'>";
		echo "<br />";		
		
		echo "Note: ";
		echo "<textarea rows='6' cols='70' name='note'>";
		echo "</textarea>";		
		echo "<br />";
		
		echo "<br />";
		echo "</td>";
	echo "</tr>";
	
	?>
	<!-- fine tabella field di input -->
	</table>
	<P><INPUT TYPE=SUBMIT NAME="Salva" VALUE="Salva"><br>
	<a href='index.php'>Annulla e torna al menu principale</a>;
	</P>

	<?php

} else
{
	echo "Modifica scheda:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
}

?>
</body>
</html>
