<?php
//RowDataGateway 
class Post {

	private $attrs = array();
	private $attrValues = array();
	
	private $id = false;
	private $version = false;
	
	private $model = 'tbl_person';
	
	
	public function __construct($attrs=false,$model=false,$fields=false){
		global $db;
		if( $model ) $this->model = $model;
		
		if($fields === false ){
			$this->attrs = array('created','title','content');
		} else {
			$this->attrs = $fields;
		}
		
		foreach( $this->attrs as $key ) {
			$this->attrValues[$key] = '';
		}
		if(isset($this->attrValues['created']) && $this->attrValues['created'] === ''){
			$actualDate = new DateTime();
			$this->attrValues['created'] = $actualDate->format("Y-m-d H:i:s");
		} 
		
		if( $attrs !== false ) {
			if( $attrs === true ) $attrs = array();
			$this->create($attrs);
		}
	}
	
	public function create($attrs){
		$this->update($attrs,false);
	}
	
	public function update($attrs,$id=true){
		if( $id === true ){
			 $id = $this->id;
		}
		foreach( $attrs as $key => $attr ){
			$this->attrValues[$key] = $attr;
		}
		$this->save($this->id);
	}
	
	private function save($id=false){
		global $db;
		$executeVals = $this->attrValues;
		
		$newVersion = microtime(true);
		
		if( $id === false ) {
			$executeVals['_version'] = $newVersion;
			$this->version = $newVersion;
			
			$keys = $this->attrs;
			$keys_t = implode(',',$keys);
			$vals = array_values($this->attrs);
			$vals_t = implode(',:',$vals);
	
			$sql = 'INSERT INTO '.$this->model.' ('.$keys_t.',_version)
			VALUES (:'.$vals_t.',:_version);';
			echo 'Sql statment: ' . $sql.'<br/>';
			$stmt = $db->prepare($sql);
			
		} else {
			$executeVals['_newVersion'] = $newVersion;
			$executeVals['_version'] = $this->version;
			$this->version = $newVersion;
			
			$variables = array();
			foreach ( $this->attrs as $key ) {
				$variables[] = $key . ' = :'.$key;
			}
			
			$variables[] = '_version=:_newVersion';
			
			$sql = 'UPDATE '.$this->model.' SET '.implode(',',$variables).' WHERE id=:id AND _version=:_version;';
			echo 'Sql statment: ' . $sql.'<br/>';
			$stmt = $db->prepare($sql);
			$executeVals['id'] = $this->id;
			
		}
		echo 'Execute values:<br/>';
		print_r($executeVals);
		echo '<br/>';
		$stmt->execute( $executeVals );
		
		if( $id === false ){
			$this->id = $db->lastInsertId('id');
		} else if ($stmt->rowCount() === 0){
			throw new Exception("Invalid Version number found, count not update!");
		}
	}
	
	
	public function delete(){
		global $db;
		
		$executeVals = array( 'id' =>  $this->id );
		
		$sql = 'DELETE FROM '.$this->model.' WHERE id= :id';
		
		echo 'Sql statment: ' . $sql.'<br/>';
		echo "Excecute values: <br/>";
		print_r($executeVals);
		echo '<br/>';		
		
		$stmt = $db->prepare($sql);
		$stmt->execute( $executeVals );		
		
		foreach( $this->attrs as $key => $attr ){
			unset($this->attrValues[$key]);
		}
	}
	
	
	
	public function findByID( $id ){
		global $db;
		$executeVals = array( 'id' =>  $id ) ;
		$sql = 'SELECT * FROM '.$this->model.' WHERE id= :id';
		
		echo 'Sql statment: ' . $sql.'<br/>';
		echo "Excecute values: <br/>";
		print_r($executeVals);
		echo '<br/>';
		
		$stmt = $db->prepare($sql);
		$stmt->execute( $executeVals );
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		foreach( $this->attrs as $attr ){
			$this->attrValues[$attr] = $data[0][$attr];
		}
		$this->id = $data[0]['id'];
		$this->version = $data[0]['_version'];
	}
	
	
	public function getID(){
		return $this->id;
	}
	
	public function getCreated(){
		return $this->getAttr('created');
	}
	
	public function getTitle(){
		return $this->getAttr('title');
	}
	
	public function getContent(){
		return $this->getAttr('content');
	}
	
	private function getAttr($attr){
		global $db;
		$attr_sql = SQLite3::escapeString($attr);
		$executeVals = array(  'id' =>  $this->id ) ;
		$sql = 'SELECT '.$attr_sql.' FROM '.$this->model.' WHERE id= :id';
		
		echo 'Sql statment: ' . $sql.'<br/>';
		echo "Excecute values: <br/>";
		print_r($executeVals);
		echo '<br/>';		
		
		$stmt = $db->prepare($sql);
		$stmt->execute( $executeVals );

		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $data[0][$attr];
	}
		
}
?>