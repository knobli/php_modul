<?php
abstract class View {
    private $_ = array();
	
	private $header = "<!DOCTYPE html><html><head><title>____TITLE____ - Blog</title><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" /><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'><script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script></head><body>";
	private $footer = "</body></html>";
	
	public function __construct($title){
		$this->header = preg_replace("/____TITLE____ /", $title, $this->header);
	}
	
    public function assign($name, $value) {
        $this->_[$name] = $value;   
    }
	
	public function get($name){
		return $this->_[$name];
	}
	
    public function render(Request $request, Response $response) {
        $response->write($this->header);
		$response->write($this->renderSub($request, $response));
		$response->write($this->footer);
    }
	
	abstract function renderSub(Request $request, Response $response);
	
}