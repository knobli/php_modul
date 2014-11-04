<?php
class BlogEntry {	
	const UPLOAD_DIR = "Posts/";
	const FILE_PREFIX = "blogEntry-";

	const USERNAME = "username: "; 
	const TITLE = "title: ";
	const CONTENT = "content: ";
	const DATE = "date: ";

	/**
     * @var string
	 */
    private $username;

	/**
     * @var DateTime 
	 */	
	private $createDate;
	
	/**
     * @var string
	 */
    private $title;
	
	/**
     * @var string
	 */
    private $content;
	
	/**
     * @var string
	 */
    private $filename;

	public function __construct(){
		$this->username = "";
		$this->createDate = new DateTime();
		$this->title = "";
		$this->content = "";	
	}

	/**
	 * @param string $filename
	 * @return BlogEntry
	 */		
	public static function createFromFile($filename){
		$filecontent = file(BlogEntry::UPLOAD_DIR . $filename);
		$blogEntry = BlogEntry::createFromArray($filecontent);
		$blogEntry->setFilename($filename);
		return $blogEntry;		
	}

	/**
	 * @param array $filecontent
	 * @return BlogEntry
	 */	
	public static function createFromArray($filecontent){
		$instance = new BlogEntry();
		$instance->loadFromArray($filecontent);
		return $instance;
	}
	
	/**
	 * @param array $filecontent
	 */
	private function loadFromArray($filecontent){
		$this->username = trim(substr($filecontent[0], strlen(BlogEntry::USERNAME)));
		$this->title = trim(substr($filecontent[1], strlen(BlogEntry::TITLE)));
		$this->content = trim(substr($filecontent[2], strlen(BlogEntry::CONTENT)));
		$date = trim(substr($filecontent[3], strlen(BlogEntry::DATE)));
		$createDate= new DateTime();
		$createDate->setTimestamp(intval($date));
		$this->createDate = $createDate;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function setUsername($username){
		$this->username = $username;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getContent(){
		return str_replace(array("\\n", "\\r\\n"), array("\n", "\r\n"), $this->content);
	}
	
	public function getContentForHTML(){
		return str_replace(array("\\n", "\\r\\n"), "<br>", $this->content);
	}
	
	public function getContentForSaving(){
		return $this->content;
	}	
	
	public function setContent($content){
		$this->content = str_replace(array("\n", "\r\n"), array("\\n", "\\r\\n"), $content);
	}
	
	public function getCreateDate(){
		return $this->createDate->format("d.m.Y H:i");
	}
	
	public function getTimestamp(){
		return $this->createDate->getTimestamp();
	}
	
	public function getOutputForSaving(){
		$blogEntryText = BlogEntry::USERNAME . $this->getUsername() . PHP_EOL;
		$blogEntryText .= BlogEntry::TITLE . $this->getTitle(). PHP_EOL;
		$blogEntryText .= BlogEntry::CONTENT . $this->getContentForSaving() . PHP_EOL;
		$blogEntryText .= BlogEntry::DATE . $this->getTimestamp() . PHP_EOL;		
		return $blogEntryText;
	}
	
	public function getFilename(){
		return $this->filename;
	}
	
	public function setFilename($filename){
		$this->filename = $filename;
	}
}
?>