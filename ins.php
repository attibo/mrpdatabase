<?php
/*
ins.php - controlla l'input proveniente dalla form di mrp_ins.php e poi esegue l'insert del record
Attilio Bongiorni - ottobre 2013
*/
session_start();
include_once("mrpRobj.php");
include_once("taberror.php");

include("db_conn_i.php");
include("cleanup_text.php");
include("my_to_dit.php");
include ("writelog.php");
define("GET",0);
define("SET",1);
//la costante che segue è il codice di errore MySql di duplicate key entry
define("DUPKEY",1062);

$nuovoCodice = 0;

// istanzia l'oggetto
$objrecPart = new mrpRobj(0); //per adesso il codice è = 0 poi si genera

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
			$objrecPart->mrpKeyGen($handlecon); //genera codice univoco nuovo
			$la_query= $objrecPart->build_query_insert($handlecon);

			// esegui l'inserimento
			$retry=true;

			while (!mysqli_query($handlecon,$la_query) and $retry)
			{
				if(mysqli_errno($handlecon)==DUPKEY) 
				{
					$objrecPart->mrpKeyGen($handlecon);
					$la_query=$objrecPart->build_query_insert($handlecon);


				} else //non è un duplicate key ma qualcosaltro
				{
					echo "Errore! Operazione di inserimento non riuscita ".mysqli_errno($handlecon); 
					$retry=false;
					$esito=false;
				}				
			} //endwhile

			if($retry) 
			{
				$wnome=$objrecPart->nome(GET,"");
				$wcognome=$objrecPart->cognome(GET,"");
				$wcodice=$objrecPart->codice(GET,"");
				$stringa="Inserito record: ".$wnome. " - ". $wcognome." - cod. ".$wcodice." utente: ".$_SESSION['who'];
				writelog("mrpdblog.txt", $stringa);
				?>
				<BODY LANG="en-US" DIR="LTR">
				<P ALIGN=CENTER><FONT COLOR="#000080"><FONT SIZE=6 STYLE="font-size: 28pt">Museo Della
				Resistenza Piacentina - Sperongia (PC)</FONT></FONT></P>
				<HR>
				<P ALIGN=CENTER><IMG SRC="immagini/mrp266.jpg" NAME="Immagine1" ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>
				<P ALIGN=CENTER>Inserimento effettuato, fai click su <B><FONT SIZE=5><A HREF="index.php">AVANTI</A>
				</FONT></B>per continuare.</P>
				<P ALIGN=CENTER><BR><BR>
				</P>
				<?php
				
			 } else 
			 {
				?>
				<BODY LANG="en-US" DIR="LTR">
				<P ALIGN=CENTER><FONT COLOR="#000080"><FONT SIZE=6 STYLE="font-size: 28pt">Museo Della
				Resistenza Piacentina - Sperongia (PC)</FONT></FONT></P>
				<HR>
				<P ALIGN=CENTER><IMG SRC="immagini/errorico.png" NAME="Immagine1" ALIGN=BOTTOM WIDTH=168 HEIGHT=229 BORDER=0></P>
				<P ALIGN=CENTER>Aggiornamento NON effettuato, fai click su <B><FONT SIZE=5><A HREF="index.php">AVANTI</A>
				</FONT></B>per continuare.</P>
				<P ALIGN=CENTER><BR><BR>
				</P>
				<?php
			 }
				
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