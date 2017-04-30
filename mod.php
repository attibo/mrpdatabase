<?php
session_start();
include_once("mrpRobj.php");
include_once("taberror.php");
$il_codice=$_COOKIE['cooknmod'];

include("db_conn_i.php");
include("cleanup_text.php");
include("my_to_dit.php");
define("GET",0);
define("SET",1);

// istanzia l'oggetto
$objrecPart = new mrpRobj($il_codice);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE></TITLE>
	<meta name="generator" content="Bluefish 2.2.4" >
	<META NAME="CREATED" CONTENT="20050522;15550400">
	<META NAME="CHANGED" CONTENT="20050522;16443900">
</HEAD>

<?php
if ($_SESSION["user_id_pattern"] == "bravo ragazzo")
{
	$objrecPart->nome(SET, addslashes(cleanup_text($_POST['nome'],"",1)));
	$objrecPart->cognome(SET, addslashes(cleanup_text($_POST['cognome'],"",1)));
	$objrecPart->paternit(SET, addslashes(cleanup_text($_POST['paternit'],"",1)));
	$objrecPart->data_nasc(SET, dit_to_my(addslashes(cleanup_text($_POST['data_nascita'],"",1))));
	$objrecPart->luogonasci(SET, addslashes(cleanup_text($_POST['luogonasci'],"",1)));
	$objrecPart->formazione(SET, addslashes(cleanup_text($_POST['formazione'],"",1)));	
	$objrecPart->qualifica(SET, addslashes(cleanup_text($_POST['qualifica'],"",1)));
	$objrecPart->grado(SET, addslashes(cleanup_text($_POST['grado'],"",1)));	
	$objrecPart->inizio_arruol(SET, dit_to_my(addslashes(cleanup_text($_POST['inizio_arruol'],"",1))));
	$objrecPart->fine_arruol(SET, dit_to_my(addslashes(cleanup_text($_POST['fine_arruol'],"",1))));
	$objrecPart->nazionalit(SET, addslashes(cleanup_text($_POST['nazionalit'],"",1)));
	$objrecPart->caduto(SET, addslashes(cleanup_text($_POST['caduto'],"",1)));
	$objrecPart->luogomorte(SET, addslashes(cleanup_text($_POST['luogo_morte'],"",1)));
	$objrecPart->data_morte(SET, dit_to_my(addslashes(cleanup_text($_POST['data_morte'],"",1))));
	$objrecPart->evento(SET, addslashes(cleanup_text($_POST['evento'],"",1)));
	$objrecPart->associato(SET, addslashes(cleanup_text($_POST['associato'],"",1)));
	$objrecPart->comitatopr(SET, addslashes(cleanup_text($_POST['comitatopr'],"",1)));
	$objrecPart->commission(SET, addslashes(cleanup_text($_POST['commission'],"",1)));	
	$objrecPart->ferito(SET, addslashes(cleanup_text($_POST['ferito'],"",1)));	
	$objrecPart->mutilato(SET, addslashes(cleanup_text($_POST['mutilato'],"",1)));	
	$objrecPart->pubblica(SET, addslashes(cleanup_text($_POST['pubblica'],"",1)));	
	$objrecPart->tipologia(SET, addslashes(cleanup_text($_POST['tipologia'],"",1)));
	$objrecPart->nome_batt(SET, addslashes(cleanup_text($_POST['nome_batt'],"",1)));	
	$objrecPart->note(SET, addslashes(cleanup_text($_POST['note'],"",1)));
	
	$objrecPart->check();
	
	if($objrecPart->iserrordata()) 
	{
		$nerrori = $objrecPart->nerrordata();
		for($n=0;$n<$nerrori;$n++) 
		{
			$arrErr[]=$objrecPart->errordata($n);
			$arrMen[]="Torna indietro";
			$arrAct[]="javascript:history.go(-1)";
		}
		//Ci sono errori di incongruenza nel record
		msg_taberror($arrErr,1,$arrMen,$arrAct);
		
	} else 
	{
		//Non ci sono errori di incongruenza
		// connessione
		$handlecon = db_conn_i();
		
		if (gettype($handlecon)!="boolean") //vuol dire che la connessione è riuscita
		{
			$la_query = "UPDATE `partigiani`".
			" SET `nome` 			= '".mysqli_real_escape_string($handlecon,$objrecPart->nome(GET,"")). 
			"',   `cognome`		= '".mysqli_real_escape_string($handlecon,$objrecPart->cognome(GET,"")).
			"',   `paternit` 		= '".mysqli_real_escape_string($handlecon,$objrecPart->paternit(GET,"")).
			"',	`data_nasc`		= '".mysqli_real_escape_string($handlecon,$objrecPart->data_nasc(GET,"")).
			"',	`luogonasci`	= '".mysqli_real_escape_string($handlecon,$objrecPart->luogonasci(GET,"")).
			"',	`formazione`	= '".mysqli_real_escape_string($handlecon,$objrecPart->formazione(GET,"")).
			"',	`qualifica`		= '".mysqli_real_escape_string($handlecon,$objrecPart->qualifica(GET,"")).
			"',	`grado`			= '".mysqli_real_escape_string($handlecon,$objrecPart->grado(GET,"")).
			"',	`inizio_arruol`= '".mysqli_real_escape_string($handlecon,$objrecPart->inizio_arruol(GET,"")).
			"',	`fine_arruol`	= '".mysqli_real_escape_string($handlecon,$objrecPart->fine_arruol(GET,"")).
			"',	`nazionalit`	= '".mysqli_real_escape_string($handlecon,$objrecPart->nazionalit(GET,"")).
			"',	`caduto`			= '".mysqli_real_escape_string($handlecon,$objrecPart->caduto(GET,"")).
			"',	`luogomorte`	= '".mysqli_real_escape_string($handlecon,$objrecPart->luogomorte(GET,"")).
			"',	`data_morte`	= '".mysqli_real_escape_string($handlecon,$objrecPart->data_morte(GET,"")).
			"',	`evento`			= '".mysqli_real_escape_string($handlecon,$objrecPart->evento(GET,"")).
			"',	`associato`		= '".mysqli_real_escape_string($handlecon,$objrecPart->associato(GET,"")).
			"',	`comitatopr`	= '".mysqli_real_escape_string($handlecon,$objrecPart->comitatopr(GET,"")).
			"',	`commission`	= '".mysqli_real_escape_string($handlecon,$objrecPart->commission(GET,"")).
			"',	`ferito`			= '".mysqli_real_escape_string($handlecon,$objrecPart->ferito(GET,"")).
			"',	`mutilato`		= '".mysqli_real_escape_string($handlecon,$objrecPart->mutilato(GET,"")).
			"',	`note`			= '".mysqli_real_escape_string($handlecon,$objrecPart->note(GET,"")).
			"',	`pubblica`		= '".mysqli_real_escape_string($handlecon,$objrecPart->pubblica(GET,"")).
			"',	`nome_batt`		= '".mysqli_real_escape_string($handlecon,$objrecPart->nome_batt(GET,"")).
			"',	`tipologia`		= '".mysqli_real_escape_string($handlecon,$objrecPart->tipologia(GET,"")).
			"' WHERE `codice` = ".$il_codice." LIMIT 1" ;
			// esegui l'upgrade
			$result = mysqli_query($handlecon,$la_query) or die ("Errore query ".$la_query);

			?>

			<BODY LANG="en-US" DIR="LTR">
			<P ALIGN=CENTER><FONT COLOR="#000080"><FONT SIZE=6 STYLE="font-size: 28pt">COMUNE
			di PECORARA (PC)</FONT></FONT></P>
			<HR>
			<P ALIGN=CENTER><IMG SRC="immagini/mrp266.jpg" NAME="Immagine1" ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>
			<P ALIGN=CENTER>Aggiornamento effettuato, fai click su <B><FONT SIZE=5><A HREF="index.php">AVANTI</A>
			</FONT></B>per continuare.</P>
			<P ALIGN=CENTER><BR><BR>
			</P>
			<?php
		} else 
		{
			echo "Errore, connessione alla base dati non effettuata<br>";
			echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
		}
		
	}
		
	
} else //sessione ok ?
{
	echo "Errore, connessione non effettuata<br>";
	echo "<A HREF='index.php'>Torna al menu principale</A>per continuare.</P>";
}
?>
</BODY>
</HTML>