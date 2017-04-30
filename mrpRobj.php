<?php
/*
mrpRobj.php
Attilio Bongiorni - agosto 2012
Oggetto per la gestione dei record di scheda partigiano per il museo della Resistenza Piacentina
parametro del costruttore: solo il codice
utilizza:
atti_connect_only.php
config.php
usa:
dit_to_time.php
manyfunk.php

METODI:
- i metodi con i nomi dei campi definiscono/ricavano il valore per quel campo
- retrieve() si connette al database, ricerca il record mediante codice_up (ad oggetto già istanziato) e mette i valori 
	recuperati nell'oggetto
- check() verifica il record controllando:
	= che nome e cognome siano compilati
	= che le date nascita/morte siano congruenti
- iserrordata() controlla se ci sono errori di dati (incongruenze)
- nerrordata() restituisce il numero di errori di dati
- errordata(Ne) restituisce la spiegazione dell'errore Ne

*/
class mrpRobj
{ //inizio classe

private $codice_up;
private $nome_up;
private $cognome_up;
private $paternit_up;
private $data_nasc_up;
private $data_nasc_ts; // time stamp
private $luogonasci_up;
private $formazione_up;
private $qualifica_up;
private $grado_up;
private $inizio_arruol_up;
private $inizio_arruol_ts; //time stamp
private $fine_arruol_up;
private $fine_arruol_ts; //time stamp
private $nazionalit_up;
private $caduto_up;
private $luogomorte_up;
private $datamorte_up;
private $datamorte_ts; // time stamp
private $evento_up;
private $associato_up;
private $comitatopr_up;
private $commission_up;
private $ferito_up;
private $mutilato_up;
private $note_up;
private $pubblica_up;
private $nome_batt_up;
private $tipologia_up;
//-------------------
private $aerr;
private $iserror;
private $aerrdata;
private $iserrordata;
private $nerrordata;
private $debugvar;

	function __construct($codestart) 
	{
		include_once("dit_to_time.php");
		include_once("manyfunk.php");
		include_once("my_to_dit.php");

		$this->codice_up 			= $codestart;
		$this->nome_up				= "";
		$this->cognome_up			= "";
		$this->paternit_up		= "";
		$this->data_nasc_up		= date("00-00-000");
		$this->luogonasci_up		= "";
		$this->formazione_up		= "";
		$this->qualifica_up		= "";
		$this->grado_up			= "";
		$this->inizio_arruol_up	= "";
		$this->nazionalit_up		= "";
		$this->caduto_up			= "no";
		$this->luogomorte_up		= "";
		$this->datamorte_up		= date("00-00-000");
		$this->evento_up			= "";
		$this->associato_up		= "no";
		$this->comitatopr_up		= "no";
		$this->commission_up		= "no";
		$this->ferito_up			= "no";
		$this->mutilato_up		= "no";
		$this->note_up				= "";
		$this->pubblica_up		= "no";
		$this->nome_batt_up		= "";
		$this->tipologia_up		= 0;
		$this->iserror				= false;
		$this->iserrordata		= false;
		$this->nerrordata 		= 0;
		$this->debugvar			= "";
	}// fine costruttore
		
	// definisce/ottiene il codice	
	function codice($mode, $cod)
	{
		if ($mode==1)
		{
			$this->codice_up = $cod;
			$rco = $cod;
		} elseif($mode==0) 
		{
			$rco = $this->codice_up;
		}
		return $rco;
	} // fine metodo  codice()	
	
		
	// definisce/ottiene il nome	
	function nome($mode, $vno)
	{
		if ($mode==1)
		{
			$this->nome_up = $vno;
			$rno = $vno;
		} elseif($mode==0) 
		{
			$rno = $this->nome_up;
		}
		return $rno;
	} // fine metodo  nome()

	//definisce/ottiene il cognome
	function cognome($mode, $vco)
	{
		
		if($mode==1) 
		{
			$this->cognome_up = $vco;
			$rco = $vco;
		} elseif($mode==0) 
		{
			$rco = $this->cognome_up;
		}
		return $rco;
	} // fine metodo cognome()
	
	//definisce/ottiene la paternità
	function paternit($mode, $vpa) 
	{
		if($mode==1) 
		{
			$this->paternit_up = $vpa;
			$rpa = $vpa;
		} elseif($mode==0) 
		{
			$rpa = $this->paternit_up;
		}
		return $rpa;
		
	}// fine metodo paternita()
	
	//definisce/ottiene 	la data di nascita
	function data_nasc($mode, $vdn) 
	{
		if($mode==1) 
		{
			$this->data_nasc_up = $vdn;
			$rdn = $vdn;
			$nozero = nozero_my_date($vdn);
			//adesso $nozero è una data mysql senza zeri e col trattino
			$this->data_nasc_ts = strtotime($nozero." 00:00");
		} elseif($mode==0) 
		{
			$rdn = $this->data_nasc_up;
		}
		return $rdn;
	} //fine metodo datanasc
	
	// ottiene la data_nasc in timestamp
	function data_nasc_ts() 
	{
		return $this->data_nasc_ts;
	}
	
	//definisce/ottiene il luogo nascita
	function luogonasci($mode, $vlu) 
	{
		if($mode==1) 
		{
			$this->luogonasci_up = $vlu;
			$rlu = $vlu;
		} elseif($mode==0) 
		{
			$rlu = $this->luogonasci_up;
		}
		return $rlu;
	}//fime metodo luogonasci
	
	//definisce/ottiene la formazione
	function formazione($mode, $vfo) 
	{
			if($mode==1) 
			{
				$this->formazione_up = $vfo;
				$rfo = $vfo;
			} elseif($mode==0) 
			{
				$rfo = $this->formazione_up;
			}
			return $rfo;
	}//fine metodo formazione()
	
	//definisce/ottiene la qualifica
	function qualifica($mode, $vqu) 
	{
		if($mode==1) 
		{
			$this->qualifica_up = $vqu;
			$rqu = $vqu;
		}elseif($mode==0) 
		{
			$rqu = $this->qualifica_up;
		}
		return $rqu;
	}//fine metodo qualifica
	
	//definisce/ottiene il grado
	function grado($mode, $vgr) 
	{
		if($mode==1) 
		{
			$this->grado_up = $vgr;
			$rgr = $vgr;
		}elseif($mode==0) 
		{
			$rgr = $this->grado_up;
		}
		return $rgr;
	}//fine metodo grado
	
	//definisce/ottiene inizio_arruol
	function inizio_arruol($mode, $via)
	{
		if($mode==1) 
		{
			$this->inizio_arruol_up = $via;
			$ria = $via;
			$nozero = nozero_my_date($via);
			//adesso $nozero è una data mysql senza zeri e col trattino
			$this->inizio_arruol_ts = strtotime($nozero." 00:00");

		}elseif($mode==0) 
		{
			$ria = $this->inizio_arruol_up;
		}
		return $ria;
	}//fine metodo inizio_arruol

	// ottiene inizio_arruol in timestamp
	function inizio_arruol_ts() 
	{
		return $this->inizio_arruol_ts;
	}

	//definisce/ottiene fine_arruol
	function fine_arruol($mode, $vfa)
	{
		if($mode==1) 
		{
			$this->fine_arruol_up = $vfa;
			$rfa = $vfa;
			$nozero = nozero_my_date($vfa);
			$this->fine_arruol_ts = strtotime($nozero." 00:00");
		}elseif($mode==0) 
		{
			$rfa = $this->fine_arruol_up;
		}
		return $rfa;
	}//fine metodo fine_arruol

	// ottiene fine_arruol in timestamp
	function fine_arruol_ts() 
	{
		return $this->fine_arruol_ts;
	}
	
	//definisce/ottiene nazionalit
	function nazionalit($mode, $vna)
	{
		if($mode==1) 
		{
			$this->nazionalit_up = $vna;
			$rna = $vna;
		}elseif($mode==0) 
		{
			$rna = $this->nazionalit_up;
		}
		return $rna;
	}//fine metodo nazionalit

	//definisce/ottiene caduto
	function caduto($mode, $vca)
	{
		if($mode==1) 
		{
			$this->caduto_up = $vca;
			$rca = $vca;
		}elseif($mode==0) 
		{
			$rca = $this->caduto_up;
		}
		return $rca;
	}//fine metodo nazionalit
	
	//definisce/ottiene luogomorte
	function luogomorte($mode, $vlm)
	{
		if($mode==1) 
		{
			$this->luogomorte_up = $vlm;
			$rlm = $vlm;
		}elseif($mode==0) 
		{
			$rlm = $this->luogomorte_up;
		}
		return $rlm;
	}//fine metodo luogomorte
	
		//definisce/ottiene data_morte
	function data_morte($mode, $vdm)
	{
		if($mode==1) 
		{
			$this->datamorte_up = $vdm;
			$rdm = $vdm;
			$nozero = nozero_my_date($vdm);
			$this->datamorte_ts = strtotime($nozero." 00:00");
		}elseif($mode==0) 
		{
			$rdm = $this->datamorte_up;
		}
		return $rdm;
	}//fine metodo data_morte

	// ottiene la data_morte in timestamp
	function data_morte_ts() 
	{
		return $this->datamorte_ts;
	}
	
		//definisce/ottiene evento
	function evento($mode, $vev)
	{
		if($mode==1) 
		{
			$this->evento_up = $vev;
			$rev = $vev;
		}elseif($mode==0) 
		{
			$rev = $this->evento_up;
		}
		return $rev;
	}//fine metodo evento	
	
		//definisce/ottiene associato
	function associato($mode, $vas)
	{
		if($mode==1) 
		{
			$this->associato_up = $vas;
			$ras = $vas;
		}elseif($mode==0) 
		{
			$ras = $this->associato_up;
		}
		return $ras;
	}//fine metodo associato

	//definisce/ottiene comitatopr
	function comitatopr($mode, $vco)
	{
		if($mode==1) 
		{
			$this->comitatopr_up = $vco;
			$rco = $vco;
		}elseif($mode==0) 
		{
			$rco = $this->comitatopr_up;
		}
		return $rco;
	}//fine metodo comitatopr

	//definisce/ottiene commission
	function commission($mode, $vcmm)
	{
		if($mode==1) 
		{
			$this->commission_up = $vcmm;
			$rcmm = $vcmm;
		}elseif($mode==0) 
		{
			$rcmm = $this->commission_up;
		}
		return $rcmm;
	}//fine metodo commission

	//definisce/ottiene ferito
	function ferito($mode, $vfe)
	{
		if($mode==1) 
		{
			$this->ferito_up = $vfe;
			$rfe = $vfe;
		}elseif($mode==0) 
		{
			$rfe = $this->ferito_up;
		}
		return $rfe;
	}//fine metodo ferito

	//definisce/ottiene mutilato
	function mutilato($mode, $vmu)
	{
		if($mode==1) 
		{
			$this->mutilato_up = $vmu;
			$rmu = $vmu;
		}elseif($mode==0) 
		{
			$rmu = $this->mutilato_up;
		}
		return $rmu;
	}//fine metodo mutilato

	//definisce/ottiene note
	function note($mode, $vnot)
	{
		if($mode==1) 
		{
			$this->note_up = $vnot;
			$rnot = $vnot;
		}elseif($mode==0) 
		{
			$rnot = $this->note_up;
		}
		return $rnot;
	}//fine metodo note

	//definisce/ottiene pubblica
	function pubblica($mode, $vpub)
	{
		if($mode==1) 
		{
			$this->pubblica_up = $vpub;
			$rpub = $vpub;
		}elseif($mode==0) 
		{
			$rpub = $this->pubblica_up;
		}
		return $rpub;
	}//fine metodo pubblica

	//definisce/ottiene nome_batt
	function nome_batt($mode, $vnba)
	{
		if($mode==1) 
		{
			$this->nome_batt_up = $vnba;
			$rnba = $vnba;
		}elseif($mode==0) 
		{
			$rnba = $this->nome_batt_up;
		}
		return $rnba;
	}//fine metodo nome_batt

	//definisce/ottiene tipologia
	function tipologia($mode, $vtip)
	{
		if($mode==1) 
		{
			$this->tipologia_up = $vtip;
			$rtip = $vtip;
		}elseif($mode==0) 
		{
			$rtip = $this->tipologia_up;
		}
		return $rtip;
	}//fine metodo tipologia

	// metodo retrieve()
	//ricerca il record mediante codice_up (ad oggetto già istanziato) e mette i valori 
	//recuperati nell'oggetto
	// versione di ottobre 2013 - aggiunto come parametro l'handle di connessione (fatta dal chiamante)
	function retrieve($handle) 
	{
			$la_query="SELECT * FROM partigiani WHERE codice = ".$this->codice_up;
			$result = mysqli_query($handle,$la_query); 
			$trovati = mysqli_num_rows($result);
			if ($trovati==1) // deve trovarne uno solo!
			{
				$row = mysqli_fetch_array($result);
				$this->nome_up 				= $row['nome'];
				$this->cognome_up 			= $row['cognome'];
				$this->paternit_up			= $row['paternit'];
				$this->data_nasc_up			= $row['data_nasc'];
				$this->luogonasci_up			= $row['luogonasci'];
				$this->formazione_up			= $row['formazione'];
				$this->qualifica_up			= $row['qualifica'];
				$this->grado_up				= $row['grado'];
				$this->inizio_arruol_up		= $row['inizio_arruol'];
				$this->fine_arruol_up		= $row['fine_arruol'];
				$this->nazionalit_up			= $row['nazionalit'];
				$this->caduto_up				= $row['caduto'];
				$this->luogomorte_up			= $row['luogomorte'];
				$this->datamorte_up			= $row['data_morte'];
				$this->evento_up				= $row['evento'];
				$this->associato_up			= $row['associato'];
				$this->comitatopr_up			= $row['comitatopr'];
				$this->commission_up			= $row['commission'];
				$this->ferito_up				= $row['ferito'];
				$this->mutilato_up			= $row['mutilato'];
				$this->note_up					= $row['note'];
				$this->pubblica_up			= $row['pubblica'];
				$this->nome_batt_up			= $row['nome_batt'];
				$this->tipologia_up			= $row['tipologia'];			
			} elseif($trovati>1) 
			{
				$this->aerr[] = "Errore! Esistono record con codice doppio";
				$this->iserror = true;
			}elseif($trovati<1)
			{
				$this->aerr[] = "Errore! Codice scheda non piu' esistente";
				$this->iserror = true;
			}

		mysqli_free_result($result);


	}//fine metodo retrieve

	//check() controlla che i dati del record siano congruenti
	function check() 
	{
		if (isset($this->nome_up) and isset($this->cognome_up))
		{
			if($this->nome_up== "" or $this->cognome_up == "") 
			{
				$this->aerrdata[] = "Errore! Nome e cognome non devono essere in bianco";
				$this->iserrordata = true;
				$this->nerrordata++;
			}
			
		}else 
		{
			$this->iserrordata = true;
			$this->aerrdata[] = "Errore! I campi nome e cognome devono essere definiti";
			$this->nerrordata++;		
		}
		
		if (isset($this->data_nasc_up))
		{
				if(isset($this->datamorte_up)) 
				{
					if ($this->data_nasc_ts() > $this->data_morte_ts())
					{
						$this->iserrordata = true;
						$this->aerrdata[] = "Errore dati! Data di morte anteriore alla data nascita";
						$this->nerrordata++;
					}					
				}
				if(isset($this->inizio_arruol_up)) 
				{
					if($this->data_nasc_ts() > $this->inizio_arruol_ts()) 
					{
						$this->iserrordata = true;
						$this->aerrdata[] = "Errore dati! Data di nascita posteriore all'arruolamento";
						$this->nerrordata++;
					}	
					if($this->inizio_arruol_ts()>$this->fine_arruol_ts()) 
					{
						$this->iserrordata = true;
						$this->aerrdata[] = "Errore dati! Data inizio arruolamento / fine non congruenti";
						$this->nerrordata++;
					}
				}			
					
		}else
		{
			$this->aerrdata[] = "Errore! Il campo data di nascita deve essere definito";		
			$this->iserrordata = true;
			$this->nerrordata++;
		}
		
	}
	
	// metodo nerrordata() restituisce il numero di errori di incongruenza
	function nerrordata() 
	{
		return count($this->nerrordata);
	}
	
	//metodo iserrordata() restituisce true se c'è un errore di congruenza
	function iserrordata() 
	{
		return $this->iserrordata;
	}
	
	//metodo errordata(nerrore) restituisce l'errore n° nerrore
	// dopo mettere la gestione degli errori con count() !!!!!!!!!!!!!!!!
	function errordata($nerrore) 
	{
		return $this->aerrdata[$nerrore];
	}
	
	//metodo iserror() restituisce true se c'è un errore 
	function iserror() 
	{
		return $this->iserror;
	}
	
	//metodo nerror() restituisce l'errore n°
	function nerror($nerrore)
	{
		return $this->aerr[$nerrore];
	}

	//metodo debugvar() restituisce la variabile di debug
	//può servire per operazioni di debug anche fuori dall'oggetto
	function debugvar() 
	{
		return $this->debugvar;
	}

	//metodo mrpKeyGen($handle) genera un codice univoco
	//e lo mette nella var pubblica dell'oggetto (codice)
	//ritorna il codice generato
	
	function mrpKeyGen($handle) 
	{
		$qymax = "SELECT MAX(`codice`) AS `maxcod` FROM `partigiani`";
		$qrisult=mysqli_query($handle,$qymax);	
		if (mysqli_num_rows($qrisult) > 0)
		{
			$rnext = mysqli_fetch_row($qrisult);
			$next = $rnext[0];
			$next++;
			
		}	else 
		{
			$next = 1;
		}
	
		mysqli_free_result($qrisult);
		$this->codice_up = $next;
		return $next;		

	}
/*
metodo build_query_insert($link) - genera e restituisce la stringa di query insert
con i valori correnti dell'oggetto
da usare solo quando i valori sono validati
il parametro $link è l'handle di connessione passato dal chiamante (serve per mysqli_real_escape_string)
il controllo per la mysql injection viene fatto qui per non modificare i valori presenti nell'oggetto
della classe mrpRobj
la connessione è lasciata aperta dal chiamante
*/
	function build_query_insert($link) 
	{
			$the_query= "INSERT INTO partigiani (".
			"codice ,".
			"nome,".
			"cognome,".
			"paternit,".
			"data_nasc,".
			"luogonasci,".
			"formazione,".
			"qualifica,".
			"grado,".
			"inizio_arruol,".
			"fine_arruol,".
			"nazionalit,".
			"caduto,".
			"luogomorte,".
			"data_morte,".
			"evento,".
			"associato,".
			"comitatopr,".
			"commission,".
			"ferito,".
			"mutilato,".
			"note,".
			"pubblica,".
			"nome_batt,".
			"tipologia".
			")".
			" VALUES ('".$this->codice(GET,"")."',".
			"'".mysqli_real_escape_string($link,$this->nome(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->cognome(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->paternit(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->data_nasc(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->luogonasci(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->formazione(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->qualifica(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->grado(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->inizio_arruol(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->fine_arruol(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->nazionalit(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->caduto(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->luogomorte(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->data_morte(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->evento(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->associato(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->comitatopr(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->commission(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->ferito(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->mutilato(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->note(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->pubblica(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->nome_batt(GET,""))."',".
			"'".mysqli_real_escape_string($link,$this->tipologia(GET,""))."'".
			")";
			
			return $the_query;			
	}


} // fine classe



?>