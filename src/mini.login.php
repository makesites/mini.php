<?
/*
 * mini.PHP
 * - Login() class
 *
 * Created by Makis Tracend (@tracend) 
 * Published by Make Sites (makesites.org)
 */
class miniLogin extends miniBase { 

	function __construct( $vars=false ){ 
		
		// default variables
		$this->vars = array(
			"user" 		=> "admin",
			"password" 	=> "password"
		);
		
		// start session only if not already started:
		if (strlen(session_id()) < 1) {
			session_start();
		}
		
		if( $vars ) $this->vars = array_merge( $this->vars, $vars);
		
	}
	
	public function valid() {
		return (isset($_SESSION['login'][ $this->vars["user"] ])) ? true : false;
	}
	
	public function check( $creds ) {
		$valid = true;
		foreach( $creds as $k => $v ){ 
			// if any of the credentials doesn't match the stored data, return false
			if( $this->vars[$k] != $v ) $valid = false;
		}
		// store a logged in flag only if valid
		if( $valid ){
			$_SESSION['login'][ $this->vars["user"] ] = true;
		}
		
		return $valid;
	}
	
	public function logout(){
		session_destroy();
	}
}


?>