<?php
require_once('classes/decorator/Component.php');
require_once('classes/decorator/ModificationDecorator.php');
require_once('classes/decorator/GermanToEnglishModification.php');
require_once('classes/decorator/LowercaseModification.php');
require_once('classes/decorator/Word.php');

echo "<h1>Decorator Test</h1>";

echo "<h3>Simple word</h3>";
$simpleWord = new Word("Simple word");
echo $simpleWord->getValue(). "<br>";

echo "<h3>GermanToEnglishModification</h3>";
$translateWord = new GermanToEnglishModification(new Word("Kanton"));
echo $translateWord->getValue() . "<br>";

echo "<h3>LowercaseModification</h3>";
$lowerCase = new LowercaseModification(new Word("LOWER CASE"));
echo $lowerCase->getValue() . "<br>";

echo "<h3>LowercaseModification and GermanToEnglishModification</h3>";
$translateLowerCase = new LowercaseModification(new GermanToEnglishModification(new Word("Gemeinden 6")));
echo $translateLowerCase->getValue() . "<br>";
?>