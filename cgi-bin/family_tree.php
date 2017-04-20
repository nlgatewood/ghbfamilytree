<?php

require('lib/dbobj.php');
require('lib/ft_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$ft_members_array = get_member_data(null); //Get all the members of the tree
$ft_output_list = [];

include('header.php');

echo "<FORM method=post action='/?pg=family_tree'>

		<div class='page-text'>
			<h1>Gatewood Family Tree</h1>

		</div>";

//Begin the family tree viewer tool code
echo "<div class='tree-wrapper'>

      	<div class='tooltip'>How is this list sorted?
         	<span class='tooltiptext'>
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
         	</span>
      	</div><BR><BR>

	 <div class='tree-members'>
	  <ul class='tree-member-list'>";

//create the ft member list to output
build_members_list(1001,$ft_members_array, $ft_output_list,0);

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
	$margin 				  = $gen*20;

	//If this is the beginning of a tree, add the heading and family_echo icon
   if($id == 1001 || $id == 1011){
		
		$msg = '';

		if($id == 1001){
			$msg = "Thomas Jefferson to Atwell Bowcock";
		}
		else{
     	echo "</ul>";
			$msg = $member_first_name." ".$member_last_name;
		}

   	echo "<ul class='tree-member-list' id='".$id."-member-list'>
					<span style='display:inline;'>
						<a href='/family_echo/commilus_tree/index.htm' class='newPopup'><img src='/images/family_echo_icon.png' width=5% height=3%></a>
					</span>
					<div style='display:inline;' onclick='collapseExpandTree(".$id.");'><i>".$msg." <img id='".$id."-fam-arrow' src='/images/up_arrow_12x12.png'></i></div>";
   }

	//Print out the family member's link
   echo "<li class='ft_members' id='member".$id."' style='margin-left:".$margin."px;'><a href='javascript:void(0)' onclick ='refreshFTFrame(".$id.");'>".
         $member_last_name.$member_suffix.", ".$member_first_name." ".$member_middle_name."</a></li>";
}

echo "</ul>
     </div>
     <iframe class='tree-details-frame' id='tree-details-frame' src='/?pg=ft_frame'></iframe>
     </div>";

include('footer.php');
?>
