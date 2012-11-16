<?
/*
 * mini.PHP
 * - Session() class
 *
 * Created by Makis Tracend (@tracend) 
 * Maintained by Make Sites (makesites.org)
 */
class miniSession extends miniBase { 
	private $key;
	
	function __construct( $vars=false, $key=false ){ 
		
		// default variables
		$this->vars = array();
		
		if( $vars ) $this->vars = array_merge( $this->vars, $vars);
		
		$this->start();
		
		// populate with a specific set (or get the whole session)
		$this->key = ( $key ) ? $key : false; 
		
		$session = $this->session();
		if( $session )
			$this->vars = array_merge( $this->vars, $this->session() );
		
	}
	
	private function start() {
		// Check if there's a valid session
		if (strlen(session_id()) < 1) {
			session_start();
		}
		
	}
	
	public function destroy(){
		 session_destroy();
	}
	
	public function exists(){
		return (strlen(session_id()) >= 1);
	}
	
	public function set($key, $val) {
		if( $this->key ) {
			$_SESSION[$this->key][$key] = $val;
		} else {
			$_SESSION[$key] = $val;
		}
		return parent::set($key, $val);
	}
	
	private function session(){
		// return the whole session if no key specified
		$session = ($this->key) ? $_SESSION[$this->key] : $_SESSION;
		return is_array( $session ) ? $session : false;
	}
	
}

?>