<?
/*
 * mini.PHP
 * - Mysql() class
 *
 * Created by Makis Tracend (@tracend) 
 * Maintained by Make Sites (makesites.org)
 */
class miniMysql extends miniBase { 
	private $db;
	
	function __construct( $vars=false ){ 
		
		// default variables
		$this->vars = array(
			"host" 		=> "localhost", 
			"database" 	=> "database", 
			"username" 	=> "root", 
			"password" 	=> "root"
		);
		
		if( $vars ) $this->vars = array_merge( $this->vars, $vars);
		
		$this->connect();
	}
	
	private function connect() {
		
		$v = $this->vars;
		
		try {
			$this->db = new PDO('mysql:host='. $v["host"] .';dbname='. $v["database"], $v["username"], $v["password"]);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}
	
	private function disconnect(){
		 mysql_close();
	}
	
	public function insert( $table, $values ){
		
		// get the columns from the $entry
		$keys = array_keys($values);
		$wildcards = array_map(function($v) {return ":".$v;}, $keys );
		
		$columns = implode(", ",  $keys);
		$fields = implode(", ", $wildcards);
		
		$query = "INSERT INTO ". $table ." (". $columns .") VALUES (". $fields .")";
		
		// finally udate the values with the wildcards
		$params = array_combine ($wildcards, $values);
		$result = $this->execute($query, $params);
		
		return $result;
	}
	
	function select( $table="", $values=false ){
		
		$params = array();
		$query = "SELECT * FROM ". $table;
		
		// add conditions (if available)
		if($values){ 
			
			// get the columns from the $entry
			$keys = array_keys($values);
			$wildcards = array_map(function($v) {return ":".$v;}, $keys );
			
			$conditions = "";
			foreach( $values as $k => $v){
				$conditions = "$k=:$k";
			}
			
			$query .= " WHERE ". $conditions;
			
			// finally udate the values with the wildcards
			$params = array_combine ($wildcards, $values);
			
		}
		
		$result = $this->execute($query, $params);
		
		return $result;
	
	}
	
	// generic method to execute any query
	private function execute($query, $params) { 
	
		$result = false; 
		$data = array(); 
		
		$stm = $this->db->prepare($query); 
		if( $stm && $stm->execute($params) ) { 
			$result = $stm->rowCount(); 
			while( $row = $stm->fetch(PDO::FETCH_ASSOC) ) { 
				$data[] = $row;
			} 
		} 
		//$stm->setFetchMode(PDO::FETCH_ASSOC);
		//$data = $stm->fetchAll();
		//$result = count($data);
		
		return ($result) ? $data : $result; 
	} 
	
}


?>