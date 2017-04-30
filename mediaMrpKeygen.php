<?php
	//mediaMrpKeyGen($handle) genera un progressivo univoco
	//nella tabella mediabank
	//ritorna il progressivo generato
	//attenzione questo file contiene anche la funcione build_query_media_ins
	
	function mediaMrpKeyGen($handle) 
	{
		$qymediamax = "SELECT MAX(`n_ord`) AS `maxcod` FROM `mediabank`";
		$qrisult=mysqli_query($handle,$qymediamax);	
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
		return $next;		

	}

//build_query_media_ins() genera e ritorna la query string per inserire 
//un record nella tabella mediabank 

	function build_query_media_ins($bq_codice,$bq_progr,$bq_tmpfile) 
	{
		$the_query = "INSERT INTO mediabank (codice, n_ord, file, descrizione) VALUES (".
		"'".$bq_codice  ."',".
		"'".$bq_progr."',".
		"'".basename($bq_tmpfile)."',".
		"'"."file archiviato il ".date('dmY')."')";
		
		return $the_query;	
	}

?>