<?php
class HttpResponse implements Response {
	public function setStatus($status) {
		return http_response_code($status);
	}

	public function addHeader($name, $value) {
		header($name . ': ' . $value);
	}

	public function write($data) {
		echo $data;
	}

	public function flush() {
		die();
	}

}
?>