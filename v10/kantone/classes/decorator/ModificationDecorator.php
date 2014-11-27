<?php
abstract class ModificationDecorator implements Component {
    private $decorated;
	
    public function __construct(Component $decorated) {
        $this->decorated = $decorated;
    }
	
    public function getValue() {
        return $this->decorated->getValue();
    }
}
?>