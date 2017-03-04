<?php

	class Config {
	
		var $config_file;
		
		function __construct() {
		
			$this->config_file = parse_ini_file("config.ini");
		}		
		function get_config_file() {
			return $this->config_file;
		}
	}

?>
