<?php
$datas = array(
	array('id' => 5, 'parent' => 0, 'name' => 'rekursionen sind schon was tolles'),
    array('id' => 6, 'parent' => 5, 'name' => 'super sache'),
    array('id' => 7, 'parent' => 5, 'name' => 'sehr elegant'),
    array('id' => 10, 'parent' => 7, 'name' => 'test'),
    array('id' => 8, 'parent' => 5, 'name' => 'aber auch rechenintensiv'),
    array('id' => 9, 'parent' => 8, 'name' => 'blalbla'),
    array('id' => 1, 'parent' => 0, 'name' => 'was denkt ihr von der vorlesung?'),
    array('id' => 2, 'parent' => 1, 'name' => 'naja..'),
    array('id' => 3, 'parent' => 1, 'name' => 'ist ja seine erste'),
    array('id' => 4, 'parent' => 1, 'name' => 'also ich finds super'),
    );

function getDataWithParent($datas, $parentId){
	foreach($datas as $array){
		if($array['parent'] === $parentId){
			echo "<ul>";
			echo "<li>" . $array['name'] . "</li>";
			getDataWithParent($datas, $array['id']);
			echo "</ul>";
		}
	}
}

getDataWithParent($datas, 0);
?>