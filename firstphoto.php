<?php
/*
firstphoto($handlecon, $cod) - Attilio Bongiorni - Giugno 2014

Questa funziona fa una query ed individua la prima foto disponibile associata alla scheda
del partigiano individuata dal parametro cod passato dal chiamante e ritorna il nome del file
Se non ci sono foto o non c'è il file ritorna false.
Connessione fatta dal chiamante ($handlecon è l'handle di connessione)

*/
function firstphoto($handleCon, $cod) 
{
	include_once("extfile.php");
	$pathf = "media/";
	$primafoto = $pathf;
	
	$queryDett= "SELECT file FROM mediabank WHERE codice=".$cod;

	$qrisult = mysqli_query($handleCon, $queryDett);
				
		if (mysqli_num_rows($qrisult) == 0)
		{  // query dettaglio no
			$primafoto = $primafoto."no-picture.png";
		} else // query dettaglio ok
		{
			if($row=mysqli_fetch_array($qrisult))
			{
				$primafoto = $primafoto.$row[0];
				$estensione = extfile($primafoto);
				if($estensione == "jpg" or $estensione == "png") 
				{
					if(!file_exists($primafoto)) 
					{
						$primafoto = $pathf."no-picture.png";
					}
				} else 
				{
					$primafoto = $pathf."no-picture.png";
				}	
			} else 
			{
				$primafoto = $primafoto."no-picture.png";
			}
							
		} // query dettaglio (fine)	
	
		return $primafoto;
}
?>