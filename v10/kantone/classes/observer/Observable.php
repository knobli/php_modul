<?php
abstract class Observable {

    private $observers = array();

    public function addObserver(Observer $o) {
        $this->observers[] = $o;    
    }

    public function notifyObservers($obj) {
        array_walk($this->observers, function ($observer) use ($obj) { $observer->update($obj); });    
    }
}
?>