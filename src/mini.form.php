<?
/*
 * mini.PHP
 * - Form() class
 *
 * <MM>Date: 09-Jul-2012  16:27<MM:EndLock>
 *
 * Created by Makis Tracend (@tracend) 
 * Published by Make Sites (makesites.org)
 */
class miniForm extends miniBase { 

	function __construct( $vars=false ){ 
	
		//defaults
		$this->vars = array(
			"method" => "POST"
		);
		
		if( $vars ) $this->vars = array_merge( $this->vars, $vars);
		
	}
	
	public function filter( $options ) {
		// get the method
		$input = $this->method();
		// filter the data
		$data = filter_input_array($input, $options);
		// recursively replace the data in the $options
		return array_replace_recursive($options, $data);
	}
	
	public function method( $type =false){
		// see is we're calling the method directly
		$method = ( $type ) ? $type : $this->vars['method'];
		
		$input;
		
		switch( strtoupper($method) ){
			case "POST":
				$input = INPUT_POST;
			break;
			case "GET":
				$input = INPUT_GET;
			break;
			default: 
				$input = INPUT_POST;
			break;
		}
		
		return $input;
	}
	
}


?>