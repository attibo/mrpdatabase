<?php
	/*
		Classe PHP
		QuryPager 1.2.1
		scritta da Michele Malgaretto

		Adattato da Attilio Bongiorni - settembre 2013
		connessione già aperta dal chiamante
	*/

	class queryPager{
		
		var $query; // � la query
		var $numrows; // totale righe nella query
		var $rowforpage; // numero di righe per pagina
		var $currentpage; // � la pagina corrente

		var $rows; // � il risultato della query
		var $numfieldrow;// indica il numero di campi presenti in una ROW
		var $numpage; // indica il numero si pagine che sono necessarie per visualizzare l'output della query numpage=numrows/rowforpage+1
		var $maxnumpage; // indica il numero massimo di pagine VISUALIZZABILI  1 2 3 4 5 > ...  in questo caso maxnumpage � 5
		
		var $from;
		var $to;
		var $conn;
		
		/* il costruttore di questa classe ha come parametri
		
			$pcon l'handle di connessione per poter usare le nuove mysqli		
			$qry la query da paginare
		 	$iTotRowsForPage numero di righe per pagina
		   $mnp il numero massimo di pagine visualizzabili nel path di navigazione		
		   di default il parametro $iTotRowsForPage=10
		   mentre il parametro $mnp � uguale a 5 */
		function queryPager($pcon,$qry,$iTotRowsForPage=null,$mnp=null){
			$this->conn = $pcon;
			$this->rowforpage=$iTotRowsForPage;
			$this->maxnumpage=$mnp;
			if ($iTotRowsForPage==null)
				$this->rowforpage=10;
			if ($mnp==null)
				$this->maxnumpage=5;
			$this->query=$qry;
			
			//connessione già aperta dal chiamante peDbSearch che si incarica anche di chiuderla al termine
    		$result = mysqli_query($this->conn,$qry);
   
			$this->numrows=mysqli_num_rows($result);
			$this->currentpage=1;
			$this->numpage=ceil($this->numrows/$this->rowforpage);
			
		}

		// predispone la tabella con i risultati della pagina passata come parametro
		// input:		$p la pagina
		//				$border lo spessore del bordo della tabella
		//				$cellsp lo spaccing tra le celle
		//				$celpad i padding tra le celle
		//				$htmlcol1 colore #xxxxxx
		//				$htmlcol2 colore #xxxxxx		
		//				$width larghezza
		//			se	$tofile � settato il primo campo dei risultati sar� un link alla
		//				pagina indicata in $tolink con parametro id uguale al primo campo della riga
		// -----Modifica
		function getGridResult($p,$border,$cellsp,$cellpad,$htmlcol1,$htmlcol2,$width,$tolink=null){
			$this->currentpage=$p;
			$limit=" LIMIT ".(($p - 1) * $this->rowforpage ).", ". $this->rowforpage;
			$qry=$this->query.$limit;
			$result=mysqli_query($this->conn,$qry);	
			$this->numfieldrow=mysqli_num_fields($result);
			echo "<table border='".$border."' cellspacing='".$cellsp."' cellpadding='".$cellpad."' width='".$width."'>";
			$j=1;
			while ($row=mysqli_fetch_array($result)){
				if ($j%2==1)
				{
					$colore=$htmlcol1;
				}else
				{
					$colore=$htmlcol2;
				}
				
				echo "<tr bgcolor='".$colore."'>";
				// qui vengono visualizzati i dati riga x riga
				
				
					for ($i=0;$i<=$this->numfieldrow-1;$i++){
						if ($tolink!="" and $i==0)
							echo "<td><a href='".$tolink."?id=$row[$i]'>".$row[$i]."</a></td>";
						else
							echo "<td>";	
							echo "<font FACE='Arial, sans-serif'><FONT SIZE=1 STYLE='font-size: 8pt'color='black";
							echo "'>";
							// memorizza il codice per poi poter fare
							// una ricerca gestire il dettaglio record
							if ($i==0) // codice (n. codice della scheda)
							{
								
								$il_codice = $row[$i]; 
								/* visualizzazione del matitino per la modifica/gestione
								 	il link per la modifica dovrà essere collegato qui
								 	esempio:
				 					echo "<a href='atticom_updoc.php?f=".$documento."'>";
				 					echo "<img border = '0' src='immagini/icodoc2.png'>";
				 					echo "</a>";	
								*/ 
									echo "<td><a href='mrp_dett.php?c=".$il_codice."'>";
									echo "<img src='immagini/matitina.png'> ";
									echo "</a></td>";
							}else 							
							{													
								echo $row[$i];
								echo "</td>";
								echo "</font>";
							}
					}
				
				echo "</tr>";
				
				$j++;
			}
			echo "<tr><td colspan='".$this->numfieldrow."'>";
			echo $this->getPageList($p);
			echo "</td></tr>";
			echo "</table>";
			echo "</font>";
		}	
		
		// questa funzione restituisce l'oggetto result che contiene i risultati della query
		function getResult($p){
			$this->currentpage=$p;
			$limit=" LIMIT ".(($p - 1) * $this->rowforpage ).", ". $this->rowforpage;
			$qry=$this->query.$limit;
			//echo $qry;
			$result=mysqli_query($this->conn,$qry) or die ("Pager error - LIMIT not correct 2");	
			$this->numfieldrow=mysqli_num_fields($result);
			return $result;
		}	
		
		// questa funzione stampa il path di navigazione in base alla currentpage
		// tenendo conto di altri eventuali parametri passati nell'url
		function getPageList($cp){
			$str="";
			$strq="";
			$pos =0;
			$np=ceil($cp/$this->maxnumpage);
			$self = $_SERVER['PHP_SELF'];
			$parametri=$_SERVER['QUERY_STRING'];
			$spar="";
			$lenstr = 0;
			if ($parametri!=""){
				$arr=split("&",$parametri);
				$spar="";
				if (sizeof($arr)>1){
					$newindex=1;
					if (substr($arr[0],0,4)=="page")
						$newindex=2;
					$spar=$arr[$newindex-1];
					for ($i=$newindex;$i<sizeof($arr);$i++)
						$spar=$spar."&".$arr[$i];
				}
				elseif ((sizeof($arr)==1)and(substr($arr[0],0,4)!="page"))
					$spar=$arr[0];
			}
			if($spar!="")
				$spar="&".$spar;
			
			if ($cp<=($this->maxnumpage*$np)){
				$from=(($this->maxnumpage*$np)-$this->maxnumpage)+1;
				if ($np*$this->maxnumpage<=$this->numpage)
					$to=$np*$this->maxnumpage;
				else
					$to=$this->numpage;
			}
			if (($cp!=1) && ($np!=1))
				$str="<a href=\"$self?page=1$spar\"> <<</a> <a href=\"$self?page=".($from-1)."$spar\"> <</a>".$str;
				
			for ($i=$from;$i<=$to;$i++)
				if ($i!=$cp)
					$str=$str." "."<a href=\"$self?page=$i$spar\">".$i."</a>";
				else
					$str=$str." <span id='select'>".$i."</span>";
				
			if ($to<$this->numpage)
				$str=$str." <a href=\"$self?page=".($to+1) ."$spar\"> ></a> <a href=\"$self?page=".$this->numpage."$spar\">>> </a>";

			return $str;
		}
		
		// restituisce true se la query � inizializzata 
		function isInitialize(){
			return ($this->query=="");
		}
		
		// restituisce il valore della stringa $query 
		function getQuery(){
			return $this->query;
		}
		
		// restituisce il numero di righe per pagina 
		function getRowsForPage(){
			return $this->rowforpage;
		}

		// restituisce il totale delle righe della query 
		function getNumRows(){
			return $this->numrows;
		}

		// imposta la current page 
		function setCurrentPage($i){
			$this->currentpage=$i;
		}
		
		// restituisce il valore della current page 
		function getCurrentPage(){
			return 	$this->currentpage;
		}
		
		// restituisce il numero di field della query 
		function getNumFieldsRow(){
			return $this->numfieldrow;
		}

	}
?>






