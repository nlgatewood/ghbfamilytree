<?php
require('lib/ft_funcs.php');
require('lib/date_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$query = isset($_GET["query"]) ? $_GET["query"] : '';
$range = isset($_GET["range"]) ? $_GET["range"] : '';
$body_event = "";

include('header.php');

if($range == null){

   $range = 20;
}

echo "<FORM method='get' name='ft_form' id='ft_form' action='/'>
         <input type='hidden' name='pg' value='$page'>
         <div class='page-text'>
				<h1>Family Member Search</h1>
			</div>";

$query_flds = [];
$query_comps = preg_split("/\~/", $query);

foreach($query_comps as $value){

	$search_flds = preg_split("/\:/", $value);
	$query_flds[$search_flds[0]] = $search_flds[1];
}

echo "<div id='search-box'>
         <fieldset>
         
            <div class='search-criteria'>
               <div class='search-section'>
                  <div class='search-fld'>
                     <label id='top-label'>Last Name</label>
                     <input type='text' name='last_name' id='last_name' value='".$query_flds['last_name']."'>
                  </div>
                  <div class='search-fld'>
                     <label id='top-label'>First Name</label>
                     <input type='text' name='first_name' id='first_name' value='".$query_flds['first_name']."'>
                  </div>
               </div>
               <div class='search-section'>
                  <div class='search-fld'>
                     <label>Male:</label>
                     <input type='radio' name='gender' class='search-fld' id='genderm' value='M' ".(($query_flds['gender'] == 'M') ?"checked='checked'" : "").">
                  </div>
                  <div class='search-fld'>
                     <label>Female:</label>
                     <input type='radio' name='gender' class='search-fld' id='genderf' value='F' ".(($query_flds['gender'] == 'F') ?"checked='checked'" : "").">
                  </div>
               </div>
            </div>
            
            <div class='search-criteria'>
               <div class='search-section'>
                  <label id='top-label'>Birth Date (MM-DD-YYYY):</label>
                  <div class='search-fld'>
                     <input type='text' name='birth_month' class='search-fld' id='birth_month' value='".$query_flds['birth_month']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='birth_day' class='search-fld' id='birth_day' value='".$query_flds['birth_day']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='birth_year' class='search-fld' id='birth_year' value='".$query_flds['birth_year']."' maxlength='4' size='4'>
                  </div>
                  <div class='search-fld'>
                     &nbsp;<label>Birth Location:</label>
                     <input type='text' name='birth_loc' class='search-fld' id='birth_loc' value='".$query_flds['birth_loc']."'>
                  </div>
               </div>
            </div>

            <div class='search-criteria'>
               <div class='search-section'>
                  <label id='top-label'>Death Date (MM-DD-YYYY):</label>
                  <div class='search-fld'>
                     <input type='text' name='death_month' class='search-fld' id='death_month' value='".$query_flds['death_month']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='death_day' class='search-fld' id='death_day' value='".$query_flds['death_day']."' maxlength='2' size='2'>
                  </div>
                  <div class='search-fld'>
                     <input type='text' name='death_year' class='search-fld' id='death_year' value='".$query_flds['death_year']."' maxlength='4' size='4'>
                  </div>
                  <div class='search-fld'>
                     <label>Death Location:</label>
                     <input type='text' name='death_loc' class='search-fld' id='death_loc' value='".$query_flds['death_loc']."'>
                  </div>
               </div>
               <HR>
                  <div class='search-submit'>
                     <input type='submit' value='Search'>
                  </div>
                  <div class='search-submit'>
                     <input type='submit' value='Clear'>
                  </div>
            </div>
            
         </fieldset>
      </div>";

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

	echo "<div style='width: 60%; margin: 20px auto 0px;'>";

	//Print the link to go to the next set of results   
	resultPages($result_keys, $query, $range, $num);
   
   echo "<TABLE style='width:100%;'>";

   //Loop through the results
   for($i=($range-20); $i<$num; $i++){

		$member_data = $results_array[$result_keys[$i]];

      echo "<TD colspan=3 style='padding:0 0 0 0;'><hr></TD>
				<TR>
               <TD style='vertical-align:text-top; text-align:left;'><a href='/?pg=profile&mid=".$result_keys[$i]."'>".$member_data['last_name'].", ".$member_data['first_name']."</a></TD>
               <TD>
                  <TABLE style='width:100%;'>
                  <TR>
                     <TD align='right'>Birth:</TD>
                     <TD align='left'>".format_date($member_data['birth_year'],$member_data['birth_month'],$member_data['birth_day'],'MM/DD/YYYY')."</TD>
                  </TR>
                  <TR>
                     <TD align='right'>Death:</TD>
                     <TD align='left'>".format_date($member_data['death_year'],$member_data['death_month'],$member_data['death_day'],'MM/DD/YYYY')."</TD>
                  </TR>
                  </TABLE>
               </TD>
               <TD>
                  <TABLE style='width:100%;'>
                  <TR>
                     <TD>Relationships</TD>
                  </TR>
                  </TABLE>
               </TD>
            </TR>";
   }
   
   echo "<TD colspan=3 style='padding:0 0 0 0;'><hr></TD>
			</TABLE>";

	//Print the link to go to the next set of results   
	resultPages($result_keys, $query, $range, $num);

	echo "</div>";
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
