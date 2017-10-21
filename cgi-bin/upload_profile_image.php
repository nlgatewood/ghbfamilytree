<?php
require('lib/ft_funcs.php');

$mid 	= isset($_POST["mid"]) ? $_POST["mid"] : '';
$opt  = isset($_POST["opt"]) ? $_POST["opt"] : '';
$conn = get_mysqli_admin_object('ghbfamilytree');

include('header.php');

$target_dir = "/home/nlgatewood/public_html/images/family_profile/";
$new_filename = "PIMG".$mid."_";

//Search for images that already exist for the family member
$files = scandir($target_dir, 1);

foreach($files as $file){

	//If one is found, increment the number and create the file name
	if(preg_match('/^PIMG'.$mid.'_(\d).jpg$/', $file, $matches, PREG_OFFSET_CAPTURE)){

		$new_filename .= ++$matches[1][0].'.jpg';
		break;
	}
}

//If one was not found, the file is a '1'
if(!preg_match('/\.jpg$/', $new_filename)){

	$new_filename .= '1.jpg';
}

//Upload the file
$target_file = $target_dir.$new_filename;

echo "<p>";

if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

	//Update the image table
	$sql = "INSERT INTO ft_member_images(NULL,?,'./images/family_profile/',?,NULL,NULL)";

	if($stmt = $conn->prepare($sql)){

	   //$stmt->bind_param("is", $mid,$new_filename);
	   //$stmt->execute();
	}

	echo "The Image '". basename( $_FILES["fileToUpload"]["name"]). "' has been uploaded as '".$target_file."'.";
}
else{
	echo "Error: Image was not uploaded";
}

echo "</p>";

back_button();

$conn->close();

include('footer.php');
?>
