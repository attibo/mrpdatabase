<?php
/*
	xdwn.php - autore sconosciuto, già usato con applicazione di Peco Rara Gente
	usa la variabile di sessione $_SESSION["xcsv"]
	Download del file $file, il codice php iniziale serve per 
	costringere il browser a non usare nessuna cache e a scaricare
	direttamente il file.
*/
session_start();
if ($_SESSION["user_id_pattern"] == "bravo ragazzo")

{ //sessione
		$file = $_SESSION["xcsv"];
		if (file_exists($file)) {
    		header('Content-Description: File Transfer');
    		header('Content-Type: application/octet-stream');
    		header('Content-Disposition: attachment; filename='.basename($file));
    		header('Content-Transfer-Encoding: binary');
    		header('Expires: 0');
    		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    		header('Pragma: public');
    		header('Content-Length: ' . filesize($file));
    		ob_clean();
    		flush();
    		readfile($file);
    		unlink($file);
    		exit;
		}
} //sessione

?>
