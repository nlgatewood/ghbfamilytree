<?php
require('lib/ft_funcs.php');
require('lib/date_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$query = isset($_GET["query"]) ? $_GET["query"] : '';
$range = isset($_GET["range"]) ? $_GET["range"] : '';
$body_event = 1;

include('header.php');

if($range == null){

   $range = 20;
}

echo "<FORM method='get' name='ft_form' id='ft_form' action='/'>
         <input type='hidden' name='pg' value='$page'>
         <div class='page-text'>
				<h1>Family Member Search</h1>
			</div>";

//parse the fields from the query string
$query_flds = parse_query_field($query);

echo "<div class='panel' style='position:absolute;'>
         <div class='panel-heading'>
            <h1>Important Profiles</h1>
         </div>
			<div class='panel-text'>
				<TABLE>
					<TR>
						<TD><a href='/?pg=profile&mid=1154'>Thomas Gatewood</a></TD>
						<TD>".format_date(1586,NULL,NULL,'MM/DD/YYYY')." - ".format_date(NULL,NULL,NULL,'MM/DD/YYYY')."</TD>
					</TR>
					<TR>
						<TD><a href='/?pg=profile&mid=1160'>John Gatewood</a></TD>
						<TD>".format_date(1654,NULL,NULL,'MM/DD/YYYY')." - ".format_date(1706,NULL,NULL,'MM/DD/YYYY')."</TD>
					</TR>
					<TR>
						<TD><a href='/?pg=profile&mid=1011'>Atwell Bowcock Gatewood</a></TD>
						<TD>".format_date(1829,1,26,'MM/DD/YYYY')." - ".format_date(1919,7,22,'MM/DD/YYYY')."</TD>
					<TR>
						<TD><a href='/?pg=profile&mid=1160'>Commilus Atwell Gatewood</a></TD>
						<TD>".format_date(1855,8,21,'MM/DD/YYYY')." - ".format_date(1937,5,23,'MM/DD/YYYY')."</TD>
					<TR>
						<TD><a href='/?pg=profile&mid=1053'>Ludie Gatewood</a></TD>
						<TD>".format_date(1890,4,2,'MM/DD/YYYY')." - ".format_date(1977,5,27,'MM/DD/YYYY')."</TD>
					</TR>
				</TABLE>
			</div>
      </div>

		<div class='panel' style='float:right;'>
         <div class='panel-heading'>
            <h1>Visual Family Tree</h1>
         </div>
			<div class='panel-text'>
				Click the image below for a visual representation of the Gatewood Family Tree (Currently not complete).
			</div>

			<a href='/family_echo/COMG/index.htm' class='newPopup'><img src='/images/family_echo.png' style='width:300px; height:auto;'></a>

			<div class='panel-text' style='font-size:10px;'>
				(Family Echo (<a href='https://www.familyecho.com/'>www.familyecho.com/</a>) family is a free Family Tree builder created by  Familiality Ltd., a private company based in Tel Aviv.)
			</div>
		</div>";

echo "<div id='search-box'>
         <div class='panel-heading'>
            <h1>Search for Members</h1>
         </div>

         <fieldset>
         
            <div class='search-criteria'>
               <div class='search-section'>
                  <div class='search-fld'>
                     <label id='top-label'>Last Name</label>
                     <input type='text' name='last_name' class='search-input' value='".$query_flds['last_name']."'>
                  </div>
                  <div class='search-fld'>
                     <label id='top-label'>First Name</label>
                     <input type='text' name='first_name' class='search-input' value='".$query_flds['first_name']."'>
                  </div>
               </div>
               <div class='search-section'>
                  <div class='search-fld'>
                     <label>Male:</label>
                     <input type='radio' name='gender' class='search-input' value='M' ".(($query_flds['gender'] == 'M') ?"checked='checked'" : "").">
                  </div>
                  <div class='search-fld'>
                     <label>Female:</label>
                     <input type='radio' name='gender' class='search-input' value='F' ".(($query_flds['gender'] == 'F') ?"checked='checked'" : "").">
                  </div>
               </div>
            </div>
            
            <div class='search-criteria'>
               <div class='search-section'>
                  <label id='top-label'>Birth Date (MM-DD-YYYY):</label>
                  <div class='search-fld'>
                     <input type='text' name='birth_month' class='search-input' value='".$query_flds['birth_month']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='birth_day' class='search-input' value='".$query_flds['birth_day']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='birth_year' class='search-input' value='".$query_flds['birth_year']."' maxlength='4' size='4'>
                  </div>
                  <div class='search-fld'>
                     &nbsp;<label>Birth Location:</label>
                     <input type='text' name='birth_loc' class='search-input' value='".$query_flds['birth_loc']."'>
                  </div>
               </div>
            </div>

            <div class='search-criteria'>
               <div class='search-section'>
                  <label id='top-label'>Death Date (MM-DD-YYYY):</label>
                  <div class='search-fld'>
                     <input type='text' name='death_month' class='search-input' value='".$query_flds['death_month']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='death_day' class='search-input' value='".$query_flds['death_day']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='death_year' class='search-input' value='".$query_flds['death_year']."' maxlength='4' size='4'>
                  </div>
                  <div class='search-fld'>
                     <label>Death Location:</label>
                     <input type='text' name='death_loc' class='search-input' value='".$query_flds['death_loc']."'>
                  </div>
               </div>

					<div class='search-section'>
               	<label>Sort By:</label>
                  <div class='search-fld'>
							<SELECT name='sort_by' class='search-input'>
								<OPTION value='name' ".(($query_flds['sort_by'] == 'name') ?"selected" : "").">Name</OPTION>
								<OPTION value='birth_date' ".(($query_flds['sort_by'] == 'birth_date') ?"selected" : "").">Birth Date</OPTION>
								<OPTION value='death_date' ".(($query_flds['sort_by'] == 'death_date') ?"selected" : "").">Death Date</OPTION>
							</SELECT>
                  </div>
					</div>
<hr>
               <div class='search-submit'>
               	<input type='submit' value='Search'>
               </div>
               <div class='search-submit'>
               	<input type='reset' value='Clear'>
               </div>
            </div>
            
         </fieldset>
      </div>";


//Look up results if search criteria was entered
if($query != null){

	//Get the search results from the search criteria
	$results_array = get_search_results($query);

	//If results were returned, print them out
	if(count($results_array) > 0){
   
   	//Get all of the keys from the array
   	$result_keys = array_keys($results_array);
		$num;

		if(count($results_array) < $range){

			$num = count($results_array);
		}
		else{
			$num = $range;
		}

		echo "<BR>
				<div id='search-results'>";

		//Print the link to go to the next set of results   
		resultPages($result_keys, $query, $range, $num);
   
   	echo "<TABLE id='result-main'>";

   	//Loop through the results
   	for($i=($range-20); $i<$num; $i++){

			$member_data = $results_array[$result_keys[$i]];

			$mid = $result_keys[$i];
			$m_parents_array  = get_member_parents($mid);
			$m_siblings_array = get_member_siblings($mid);
			$m_children_array = get_member_children($mid);
			$row_group = ($i%2==0) ? 0 : 1;

      	echo "<TR class='member-row'>
      	         <TD id='result-member-name' class='main-tbl'><a href='/?pg=profile&mid=$mid'>".$member_data['last_name'].", ".$member_data['first_name']."</a></TD>
      	         <TD id='result-member-date' class='main-tbl'>
      	            <TABLE>
      	            <TR>
      	               <TH>Birth:</TH>
      	               <TD>".format_date($member_data['birth_year'],$member_data['birth_month'],$member_data['birth_day'],'MM/DD/YYYY')."</TD>
      	            </TR>
      	            <TR>
      	               <TH>Death:</TH>
      	               <TD>".format_date($member_data['death_year'],$member_data['death_month'],$member_data['death_day'],'MM/DD/YYYY')."</TD>
      	            </TR>
      	            </TABLE>
      	         </TD>
      	         <TD id='result-member-relation' class='main-tbl'>
      	            <TABLE>";

					$size = 0;
					$parents_keys = array_keys($m_parents_array);
					$siblings_keys = array_keys($m_siblings_array);
					$children_keys = array_keys($m_children_array);
						
					echo "<TR>
								<TD>Parents</TD>
								<TD>Siblings</TD>
								<TD>Children</TD>
							</TR>";

					if(count($parents_keys) > $size){

						$size = count($parents_keys);
					}
					if(count($siblings_keys) > $size){

						$size = count($siblings_keys);
					}
					if(count($children_keys) > $size){

						$size = count($children_keys);
					}

					for($j=0; $j<$size; $j++){

						$rtypes = array();
						$rtypes['parents']  = $m_parents_array;
						$rtypes['siblings'] = $m_siblings_array;
						$rtypes['children'] = $m_children_array;

						echo "<TR>";

						foreach($rtypes as $type => $array){
		
							$new_line = null;
							$keys = array_keys($array);

							//Initialize variables
							$keys[$j] = isset($keys[$j]) ? $keys[$j] : null;

							foreach(array('first_name','middle_name','last_name','suffix') as $fld){

								$array[$keys[$j]][$fld] = isset($array[$keys[$j]][$fld]) ? $array[$keys[$j]][$fld] : null;
							}
							
							if($keys[$j] != null){

                     	$new_line = "<a href='/?pg=profile&mid=".$keys[$j]."'>".$array[$keys[$j]]['first_name']." ".$array[$keys[$j]]['middle_name']." ".
                                     $array[$keys[$j]]['last_name']." ".$array[$keys[$j]]['suffix']."</a>";

							}

							echo "<TD>$new_line</TD>";
						}

						echo "</TR>";
					}

      	      echo"</TABLE>
      	         </TD>
      	      </TR>";
   	}
   
   	echo "</TABLE>";

		//Print the link to go to the next set of results   
		resultPages($result_keys, $query, $range, $num);

		echo "</div>";
	}
	else {
		echo "<div id='search-results'>
					<p>No Results Returned</p>
				</div>";
	}
}

include('footer.php');

#----------------------------------------------------------
#	resultPages() - Print the next results list links
#----------------------------------------------------------
function resultPages($result_keys, $query, $range, $num){

   //Print the link to go to the next set of results   
   if($range-20 > 0){

      echo "<a href='/?pg=family_tree&query=".urlencode($query)."&range=".($range-20)."' style='margin-right:5px;'><img src='/images/left_arrow_12x12.png'></a>";
   }

   echo ($range-19)."-".$num;

   if(count($result_keys) > $range){

      echo "<a href='/?pg=family_tree&query=".urlencode($query)."&range=".($range+20)."' style='margin-left:5px;'><img src='/images/right_arrow_12x12.png'></a>";
   }
}
?>
