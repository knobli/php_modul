<?php
$mark = 4;

var_dump($mark);
switch ($mark) {
	case 1 :
	case 2 :
	case 3 :
	case 4 :
		echo "nicht bestanden";
		break;
	case 5 :
	case 6 :
		echo "bestanden";
		break;
	default :
		if (is_float($mark)) {
			echo "keine ganze Note";
		} else {
			echo "Test nicht abgegeben";
		}
		break;
}
?>