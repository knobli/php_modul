<?php
class EchoLogger implements Logger {
    public function log($message) {
        echo "Logger: $message<br>";
    }   
}
?>