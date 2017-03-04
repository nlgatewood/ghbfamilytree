<?php

	/*------------------------------------------------------------
	 * get_member_data($id) -- Returns an array of the persons
	 *				'ft_members' data
	 *------------------------------------------------------------*/
	function get_member_data($id) {
	
		$ft_members_array = [];
		$conn = get_mysqli_object(); //Get the connection to the database

		//Get all the members of the tree
		$sql = "SELECT * FROM ft_members";
		$sql .= ($id != null) ? " WHERE id = ".$id : "";

		if(!$result = $conn->query($sql)) {

   		echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
		}

		//If an 'id' wasn't passed, add to array by id
		if($id == null){

			while ($data = $result->fetch_assoc()) {

        		$ft_members_array[$data['id']] = $data;
			}
		}
		//Else, just copy the returned data
		else{
			$ft_members_array = $result->fetch_assoc();
		}

		$conn->close();

		return $ft_members_array;
	}

   /*------------------------------------------------------------
    * get_member_parents($id) - returns an array of the member's
    *             Parent information
    *------------------------------------------------------------*/
   function get_member_parents($id){

      $conn = get_mysqli_object();
      $parents_array = [];

      $sql = "SELECT * FROM ft_members 
				  WHERE (id IN(SELECT parent_id1 FROM ft_members WHERE id = ".$id.") OR 
						   id IN(SELECT parent_id2 FROM ft_members WHERE id=".$id."))";


      if(!$result = $conn->query($sql)){

         echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
      }

      while($data = $result->fetch_assoc()){

         $parents_array[$data['id']] = $data;
      }

		$conn->close();

      return $parents_array;
   }

	/*------------------------------------------------------------
	 * get_member_siblings($id) - Returns an array of the member's
	 * 				siblings
	 *------------------------------------------------------------*/
	function get_member_siblings($id){

		$conn = get_mysqli_object();
		$sibling_array = [];

		//Get the parents id
		$sql = "SELECT parent_id1, parent_id2
				  FROM ft_members
					WHERE id=".$id;

		if(!$result = $conn->query($sql)){

         echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
      }

		$pdata = $result->fetch_assoc();

		//Get the siblings
		$sib_sql = "SELECT *
					  FROM ft_members
						WHERE ((parent_id1='".$pdata['parent_id1']."' OR
								  parent_id1='".$pdata['parent_id2']."') AND
								 (parent_id2='".$pdata['parent_id1']."' OR
								  parent_id2='".$pdata['parent_id2']."'))
						AND id !=".$id;

      if(!$result = $conn->query($sib_sql)){

         echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
      }

      while($sib_data = $result->fetch_assoc()){

         $sibling_array[$sib_data['id']] = $sib_data;
      }

		$conn->close();

		return $sibling_array;
	}

	/*------------------------------------------------------------
	 * get_member_relations($id) - returns an array of the member's
	 *					relationship history
	 *------------------------------------------------------------*/
	function get_member_relations($id){

		$conn = get_mysqli_object();
		$relation_array = [];

		$sql = "SELECT IF(member_id1 != ".$id.",member_id1, member_id2) as 'partner',relation_type,begin_year,begin_month,begin_day,begin_loc,
							end_year, end_month, end_day,end_reason
              FROM ft_members_relations 
               WHERE (member_id1 = ".$id." OR member_id2 = ".$id.")";

		if(!$result = $conn->query($sql)){

   		echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
		}

		while($data = $result->fetch_assoc()){

   		$relation_array[$data['partner']] = array('relation_type' => $data['relation_type'],
                                                   'member_id1' 	 => $data['member_id1'],
                                                   'member_id2' 	 => $data['member_id2'],
                                                   'relation_type' => $data['relation_type'],
                                                   'begin_year' 	 => $data['begin_year'],
                                                   'begin_month' 	 => $data['begin_month'],
                                                   'begin_day' 	 => $data['begin_day'],
                                                   'begin_loc' 	 => $data['begin_loc'],
                                                   'end_year' 		 => $data['end_year'],
                                                   'end_month' 	 => $data['end_month'],
                                                   'end_day' 		 => $data['end_day'],
                                                   'end_reason' 	 => $data['end_reason']);
		}

		$conn->close();

		return $relation_array;
	}

	/*------------------------------------------------------------
	 * get_member_children() - Get an array of the member's children
	 *------------------------------------------------------------*/
	function get_member_children($id){

		$conn = get_mysqli_object();
		$children_array = [];

		// Get this person's children information
		$sql = "SELECT *
              FROM ft_members
               WHERE (parent_id1 = ".$id." OR parent_id2 = ".$id.")";

		if(!$result = $conn->query($sql)){

   		echo "Query: " . $sql . "\nError: " . $conn ->errno."--".$conn->error;
		}

		while($data = $result->fetch_assoc()){

   		$children_array[$data['id']] = $data;
		}

		$conn->close();

		return $children_array;
	}

	/*------------------------------------------------------------
	 *
	 *------------------------------------------------------------*/
	function build_members_list($id, &$ft_members_array, &$ft_output_list){

	   //my idea on how to deal with this...
	   $ft_members_relations = get_member_relations($id);

		$ft_output_list[$id] = array('first_name'		=> $ft_members_array[$id]['first_name'],
											  'last_name'	   => $ft_members_array[$id]['last_name'],
											  'middle_name'	=> $ft_members_array[$id]['middle_name'],
											  'suffix'			=> $ft_members_array[$id]['suffix']);

	   //Get the person they had a relationship with
	   foreach($ft_members_relations as $relation_member_id => $relation_data){

			$ft_output_list[$relation_member_id] = array('first_name'    => $ft_members_array[$relation_member_id]['first_name'],
                                   	  						'last_name'     => $ft_members_array[$relation_member_id]['last_name'],
                                      						'middle_name'   => $ft_members_array[$relation_member_id]['middle_name'],
                                      						'suffix'        => $ft_members_array[$relation_member_id]['suffix'],
																		'married'		 => $id);

	      //Get the children they had together
	      foreach($ft_members_array as $child_member_id => $child_data){

	         if(($child_data['parent_id1'] == $id || $child_data['parent_id2'] == $id) &&
	            ($child_data['parent_id1'] == $relation_member_id || $child_data['parent_id2'] == $relation_member_id)){

	            //recursively build the tree
	            build_members_list($child_member_id, $ft_members_array, $ft_output_list);
	         }
	      }
	   }
	}
?>
