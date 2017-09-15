<?php

include('dbobj.php');

/*------------------------------------------------------------------------------
 * get_member_data() - Look up the children of the member id passed.  Return
 *                         results in an array.
 *------------------------------------------------------------------------------*/
function get_member_data($id = NULL) {

	$ft_members_array = [];
	$has_id = ($id == null) ? 0 : 1;		//id flag - '1'=id passed, '0'=no id passed
	$conn = get_mysqli_object(); 			//Get the connection to the database

	$sql = "SELECT id, first_name, middle_name, last_name, suffix, maiden_name, nicknames,
   		      	gender, birth_year, birth_month, birth_day, birth_loc, death_year,
 	         		death_month, death_day, death_loc, burial_loc, bio, parent_id1, parent_id2
 	  		  FROM ft_members
 	  		  WHERE (id = ? OR ".$has_id."=0)
	 		  ORDER BY birth_year, birth_month, birth_day";

	if($stmt = $conn->prepare($sql)){

		$stmt->bind_param("i", $id); 
		$stmt->execute();

		$stmt->bind_result($res_id, $first_name, $middle_name, $last_name, $suffix, $maiden_name, $nicknames,
								 $gender, $birth_year, $birth_month, $birth_day, $birth_loc, $death_year,
 	      				    $death_month, $death_day, $death_loc, $burial_loc, $bio, $parent_id1, $parent_id2);

		while($stmt->fetch()){

 			$data = array('id'	      	=> $res_id,
 				      	  'first_name'    => $first_name,
 				      	  'middle_name'   => $middle_name,
 				      	  'last_name'     => $last_name,
                       'suffix'        => $suffix,
 				      	  'maiden_name'   => $maiden_name,
 				      	  'nicknames'     => $nicknames,
 				      	  'gender'        => $gender,
 				      	  'birth_year'    => $birth_year,
 				      	  'birth_month'   => $birth_month,
 				      	  'birth_day'     => $birth_day,
 				      	  'birth_loc'     => $birth_loc,
 				      	  'death_year'    => $death_year,
 				      	  'death_month'   => $death_month,
 				      	  'death_day'     => $death_day,
 				      	  'death_loc'     => $death_loc,
 				      	  'burial_loc'    => $burial_loc,
 				      	  'bio'   	      => $bio,
 				      	  'parent_id1'    => $parent_id1,
 				      	  'parent_id2'    => $parent_id2);

 			if(!$has_id){

 				$ft_members_array[$res_id] = $data;
 			}
 			else{
 				$ft_members_array = $data;
 			}
 		}

 			//close the statement
 			$stmt->close();
	}

	//close the connection
	$conn->close();

	return $ft_members_array;
}

/*------------------------------------------------------------------------------
 * get_member_parents() - Look up the parents of the member id passed.  Return
 *                        parent's member information in an array.
 *------------------------------------------------------------------------------*/
function get_member_parents($id){

	if($id == null){

      echo "ft_funcs::get_member_parents() - id parameter is null";
      return [];
   }

   $parents_array = [];
   $conn = get_mysqli_object();

   $sql = "SELECT id, first_name, middle_name, last_name, suffix, maiden_name, nicknames,
                  gender, birth_year, birth_month, birth_day, birth_loc, death_year,
                  death_month, death_day, death_loc, burial_loc, bio, parent_id1, parent_id2
	  		  FROM ft_members 
	  		  WHERE (id IN(SELECT parent_id1 FROM ft_members WHERE id = ?) OR 
			   		id IN(SELECT parent_id2 FROM ft_members WHERE id= ?))
	  		  ORDER BY birth_year, birth_month, birth_day";

   if($stmt = $conn->prepare($sql)){

   	$stmt->bind_param("ii", $id,$id);
      $stmt->execute();

      $stmt->bind_result($res_id, $first_name, $middle_name, $last_name, $suffix, $maiden_name, $nicknames,
                         $gender, $birth_year, $birth_month, $birth_day, $birth_loc, $death_year,
                         $death_month, $death_day, $death_loc, $burial_loc, $bio, $parent_id1, $parent_id2);

      while($stmt->fetch()){

      	$data = array('id'            => $res_id,
                       'first_name'    => $first_name,
                       'middle_name'   => $middle_name,
                       'last_name'     => $last_name,
                       'suffix'        => $suffix,
                       'maiden_name'   => $maiden_name,
                       'nicknames'     => $nicknames,
                       'gender'        => $gender,
                       'birth_year'    => $birth_year,
                       'birth_month'   => $birth_month,
                       'birth_day'     => $birth_day,
                       'birth_loc'     => $birth_loc,
                       'death_year'    => $death_year,
                       'death_month'   => $death_month,
                       'death_day'     => $death_day,
                       'death_loc'     => $death_loc,
                       'burial_loc'    => $burial_loc,
                       'bio'           => $bio,
                       'parent_id1'    => $parent_id1,
                       'parent_id2'    => $parent_id2);

			$parents_array[$res_id] = $data;
		}

		//close the statement
		$stmt->close();
	}

	//close the connection
	$conn->close();

	return $parents_array;
}

/*------------------------------------------------------------------------------
 * get_member_siblings() - Look up the siblings of the member id passed.  Return
 *                         the siblings member information in an array.
 *------------------------------------------------------------------------------*/
function get_member_siblings($id){

		if($id == null){

			echo "ft_funcs::get_member_siblings() - id parameter is null";
			return [];
		}

		$p_id1;
		$p_id2;
		$sibling_array = [];
		$conn = get_mysqli_object();

		//Get the parents id
		$sql = "SELECT parent_id1, parent_id2
	  			  FROM ft_members
					WHERE id= ?";

		if($stmt = $conn->prepare($sql)){

			$stmt->bind_param("i",$id);
			$stmt->execute();

			$stmt->bind_result($p_id1,$p_id2);
			$stmt->fetch();

			$stmt->close();
		}

		//Get the siblings
		$sib_sql = "SELECT id, first_name, middle_name, last_name, suffix, maiden_name, nicknames,
                      gender, birth_year, birth_month, birth_day, birth_loc, death_year,
                      death_month, death_day, death_loc, burial_loc, bio, parent_id1, parent_id2
		  				FROM ft_members
						WHERE ((parent_id1= ?  OR
					  			  parent_id1= ?) AND
					 			 (parent_id2= ?  OR
					  			  parent_id2= ?))
						AND id != ?
		  				ORDER BY birth_year, birth_month, birth_day";

		if($stmt = $conn->prepare($sib_sql)){

			$stmt->bind_param("iiiii", $p_id1,$p_id2,$p_id1,$p_id2,$id);
			$stmt->execute();

      	$stmt->bind_result($sib_id, $first_name, $middle_name, $last_name, $suffix, $maiden_name, $nicknames,
         	                $gender, $birth_year, $birth_month, $birth_day, $birth_loc, $death_year,
         	                $death_month, $death_day, $death_loc, $burial_loc, $bio, $parent_id1, $parent_id2);

      	while($stmt->fetch()){

      		$data = array('id'            => $sib_id,
				 				  'first_name'    => $first_name,
                          'middle_name'   => $middle_name,
                          'last_name'     => $last_name,
                          'suffix'        => $suffix,
                          'maiden_name'   => $maiden_name,
                          'nicknames'     => $nicknames,
                          'gender'        => $gender,
                          'birth_year'    => $birth_year,
                          'birth_month'   => $birth_month,
                          'birth_day'     => $birth_day,
                          'birth_loc'     => $birth_loc,
                          'death_year'    => $death_year,
                          'death_month'   => $death_month,
                          'death_day'     => $death_day,
                          'death_loc'     => $death_loc,
                          'burial_loc'    => $burial_loc,
                          'bio'           => $bio,
                          'parent_id1'    => $parent_id1,
                          'parent_id2'    => $parent_id2);

				$sibling_array[$sib_id] = $data;
			}
		}
		$conn->close();

	return $sibling_array;
}

/*------------------------------------------------------------------------------
 * get_member_relations() - Look up the relationships of the member id passed.  Return
 *                          a list of the members in a relationship with
 *------------------------------------------------------------------------------*/
function get_member_relations($id){

	if($id == null){

      echo "ft_funcs::get_member_relations() - id parameter is null";
      return [];
   }

	$relation_array = [];
	$conn = get_mysqli_object();

	$sql = "SELECT id,IF(member_id1 != ?,member_id1, member_id2) as 'partner',relation_type,begin_year,begin_month,begin_day,begin_loc,
						end_year, end_month, end_day,end_reason,member_id1,member_id2
           FROM ft_members_relations 
           WHERE (member_id1 = ? OR member_id2 = ?)";

		if($stmt = $conn->prepare($sql)){

			$stmt->bind_param("iii", $id,$id,$id);
			$stmt->execute();

			$stmt->bind_result($r_id,$partner_id,$relation_type,$begin_year,$begin_month,$begin_day,$begin_loc,
									 $end_year,$end_month,$end_day,$end_reason,$member_id1,$member_id2);

			while($stmt->fetch()){

      		$data = array('id'            => $r_id,
            	           'relation_type' => $relation_type,
            	           'begin_year'    => $begin_year,
            	           'begin_month'   => $begin_month,
            	           'begin_day'     => $begin_day,
            	           'begin_loc'     => $begin_loc,
            	           'end_year'      => $end_year,
            	           'end_month'     => $end_month,
            	           'end_day'       => $end_day,
            	           'end_reason'    => $end_reason,
            	           'member_id1'    => $member_id1,
            	           'member_id2'    => $member_id2);

				$relation_array[$partner_id] = $data;
			}

			$stmt->close();
		}

		$conn->close();

	return $relation_array;
}

/*------------------------------------------------------------------------------
 * get_member_children() - Look up the children of the member id passed.  Return
 *									results in an array.
 *------------------------------------------------------------------------------*/
function get_member_children($id){

	if($id == null){

   	echo "ft_funcs::get_member_children() - id parameter is null";
      return [];
   }

	$children_array = [];
	$conn = get_mysqli_object();

	// Get this person's children information
	$sql = "SELECT id, first_name, middle_name, last_name, suffix, maiden_name, nicknames,
                  gender, birth_year, birth_month, birth_day, birth_loc, death_year,
                  death_month, death_day, death_loc, burial_loc, bio, parent_id1, parent_id2
           FROM ft_members
           WHERE (parent_id1 = ? OR parent_id2 = ?)
	  		  ORDER BY birth_year, birth_month, birth_day";

	if($stmt = $conn->prepare($sql)){

		$stmt->bind_param("ii",$id,$id);
		$stmt->execute();

      $stmt->bind_result($child_id, $first_name, $middle_name, $last_name, $suffix, $maiden_name, $nicknames,
                         $gender, $birth_year, $birth_month, $birth_day, $birth_loc, $death_year,
                         $death_month, $death_day, $death_loc, $burial_loc, $bio, $parent_id1, $parent_id2);

		while($stmt->fetch()){

			$data = array('id'           => $child_id,
                       'first_name'   => $first_name,
                       'middle_name'  => $middle_name,
                       'last_name'    => $last_name,
                       'suffix'       => $suffix,
                       'maiden_name'  => $maiden_name,
                       'nicknames'    => $nicknames,
                       'gender'       => $gender,
                       'birth_year'   => $birth_year,
                       'birth_month'  => $birth_month,
                       'birth_day'    => $birth_day,
                       'birth_loc'    => $birth_loc,
                       'death_year'   => $death_year,
                       'death_month'  => $death_month,
                       'death_day'    => $death_day,
                       'death_loc'    => $death_loc,
                       'burial_loc'   => $burial_loc,
                       'bio'          => $bio,
                       'parent_id1'   => $parent_id1,
                       'parent_id2'   => $parent_id2);

			$children_array[$child_id] = $data;
		}

		$stmt->close();
	}

	$conn->close();

	return $children_array;
}

/*------------------------------------------------------------------------------
 * get_member_groups() - Retrieve an array of the member groups used for sorting
 *------------------------------------------------------------------------------*/
function get_member_groups(){

   $group_array = [];
   $conn = get_mysqli_object();

   // Get this person's children information
   $sql = "SELECT start_member_id, group_name, group_desc, rank
           FROM ft_member_groups";

   if($stmt = $conn->prepare($sql)){

      $stmt->execute();

      $stmt->bind_result($start_member_id, $group_name, $group_desc, $rank);

      while($stmt->fetch()){

         $data = array('start_member_id'  => $start_member_id,
                       'group_name'       => $group_name,
                       'group_desc'       => $group_desc);

         $group_array[$rank] = $data;
      }

      $stmt->close();
   }

   $conn->close();

   return $group_array;
}

/*------------------------------------------------------------------------------
 * build_members_list() - Recursive function to build a sorted list of family members
 *                        for the family tree tool.
 *------------------------------------------------------------------------------*/
function build_members_list($id, &$ft_members_array, &$ft_output_list, $gen,$group){


   if($id == 1160 || $id == 1011 || $id == 1154){

		$group = $id;
	}

	//Add the person to the output array
	$ft_output_list[$group][$id] = array(	'first_name'	=> $ft_members_array[$id]['first_name'],
		  			     								'last_name'		=> $ft_members_array[$id]['last_name'],
					     								'middle_name'	=> $ft_members_array[$id]['middle_name'],
					     								'suffix'			=> $ft_members_array[$id]['suffix'],
														'birth_year'	=> $ft_members_array[$id]['birth_year'],
														'death_year'	=> $ft_members_array[$id]['death_year'],
														'gen'				=> $gen);

	//Get the members relationships
 	$ft_members_relations = get_member_relations($id);

	//Loop through each of the person's relationships
	foreach($ft_members_relations as $relation_member_id => $relation_data){

		$ft_output_list[$group][$relation_member_id] = array(	'first_name'	=> $ft_members_array[$relation_member_id]['first_name'],
																				'last_name'		=> $ft_members_array[$relation_member_id]['last_name'],
								     											'middle_name'	=> $ft_members_array[$relation_member_id]['middle_name'],
								     											'suffix'			=> $ft_members_array[$relation_member_id]['suffix'],
								     											'birth_year'	=> $ft_members_array[$relation_member_id]['birth_year'],
                                  				     				'death_year'	=> $ft_members_array[$relation_member_id]['death_year'],
								     											'married'	  	=> $id,
								     											'gen'				=> $gen);

		$gen++;

		//Get the children they had together
		foreach($ft_members_array as $child_member_id => $child_data){

			if(($child_data['parent_id1'] == $id || $child_data['parent_id2'] == $id) &&
				($child_data['parent_id1'] == $relation_member_id || $child_data['parent_id2'] == $relation_member_id)){

				//recursively build the tree
				build_members_list($child_member_id, $ft_members_array, $ft_output_list, $gen, $group);
			}
		}
	}
}

/*------------------------------------------------------------------------------
 * get_search_results($query) - Get the results from the query
 *------------------------------------------------------------------------------*/
function get_search_results($query){

	$query_flds = parse_query_field($query);
   
	//format for the search query
   $last_name = "%".$query_flds['last_name']."%";
   $first_name = "%".$query_flds['first_name']."%";
   $gender = "%".$query_flds['gender']."%";
   $birth_year = "%".$query_flds['birth_year']."%";
   $birth_month = "%".$query_flds['birth_month']."%";
   $birth_day = "%".$query_flds['birth_day']."%";
   $birth_loc = "%".$query_flds['birth_loc']."%";
   $death_year = "%".$query_flds['death_year']."%";
   $death_month = "%".$query_flds['death_month']."%";
   $death_day = "%".$query_flds['death_day']."%";
   $death_loc = "%".$query_flds['death_loc']."%";
	$sort_by;

	//Format sort String
	if($query_flds['sort_by'] == 'birth_date'){

		$sort_by = "birth_year, birth_month, birth_day";
	}
	else if($query_flds['sort_by'] == 'death_date'){

		$sort_by = "death_year, death_month, death_day";
	}
	else{
		$sort_by = "last_name, first_name";
	}

   $result_array = [];
	$conn = get_mysqli_object();

	// Get this person's children information
	$sql = "SELECT id, first_name, middle_name, last_name, maiden_name, nicknames,
                  gender, birth_year, birth_month, birth_day, birth_loc, death_year,
                  death_month, death_day, death_loc, burial_loc, parent_id1, parent_id2
           FROM ft_members
            WHERE (? IS NULL OR last_name LIKE ?)
            AND (? IS NULL OR first_name LIKE ?)
            AND (? IS NULL OR gender LIKE ?)
				AND (? IS NULL OR birth_year LIKE ?)
            AND (? IS NULL OR birth_month LIKE ?)
            AND (? IS NULL OR birth_day LIKE ?)
            AND (? IS NULL OR birth_loc LIKE ?)
            AND (? IS NULL OR death_year LIKE ?)
            AND (? IS NULL OR death_month LIKE ?)
            AND (? IS NULL OR death_day LIKE ?)
            AND (? IS NULL OR death_loc LIKE ?)
			  ORDER BY $sort_by";

	if($stmt = $conn->prepare($sql)){

		$stmt->bind_param("ssssssssssssssssssssss",
								$query_flds['last_name'], 	 $last_name, 
								$query_flds['first_name'],  $first_name, 
								$query_flds['gender'], 		 $gender,
								$query_flds['birth_year'],  $birth_year,
								$query_flds['birth_month'], $birth_month,
								$query_flds['birth_day'], 	 $birth_day,
								$query_flds['birth_loc'], 	 $birth_loc,
                        $query_flds['death_year'],  $death_year,
                        $query_flds['death_month'], $death_month,
                        $query_flds['death_day'],   $death_day,
                        $query_flds['death_loc'],   $death_loc);
		$stmt->execute();

      $stmt->bind_result($id, $first_name, $middle_name, $last_name, $maiden_name, $nicknames,
                         $gender, $birth_year, $birth_month, $birth_day, $birth_loc, $death_year,
                         $death_month, $death_day, $death_loc, $burial_loc, $parent_id1, $parent_id2);

		while($stmt->fetch()){

			$data = array('id'           => $id,
                       'first_name'   => $first_name,
                       'middle_name'  => $middle_name,
                       'last_name'    => $last_name,
                       'maiden_name'  => $maiden_name,
                       'nicknames'    => $nicknames,
                       'gender'       => $gender,
                       'birth_year'   => $birth_year,
                       'birth_month'  => $birth_month,
                       'birth_day'    => $birth_day,
                       'birth_loc'    => $birth_loc,
                       'death_year'   => $death_year,
                       'death_month'  => $death_month,
                       'death_day'    => $death_day,
                       'death_loc'    => $death_loc,
                       'burial_loc'   => $burial_loc,
                       'parent_id1'   => $parent_id1,
                       'parent_id2'   => $parent_id2);

			$result_array[$id] = $data;
		}

		$stmt->close();
	}

	$conn->close();

	return $result_array;
}

/*------------------------------------------------------------------------------
 * parse_query_field($query) - Parse the query GET field and return the fields
 *                             in an array
 *------------------------------------------------------------------------------*/
function parse_query_field($query) {

   $query_comps = preg_split("/\~/", $query);
   $query_flds = [];

	//Initialize the fields
	foreach(array('last_name','first_name','gender','birth_month','birth_day','birth_year','birth_loc','death_month','death_day','death_year','death_loc','sort_by') as $fld){

	   $query_flds[$fld] = null;
	}

	foreach($query_comps as $value){

	   $search_flds = preg_split("/\:/", $value);
	   $query_flds[$search_flds[0]] = isset($search_flds[1]) ? $search_flds[1] : null;
	}
   
   return $query_flds;
}

?>
