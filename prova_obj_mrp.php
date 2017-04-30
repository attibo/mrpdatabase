<html>
<head><title>Test mrpRobj</title></head>
<body>
<?php
/*pagina di prova dell'oggetto mrpRobj.php
Autore: Attilio Bongiorni
a.bon6iorni@gmail.com
*/
include ("mrpRobj.php");
define("GET",0);
define("SET",1);
?>
<center> <font color='#ff8c00' size="5"><strong>Test classe mrpRobj</strong><br></font>
<font size="2" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="black">
Museo della Resistenza Piacentina<br>
rel. 2.0 - agosto 2012
</font></center>
<hr align="center" noshade="" width="90%">
<center>
Questa &egrave; una pagina di Test per la programmazione.
</center>
<p>Test dell'oggetto mrpRobj 

<?php
// inserire qui codice scheda da testare
// -------------------------------------------------
$code = 6022;//è il Ballonaio
//--------------------------------------------------

$oggettoMrp = new mrpRobj($code);
/*esempio di utilizzo metodo 
$numero_immobili = $oggettoIci->nimm();
echo "  - Numero immobili dell'oggetto = ".$oggettoIci->nimm();
echo "<br>";

*/
$oggettoMrp->nome(SET, "Gino");
$testNome = $oggettoMrp->nome(GET,"");
echo "Nome: ";
echo $testNome;
echo "<br />";

$oggettoMrp->cognome(SET, "Bongiorni");
$testCognome = $oggettoMrp->cognome(GET, "");
echo "Cognome: ";
echo $testCognome;
echo "<br />";

$oggettoMrp->paternit(SET, "Attilio");
$testPaternit = $oggettoMrp->paternit(GET, "");
echo "Paternit: ";
echo $testPaternit;
echo "<br />";

$oggettoMrp->data_nasc(SET, "1919-10-07");
$testDatanasc = $oggettoMrp->data_nasc(GET, "");
echo "Data nascita: ";
echo $testDatanasc;
echo "<br />";

echo "Timestamp della data di nascita: ";
echo $oggettoMrp->data_nasc_ts();
echo "<br />";

$oggettoMrp->luogonasci(SET, "Nibbiano");
$testLuogonasc = $oggettoMrp->luogonasci(GET, "");
echo "Luogo nascita: ";
echo $testLuogonasc;
echo "<br />";

$oggettoMrp->formazione(SET, "Giustizia e Liberta");
$testFormaz = $oggettoMrp->formazione(GET, "");
echo "Formazione: ";
echo $testFormaz;
echo "<br />";

$oggettoMrp->qualifica(SET, "partigiano");
$testQualif = $oggettoMrp->qualifica(GET, "");
echo "Qualifica: ";
echo $testQualif;
echo "<br />";

$oggettoMrp->grado(SET, "semplice");
$testGrado = $oggettoMrp->grado(GET, "");
echo "Grado: ";
echo $testGrado;
echo "<br />";

$oggettoMrp->inizio_arruol(SET, "1943-09-08");
$testIniarr = $oggettoMrp->inizio_arruol(GET, "");
echo "Inizio arruolamento: ";
echo $testIniarr;
echo "<br />";

echo "Timestamp della data di inizio arruolamento: ";
echo $oggettoMrp->inizio_arruol_ts();
echo "<br />";

$oggettoMrp->fine_arruol(SET, "1945-04-25");
$testFinearr = $oggettoMrp->fine_arruol(GET, "");
echo "Fine arruolamento: ";
echo $testFinearr;
echo "<br />";

echo "Timestamp della data di fine arruolamento: ";
echo $oggettoMrp->fine_arruol_ts();
echo "<br />";

$oggettoMrp->nazionalit(SET, "Italia");
$testNazion = $oggettoMrp->nazionalit(GET, "");
echo "Nazionalita: ";
echo $testNazion;
echo "<br />";

$oggettoMrp->caduto(SET, "no");
$testCaduto = $oggettoMrp->caduto(GET, "");
echo "Caduto: ";
echo $testCaduto;
echo "<br />";

$oggettoMrp->luogomorte(SET, "niente");
$testLuogomor = $oggettoMrp->luogomorte(GET, "");
echo "Luogo morte: ";
echo $testLuogomor;
echo "<br />";

$oggettoMrp->data_morte(SET, "2001-05-03");
$testDatamor = $oggettoMrp->data_morte (GET, "");
echo "Data morte: ";
echo $testDatamor;
echo "<br />";

echo "Timestamp della data di morte: ";
echo $oggettoMrp->data_morte_ts();
echo "<br />";

$oggettoMrp->evento(SET, "test evento");
$testEvento = $oggettoMrp->evento(GET, "");
echo "Evento: ";
echo $testEvento;
echo "<br />";

$oggettoMrp->associato(SET, "si");
$testAssoc = $oggettoMrp->associato(GET, "");
echo "Associato: ";
echo $testAssoc;
echo "<br />";

$oggettoMrp->comitatopr(SET, "si");
$testComit = $oggettoMrp->comitatopr(GET, "");
echo "Comitatopr: ";
echo $testComit;
echo "<br />";

$oggettoMrp->commission(SET, "si");
$testCommiss = $oggettoMrp->commission(GET, "");
echo "Commissione: ";
echo $testCommiss;
echo "<br />";

$oggettoMrp->ferito(SET, "si");
$testFerit = $oggettoMrp->ferito(GET, "");
echo "Ferito: ";
echo $testFerit;
echo "<br />";

$oggettoMrp->mutilato(SET, "no");
$testMutil = $oggettoMrp->mutilato(GET, "");
echo "Mutilato: ";
echo $testMutil;
echo "<br />";

$oggettoMrp->note(SET, "prova ad inserire testo in note");
$testNote = $oggettoMrp->note(GET, "");
echo "Note: ";
echo $testNote;
echo "<br />";

$oggettoMrp->pubblica(SET, "no");
$testPubbl = $oggettoMrp->pubblica(GET, "");
echo "Pubblica: ";
echo $testPubbl;
echo "<br />";

$oggettoMrp->nome_batt(SET, "Luse");
$testNomebatt = $oggettoMrp->nome_batt(GET, "");
echo "Nome battaglia: ";
echo $testNomebatt;
echo "<br />";

$oggettoMrp->tipologia(SET, "test evento");
$testTipo = $oggettoMrp->tipologia(GET, "");
echo "Tipologia: ";
echo $testTipo;
echo "<br />";

$oggettoMrp->retrieve();
echo "Test del medoto retrieve<br />";
echo "==============================<br />";
echo $oggettoMrp->nome(GET, "");
echo $oggettoMrp->cognome(GET, "");
echo "<br>";
echo "test del metodo check()<br />";
//inserimento data incongruente(1)
$oggettoMrp->data_nasc(SET, "2012-01-01");
echo "<br />";
echo "Nuova data di nascita incongruente (test) : ";
echo $oggettoMrp->data_nasc(GET, "");
echo "<br />";
echo "Time stamp della data di nascita incongruente";
echo $oggettoMrp->data_nasc_ts();
echo "<br />";
echo "Data di morte che viene confrontata: ";
echo $oggettoMrp->data_morte(GET, "");
echo "<br />";
echo "Timestamp della data di morte: ";
echo $oggettoMrp->data_morte_ts();
$oggettoMrp->check();
if($oggettoMrp->iserrordata())
 {
 	echo "<br />";
 	echo "Ci sono errori di congruenza nei dati";
 	echo "<br />";
 }
 echo "Numero errori di congruenza: ";
 echo $oggettoMrp->nerrordata();
 echo "<br />";
 echo $oggettoMrp->errordata(0);

//inserimento di nome e cognome in bianco
$oggettoMrp->nome(SET, "");
$oggettoMrp->cognome(SET, "");
$oggettoMrp->check();
echo "<br />";
echo "Prova congruita' nome e cognome";
echo "<br />";
echo "Numero errori di congruita' : ";
echo $oggettoMrp->nerrordata();
echo "<br />";
for($i=0; $i<=$oggettoMrp->nerrordata(); $i++) 
{
	echo $oggettoMrp->errordata($i);
	echo "<br /> ";
}

//prova creazione di un nuovo oggetto vuoto
echo "<br />";
$nuovooggetto = new mrpRobj(0);
$nuovooggetto->check();
echo "Prova congruita' nuovo oggetto in bianco";
echo "<br />";
echo "Numero errori di congruita' : ";
echo $nuovooggetto->nerrordata();
echo "<br />";
for($i=0; $i<=($nuovooggetto->nerrordata()-1); $i++) 
{
	echo $nuovooggetto->errordata($i);
	echo "<br /> ";
}

?>


</font>


<hr align="center" noshade="" width="80%">
<font size="1" face="Arial, Lucida Grande, Verdana, Arial, Sans-Serif" color="black">
<blockquote>
<center><h7>Pagina scritta in Html e <a href="http://www.php.net/">PHP</a> da
<A HREF="mailto:a.bon6iorni@gmail.com">Attilio Bongiorni</a><br>
Classe mrpRobj </h7></font></center>
</blockquote>
</body>
</html>
