<?php
/*
mrp_mod.php - Attilio Bongiorni - ottobre 2013
Pagina utilizzata per modificare un record delle schede dei partigiani
la pagina riceve i seguenti parametri via post
cod=codice della scheda
con questi dati viene effettuata la ricerca sulla tabella mysql
*/

	session_start();

setcookie("cooknmod",$_REQUEST['cod'],0);

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
	<TITLE>Variazione scheda del partigiano</TITLE>
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

<?php

$il_codice=$_REQUEST['cod'];
// istanzia l'oggetto
$objmrp = new mrpRobj($il_codice);
$objmrp->retrieve($handlecon);
?>

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

<FORM name="frmmodobj" ACTION="mod.php" METHOD="POST">
<center>

</font>

<P STYLE="text-indent: 0.1cm; margin-bottom: 0cm">
<table>

	<?php
	//istanzia l'oggetto
	if (!$objmrp->iserror()) // non ci devono essere errori nel metodo retrieve dell'oggetto
	{	
	echo "<font color='blue'>";
	echo "Codice scheda: ";
	echo $il_codice;
	echo "</center>"; //chiusura center titolo e n° scheda
	echo "<br>";
	// inizio tabella campi input
	echo "<tr>";

		// prima colonna	
		echo "<td>";
		echo "Cognome: ";
		echo "<INPUT type='text' size='30' maxlenght='40' name='cognome' value='";
		echo $objmrp->cognome(GET,'');
		echo "'>";
		echo "<br>";

		echo "Nome:";
		echo "<INPUT type='text' size='30' maxlenght='40' name='nome' value='";
		echo $objmrp->nome(GET, '');
		echo "'>";
		echo "<br />";
		
		echo "Paternit&agrave;:";
		echo "<INPUT type='text' size='30' maxlenght='40' name='paternit' value='";
		echo $objmrp->paternit(GET, '');
		echo "'>";
		echo "<br />";
		
		echo "Data di nascita:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='data_nascita' value='";
		echo my_to_dit($objmrp->data_nasc(GET, ''));
		echo "'>";
		echo "<br />";
		
		echo "Luogo di nascita:";
		echo "<INPUT type='text' size='20' maxlenght='35' name='luogonasci' value='";
		echo $objmrp->luogonasci(GET, '');
		echo "'>";
		echo "<br />";
		
		echo "Formazione:";
		echo "<INPUT type='text' size='30' maxlenght='50' name='formazione' value='";
		echo $objmrp->formazione(GET, '');
		echo "'>";
		echo "<br />";
		
		echo "Qualifica:";
		echo "<INPUT type='text' size='30' maxlenght='40' name='qualifica' value='";
		echo $objmrp->qualifica(GET, '');
		echo "'>";
		echo "<br />";	
		
		echo "Grado:";
		echo "<INPUT type='text' size='30' maxlenght='30' name='grado' value='";
		echo $objmrp->Grado(GET, '');
		echo "'>";
		echo "<br />";
		
		echo "Inizio arruolamento:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='inizio_arruol' value='";
		echo my_to_dit($objmrp->inizio_arruol(GET, ''));
		echo "'>";
		echo "<br />";
		
		echo "Fine arruolamento:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='fine_arruol' value='";
		echo my_to_dit($objmrp->fine_arruol(GET, ''));
		echo "'>";
		echo "<br />";		
		
		echo "Nazionalit&agrave;:";
		echo "<INPUT type='text' size='20' maxlenght='50' name='nazionalit' value='";
		echo $objmrp->nazionalit(GET, '');
		echo "'>";
		echo "<br />";

		$blankVar = $objmrp->caduto(GET,'');
		echo "Caduto:";
		if($blankVar!="") 
		{ //blank				
				if($objmrp->caduto(GET, '')=="si") 
				{
					echo "<INPUT type='radio' name='caduto' value='si' checked>si";
					echo "<INPUT type='radio' name='caduto' value='no'>no";
				} elseif($objmrp->caduto(GET, '')=="no")  
				{
					echo "<INPUT type='radio' name='caduto' value='si'>si";
					echo "<INPUT type='radio' name='caduto' value='no' checked>no";
				}
		} else //blank
		{ //blank
					echo "<INPUT type='radio' name='caduto' value='si'>si";
					echo "<INPUT type='radio' name='caduto' value='no' checked>no";
		
		} //blank
			
		echo "<br />";
		
		echo "Luogo di morte:";
		echo "<INPUT type='text' size='30' maxlenght='50' name='luogo_morte' value='";
		echo $objmrp->luogomorte(GET, '');
		echo "'>";
		echo "<br />";
		
		echo "Data di morte:";
		echo "<INPUT type='text' size='20' maxlenght='10' name='data_morte' value='";
		echo my_to_dit($objmrp->data_morte(GET, ''));
		echo "'>";
		echo "<br />";
		
		echo "</td>"; //fine prima colonna
		
		//seconda colonna
		echo "<td>";
		echo "Evento:";
		echo "<INPUT type='text' size='50' maxlenght='50' name='evento' value='";
		echo $objmrp->evento(GET, '');
		echo "'>";
		echo "<br />";
		
		echo "Associato:";
		$blankVar = $objmrp->associato(GET, '');
		if($blankVar!="") 
		{ //bkank?
			if($objmrp->associato(GET, '')=="si") 
			{
				echo "<INPUT type='radio' name='associato' value='si' checked>si";
				echo "<INPUT type='radio' name='associato' value='no'>no";
			} elseif($objmrp->associato(GET, '')=="no")  
			{
				echo "<INPUT type='radio' name='associato' value='si'>si";
				echo "<INPUT type='radio' name='associato' value='no' checked>no";
			}
		} else //blank? 
		{ //blank?
				echo "<INPUT type='radio' name='associato' value='si'>si";
				echo "<INPUT type='radio' name='associato' value='no' checked>no";	
		} //blank?
		echo "<br />";

		echo "Comitato pr.:";
		$blankVar = $objmrp->comitatopr(GET,'');
		if($blankVar!="") 
		{ //blank
			if($objmrp->comitatopr(GET, '')=="si") 
			{
				echo "<INPUT type='radio' name='comitatopr' value='si' checked>si";
				echo "<INPUT type='radio' name='comitatopr' value='no'>no";
			} elseif($objmrp->comitatopr(GET, '')=="no")  
			{
				echo "<INPUT type='radio' name='comitatopr' value='si'>si";
				echo "<INPUT type='radio' name='comitatopr' value='no' checked>no";
			}		
		} else //blank
		{ //blank
				echo "<INPUT type='radio' name='comitatopr' value='si'>si";
				echo "<INPUT type='radio' name='comitatopr' value='no' checked>no";			
		} //blank
		echo "<br />";		
		
		
		echo "Commissione: ";
		$blankVar = $objmrp->commission(GET, '');
		if($blankVar!="") 
		{ //blank
			if($objmrp->commission(GET, '')=="si") 
			{
				echo "<INPUT type='radio' name='commission' value='si' checked>si";
				echo "<INPUT type='radio' name='commission' value='no'>no";
			} elseif($objmrp->commission(GET, '')=="no")  
			{
				echo "<INPUT type='radio' name='commission' value='si'>si";
				echo "<INPUT type='radio' name='commission' value='no' checked>no";
			}		
		}else //blank 
		{ //blank
				echo "<INPUT type='radio' name='commission' value='si'>si";
				echo "<INPUT type='radio' name='commission' value='no' checked>no";
		} //blank
		echo "<br />";		
		
		echo "Ferito:";
		$blankVar = $objmrp->ferito(GET,'');
		if($blankVar!="") 
		{ //blank
			if($objmrp->ferito(GET, '')=="si") 
			{
				echo "<INPUT type='radio' name='ferito' value='si' checked>si";
				echo "<INPUT type='radio' name='ferito' value='no'>no";
			} elseif($objmrp->ferito(GET, '')=="no")  
			{
				echo "<INPUT type='radio' name='ferito' value='si'>si";
				echo "<INPUT type='radio' name='ferito' value='no' checked>no";
			}		
		} else //blank
		{ //blank
				echo "<INPUT type='radio' name='ferito' value='si'>si";
				echo "<INPUT type='radio' name='ferito' value='no' checked>no";
		
		} //blank
		echo "<br />";
	
		echo "Mutilato:";	
		$blankVar=$objmrp->mutilato(GET,'');
		if($blankVar!="") 
		{ //blank
			if($objmrp->mutilato(GET, '')=="si") 
			{
				echo "<INPUT type='radio' name='mutilato' value='si' checked>si";
				echo "<INPUT type='radio' name='mutilato' value='no'>no";
			} elseif($objmrp->mutilato(GET, '')=="no")  
			{
				echo "<INPUT type='radio' name='mutilato' value='si'>si";
				echo "<INPUT type='radio' name='mutilato' value='no' checked>no";
			}		
		} else //blank
		{ //blank
				echo "<INPUT type='radio' name='mutilato' value='si'>si";
				echo "<INPUT type='radio' name='mutilato' value='no' checked>no";
		} //blank
		echo "<br />";		


		echo "Pubblica:";		
		$blankVar=$objmrp->pubblica(GET,'');
		if($blankVar!="") 
		{ //blank
			if($objmrp->pubblica(GET, '')=="si") 
			{
				echo "<INPUT type='radio' name='pubblica' value='si' checked>si";
				echo "<INPUT type='radio' name='pubblica' value='no'>no";
			} elseif($objmrp->pubblica(GET, '')=="no")  
			{
				echo "<INPUT type='radio' name='pubblica' value='si'>si";
				echo "<INPUT type='radio' name='pubblica' value='no' checked>no";
			}		
		} else //blank 
		{ //blank
				echo "<INPUT type='radio' name='pubblica' value='si'>si";
				echo "<INPUT type='radio' name='pubblica' value='no' checked>no";

		} //blank
		echo "<br />";

		
		
		echo "Tipologia:";
		echo "<INPUT type='text' size='4' maxlenght='2' name='tipologia' value='";
		echo $objmrp->tipologia(GET, '');
		echo "'>";
		echo "<br />";

		echo "Nome di battaglia:";
		echo "<INPUT type='text' size='40' maxlenght='35' name='nome_batt' value='";
		echo $objmrp->nome_batt(GET, '');
		echo "'>";
		echo "<br />";		
		
		echo "Note: ";
		echo "<textarea rows='6' cols='70' name='note'>";
		echo $objmrp->note(GET, '');
		echo "</textarea>";		
		echo "<br />";
		
		echo "<br />";
		echo "</td>";
	echo "</tr>";
	
	?>
	<!-- fine tabella field di input -->
	</table>
	<P><INPUT TYPE=SUBMIT NAME="Conferma" VALUE="Conferma"><br>
	<a href='index.php'>Annulla e torna al menu principale</a>;
	</P>

	<?php
	} else // non ci devono essere errori nel metodo retrieve dell'oggetto
	{
		echo "<br><br>";
		echo "Errore!";
		echo $objmrp->nerror[0];
		//da modificare, non deve visualizzare solo il primo
		echo "<a href='index.php'>Torna al menu principale</a>";
		
	}

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
