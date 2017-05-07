<?php

require('lib/dbobj.php');
require('lib/ft_funcs.php');
require('lib/date_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$mid = isset($_GET["mid"]) ? $_GET["mid"] : '';
$page_post = $page.($mid != null) ? "&mid=".$mid : "";
$body_event = "onload='selectFamilyMember()'";

$ft_members_array = get_member_data(null); //Get all the members of the tree
$ft_output_list = [];
$head_margin = 0;

include('header.php');

echo "<FORM method=post action='/?pg=".$page_post."'>
			<div id='tree-wrapper'>";
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
      	</div><BR><BR>";*/

echo "<div id='tree-members' onload='selectFamilyMember();'>
	  	 <ul class='tree-member-list'>";

//create the ft member list to output
build_members_list(1154,$ft_members_array, $ft_output_list,0);

echo "<a href='/?pg=".$page."'>Home</a>";

//Loop through each member in the tree
foreach($ft_output_list as $id => $field_array){

	$member_first_name  = $field_array['first_name'];
   $member_last_name   = $field_array['last_name'];
   $member_middle_name = $field_array['middle_name'];
   $member_suffix      = $field_array['suffix'];
   $member_suffix      = ($field_array['suffix'] != null) ? " ".$field_array[$id]['suffix'] : "";
   $member_count 	     = $field_array['count'];
   $married 		     = $field_array['married'];
   $gen 		     		  = $field_array['gen'];
	$margin 				  = $gen*10;

	//If this is the beginning of a tree, add the heading and family_echo icon
   if($id == 1001 || $id == 1011 || $id == 1154){
		
		$msg = '';

		if($id == 1154){

			$msg = "England to Thomas Jefferson";
		}
		elseif($id == 1001){

     		echo "</ul>";
			$msg = "Thomas Jefferson to Atwell Bowcock";
		}
		else{
	     	echo "</ul>";
			$msg = $member_first_name." ".$member_last_name;
		}

   	echo "<ul class='ft-members-header' id='".$id."-member-list' style='margin-left:".$margin."px;'>
					<a href='/family_echo/commilus_tree/index.htm' class='newPopup'><img src='/images/family_echo_icon.png'></a>
					<SPAN onclick='collapseExpandTree(".$id.");'>
						<i>".$msg." <img id='".$id."-fam-arrow' src='/images/up_arrow_12x12.png'></i>
				   </SPAN>";

		$head_margin = $margin;
   }

	//Print out the family member's link
   echo "<li id='member".$id."' style='margin-left:".($margin-$head_margin)."px;'>
			<a href='/?pg=".$page."&mid=".$id."'>".
         $member_last_name.$member_suffix.", ".$member_first_name." ".$member_middle_name."</a></li>";
}

echo "</ul>
     </div>";

//If a member exists, display their profile. 
if($mid){

	include('family_tree_profile.php');
}
//Otherwise, go to the 'home' page
else{

	echo "<div id='tree-member-profile'>";
	echo"<div class='page-text'>
	 	  	<h1>Family Tree Tool</h1>
     	  </div>";

	echo "</div>";
}

include('footer.php');
?>
