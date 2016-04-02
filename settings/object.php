<?php
$SETTINGS_FILE = 'settings.ini'
class Settings extends array {
	private $file;
	
	function __construct($file_path) {
		$this->file = parse_ini_file($file_path)
	}
}

?>