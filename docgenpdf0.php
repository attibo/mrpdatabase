<?php
/*
Attilio Bongiorni - giugno 2014
docgenpdf0.php creazione del pdf dell'attestato 
usa: libreria fpdf e sottoclasse attestatobj

Parametri passati allo script ($_REQUEST)
cp=codice per il quale stampare il pdf
oi=progressivo immagine da includere nel pdf associato alla scheda
esempio di url di attivazione: localhost/mrpdatabase_ns/prova_fpdf.php?cp=6876&oi=1
la connessione viene effettuata da questo script che poi passa l'handle al costruttore dell'oggetto mrpRobj
per poi ricavare i dati della scheda da stampare sull'attestato
*/
require_once("attestatobj.php"); //sottoclasse
include("db_conn_i.php"); //questo script effettua la connessione e passa l'handle mrpRobj
include("mrpRobj.php"); //oggetto per ricavare i dati
include("msgObj.php"); // gestione degli errori
include("my_to_dit.php"); //convenrione data in formato it
include("writelog.php");

$esito = True;

session_start();

if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{ // sessione

	$the_codice  	= $_REQUEST['cp'];
	$the_immagine 	= $_REQUEST['oi'];
	$handle = db_conn_i();
	
	//oggetto errori
	define("TERROR", 1);
	define("TWARN",2);
	define("GET",0);
	
	$errObj = new msgObj();

	$objppdf = new mrpRobj($the_codice);
	$objppdf->retrieve($handle);
	$objppdf->check();
	
	if($objppdf->iserrordata()) 
	{ // errore nel retrieve
		
		$errObj->push_error(TERROR, "Errore! Record non trovato o dati non congruenti" );
		$errObj->push_action("Torna al menu principale","index.php");
		$esito = False;			
		
	} else //errore nel retrieve
	{
		
		$italyDate = "";
		//variabili formattazione
		$colonna_label = 40;
		$coord_x_foto = 220;
		$coord_y_foto = 25;
		$dimens_foto = 60;
		$colonna_dati_anag = 100;
		$interlinea = 10;

		$pdf = new attestatobj();
		$pdf->setFont('Times', '', 30);
		$pdf->AddPage("L");
		$pdf->SetTextColor(128,0,0);
		$pdf->Text(100, 20, 'In onore del partigiano:');

		$pdf->setFont('Times', '', 20);
		$pdf->SetTextColor(61,94,86);
		$pdf->Text($colonna_label,50, 'Nome:');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text($colonna_dati_anag,50, $objppdf->nome(GET,0));

		$pdf->SetTextColor(61,94,86);
		$pdf->Text($colonna_label,60,'Cognome:');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text($colonna_dati_anag,60, $objppdf->cognome(GET,0));

		$pdf->SetTextColor(61,94,86);
		$pdf->Text($colonna_label,70, 'Nato a:');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text($colonna_dati_anag,70, $objppdf->luogonasci(GET,0));

		$pdf->SetTextColor(61,94,86);
		$pdf->Text($colonna_label,80, 'Il');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text($colonna_dati_anag,80, my_to_dit($objppdf->data_nasc(GET,0)));

		$pdf->SetTextColor(61,94,86);
		$pdf->Text($colonna_label,120,'Partigiano dal:');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text($colonna_dati_anag,120, my_to_dit($objppdf->inizio_arruol(GET,0)));

		$pdf->SetTextColor(61,94,86);
		$pdf->Text(160,120,'al:');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text(180,120,my_to_dit($objppdf->fine_arruol(GET,0)));

		$pdf->SetTextColor(61,94,86);
		$pdf->Text($colonna_label,130,'Con il grado di:');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text($colonna_dati_anag,130,$objppdf->qualifica(GET,0));

		$pdf->SetTextColor(61,94,86);
		$pdf->Text($colonna_label,140,'Formazione partigiana:');

		$pdf->SetTextColor(128,0,0);
		$pdf->Text(120,140,$objppdf->formazione(GET,0));

		$pdf->setFont('Arial', '', 15);
		$pdf->SetTextColor(61,94,86);
		$pdf->Text(200,190,'MUSEO DELLA RESISTENZA');
		$pdf->Text(200,197,'PIACENTINA');
		$pdf->Text(200,204,'Loc. Sperongia di Morfasso (PC)');

		$pdf->Image("media/".$_SESSION['mediafile_md'],$coord_x_foto,$coord_y_foto,$dimens_foto);
		//log
		writelog("mrpdblog.txt","docgenpdf0 cod.".$the_codice." utente: ".$_SESSION['who']);
		$pdf->Output();
		

	} //errore nel retrieve


		if(!$esito) 
		{
			$errObj->show();
		}


} else //sessione
{
	echo "Dettaglio scheda:<br>";
	echo "<br><br><br><br>Accesso negato ! Hai effettuato la connessione ?";
	echo "<p>Per connetterti fai click sul link <b>Accesso al database</b> nella pagina principale</p>";
	echo "<a href='index.php'>Torna al menu principale</a>";
} // sessione



?>