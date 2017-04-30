<?php
/*msgObj.php
Attilio Bongiorni - dicembre 2013 - gennaio 2014
Giugno 2014: introdotto il messaggio generico (i)
oggetto per la gestione dei messaggi di errore.
============ATTENZIONE============================================
Utilizza come icone i files:errorico.png, icona_punto_esclam2.jpg e iconainfo.png
che devono essere presenti nella dir immagini/
==================================================================
uso:
include("msgObj.php");
//definizione di costanti
define("TERROR", 1);
define("TWARN",2);
defint("TINFO",3)
$oggettoM = new msgObj(); //crea l'oggetto
$oggettoM->push_error(TERROR,"Errore! Niente paura &egrave; una prova"); 	//setta un errore
$oggettoM->push_error(TWARN, "Warning, solo per provare");						//setta un warning
$oggettoM->push_action("Azione n. 2", "http://bongat.altervista.org");		//setta una azione (menu)
$oggettoM->push_action("Azione n. 1","www.mrpdatabase.altervista.org");		//setta una azione (menu)
$oggettoM->show();																			//visualizza gli errori
$oggettoM->resetta();																		//resetta l'oggetto
*/
class msgObj
{ //inizio classe
//array

private $aico;					//icona di errore o warning
private $alabel;				//laber errore/warning
private $atipo;				//tipo di errore 0=undefined 1=errore 2=warning
private $aerrwa; 				//array errori/warning da visualizzare
private $aaction;				//array azione proposta (testo)
private $alink;				//array link corrispondente
//array
private $nerror;				//numero di errori 
private $nwarn;				//numero warning
private $nitem;				//totale n. errori + warning

	function __construct() 
	{
		// per default setta num. errori e warning = 0
		$this->nerror			= 0;
		$this->nwarn			= 0;
		$this->nitem			= 0;
	}

	/*
	metodo push_error() registra un errore o warning nell'oggetto
	parametri:
	$typo = errore o warning
	$testo = testo del messaggio
	*/
	function push_error($typo, $testo) 
	{
		$this->atipo[]=$typo;
		if($typo==1) 
		{
			$this->aico[] = "immagini/errorico.png";
			$this->alabel[] = "Errore!";
			$this->nitem=$this->nitem+1;
			$this->nerror=$this->nerror+1;
		} elseif($typo==2) 
		{
			$this->aico[] = "immagini/icona_punto_esclam2.jpg";
			$this->alabel[] = "Attenzione!";
			$this->nitem=$this->nitem+1;
			$this->nerror=$this->nwarn+1;
		} elseif($typo==3) 
		{
			$this->aico[] = "immagini/iconainfo.png";
			$this->alabel[] = "Informazione";
			$this->nitem=$this->nitem+1;
		}
		$this->aerrwa[]=$testo;
		
	}

	/*
	metodo push_action($azione, $link) inserisce una azione che deve essere
	resa disponibile in calce alla visualizzazione dell'errore (es. Ritorna al menu principale)
	*/
	function push_action($azione, $link) 
	{
		$this->aaction[]=$azione;
		$this->alink[]=$link;
	}

	/*
	metodo show() visualizza gli errori
	*/
	function show()
	{ 
	$n = 0;
	$i = 0;
	$nerr = count($this->aerrwa);
	$nmenu = count($this->aaction);
		
		echo "<center>";
		echo "<font size='3' face='Arial, Lucida Grande, Verdana, Arial, Sans-Serif' color='black'>";
			echo "<table>";
				echo "<tr>";
				for ($n=0; $n<=($nerr-1); $n++)
				{
					echo "<tr>";
						echo "<td>";
							echo "<img border='0', src='".$this->aico[$n]."'>";
						echo "</td>";
						echo "<td>";
							echo $this->aerrwa[$n];
						echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
			
			// menu in calce alla pagina


			if($nmenu>0)
			echo "<table>"; 
			echo "<tr>";
			{
				for ($i=0; $i<=($nmenu-1); $i++)
				{
						echo "<td>";	
							if($i>0) { echo "  |  ";} //separatore				
							echo "<a href='";
							echo $this->alink[$i];
							echo "'>"; 
							echo $this->aaction[$i]. "     ";
							echo "</a>";
						echo "</td>";
  				}
  			echo "</tr>";
  			echo "</table>";
			}
			echo "</font>";
		echo "</center>";		
		
	}

	/*
	metodo resetta()
	resetta gli array e le variabili nerror e nwarning
	*/
	function resetta() 
	{
		$this->aico 			= 	array();	//icona di errore o warning
		$this->alabel			=	array();	//laber errore/warning
		$this->atipo			=	array();	//tipo di errore 0=undefined 1=errore 2=warning
		$this->aerrwa	 		=	array();	//array errori/warning da visualizzare
		$this->aaction			= 	array();	//array azione proposta (testo)
		$this->alink			=	array();	//array link corrispondente
		$this->nerror			=		0;		//numero di errori 
		$this->nwarn			=		0; 	//numero warning
		$this->nitem			=		0;		//totale		
	}

} //fine classe
?>