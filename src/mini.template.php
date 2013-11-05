<?
/*
 * mini.PHP
 * - Template() class
 *
 * Created by Makis Tracend (@tracend)
 * Published by Make Sites (makesites.org)
 */
class miniTemplate extends miniBase {

	private $_files = array();

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

	// insert a file view
	public function load($name=null ){
		if( is_null($name) ) return;
		array_push( $this->_files, $name);
	}

	// insert a static view
	function view( $name=null, $content="" ){
		if( is_null($name) ) return;
		$this->views[$name] = $content;
		// preserve chainability
		return $this;
	}

	// renders the final output
	public function render( $data=array() ){
		// merge data
		$this->data = array_merge( $this->data, $data);
		// process the views
		foreach( $this->_files as $name ){
			$this->views[$name] = $this->fetch( $name );
		}
		// load the layout
		$template = $this->fetch( $this->vars['layout'] );

		return $template;
	}

	// Helpers
	private function fetch( $name ){
		$file = $this->vars['path'] . $name .'.'. $this->vars['ext'];
		// exit now if there is no file
		if( !is_file($file) ) return;
		// extract variables
		if (is_array($this->data))
			extract($this->data);
		// include views
		$views = $this->views;
		ob_start();
		require($file);
		return ob_get_clean();
	}

}

?>