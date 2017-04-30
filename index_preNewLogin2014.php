<?php
/*
Pagina principale del sistema di gestione del database dei partigiani online del
Museo della Resistenza Piacentina di Sperongia di Morfasso
Dati dell'ANPI Provinciale integrati mediante l'attività di ricerca del museo
---------------------------------
Attilio Bongiorni - luglio-agosto 2012
modificate routines di connessione, predisposto unico script db_conn_i.php - settembre 2013
si connette al database solo per visualizzare il numero di records nella tabella e la connessione
viene richiusa subito

Javascript free script menu provided by<br />
http://javascriptkit.com">JavaScript Kit
*/

	session_start();
?>
<html>

<?php
if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{
	$iscon = 1;
} else
{
	$iscon = 0;
}

// variabili
$numeroSchede = 0;
// fine variabili
include("db_conn_i.php"); 
?>

<HEAD><TITLE>Museo della Resistenza Piacentina - Database dei Partigiani</TITLE></HEAD>
<BODY>
<TD> 
<font size="2" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="black">

<!--  menu javascript head  -->

<style type="text/css">
<!--

.coolmenu{
width: 200px;
}

.coolmenu td{
background-color:bisque;
cursor:hand;
font-family:Arial;
font-weight:bold;
}

.coolmenu td a{
text-decoration:none;
color:black;
}

.coolmenu td#boxdescription{
background: ivory;
height: 25px;
font-weight: normal;
}

-->
</style>

<script language="javascript">
<!--

/*
Cool Table Menu
By Clarence Eldefors (http://www.freebox.com/cereweb) with modifications from javascriptkit.com
Visit http://javascriptkit.com for this and over 400+ other scripts
*/



function movein(which,html){
which.style.background='coral'
if (document.getElementById)
document.getElementById("boxdescription").innerHTML=html
else
boxdescription.innerHTML=html
}

function moveout(which){
which.style.background='bisque'
if (document.getElementById)
document.getElementById("boxdescription").innerHTML=' '
else
boxdescription.innerHTML=' '
}

//-->
</script>

<!--  menu javascript head (fine)  -->


<table align="center" border="0">
	<TR>
		<TD width="70%">
		<CENTER><h2>Museo della Resistenza Piacentina di Sperongia</h2>
		<font size="2">
		<strong>Database dei partigiani e degli elementi multimediali</strong>
		</font>
		<font size="-2" color="#FF3D07">  - Rel. 2.7</font><br>
		</CENTER>
		</TD>
		
		<TD width="30%">
		<img align="top" src="immagini/mrp.jpg"><br>
		</TD>
	</TR>
</table>
<center><br />
Database operativo dei partigiani della Provincia di Piacenza<br /><br />
L'accesso a questi archivi &egrave; riservato agli operatori del Museo della Resistenza Piacentina di Sperongia<br /><br />
Per informazioni sul Museo sito web: <a href="www.resistenzapiacenza.it" >www.resistenzapiacenza.it</a><br /><br />
</center><br /><br />

<table align="center" border="1">
	<TR>
	<TD width="50%">
	

<!-- //menu javascript esso  -->

<table class="coolmenu" bgcolor="black" border="1" bordercolor="ivory" cellpadding="2" cellspacing="0">

<tr>
<td bordercolor="black" id="choice1" onmouseover="movein(this,'Pagina di ricerca mediante dati anagrafici')" onmouseout="moveout(this)"">
<a href="cerca.php">Cerca una scheda</a></td></tr>

<td bordercolor="black" id="choice2" onmouseover="movein(this,'Inserimento nuova scheda')" onmouseout="moveout(this)">
<a href="mrp_ins.php">Aggiungi una scheda al database</a></td></tr>

<?php
if ($iscon==1)
{
echo "<td bordercolor='black' id='choice4' onmouseover='movein(this,'Disconnessione dal database')' onmouseout='moveout(this)'><a href='disconnect_atticom.php'>Logout (uscita)</a></td></tr>";
}
?>

<tr>
<td bordercolor="black" id="boxdescription"></td></tr>
</table>


	
<!--  menu javascript esso (fine) -->

	</td>

	<td width="50%">
	
	<font size="+2" color="Purple">
	<?php

	if ($iscon == 0)
	{
	?>
		<form action="atti_connect.php" method="POST">
		<font size="2" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif">
		<p>Username: <input type="text" name="usr_goread" maxlength="30" size="40"></p>
		<p>Password: <input type="password" name="pwd_goread" maxlength="20" size="30"><br>

		<input type="submit" name="btn_ok" value="Login" size="20" >
		</p>
		</font>

	<?php
	} else
	{	echo "<font size='2' face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif'>";	
		echo "Contenuto del database: <br>";
		// Ricava il numero di records della tabella
		$la_query = 'SELECT * FROM `partigiani`';
		
		$conn=db_conn_i();
			$qrisult = mysqli_query($conn,$la_query);
			$row=mysqli_num_rows($qrisult);
	      echo "Numero schede di partigiani gestite: ";
	      echo $row;	
	   mysqli_free_result($qrisult);
		mysqli_close($conn);
		echo "<br>";
		echo "</font>";
	}
	?>	
	</font>
</table>

<br>
<center>
<font size="1">
<br /><br />
</center><br>
<hr align="center" noshade="true" width="70%">
<center>
Programmazione php-mysql di <A HREF="mailto:a.bon6iorni@gmail.com">Attilio Bongiorni
</A>
</font><br>
<img src="immagini/linux_inside.jpg">


</CENTER>
</BODY>
</html>