<?php

$wight = 19;

$category1Max=20;
$category1Name="S";
$category2Max=40;
$category2Name="M";
$category3Max=60;
$category3Name="L";
$category4Max="unendlich";
$category4Name="XL";

$finalCategory=null;
$finalCategoryName=null;

if($wight <= $category1Max){
	$finalCategory=$category1Max;
	$finalCategoryName=$category1Name;
} else if($wight <= $category2Max){
	$finalCategory=$category2Max;
	$finalCategoryName=$category2Name;
} else if($wight <= $category3Max){
	$finalCategory=$category3Max;
	$finalCategoryName=$category3Name;
} else {
	$finalCategory=$category4Max;
	$finalCategoryName=$category4Name;
}

?>
Das Gep&auml;ckst&uuml;ck wiegt <?=$wight?> kg. Es geh&ouml;rt zur Kategorie <?=$finalCategoryName?> (bis <?=$finalCategory?> kg).<br /><br />

Kategorien: 0-<?=$category1Max?>,<?=$category1Max?>-<?=$category2Max?>,<?=$category2Max?>-<?=$category3Max?>,mehr als <?=$category3Max?> kg
