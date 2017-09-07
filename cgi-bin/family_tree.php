<?php
require('lib/ft_funcs.php');
require('lib/date_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$query = isset($_GET["query"]) ? $_GET["query"] : '';
$range = isset($_GET["range"]) ? $_GET["range"] : '';
$body_event = "onload='selectFamilyMember()'";

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

			<div id='search-criteria'>
				<span class='search-field'>
					<label>Last Name</label>
					<input type='text' name='last_name' class='search-fld' id='last_name' value='".$query_flds['last_name']."'>\n
				</span>
         	<span class='search-field'>
         	   <label>First Name</label>
         	   <input type='text' name='first_name' class='search-fld' id='first_name' value='".$query_flds['first_name']."'>\n
         	</span>
         	<span class='search-radio'>
					<label>Male:</label>
					<input type='radio' name='gender' value='M'>
					<label>Female:</label>
					<input type='radio' name='gender' value='F'>
				</span>
			</div>

			<input type='submit' value='Search'>";

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
   
   echo "<TABLE border=1 style='width:100%; margin-top:20px;'>";

   //Loop through the results
   for($i=($range-20); $i<$num; $i++){

		$member_data = $results_array[$result_keys[$i]];

      echo "<TR>
               <TD style='vertical-align:text-top; text-align:left;'><a href='/?pg=profile&mid=".$result_keys[$i]."'>".$member_data['last_name'].", ".$member_data['first_name']."</a></TD>
               <TD>
                  <TABLE border=1 style='width:100%;'>
                  <TR>
                     <TD>Birth:</TD>
                     <TD></TD>
                  </TR>
                  <TR>
                     <TD>Death:</TD>
                     <TD></TD>
                  </TR>
                  </TABLE>
               </TD>
               <TD>
                  <TABLE border=1 style='width:100%;'>
                  <TR>
                     <TD>Rtelationships</TD>
                  </TR>
                  </TABLE>
               </TD>
            </TR>";
   }
   
   echo "</TABLE>";

	//Print the link to go to the next set of results   
   if($range-20 > 0){
        
      echo "<a href='/?pg=family_tree&query=".urlencode($query)."&range=".($range-20)."'> << </a>";
   }

	echo ($range-19)."-".$num;

	if(count($result_keys) > $range){

		echo "<a href='/?pg=family_tree&query=".urlencode($query)."&range=".($range+20)."'> >> </a>";
	}

	echo "</div>";
}

include('footer.php');
?>
