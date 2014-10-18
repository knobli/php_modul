<?php
class TodoEntry {
	
	const OPEN = 0;
	const CLOSED = 1;	

	/**
     * @var int
	 */
    private $id;

	/**
     * @var int
	 */
    private $creator;

	/**
     * @var DateTime 
	 */	
	private $created;
	
	/**
     * @var DateTime 
	 */	
	private $deadline;	
	
	/**
     * @var string
	 */
    private $title;
	
	/**
     * @var int
	 */
    private $status;
	
	/**
     * @var int
	 */
    private $priority;	
	

	public function __construct(){
		$this->id = null;
		$this->created = new DateTime();
		$this->creator = null;
		$this->deadline = null;
		$this->title = "";
		$this->status = self::OPEN;		
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getCreator(){
		return $this->creator;
	}
	
	public function setCreator($creator){
		$this->creator = $creator;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getCreated(){
		return $this->createDate->format("m/d/Y H:i A");
	}
	
	public function getCreatedSql(){
		return $this->created->format("Y-m-d H:i:s");
	}	
	
	public function setCreated($created){
		$this->createDate = $created;
	}		
	
	public function getDeadline(){
		return $this->deadline->format("m/d/Y H:i");
	}
	
	public function getDeadlineSql(){
		return $this->deadline->format("Y-m-d H:i:s");
	}	
	
	public function setDeadline($deadline){
		$this->deadline = $deadline;
	}	
	
	public function deadlineReached(){
		$actualDate = new DateTime();
		if($this->deadline < $actualDate){
			return true;
		}
		return false;
	}
	
	public function getStatus(){
		return $this->status;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function close(){
		$this->status = self::CLOSED;
	}
	
	public function reopen(){
		$this->status = self::OPEN;
	}
	
	public function getPriority(){
		return $this->priority;
	}
	
	public function setPriority($priority){
		$this->priority = $priority;
	}
}
?>