<?php
class LoggerComposite implements Logger {

    private $loggers = array();

    public function addLogger(Logger $logger) {
        $this->loggers[] = $logger;
    }

    public function log($message) {
        foreach ($this->loggers as $logger) {
            $logger->log($message);
        }
    }
}
?>