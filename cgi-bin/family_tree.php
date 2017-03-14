
<?php

require('lib/dbobj.php');
require('lib/ft_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$fam = isset($_GET["fam"]) ? $_GET["fam"] : '';
$ft_members_array = get_member_data(null); //Get all the members of the tree
$ft_output_list = [];

include('header.php');

echo "<FORM method=post action='/?pg=family_tree&fam=".$fam."'><BR>";

echo "<h1>Gatewood Family Tree</h1><BR>
		<div class='description'>
			<img src='images/ft_overview.png' height='33%' style='float:right; margin: 0 0 10px 10px;'>
			<p>
The first United States Census in 1790 listed 22 families of Gatewoods living within the confines of the original thirteen states; eighteen in Virginia, three in North Carolina, and one of South Carolina.  While there are several Gatewood lines, this site will be focusing on Atwell Bowcock Gatewood and his heirs.  There's less information available on previous ancestors, but I hope to research  older ancestors in the near future and add them to the page.  Atwell Bowcock was born in 1829 in Stafford county, Virginia. He was the 2nd son of Thomas Jefferson Gatewood, Sr.  Thomas Jefferson Gatewood, who was the 5th generation from John Gatewood, the member who immigrated from England to America.  Atwell Bowcock married Fanny U. Harding and had several sons and daughters.  While several of his offspring met an untimely end,  three sons went on to create three large Gatewood branches: John Wallace Gatewood, Commilus Atwell Gatewood, and Cornealus Linzy Gatewood.  Therefore, we will be splitting the tree by the John Wallace tree, the Commilus Atwell tree, and the Cornealus Linzy tree. To the right is a simple tree diagram to help visualize the relationships.
			</p>
		   <p>
Below is a family member viewer tool to help users view family member information more easily.  In the left window of the member tool is the family member list split out by the different family branches, Thomas Jefferson to Atwell Bowcock, John Wallace, Commilus Atwell, and Cornealus Linzy.  The list is organized by family branches, starting with the oldest.  It begins with generation 0, then their partner, then the first born between generation 0 and his partner.  Once the first child's line is exhausted, it moves to the second  child and so on.  If more clarification is needed, please review the toolip at the top of the viewer tool for a more detailed example.
			</p>
			<p>
In addition to the family member viewer tool, a visual tree diagram supplied by <a href='https://www.familyecho.com/'>Family Echo</a> can be viewed by clicking on the icon next to the Family branch headers in the family member list of the viewer tool.  As of now, only the Commilus Atwell visual diagram is available.
			</p>
		</div>";

echo "
	<div class='tree-wrapper'>

      <div class='tooltip'>How is this list sorted?
         <span class='tooltiptext'>

				Example - Beginning with Generation 0 (George H.W. Bush):
				<ul>
				 <li>George H.W. Bush</li>
				 <li>Barbara Bush (married George H.W.)</li>
				 <li>George W. Bush</li>
				</ul>
				If Generation 0's first child married and had children, then his wife and children would come next.  If the 1st born's line end's (George W.) we move on to the 2nd born of Generation 0 (Jeb Bush):
				<ul>
				 <li>George H.W. Bush</li>
				 <li>Barbara Bush (married George H.W.)</li>
				 <li>George W. Bush</li>
				 <li>Laura Bush (married George W.)</li>
				 <li>Jenna Bush</li>
				 <li>Barbara Bush</li>
				 <li>Jeb Bush</li>
				 <li>Columba Bush (married Jeb)</li>
				</ul>
				The list continues down the branches sorted by age.

         </span>
      </div><BR><BR>

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
   	echo "<ul class='tree-member-list' id='".$id."-member-list'>
				<span style='display:inline;'>
					<a href='/family_echo/commilus_tree/index.htm' class='newPopup'><img src='/images/family_echo_icon.png' width=5% height=3%></a>
				</span>
				<div style='display:inline;' onclick='collapseExpandTree(".$id.");'><i>".$msg." <img id='".$id."-fam-arrow' src='/images/up_arrow_12x12.png'></i></div>";
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
        </div><BR><BR>";

include('footer.php');

?>
