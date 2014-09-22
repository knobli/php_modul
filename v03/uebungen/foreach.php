<?php $capitals=array("Schweiz" => "Bern", "Frankreich" => "Paris", "Deutschland" => "Berlin"); 
$capitals["Italien"] = "Rom";
$capitals["Spanien"] = "Madrid"; 
?>
<table>
	<thead>
		<th>Land</th>
		<th>Hauptstadt</th>
	</thead>
	<tbody>
<?php
foreach($capitals as $country => $capital){
	echo "<tr><td>$country</td><td>$capital</td></tr>";
}
?>
</tbody></table>