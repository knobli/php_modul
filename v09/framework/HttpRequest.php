<?php
class HttpRequest implements Request {
	public function getParameterNames() {
		$arr = array();
		foreach ($_REQUEST as $key => $value) {
			$arr[] = $key;
		}
		return $arr;
	}

	public function issetParameter($name) {
		return isSet($_REQUEST[$name]);
	}

	public function getParameter($name) {
		return $_REQUEST[$name];
	}

	public function getHeader($name) {
		$headers = apache_request_headers();
		if (isSet($headers[$name])) {
			return $headers[$name];
		} else {
			return null;
		}
	}

}
?>