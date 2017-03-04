<?php
	//Get POST and GET variables
	$page     = isset($_GET["pg"]) ? $_GET["pg"] : '';
	$submit	  = isset($_POST["submit"]) ? $_POST["submit"] : '';
	$user     = 'root';
	$password = 'cs4bguz$';
	$dbase 	 = 'ghbfamilytree';

	$field_array = [];
	$relation_array = [];
	$parent_array = [];

	//Begin HTML
	include('header.php');

   //Get the field list to create the fields we want to populate
   //-----------------------------------------------------------
   $conn = new mysqli('localhost','root','cs4bguz$','information_schema');

	//Get the members list
   $ft_members_sql = "SELECT column_name,column_comment FROM COLUMNS WHERE table_name IN ('ft_members') AND column_comment != ''";
   if (!$result = $conn->query($ft_members_sql)) {

      echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
   }

   while ($data = $result->fetch_assoc()) {

      $field_array[$data['column_name']] = $data['column_comment'];
   }

	//Get the relationship list
   $ft_relation_sql = "SELECT column_name,column_comment FROM COLUMNS WHERE table_name IN ('ft_members_relations') AND column_comment != ''";
   if (!$result = $conn->query($ft_relation_sql)) {

      echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
   }

   while ($data = $result->fetch_assoc()) {

      $relation_array[$data['column_name']] = $data['column_comment'];
   }

   $conn->close(); //Close Connection

   //Open a connection to the main database
	//--------------------------------------
   $conn = new mysqli('localhost',$user,$password,$dbase);

   if($conn->connect_error){

      echo "<p>Connection Failed: ".$conn->connect_error."</p>";
   }
	
	//If the age has been submitted, save the data entered
	//----------------------------------------------------
	if($submit == 'Submit'){
	
		$array_to_use = [];

		foreach(["ft_members","ft_members_relations"] as $table){

			$var_string = 'NULL';
			$quit_flag = 0;
			
			if($table == 'ft_members'){
				
				$array_to_use = $field_array;
			}
			else{
				$array_to_use = $relation_array;
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

			//Insert the new row into the table	
			$sql = "INSERT INTO $table VALUES(".$var_string.");";
		
			if($conn->query($sql) === TRUE) {
		
				echo "<p style='color:red;'>'".(($table=='ft_members')?'Person Info':'Relationship Info')."' Save successful!</p>";
			}
			else{
				echo "Error: ".$sql."<BR>".$conn->error;
			}
		}
	}

   //Get a list of Family tree members
   //---------------------------------
   $sql = "SELECT id,first_name,last_name, middle_name FROM ft_members ORDER BY id";

   if (!$result = $conn->query($sql)) {

      echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
   }

   while ($data = $result->fetch_assoc()) {

      $parent_array[$data['id']] = $data['id'].'-'.$data['last_name'].",".$data['first_name']." ".$data['middle_name'];
   }

   $conn->close(); //Close Connection

	echo "<FORM method=POST action='/?pg=family_tree_edit'>
			<TABLE>";

	$array_to_use = [];
	$section_title = "";

   foreach(["ft_members","ft_members_relations"] as $table){

   	if($table == 'ft_members'){

      	$array_to_use = $field_array;
			$section_title = "Person Information";
      }
      else{
      	$array_to_use = $relation_array;
			$section_title = "Relationship Information";
      }

		echo "<TR><TD><BR></TD></TR>
				<TR><TH align='right' colspan=2>$section_title</TD></TR>";
	
		foreach ($array_to_use as $name => $header){
		
			echo "<tr>
				   <th align='right'>".$header.":</th>
				   <td align='left'>";

			//For the parent ID, make a select box
			if(preg_match('/^parent|^member/', $name)){
	
				echo "<SELECT style='width: 200px;' name = '$name'>
						 <OPTION value=''>";

				foreach($parent_array as $parent_id => $parent_name){

					echo "<OPTION value='".$parent_id."'>".$parent_name;
				}

				echo "</SELECT>";
			}
			//For the description, make a textarea
			elseif($name == 'bio'){

				echo "<textarea name='".$name."'></textarea>";
	
			}
			//For everything else, make a text field
			else{
				echo "<input type='text' name='".$name."'>";
			}
			echo "</td></tr>";
		}
	}
	
	echo "</table><BR>
			<input type='submit' name='submit' value='Submit'>";
	echo "</FROM>";
	include('footer.php');
?>
