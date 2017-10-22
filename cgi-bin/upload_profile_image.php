<?php
require('lib/ft_funcs.php');

$mid 			 = isset($_POST["mid"]) ? $_POST["mid"] : '';
$opt  		 = isset($_POST["opt"]) ? $_POST["opt"] : '';
$profile_ind = isset($_POST["profile_ind"]) ? $_POST["profile_ind"] : '';
$caption  	 = isset($_POST["caption"]) ? $_POST["caption"] : '';
$date 		 = date_create();
$conn = get_mysqli_admin_object('ghbfamilytree');

include('header.php');

$target_dir = "/home/nlgatewood/public_html/images/family_profile/";
$new_filename = "PIMG".$mid."_".date_timestamp_get($date).".jpg";
$target_file = $target_dir.$new_filename;

echo "<p>";

//Upload the file
if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

	if($profile_ind){
		$p_stmt = $conn->prepare("UPDATE ft_member_images SET profile_ind = NULL WHERE member_id = ?");
		$p_stmt->bind_param("i", $mid);
		$p_stmt->execute();
	}

	//Update the image table
	$sql = "INSERT INTO ft_member_images VALUES(NULL,?,'./images/family_profile/',?,?,?)";

	if($stmt = $conn->prepare($sql)){

	   $stmt->bind_param("issi", $mid,$new_filename,$caption,$profile_ind);
	   $stmt->execute();
	}

	echo "The Image '".basename($_FILES["fileToUpload"]["name"])."' has been uploaded as '".$target_file."'.";
}
else{
	echo "Error: The Image '".basename($_FILES["fileToUpload"]["name"])."' was not uploaded";
}

echo "</p>";

back_button();

$conn->close();

include('footer.php');
?>
