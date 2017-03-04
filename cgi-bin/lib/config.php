<?php

	class Config {
	
		var $config_file = array();
		
		function __construct() {
		
			$tmp_config = parse_ini_file("config.ini", true);
			$heading;

			//If I'm at home, grab the config information 
			if(gethostname() == "nate-Minthome"){

				$heading = "nate-Minthome";
			}
			//else, use the other stuff
			else{
				$heading = "userdata";
			}

			//Copy the data
			foreach ($tmp_config[$heading] as $element => $value){

				$this->config_file[$element] = $value;
			}
		}		

		function get_config_file() {

			return $this->config_file;
		}
	}
?>
