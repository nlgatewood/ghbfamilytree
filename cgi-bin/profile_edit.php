<?php
	require('lib/ft_funcs.php');
	require('lib/date_funcs.php');

	//Get POST and GET variables
	$pg        = isset($_GET["pg"]) ? $_GET["pg"] : '';
	$mid       = isset($_POST["mid"]) ? $_POST["mid"] : '';
	$opt		  = isset($_POST["opt"]) ? $_POST["opt"] : '';
	$submit	  = isset($_POST["submit"]) ? $_POST["submit"] : '';
	$ghb_conn  = get_mysqli_admin_object('ghbfamilytree');
	$info_conn = get_mysqli_admin_object('information_schema');
	$members_array;
	
	include('header.php');
	
	echo "<FORM method='post' name='profile_edit_form' id='profile_edit_form' action='/?pg=$pg'>";
	
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
		
		echo "<input type='hidden' name='mid' value='$mid'>
				<input type='hidden' name='opt' value='$opt'>";
		
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
			
		}
		else if($opt == "info"){
			
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
									<TD>Buried Location<BR>
										 <INPUT type='text' name='buried_loc' value='".$members_array['buried_loc']."' style='width:100%;'>
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
	
	echo "<BR><BR><input type='submit' name='submit' value='Submit'><BR>
			</FORM>";
	
	include('footer.php');
	
	/*
	//-----------------------------------------------------

   //Get the field list to create the fields we want to populate
   //-----------------------------------------------------------

   //Get the members list
   $ft_members_sql = "SELECT column_name,column_comment FROM COLUMNS WHERE table_name IN ('ft_members') AND column_comment != ''";
   if (!$result = $info_conn->query($ft_members_sql)) {

      echo "Query: ".$sql."\nError: ".$info_conn->errno."--".$info_conn->error;
   }

   while ($data = $result->fetch_assoc()) {

      $members_field_array[$data['column_name']] = $data['column_comment'];
   }

   //Get the relationship list
   $ft_relation_sql = "SELECT column_name,column_comment FROM COLUMNS WHERE table_name IN ('ft_members_relations') AND column_comment != ''";
   if (!$result = $info_conn->query($ft_relation_sql)) {

      echo "Query: ".$sql."\nError: ".$info_conn ->errno."--".$info_conn->error;
   }

   while ($data = $result->fetch_assoc()) {

      $relation_field_array[$data['column_name']] = $data['column_comment'];
   }

	//Begin HTML
	include('header.php');

   //If the age has been submitted, save the data entered
   //----------------------------------------------------
   if($submit == 'Submit'){

      $array_to_use = [];

      foreach(["ft_members","ft_members_relations"] as $table){

         $var_string = 'NULL';
         $select_to_use;
         $quit_flag = 0;

         if($table == 'ft_members'){

            $array_to_use = $members_field_array;
            $select_to_use = 'member_select';
         }
         else{
            $array_to_use = $relation_field_array;
            $select_to_use = 'relation_select';
         }

         foreach($array_to_use as $field => $header){

            $field_val = $_POST[$field];
            $q = '';

            if($field_val == '' && ($field == 'member_id1' || $field == 'member_id2' || $field == 'first_name' || $field == 'last_name')){

               $quit_flag = 1;
               break;
            }

            if($field_val == ''){

               $field_val = 'NULL';
            }

            if($field_val != 'NULL'){

               if(preg_match('/^\d+$/', $field_val) == 0){

                  $q = '"';
               }
            }

            $var_string .= (($var_string != '') ? ',': '').$q.$field_val.$q;
         }

         //Quit if the flag was tripped
         if($quit_flag == 1){
            continue;
         }
         if($_POST[$select_to_use] != ''){

            $count = 0;
            $sets = [];
            $sql = "UPDATE $table
                    SET ";

            foreach($array_to_use as $field => $header){

               $sets[$count] = $field."=".(($_POST[$field] == '') ? "NULL" : "'".$_POST[$field]."'"); //$_POST[$field]."'";
               $count++;
            }

            $tbl_id = preg_split('/\_/', $_POST[$select_to_use]);
            $sql .= join(", ", $sets)." \n
                    WHERE id=".$tbl_id[0];
         }
         else{

            //Insert the new row into the table 
            $sql = "INSERT INTO $table VALUES(".$var_string.");";
         }

         if($ghb_conn->query($sql) === TRUE) {

            echo "<p style='color:red;'>'".(($table=='ft_members')?'Person Info':'Relationship Info')."' Save successful!</p>";
         }
         else{
            echo "Error: ".$sql."<BR>".$ghb_conn->error;
         }
      }
   }

	$members_array = get_member_data(null);


	echo "<SCRIPT language='JavaScript'>
				$(document).ready(function() {

					var memberSelect = $('#member_select');
					var relationSelect = $('#relation_select');
					var membersFieldArray = {};
					var relationFieldArray = {};
					var membersArray = {};
					var relationArray = {};";

	foreach($members_array as $id => $data){

		echo "membersArray[$id] = {};\n
				relationArray[$id] = {};";

      $relation_array = get_member_relations($id);

		foreach($relation_array as $relation_id => $relation_data){

			echo "relationArray[$id][$relation_id] = {};\n";

			foreach($relation_data as $field => $value){

				echo "relationFieldArray['$field'] = 1;
						relationArray[$id][$relation_id]['$field'] = '$value';\n";
			}
		}

		
		foreach($data as $field => $value){

			echo "membersFieldArray['$field'] = 1;
					membersArray[$id]['$field'] = '$value'\n";
		}
	}
			
	echo "		memberSelect.change(function() {

  						var id = memberSelect.find(':selected').attr('value');

						clearFields(membersFieldArray);
						clearFields(relationFieldArray);
						relationSelect.empty();
                 	relationSelect.append('<OPTION value=\"\"></OPTION>'); 
						
						if(id != ''){

							populateFields(membersArray[id]);

							//population the relationship selection 
   	               $.each(relationArray[id], function(relationID, fieldArray) {

								var name = relationID+' - '+membersArray[relationID]['last_name']+','+membersArray[relationID]['first_name'];
      	           		relationSelect.append('<OPTION value='+fieldArray['id']+'_'+relationID+'>'+name+'</OPTION>'); 
      	            });
						}
					});

					//population the relationship fields with whatever is selected
					relationSelect.change(function() {

						var id = memberSelect.val();
						var relationID = relationSelect.val();
						var idArray = relationSelect.val().split('_');
						var relationID = idArray[0];
						var relationPersonID = idArray[1];

						clearFields(relationFieldArray);

						if(relationID != ''){

							populateFields(relationArray[id][relationPersonID]);	
						}
					});

					//populate the fields with whatever is passed
					function populateFields(fieldArray){

                  $.each(fieldArray, function(index, value) {

                     $('#'+index).val(value);
                  });
					}

					function clearFields(fieldsToClear){

                  $.each(fieldsToClear, function(index, value) {

                     $('#'+index).val('');    //clear it first
                  });
					}
				});
			</SCRIPT>";

	echo "<FORM method=POST action='/?pg=family_tree_edit'><BR><BR>
			<TABLE>";

	$array_to_use = [];
	$section_title = "";

	echo "<TR><TD colspan=2 align='center'>
			<SELECT id='member_select' name='member_select' style='width:250px;'>
				<OPTION value=''>Add New Member</OPTION>";

	foreach($members_array as $id => $data){

		echo "<OPTION value='$id'>".$data['id'].'-'.$data['last_name'].",".$data['first_name']." ".$data['middle_name']."</OPTION>";
	}

	echo "</SELECT></TD></TR>";

	//Loop through the two tables, relationships and members table
   foreach(["ft_members","ft_members_relations"] as $table){

   	if($table == 'ft_members'){

      	$array_to_use = $members_field_array;
			$section_title = "Person Information";
      }
      else{
      	$array_to_use = $relation_field_array;
			$section_title = "Relationship Information";

			echo "<TR><TD colspan=2 align='center'>
					<BR>
					<SELECT id='relation_select' name='relation_select' style='width:250px;'>
					<OPTION value=''></OPTION>
					</SELECT>
					</TD></TR>";
      }

		echo "<TR><TD><BR></TD></TR>
				<TR><TH align='right' colspan=2>$section_title</TD></TR>";
	
		//Loop through the fields of the the table
		foreach ($array_to_use as $col_name => $header){
		
			echo "<tr>
				   <th align='right'>".$header.":</th>
				   <td align='left'>";

			//For the parent ID, make a select box
			if(preg_match('/^parent|^member/', $col_name)){
	
				echo "<SELECT id='$col_name' name='$col_name' style='width: 250px;'>
						 <OPTION value=''>";

				foreach($members_array as $parent_id => $data){

					$parent_name = $data['id'].'-'.$data['last_name'].",".$data['first_name']." ".$data['middle_name'];
					echo "<OPTION value='".$parent_id."'>".$parent_name;
				}

				echo "</SELECT>";
			}
			//For the description, make a textarea
			elseif($col_name == 'bio'){

				echo "<textarea id='".$col_name."' name='".$col_name."' style='width:250px;'></textarea>";
	
			}
			//For everything else, make a text field
			else{
				echo "<input type='text' id='".$col_name."' name='".$col_name."' style='width:250px;'>";
			}
			echo "</td></tr>";
		}
	}
	
	echo "</table><BR>
			<input type='submit' name='submit' value='Submit'>";
	echo "</FORM>";
	include('footer.php');
	*/

   $ghb_conn->close(); //Close Connection
   $info_conn->close(); //Close Connection
?>
