<?php
function cleanup_text($value, $allowed_tags, $my)
/* La stringa, passata come parametro viene ripulita dai tag html e le virgolette vengono convertite
nella corretta sintassi html.
Se My==1 fa anche il controllo sulla mySqlInjection
*/

{
	$value = strip_tags($value, $allowed_tags);
	$value = stripslashes($value);
	$value = htmlspecialchars($value);
	$value = str_replace("%", "", $value);
	
	if($my==1) 
		{
				$connessione = mysql_connect("localhost", "username", "password") or
				die("Connessione sql fallita ! ");

				if ($connessione == False )
				{
					$value = "";
				} else
				{
						$value = mysql_real_escape_string($value);
						mysql_close();
				}				
				
		} 
			
	return $value;
}
?>