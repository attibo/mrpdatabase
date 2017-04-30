<?php
/*
cerca.php - Attilio Bongiorni - ultima modifica settembre 2013
visualizza la pagine di ricerca
inizia la sessione e registra una query vuota in modo che lo script pdDbSearc non richiami la vecchia
dalla variabile cookie già registrata.
Questa pagina non effettua connessione al database
*/
	session_start();
	// questi cookie servono al querypager
	setcookie("cok_qryp","dummy");
?>
<html>

<?php
if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{
	//include ('atticom_cf.php');
	// NB: secondo parametro vuoto	
	//$ayear = atticom_cf("atticonf_year.txt","")

?>

<HEAD><TITLE>Museo della Resistenza Piacentina - database dei partigiani</TITLE></HEAD>
<BODY>
<font size="2" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="black">

<table align="center" border="0">
	<TR>
		<TD width="70%">
		<CENTER><h2>Museo della Resistenza Piacentina</h2>
		<font size="2">
		<strong>Database dei partigiani <br> </strong>
		</font>
		</TD>
		
		<TD width="30%">
		<img align="top" src="immagini/mrp.jpg"><br>
		</TD>
	</TR>
</table>
<table>
	<TR>
		<TD width="10%" align="justify">
			<font size="1" color="Navy">
			
			</font>
		</TD>

		<TD width="20%">
		<FORM action="peDbSearch.php" method="POST">
		Cognome: <input type="text" maxlength="40" name="riceCog"><br><br>
		Nome: <input type="text" maxlength="40" name="riceNom"><br /><br />
		
		Data nascita - inserire un range di ricerca<br />
		dal: <input type="text" maxlength="10" name="riceDal" size="4">
		al: <input type="text" maxlength="10" name="riceAll" size="4"><br /><br />
		Luogo di nascita: <input type="text" maxlength="35" name="riceLun"><br /><br />	
		Nome di battaglia: <input type="text" maxlength="35" name="riceBat"><br /><br />  
		<br><br><br>
		<center>
		<input type="submit" value="invia">
		<input type="reset" value="reset">
		</center>
		</FORM>
		</TD>

		<TD width="20%" bgcolor="">
			<font size="2" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="#708090">
			<p><strong>Fonte dei dati:</strong><br /></p>
			<p>Database ANPI Provinciale di Piacenza integrato con l'attivit&agrave; di ricerca del Museo della
			Resistenza Piacentina di Sperongia</p>
			<p><strong>Come effettuare la ricerca</strong><br /></p>
			<p>Inserire l dati con i quali effettuare la ricerca in uno o pi&ugrave; campi. I campi della data di nascita
			devono essere inseriti entrambi nella gamma da..a. per cercare un data singola inserire
			la stessa data in entrambi i campi. Ad esempio per ricercare un partigiano nato il 
			07/10/1919 inserire <br />
			dal:07/10/1919 al:07/10/1919. <br />
			Attenzione, in ogni caso le date di nascita devono essere inserite entrambe, in caso 
			contrario il sistema restituisce un errore.<br />
			Per ricercare tutti i partigiani nati nel 1919 inserire <br />
			dal:01/01/1919 al:31/12/1919.</p>
			Per ricercare i partigiani originari di una certa localit&agrave; (ad esempio tutti i 
			partigiani nati a Fiorenzuola), compilare solo il campo luogo di nascita.
			</font>
		</TD>
		<td width="10%">
		<!-- dummy -->
		</td>
	</TR>
</table>

<br>
<center>
<font size="1">
<a href="index.php">[Torna al menu principale]</a>
<br><br>
Programmazione php-mysql di <A HREF="mailto:a.bon6iorni@gmail.com">Attilio Bongiorni
</A>
</font><br>
<img src="immagini/linux_inside.jpg">
</center><br>
<?php
} else // ha fatto il login ? <<<<---------------
{
	echo '<font color="Red" size="+2">';
	echo '<center>';
	echo 'Accesso negato ! Prima devi effettuare il login';
	echo '<br><br><br>';
	echo '<a href="index.php"><img border="0" src="immagini/5bk02c.gif"></a>';
	echo '</center>';	
	echo '</font>';
}
?>

</BODY>
</html>