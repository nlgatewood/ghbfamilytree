<?php

$user       = $CONFIG['user_uname'];
$admin_user = $CONFIG['admin_uname'];
$pw 			= $CONFIG['user_pw'];
$admin_pw 	= $CONFIG['admin_pw'];

/*------------------------------------------------------------
 * get_mysqli_object() -- Get the connect object for the main
 *                        database
 *------------------------------------------------------------*/
function get_mysqli_object() {

	global $user;
	global $pw;
	
	//Get the connection to the database
	$conn = new mysqli('localhost',$user,$pw,'rsgcnovb_gwfamilytree');

	if($conn->connect_error){

   	echo "<p>Connection Failed: ".$conn->connect_error."</p>";
	}

	return $conn;
}

/*------------------------------------------------------------
 * get_mysqli_admin_object() -- Get the connect object for the main
 *                              database
 *------------------------------------------------------------*/
function get_mysqli_admin_object($dbase) {

	global $admin_user;
	global $admin_pw;

	//Get the connection to the database
   $conn = new mysqli('localhost',$admin_user,$admin_pw,$dbase);

	if($conn->connect_error){

		echo "<p>Connection Failed: ".$conn->connect_error."</p>";
	}

	return $conn;
}

?>
