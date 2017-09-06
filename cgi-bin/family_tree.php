<?php
require('lib/ft_funcs.php');
require('lib/date_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$mid = isset($_GET["mid"]) ? $_GET["mid"] : '';
$query = isset($_GET["query"]) ? $_GET["query"] : '';
$range = isset($_GET["range"]) ? $_GET["range"] : '';
$body_event = "onload='selectFamilyMember()'";

$ft_members_array = get_member_data(); //Get all the members of the tree
$member_groups_array = get_member_groups();
$ft_output_list = [];
$head_margin = 0;

include('header.php');

#echo "<FORM method='get' action='/'>
#			<div id='tree-wrapper'>";

//-------------------------------------------------------
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

			<input type='submit' value='Search'>
		</div>";

$results_array = get_search_results($query);

if(count($results_array) > 0){
   
   //Get all of the keys from the array
   $result_keys = array_keys($results_array);
   
   echo "<TABLE border=1>";
   
   //Loop through the results
   for($i=0; $i<20; $i++){

      echo "<TR>
               <TD><a href='/?pg=profile&id=$member_id'>".$member_data['last_name'].", ".$member_data['first_name']."</a></TD>
               <TD>
                  <TABLE border=1>
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
                  <TABLE border=1>
                  <TR>
                     <TD>Relationships</TD>
                     <TD></TD>
                  </TR>
                  </TABLE>
               </TD>
            </TR>";
   }
   
   echo "</TABLE>";
   
   if(count($result_keys) > $range){
        
      echo "<input type='hidden' id='range' value='".$range+20."'>
            <a href='#' onclick='form.submit();'> <<".$range-19."-$range>> </a>";
   }
}

//-------------------------------------------------------
/*
/*
echo "<div class='tooltip'>How is this list sorted?
         	<SPAN class='tooltiptext'>
					Example - Beginning with Generation 0 (George H.W. Bush):
					<ul>
				 	 <li>George H.W. Bush</li>
				 	 <li>Barbara Bush (married George H.W.)</li>
				 	 <li style='margin-left:20px;'>George W. Bush</li>
					</ul>
					If Generation 0's first child married and had children, then his wife and children would come next.  If the 1st born's line end's (George W.) we move on to the 2nd born of Generation 0 (Jeb Bush):
					<ul>
				 	 <li>George H.W. Bush</li>
				 	 <li>Barbara Bush (married George H.W.)</li>
				 	 <li style='margin-left:20px;'>George W. Bush</li>
				 	 <li style='margin-left:20px;'>Laura Bush (married George W.)</li>
				 	 <li style='margin-left:40px;'>Jenna Bush</li>
				 	 <li style='margin-left:40px;'>Barbara Bush</li>
				 	 <li style='margin-left:20px;'>Jeb Bush</li>
				 	 <li style='margin-left:20px;'>Columba Bush (married Jeb)</li>
					</ul>
					The list continues down the branches sorted by age.
         	</SPAN>
      	</div><BR><BR>";

echo "<div id='tree-members' onload='selectFamilyMember();'>
	  	 <ul id='tree-member-list'>";

//create the ft member list to output
build_members_list(1154,$ft_members_array, $ft_output_list,0,null);

echo "<a href='/?pg=".$page."'>Home</a>";

ksort($member_groups_array);

foreach($member_groups_array as $rank => $group_data){

	$group_id   = $group_data['start_member_id'];
	$group_name = $group_data['group_name'];
	$group_desc = $group_data['group_desc'];
	$margin     = $ft_output_list[$group_id][$group_id]['gen']*10;
	echo $ft_output_list[$group_id]['gen'];

	echo "<ul class='ft-members-header' id='".$group_id."-member-list'>
				<SPAN class='header-desc' style='margin-left:".$margin."px;'>
      			<a href='/family_echo/$group_name/index.htm' class='newPopup'><img src='/images/family_echo_icon.png'></a>
         		<SPAN onclick='collapseExpandTree(".$group_id.");'>
            		<i>".$group_desc." <img id='".$group_id."-fam-arrow' src='/images/up_arrow_12x12.png'></i>
            	</SPAN>
				</SPAN>";

	//Loop through each member in the tree
	foreach($ft_output_list[$group_id] as $id => $field_array){

		$member_first_name  = $field_array['first_name'];
	   $member_last_name   = $field_array['last_name'];
	   $member_middle_name = $field_array['middle_name'];
	   $member_suffix      = $field_array['suffix'];
	   $member_suffix      = ($field_array['suffix'] != null) ? " ".$field_array[$id]['suffix'] : "";
	   $member_birth_year  = ($field_array['birth_year']) ? $field_array['birth_year'] : "";
	   $member_death_year  = ($field_array['death_year']) ? $field_array['death_year'] : "";
	   $member_life_range  = " (".$member_birth_year." - ".$member_death_year.")";
	   $member_count 	     = $field_array['count'];
	   $married 		     = $field_array['married'];
	   $gen 		     		  = $field_array['gen'];
		$margin 				  = $gen*10;

		//Print out the family member's link
   	echo "<li id='member".$id."' style='margin-left:".$margin."px;'>
				<a href='/?pg=".$page."&mid=".$id."'>".
   	      $member_last_name.$member_suffix.", ".$member_first_name." ".$member_middle_name.$member_life_range."</a></li>";
	}

	echo "</ul>";
}

echo "
     </div>";

//If a member exists, display their profile. 
if($mid){

	include('family_tree_profile.php');
}
//Otherwise, go to the 'home' page
else{

	echo "<div id='tree-member-profile'>";
	echo"<div class='page-text'>
	 	  	<h1>Gatewood Family Tree</h1>
		
			<p>
				Representing family trees in a way that is easily readable and searchable can be very difficult.  Family trees can be very large and very complicated with large gaps of information.  Fining a balance between relationship visualization and the information content can be challenging.  The goal was to create a tool that was easily navigable, yet informative.
         </p>
         <p>
            <a href='images/ft_diagram.jpg' data-lightbox='image-1' data-title='Diagram breaking down the family groups relationship.'>
            <img src='images/ft_diagram.jpg' style='float:right; margin-left:10px; margin:2px 2px 2px 2px;'></a>
            
            While the Gatewood name is not particularly common, it is still vast and complex.  Therefore, this website primarily focuses on the descendants of <a href='/?pg=tree&mid=1009'>Atwell Bowcock Gatewood</a> and his direct ancestors.  To the left is a list of Gatewood family members that have been researched so far.  The list splits into different groups for easier navigation.
            Currently, we have three groups:  '<i>England to John Gatewood</i>', '<i>John Gatewood to Atwell Bowcock Gatewood</i>', and '<i>Commilus Atwell Gatewood</i>'.  These are not arbitrary groups.  Each group represents an important branch point within the family tree.  For example, one of the most important branch points in the tree is <a href='/?pg=tree&mid=1160'>John Gatewood</a>.  
            He immigrated to the United States from England in the 1600s.  Every Gatewood in the United States today can trace their ancestry back to him.  Other inflection points include the three sons of Atwell Bowcock: John Wallace Gatewood, <a href='/?pg=tree&mid=1011'>Commilus Atwell Gatewood</a>, and Cornealus Linzy Gatewood.  All three spawned large family trees that include much of 
            the modern day Gatewoods found in Texas and Missouri.  Currently, only the Commilus Atwell tree has been researched.  The other two branches will be added later.
            Additionally, there is also a visual representation of the family trees.  To the left of the group headings is a small people image.  Click on this image to bring up a graphical representation of the family tree, supplied by Family Echo (<a href='https://www.familyecho.com'>https://www.familyecho.com</a>).  It is a great way to create and share your own family tree.  
            Currently, only the Commilus Atwell Family Echo tree has been created.
			</p>
     	  </div>";

	echo "</div>";
}
*/

include('footer.php');
?>
