<?php
/*
Attilio Bongiorni - giugno 2014
attestato.php oggetto chiamato:attestatobj.php
sottoclasse di fpdf.php
gestito il metodo header() per creare lo sfondo della pagina
*/
require_once ('fpdf.php');

class attestatobj extends fpdf 
{ //inizio classe

function attestatobj() 
{
	
}

function Header()
{
	// To be implemented in your own inherited class
	$this->Image("sfondo_mrp.jpg",2,2,295,205);
}

} //fine classe
?>