<?php
class Inspector implements Observer {
	
	public function update($methodName) {
		echo "Inspector: Method $methodName invoked<br>";
	}

}
?>
