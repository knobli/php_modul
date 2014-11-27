<?php
class LowercaseModification extends ModificationDecorator {
	
    public function __construct(Component $component) {
        parent::__construct($component);    
    }

    public function getValue() {
        return strtolower(parent::getValue());
    }
}
?>