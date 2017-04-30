<?php
/*
Attilio Bongiorni - giugno 2014
attestatobj.php
sottoclasse di fpdf.php
Questo oggetto eredita tutti i metodi da fpdf l'unica cosa modificata è il metodo header() per creare lo sfondo della pagina

*/
require_once ('fpdf.php');

class attestatobj extends fpdf 
{ //inizio classe

function Header()
{
	// To be implemented in your own inherited class
	// manipolare le coordinate che seguono per cambiare posizione dello sfondo sulla pagina
	// aumentare o diminuire i margini bianchi
	
	$this->Image("sfondo_mrp.jpg",2,2,295,205);
}


} //fine classe
?>