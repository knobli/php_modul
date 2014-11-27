<?php
/**
 * Template Method Pattern
 */
abstract class Kanton extends Observable {

    private $logger;

    public function __construct() {
        $this->addObserver(new Inspector());    
    }

    public function registerLogger(Logger $logger) {
        $this->logger = $logger;    
    }

    public function query($fieldName, $fieldValue, $one, $sortBy, $order = 'ASC') {
        $this->notifyObservers("query($fieldName, $fieldValue, $one, $sortBy, $order)");

        $vals = $this->getCantons();
        $this->logger->log('Found ' . count($vals) . ' Cantons');

        // filter if criteria is given
        if (!is_null($fieldName) && !is_null($fieldValue)) {
            $this->logger->log('Filter enabled');
            $vals = array_filter($vals,
                function ($elem) use ($fieldName, $fieldValue) {
                    return $elem[$fieldName] == $fieldValue;
                }
            );
        } else {
            $this->logger->log('Filter disabled');
        }

        if (!is_null($sortBy)) {
            $this->logger->log('Sorting enabled');
            $vals = Helper::sort($vals, $sortBy, $order);
        } else {
            $this->logger->log('Sorting disabled');
        }

        $this->logger->log('Fetch mode ' . ($one ? 'single' : 'list'));
        if ($one) {
        	return empty($vals) ? null : $vals[0];
		} else {
			return $vals;
		}
    }

    public abstract function getCantons();

}
