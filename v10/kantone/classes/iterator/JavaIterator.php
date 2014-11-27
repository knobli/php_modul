<?php
class JavaIterator implements YAIterator {
    private $vals;
    private $idx = 0;
    
    public function __construct(array $vals) {
        $this->vals = $vals;
    }

    public function hasNext() {
        return $this->idx < count($this->vals);    
    }

    public function next() {
        return $this->vals[$this->idx++];    
    }
}
?>