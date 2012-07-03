<?
/*
 * mini.PHP
 * - Base() class
 *
 * Created by Makis Tracend (@tracend) 
 * Published by Make Sites (makesites.org)
 */
class miniBase {
	
	public $vars;
	
	function __construct(){
		
	}
	
	public function get($var) {
		return $this->vars[$var];
	}

	public function set($key, $val) {
		$this->vars[$key] = $val;
		return $this;
	}
	
}

// includes all the files in the same folder that start with "mini." and end with ".php"
$minis = glob( __DIR__ ."/mini.*.php");
foreach ($minis as $filename) {
    include_once("$filename");
}

?>