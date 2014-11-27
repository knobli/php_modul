<?php
class MailLogger implements Logger {
    public function log($message) {
        echo "send mail with message: $message<br>";
    }   
}
?>