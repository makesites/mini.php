<?
/*
 * mini.PHP
 * - Template() class
 *
 * Created by Makis Tracend (@tracend)
 * Published by Make Sites (makesites.org)
 */
class miniTemplate extends miniBase {

	function __construct( $vars=false ){

		// default variables
		$this->vars = array(
			"path" => $_SERVER['DOCUMENT_ROOT'] . '/templates/',
			"layout" => "layout",
			"ext" => "php"
		);
		// containers
		$this->views = array();
		$this->data = array();

		if( $vars ) $this->vars = array_merge( $this->vars, $vars);

	}

	public function render(){

		// get the view first
		$this->views["body"] = $this->fetch( $this->vars['view'] );

		// load the layout
		$template = $this->fetch( $this->vars['layout'] );

		//var_dump($template);

		return $template;
	}

	// Helpers

	private function fetch( $name, $data=array() ){
		$file = $this->vars['path'] . $name .'.'. $this->vars['ext'];
		// exit now if there is no file
		if( !is_file($file) ) return;
		// extract variables
		$this->data = array_merge( $this->data, $data);
		if (is_array($this->data))
			extract($this->data);
		ob_start();
		require($file);
		return ob_get_clean();
	}

}

?>