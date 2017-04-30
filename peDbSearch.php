<?php
/*
pedbsearch.php - action-post di mrpdatabase\index.php
Attilio Bongiorni - luglio-agosto 2011
-------------------------------
utilizza la classe
QueryPager 1.2.1 prodotta da Michele Malgaretto adattata con modifiche
la connessione viene aperta e chiusa da questa pagina
5/5/2014 modificato in modo da permettere il ritorno alla "lista trovati"
da mrp_dett.php
*/
			$num = 0;
			$anno = 0;
			$tipo = "";
			$parola = "";

			$where_string = "";
			// $qrisult // raccoglie il risultato della query
			$esito = true;
			$dgcolor = "#F0FFF0"; // colore riga pari
			$dccolor = "#FFFFFF"; // colore riga dispari
			$colore_ok = "";
			$sizeQuery = 0;
			$pipe = "";
			$lastwhere = "";
			$num = "";
			$anno ="";
			$tipo ="";
			$parola = "";
			$documento = "";
			//mrp
			//$dataDa = "";
			//$dataA = "";
			$cognome = "";
			$nome = "";
			$luogoNasc = "";
			$nomeBatt = "";
			$timeDa="";
			$timeA="";
			$vardebug="";


session_start();
if ($_SESSION["user_id_pattern"] == "bravo ragazzo")

{ //sessione

	include ("cleanup_text.php");
	include ("manyfunk.php");
	include ("date_range_where.php");
	include ("taberror.php");
	include ("db_conn_i.php");
	
	$la_query = urldecode($_COOKIE['cok_qryp']);
	
	if($la_query=="dummy") //vuota, settata da cerca.php
	{	
			$handleCon = db_conn_i();

			$today=getdate();
			$anno_attuale =$today["year"];

			/* controllo dati immessi nella form, pulizia tags 
			elenco variabili:
			*/
			// assume il valore 2 se entrambe le date sono blank 
			$blankdate=0;

			//prende i dati in input e li metto in variabili
			// per le date però controlla prima che non siano in bianco
			$dataDa 		= $_POST["riceDal"];
			$dataA		= $_POST["riceAll"];
			if($dataDa=="") 
				{
					//debug
					$blankdate++;
				} else 
				{

					$dataDa = dit_to_my(cleanup_text($dataDa,"/",1));
		
				}
			if($dataA=="") 
				{
					//debug
					$blankdate++;
				} else 
				{

					$dataA = dit_to_my(cleanup_text($dataA,"/","1"));
		
				}

			$cognome 	= mysqli_real_escape_string($handleCon, cleanup_text($_POST["riceCog"],"","1"));
			$nome			= mysqli_real_escape_string($handleCon, cleanup_text($_POST["riceNom"],"","1"));
			$luogoNasc	= mysqli_real_escape_string($handleCon, cleanup_text($_POST["riceLun"],"","1"));
			$nomeBatt	= mysqli_real_escape_string($handleCon, cleanup_text($_POST["riceBat"],"","1"));
			//meglio chiudere subito la connessione perchè poi ci possono essere gli errori ed è più
			//complicato da gestire
			mysqli_close($handleCon);



		// controllo validità dati immessi (solo le date)
		if ($dataA=="e" or $dataDa=="e")  
		{
			$esito=false;
			$errmess[] = "Date di nascita immesse non valide"; 
			$errlink[] = "Torma alla ricerca";
			$errurl[]  = "cerca.php";
			setcookie("cok_qryp","dummy");
		} else 
		{
			// controllo congruenza date
			$timeDa=strtotime(nozero_my_date($dataDa, "/")." 00:00");
			$timeA=strtotime(nozero_my_date($dataA, "/")." 00:00");
			if($timeDa > $timeA)
			{
				$esito = false;
				$vardebug="   incongruenti   ";
				$errmess[] = "Date inserite non congruenti";
				$errlink[] = "Torna alla ricerca";
				$errurl[] = "cerca.php";
				setcookie("cok_qryp","dummy");
			}
			// fine controllo congruenza date 
		
		} // fine controllo validità date
	
			// ricavo della query da input (primo passaggio)

			$la_query = "SELECT codice, cognome, nome, data_nasc, luogonasci, nome_batt FROM partigiani WHERE " ;// aggiungere dopo -->  WHERE "; //matrice di partenza
			if($nome !="") 
			{
				$where_string = " nome LIKE '%".$nome."%' AND";
			}
			if($cognome != "") 
			{
				$where_string = $where_string." cognome LIKE '%".$cognome."%' AND";
			}
			//se le date non sono entrambe in bianco costruisce la query
			//anche con quelle
			if($blankdate==0) 
			{
				$where_string = $where_string.date_range_where($timeDa, $timeA, $dataDa, $dataA);
			} elseif($blankdate==1) 
			{
				$esito = false;
				$errmess[] = "Occorre compilare entrambe le date";	
				setcookie("cok_qryp","dummy");
			}	
			// fine where date
			if($luogoNasc !="") 
			{
				$where_string = $where_string ." luogonasci LIKE '%".$luogoNasc."%' AND";
			}
			if($nomeBatt !="") 
			{
				$where_string = $where_string." nome_batt LIKE '%".$nomeBatt."%' AND";
			}
			$la_query = $la_query.$where_string;
		// togliamo un eventuale AND residuo alla fine della stringa where	
		$sizeQuery = strlen($la_query);
		$pipe = substr($la_query,$sizeQuery-3,3);
		if ($pipe == "AND")
			{
				$la_query = substr($la_query,0,$sizeQuery-3);
			}
		// se gli ultimi 5 caratteri sono "WHERE" allora non ha scelto niente (errore)
		$sizeQuery = strlen($la_query);
		$pipe = substr($la_query,$sizeQuery-6,6);
		if ($pipe == "WHERE ")
			{
				$esito = false;
				$errmess[] = "Non &egrave; stata effettuata alcuna scelta";
				$errlink[] = "";
				$errurl[] = "";
				setcookie("cok_qryp","dummy");
			}	
	
		// registro un cookie con la query
		setcookie("cok_qryp", urlencode($la_query));
		$_SESSION["qry_lista"]=$la_query;
		// DA QUI SI PUO' ESEGUIRE UN OUTPUT SULLA PAGINA - PRIMA NO !
		// ===========================================================

	} // ricavo della query da input - fine

	include ("my_to_dit.php");
	include ("pager.php");

	if($esito) 
	{
		// riconnetto prima di passare a querypager
		$handleCon = db_conn_i();
		$qrisult = new queryPager($handleCon, $la_query,10,15);
		if ($qrisult->getNumRows() > 0)
		{
			echo "Ok";	
		}
	}		

	// intestazioni e visualizzazioni html

	?>
	<head> <title>Ricerca Documenti Museo della Resistenza Piacentina</title>
	</head>
	<body>
	<center> <font color='#ff8c00' size="5"><strong>Museo della Resistenza Piacentina</strong><br></font>
	<img src="immagini/mrp.jpg" border="0" align="middle"><br clear="all" />
	<font size="4" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif">
	<center"><strong>Visualizzazione risultati della ricerca</strong></center>
	<hr align="center" noshade="" width="80%">
	<font size="1" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="black">

	<?php
	// eventuali messaggi o legende nella pagina, inserire qui

	if ($esito)
	{ // esito


			if ($qrisult->getNumRows() > 0)
				{
				echo "<FONT SIZE=4 STYLE='font-size: 16pt'><FONT COLOR='#eb613d'>";
				echo "<p><blockquote>"; 
				echo "</center>";
				echo "<h6>Query applicata= [".$qrisult->getQuery()."], totale documenti trovati=".$qrisult->getNumRows();
				echo "</h6></blockquote></p>";
				echo "</center></FONT>";
			
				$page=1;
				if(isset($_GET['page'])){
					$page=$_GET['page'];
				}
				$qrisult->getGridResult($page,0,2,5,$dgcolor,$dccolor,"80%","");

						
				} else // query ok e righe ritornate
				{
					echo "Nessun record presente";
				} // query ok ma nessun record	

				 // alla fine comunque si chiude la connessione
				 mysqli_close($handleCon);

	}else // esito
	{ // esito
		msg_taberror($errmess,0, $errlink, $errurl);
	} // fine esito

} else // sessione
{		 // sessione
		echo "Errore, connessione non effettuata<br>";
		echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
}		 // sessione

	?>
	<center>
	<br><br><a href="cerca.php">[Nuova ricerca]</a>  | 
   <a href="mrpExpoCsv.php">[Esporta i dati trovati in CSV (Excel)]</a>  |  
	<a href="index.php">[Menu principale]</a>
	</center>
	<blockquote>
	<center>
	<font size="1">
	Programmazione php-mysql di <A HREF="mailto:a.bon6iorni@gmail.com">Attilio Bongiorni<br></A>
	Classe di Oggetti PHP QueryPager di Michele Malgaretto
	</font><br>
	<img src="immagini/linux_inside.jpg">
	</center>
	</blockquote>

	</font>

	</body>
	</html>
