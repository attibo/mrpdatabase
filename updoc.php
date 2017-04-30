<?php
//Attilio Bongiorni - novembre 2009
//Script php che materialmente copia il file da aggiornare sul file nella http root document
//applicazione atticom_new

session_start();
include('atticom_cf.php');

if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{
	if (isset($_POST['Conferma']))
	{
		
		//------archiviazione del documento informatico associato 
				if(isset($_FILES['datafile']['tmp_name'])) // se è stato inserito un nome di file
				{
					$nomefileutente = $_FILES['datafile']['tmp_name'];
					$nfuteimmesso = $_FILES['datafile']['name'];
					
					//nome file documento informatico
					$destinazione= basename($_COOKIE['cookfileup']);
					$adirdest = atticom_cf('atticom_cf.txt', 'PATHrepo');
					
					if (file_exists(rtrim($adirdest[1])))
					{
						if (move_uploaded_file($nomefileutente, rtrim($adirdest[1])."/".$destinazione));
						{
							echo "<center>";
							echo "<font color='#ff8c00' size='+3'>";
							echo "Documento informatico archiviato: ";
							echo "</font>";
							echo "</center>";
							echo "<table border ='0'>";
							echo "<TR align='center'>";
							echo "<TD>";
							echo $nfuteimmesso;
							echo "</TD>";
							echo "<TD>";	
							echo "<img align='left' border='0' src='immagini/ingcopia.gif'>";
							echo "</TD>";
							echo "<TD>";
							echo $destinazione;
							echo "</TD>";
							echo "</TR></table>";
							echo "<br><br>";
							echo "<center>";
							echo "<font color='Blue'>";
							echo "<a href='index.php' >[Menu principale]</a>";
   							echo "  -  ";
							echo "<a href='cerca.php'>[Nuova ricerca]</a>";
							echo "</font>";
							echo "</center>";
						}		
					} else // file esiste?
					{
						echo "<font color='red'>";
						echo "Errore directory o invio file! Archiviazione del documento informatico non riuscita";
						echo "</font>";
					} // file esiste ? fine	
						//------archiviazione del documento informatico associato - fine
				} // se è stato inserito un nome di file
	
	} else //sessione
	{
		echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
		echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
		echo "<a href='index.php'>Torna al menu principale</a>";
	}



} else
{
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
}
?>
