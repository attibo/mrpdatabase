<html>
<head><title>Pagina di test - obj msg</title></head>
<body>
<?php
/*pagina di prova dell'oggetto msgObj
Autore: Attilio Bongiorni
a.bon6iorni@gmail.com
*/
?>
<center> <font color='#ff8c00' size="5"><strong>Test classe msgObj</strong><br></font>
<font size="2" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="black">
Pagina di prova dell'oggetto msgObj.php - dicembre 2013
</font></center>
<hr align="center" noshade="" width="90%">
<center>
Questa &egrave; una pagina di Test per la programmazione.
</center>
<p>Test dell'oggetto msgObj 

<?php
include("msgObj.php");
define("TERROR", 1);
define("TWARN",2);
define("TINFO",3);
$oggettoM = new msgObj();
$oggettoM->push_error(TERROR,"Errore! Niente paura &egrave; una prova");
$oggettoM->push_error(TWARN, "Warning, solo per provare");
$oggettoM->push_error(TINFO, "Messaggio generico");
$oggettoM->push_action("Azione n. 2", "http://bongat.altervista.org");
$oggettoM->push_action("Azione n. 1","www.mrpdatabase.altervista.org");
$oggettoM->show();
$oggettoM->resetta();
$oggettoM->push_error(TERROR,"Errore! Dopo il reset");
$oggettoM->push_action("Azione n. 1", "http://bongat.altervista.org");
$oggettoM->show();
?>

<hr align="center" noshade="" width="80%">
<font size="1" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="black">
<blockquote>
<center><h7>Pagina scritta in Html e <a href="http://www.php.net/">PHP</a> da
<A HREF="mailto:a.bon6iorni@gmail.com">Attilio Bongiorni</a><br>
Classe PHP iciObj </h7></font></center>
</blockquote>
</body>
</html>
