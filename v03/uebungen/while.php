<ul>
	<li>bei 1 beginnen zu zaehlen</li>
	<li>die Zahl mit sich selber addieren, bis 100 erreicht ist</li>
</ul>
<?php
$i=1;
while($i < 100){
	echo $i . "<br />";
	$i += $i;
}
?>