
<?php

require('lib/dbobj.php');
require('lib/ft_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$fam = isset($_GET["fam"]) ? $_GET["fam"] : '';
$ft_members_array = get_member_data(null); //Get all the members of the tree
$ft_output_list = [];

include('header.php');

echo "<FORM method=post action='/?pg=family_tree&fam=".$fam."'>";

//echo "<BR><iframe style='width:98%; height:100%' src='/gatewood_tree'></iframe>";
echo "<BR><BR>
	<div class='tree-wrapper'>
	 <div class='tree-members'>
	  <ul class='tree-member-list'>";

//create the ft member list to output
build_members_list(1,$ft_members_array, $ft_output_list);

$member_cnt = 1;

foreach($ft_output_list as $id => $field_array){

	$ft_output_list[$id]['count'] = $member_cnt;
	$member_cnt++;
}

foreach($ft_output_list as $id => $field_array){

	$member_first_name  = $field_array['first_name'];
   $member_last_name   = $field_array['last_name'];
   $member_middle_name = $field_array['middle_name'];
   $member_suffix      = $field_array['suffix'];
   $member_suffix      = ($field_array['suffix'] != null) ? " ".$field_array[$id]['suffix'] : "";
   $member_count 	     = $field_array['count'];
   $married 		     = $field_array['married'];

   if($id == 1 || $id == 11){
		
		$msg = '';

		if($id == 1){
			$msg = "Thomas Jefferson to Atwell Bowcock";
		}
		else{
			$msg = $member_first_name." ".$member_last_name;
		}

     echo "</ul>";
     echo "<ul class='tree-member-list' id='".$id."-member-list'><div style='display:inline;' onclick='collapseExpandTree(".$id.");'><i>
			 ".$msg." <img id='".$id."-fam-arrow' src='/images/up_arrow_12x12.png'></i></div>";
   }

   echo "<li class='ft_members' id='member".$id."'><a href='javascript:void(0)' onclick ='refreshFTFrame(".$id.");'>".
         $member_count.") ".$member_last_name.$member_suffix.", ".$member_first_name." ".$member_middle_name."</a>";

			if($married != null){

				echo "<div style='display:inline; font-size:12px;'> (m. to #".$ft_output_list[$married]['count'].")</div>";
			}

	echo "<li>";
}

echo "    </ul>
         </div>
         <iframe class='tree-details-frame' id='tree-details-frame' src='/?pg=ft_frame'></iframe>
        </div>";

include('footer.php');

?>
