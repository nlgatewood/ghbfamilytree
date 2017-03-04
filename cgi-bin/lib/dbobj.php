<?php

	/*------------------------------------------------------------
	 * get_mysqli_object() -- Get the connect object for the main
	 *                        database
	 *------------------------------------------------------------*/
	function get_mysqli_object() {
	
		//Get the connection to the database
		$conn = new mysqli('localhost','root','cs4bguz$','ghbfamilytree');

		if($conn->connect_error){

   		echo "<p>Connection Failed: ".$conn->connect_error."</p>";
		}

		return $conn;
	}

?>
