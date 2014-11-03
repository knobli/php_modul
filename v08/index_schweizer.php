<?php
	include( 'class/lebewesen.php');
	include( 'class/mensch.php');
	include( 'class/schweizer.php');
	
$mensch = new Mensch("Test Mensch", "männlich");

echo "Name von Mensch: " . $mensch->getName() . "<br>";

$mensch->umbennen("Tester Mensch");

echo "Alter von Mensch: " . $mensch->getAlter() . "<br>";

if($mensch instanceof Mensch){
	echo $mensch->getName() . " stammt von einem Menschen ab" . "<br>";
} else {
	echo $mensch->getName() . " stammt NICHT von einem Menschen ab" . "<br>";
}

echo "Vorfahre von Mensch: " . $mensch->getVorfahre() . "<br>";

$mensch->neueEvolutionstheorie("=Alien=");

echo "Neue Vorfahre von Mensch: " . $mensch->getVorfahre() . "<br>";

$schweizer = new Schweizer("Testin Schweizer", "weiblich");

$schweizer->umbennen("Testerin Schweizer");




?>