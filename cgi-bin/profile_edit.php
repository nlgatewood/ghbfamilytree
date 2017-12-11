<?php
	require('lib/ft_funcs.php');
	require('lib/date_funcs.php');

	//Get POST and GET variables
	$pg        	 = isset($_GET["pg"]) ? $_GET["pg"] : '';
	$mid       	 = isset($_POST["mid"]) ? $_POST["mid"] : '';
	$opt		  	 = isset($_POST["opt"]) ? $_POST["opt"] : '';
	$info_save   = isset($_POST["info_save"]) ? $_POST["info_save"] : '';
	$submit_name = ($opt != null) ? $opt."_save" : "submit";
	$ghb_conn  	 = get_mysqli_admin_object('ghbfamilytree');
	$members_array;

	//If the info edit form was submitted
	if($info_save != null){
		
		$field_names = array("first_name", "middle_name", "last_name", "maiden_name", "suffix",
									"nicknames", "gender", "birth_year", "birth_month", "birth_day",
									"birth_loc", "death_year", "death_month", "death_day", "death_loc", "burial_loc");
									
		$first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : '';
		$middle_name = isset($_POST["middle_name"]) ? $_POST["middle_name"] : '';
		$last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : '';
      $maiden_name = isset($_POST["maiden_name"]) ? $_POST["maiden_name"] : '';
      $suffix = isset($_POST["suffix"]) ? $_POST["suffix"] : '';
      $nicknames = isset($_POST["nicknames"]) ? $_POST["nicknames"] : '';
      $gender = isset($_POST["gender"]) ? $_POST["gender"] : '';
      $birth_year = isset($_POST["birth_year"]) ? $_POST["birth_year"] : '';
      $birth_month = isset($_POST["birth_month"]) ? $_POST["birth_month"] : '';
      $birth_day = isset($_POST["birth_day"]) ? $_POST["birth_day"] : '';
      $birth_loc = isset($_POST["birth_loc"]) ? $_POST["birth_loc"] : '';
      $death_year = isset($_POST["death_year"]) ? $_POST["death_year"] : '';
      $death_month = isset($_POST["death_month"]) ? $_POST["death_month"] : '';
      $death_day = isset($_POST["death_day"]) ? $_POST["death_day"] : '';
      $death_loc = isset($_POST["death_loc"]) ? $_POST["death_loc"] : '';
      $burial_loc = isset($_POST["burial_loc"]) ? $_POST["burial_loc"] : '';
      $update_cnt = 0;
		
		//Create the SQL Statement
		$sql = "UPDATE ft_members SET ";
		
		foreach($field_names as $fld){
			
			$update_cnt++;
			$sql .= "$fld = ?";
			$sql .= ($update_cnt < count($field_names)) ? "," : " ";
		}
		
		$sql .= "WHERE id = ?";
		
		//Update the table
		if($stmt = $ghb_conn->prepare($sql)){
			
			$stmt->bind_param("ssssssssssssssssi", $first_name,$middle_name,$last_name,$maiden_name,$suffix,$nicknames,$gender,
                           $birth_year,$birth_month,$birth_day,$birth_loc,$death_year,$death_month,$death_day,
                           $death_loc,$burial_loc,$mid); 
			$stmt->execute();
		}
	}

   include('header.php');

	if($opt == "pic"){

   	echo "<FORM method='post' name='profile_edit_form' id='profile_edit_form' action='/?pg=upload_profile_image' enctype='multipart/form-data'>";
	}
	else{
   	echo "<FORM method='post' name='profile_edit_form' id='profile_edit_form' action='/?pg=$pg'>";
	}

   echo "<input type='hidden' name='mid' value='$mid'>
         <input type='hidden' name='opt' value='$opt'>";
	
	// If no member is selected, show the list so they can activate
	if($mid == null){
		
		$members_array = get_member_data();

		echo "<h1>Please select a Family Member</h1>
					<SELECT name='mid'>
					<OPTION value=''></OPTION>";
					
		foreach ($members_array as $id => $marray) {
			
			$member_birth = format_date($members_array[$id]['birth_year'],$members_array[$id]['birth_month'],$members_array[$id]['birth_day'],'MM/DD/YYYY');
		
			echo "<OPTION value='".$id."'>$id: ".$members_array[$id]['first_name']." ".
															 $members_array[$id]['middle_name']." ".
															 $members_array[$id]['last_name']." ".
														  "(Born: $member_birth)</OPTION>";
		}
		
		echo "</SELECT>";
	}
	//Else, edit the active member
	else{
		$members_array = get_member_data($mid);
		$member_birth = format_date($members_array['birth_year'],$members_array['birth_month'],$members_array['birth_day'],'MM/DD/YYYY');
		
		echo "<h3>$mid: ".$members_array['first_name']." ".
							  $members_array['middle_name']." ".
						     $members_array['last_name']." ".
							  "(Born: $member_birth)</h3>";
		
		if($opt == null){
			
			echo "<TABLE border=1 align=center style='text-align:left;'>
						<TR>
							<TD><INPUT type='radio' name='opt' value='pic'> Edit Profile Pictures</TD>
						</TR>
						<TR>
							<TD><INPUT type='radio' name='opt' value='info'> Edit Profile Information</TD>
						</TR>
					</TABLE>";
		}
		else if($opt == "pic"){

			echo "<TABLE border=1 align=center>
					<TR>
					 <TD><input type='file' name='fileToUpload' id='fileToUpload'></TD>
					</TR>
					<TR>
					 <TD align=left>Make Profile Picture? <input type='checkbox' name='profile_ind' value='1'></TD>
					</TR>
					<TR>
					 <TD align=left>Image Caption: <input type='text' name='caption' size='50'></TD>
					</TABLE>";
		}
		else if($opt == "info"){
			
   		echo "<FORM method='post' name='profile_edit_form' id='profile_edit_form' action='/?pg=$pg'>";
			echo "<TABLE align='center'><TR><TD>";
			echo "<TABLE style='text-align:left;'>
						<TR><HR><TH colspan=3>Name(FML)</TH></TR>
						<TR>
							<TD colspan=3>
						
								<TABLE>
								<TR>
									<TD colspan=3><INPUT type='text' name='first_name' value='".$members_array['first_name']."'>
													  <INPUT type='text' name='middle_name' value='".$members_array['middle_name']."'>
													  <INPUT type='text' name='last_name' value='".$members_array['last_name']."'></TD>
								</TR>
								<TR>
									<TD align=right>Maiden: <INPUT type='text' name='maiden_name' value='".$members_array['maiden_name']."'></TD>
								</TR>
								<TR>
									<TD align=right>Suffix: <INPUT type='text' name='suffix' value='".$members_array['suffix']."'></TD>
								</TR>
								<TR>
									<TD align=right>Nicknames: <INPUT type='text' name='nicknames' value='".$members_array['nicknames']."'></TD>
								</TR>
								<TR>
									<TD><INPUT type='radio' name='gender' value='M' ".(($members_array['gender'] == 'M') ? "checked='checked'" : "").">Male 
										 <INPUT type='radio' name='gender' value='F' ".(($members_array['gender'] == 'F') ? "checked='checked'" : "").">Female</TD>
								</TR>
								</TABLE>
								
							</TD>
						</TR>
						<TR><TH colspan=3><BR><HR>Birth Date (MM/DD/YYYY)</TH></TR>
						<TR>
							<TD colspan=3>

								<TABLE width=100%>
								<TR>
									<TD>
										<INPUT type='text' name='birth_month' value='".$members_array['birth_month']."' size=2 maxlength=2>
										<INPUT type='text' name='birth_day' value='".$members_array['birth_day']."' size=2 maxlength=2>
										<INPUT type='text' name='birth_year' value='".$members_array['birth_year']."' size=4 maxlength=4>
									</TD>
									<TD>Birth Location<BR>
										 <INPUT type='text' name='birth_loc' value='".$members_array['birth_loc']."' style='width:100%;'>
									</TD>
								</TR>
								</TABLE>
								
							</TD>
						</TR>
						<TR><TH colspan=3><BR><HR>Death Date (MM/DD/YYYY)</TH></TR>
						<TR>
							<TD colspan=3>
							
								<TABLE width=100%>
								<TR>
									<TD>
										<INPUT type='text' name='death_month' value='".$members_array['death_month']."' size=2 maxlength=2>
										<INPUT type='text' name='death_day' value='".$members_array['death_day']."' size=2 maxlength=2>
										<INPUT type='text' name='death_year' value='".$members_array['death_year']."' size=4 maxlength=4>
									</TD>
									<TD>Death Location<BR>
										<INPUT type='text' name='death_loc' value='".$members_array['death_loc']."' style='width:100%;'>
									</TD>
								<TR>
									<TD></TD>
									<TD>Burial Location<BR>
										 <INPUT type='text' name='burial_loc' value='".$members_array['burial_loc']."' style='width:100%;'>
									</TD>
								</TR>
								</TABLE>
								
							</TD>
						</TR>
					</TABLE>";
					
				echo "</TD></TR></TABLE>";
				
				echo "<h3>Biography:<h3>
						<textarea rows=10 cols=100>".$members_array['bio']."</textarea> ";
		}
	}
	
	echo "<BR><BR><input type='submit' name='$submit_name' value='Submit'> ";

	echo "</FORM>";
	
	include('footer.php');
	
   $ghb_conn->close(); //Close Connection
?>
