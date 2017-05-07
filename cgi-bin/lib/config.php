<?php

	/*------------------------------------------------------------------
	 * Config - CLASS - Encapsulates the config file; allowing you to 
	 *						  retrieve them
	 *------------------------------------------------------------------*/
	class Config {
	
		var $config_file = array();
		
		/*-------------------------------------------------
		 * CONSTRUCTOR - Opens the config file and stores it 
		 *					  in the array
		 *-------------------------------------------------*/
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

      /*-------------------------------------------------
       * get_config_file() - Return the config file array
       *-------------------------------------------------*/
		function get_config_file() {

			return $this->config_file;
		}
	}

?>
