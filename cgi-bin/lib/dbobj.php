<?php

	$user = $CONFIG['user_uname'];
	$pw 	= $CONFIG['user_pw'];

	/*------------------------------------------------------------
	 * get_mysqli_object() -- Get the connect object for the main
	 *                        database
	 *------------------------------------------------------------*/
	function get_mysqli_object() {

		global $user;
		global $pw;
	
		//Get the connection to the database
		$conn = new mysqli('localhost',$user,$pw,'ghbfamilytree');

		if($conn->connect_error){

   		echo "<p>Connection Failed: ".$conn->connect_error."</p>";
		}

		return $conn;
	}

?>
