<?php
require('lib/ft_funcs.php');
require('lib/date_funcs.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$mid = isset($_GET["mid"]) ? $_GET["mid"] : '';

$ft_members_array = get_member_data($mid);

include('header.php');

echo "<div id='tree-member-profile'>";

/*--------------------------
 * Basic Information Section
 *--------------------------*/
$member_name       = $ft_members_array['first_name']." ".$ft_members_array['middle_name']." ".$ft_members_array['last_name']." ".$ft_members_array['suffix'];
$member_maiden     = ($ft_members_array['maiden_name'] != null) ? "(n&eacute;e ".$ft_members_array['maiden_name'].")" : '';
$member_nicknames  = ($ft_members_array['nicknames'] != null) ? "Nicknames: <i>".$ft_members_array['nicknames']."</i>" : '';
$member_birth      = format_date($ft_members_array['birth_year'],$ft_members_array['birth_month'],$ft_members_array['birth_day'],'MM/DD/YYYY');
$member_death      = format_date($ft_members_array['death_year'],$ft_members_array['death_month'],$ft_members_array['death_day'],'MM/DD/YYYY');
$member_birth_loc = ($ft_members_array['birth_loc'] != null) ? $ft_members_array['birth_loc'] : 'N/A';
$member_death_loc = ($ft_members_array['death_loc'] != null) ? $ft_members_array['death_loc'] : 'N/A';
$member_burial_loc = ($ft_members_array['burial_loc'] != null) ? $ft_members_array['burial_loc'] : 'N/A';
$member_gender     = $ft_members_array['gender'];
$image_dir;

//Set the sex description
if($member_gender== 'M'){

	$member_gender = 'Male';
}
elseif($member_gender == 'F'){

	$member_gender = 'Female';
}
else{
	$member_gender = 'Unknown';
}

$ft_member_images = get_profile_images($mid);
$main_profile_image = $ft_member_images[0]['file'];
$main_profile_caption = $ft_member_images[0]['caption'];

//Begin the main container table
echo "<TABLE id='main-tbl'>
       <TR>
        <TD>
         <div id='img-gallery'>
            <div id='profile-img'>
               <a href='$main_profile_image' data-lightbox='image-1' data-title='$main_profile_caption'><img src='$main_profile_image'>
               </a>
            </div>";

//Print out the image link
for($i=1; $i<count($ft_member_images);$i++){
   
   echo "<a href='".$ft_member_images[$i]['file']."' data-lightbox='image-1' data-title='".$ft_member_images[$i]['caption']."'><img class='add-img' src='".$ft_member_images[$i]['file']."'></a>";
}
             
echo "   </div>
         <TABLE id='demog-tbl'>
            </TR>
            <TR>
             <TD id='member-name' colspan=2>".$member_name." ".$member_maiden."
            </TR>
            <TR>
             <TD id='member-nicknames' colspan=2>".$member_nicknames."</TD>
            </TR>
            <TR>
             <TH>Gender:</TH>
             <TD>".$member_gender."</TD>
            </TR>
            <TR>
             <TH>Date of Birth:</TH>
             <TD>".$member_birth.": ".$member_birth_loc."</TD>
            </TR>
            <TR>
             <TH>Date of Death:</TH>
             <TD>".$member_death.": ".$member_death_loc."</TD>
            </TR>
            <TR>
             <TH>Buried:</TH>
             <TD>".$member_burial_loc."</TD>
            </TR>
         </TABLE>

        </TD>
       </TR>
       <TR>
        <TD>";

/*-----------------------------------
 * Relationship and Offspring Section
 *-----------------------------------*/
$ft_parents_array  = get_member_parents($mid);
$ft_siblings_array = get_member_siblings($mid);
$ft_relation_array = get_member_relations($mid);
$ft_children_array = get_member_children($mid);

//begin the nexted relationship table
echo "<TABLE id='relation-tbl' style='width:100%;'>
         <TR>
          <TD class='divider' colspan=3><HR></TD>
         </TR>
         <TR>
          <TH class='heading' colspan=3>Parents</TH>
         </TR>";

//If member has no children on file, display N/A
if(count($ft_parents_array) == 0){

   echo "<TR>
          <TD class='na' colspan=3>N/A</TD>
         </TR>";
}

//Loop through each of the children and print them
foreach($ft_parents_array as $parent_id => $parent_array){

   $parent_name       = $parent_array['first_name']." ".$parent_array['middle_name']." ".$parent_array['last_name']." ".$parent_array['suffix'];
   $parent_maiden     = ($parent_array['maiden_name'] != null) ? " (n&eacute;e ".$parent_array['maiden_name'].")" : '';
   $parent_birth      = format_date($parent_array['birth_year'],$parent_array['birth_month'],$parent_array['birth_day'],'MM/DD/YYYY');
   $parent_birth_loc  = ($parent_array['birth_loc']) ? ": ".$parent_array['birth_loc'] : '';
   $parent_death      = format_date($parent_array['death_year'],$parent_array['death_month'],$parent_array['death_day'],'MM/DD/YYYY');
   $parent_death_loc  = ($parent_array['death_loc']) ? ": ".$parent_array['death_loc'] : '';

   echo "<TR>
          <TD><a href='/?pg=".$page."&mid=".$parent_id."'>".$parent_name.$parent_maiden."</a></TD>
          <TD><SPAN>Born:</SPAN> ".$parent_birth.$parent_birth_loc."</TD>
          <TD><SPAN>Death:</SPAN> ".$parent_death.$parent_death_loc."</TD>
         </TR>";
}

echo "<TR>
		 <TD class='divider' colspan=3><HR></TD>
		</TR>
      <TR>
		 <TH class='heading' colspan=3>Siblings</TH>
		</TR>";

//If a relationship doesn't exist, default to N/A
if(count($ft_siblings_array) == 0){

   echo "<TR>
          <TD class='na' colspan=3>N/A</TD>
         </TR>";
}

//Loop through each of the sibling relationships and print them
foreach($ft_siblings_array as $sibling_id => $sibling_array){

   $sibling_name     = $sibling_array['first_name']." ".$sibling_array['middle_name']." ".$sibling_array['last_name']." ".$sibling_array['suffix'];
   $sibling_maiden   = ($sibling_array['maiden_name'] != null) ? " (n&eacute;e ".$sibling_array['maiden_name'].")" : '';
   $birth_date       = format_date($sibling_array['birth_year'],$sibling_array['birth_month'],$sibling_array['birth_day'],'MM/DD/YYYY');
   $birth_loc        = ($sibling_array['birth_loc']) ? ": ".$sibling_array['birth_loc'] : '';
   $death_date       = format_date($sibling_array['death_year'],$sibling_array['death_month'],$sibling_array['death_day'],'MM/DD/YYYY');
   $death_loc        = ($sibling_array['death_loc']) ? ": ".$sibling_array['death_loc'] : '';

   echo "<TR>
          <TD><a href='/?pg=".$page."&mid=".$sibling_id."'>".$sibling_name.$sibling_maiden."</a></TD>
          <TD><SPAN>Birth:</SPAN>".$birth_date.$birth_loc."</TD>
          <TD><SPAN>Death:</SPAN>".$death_date.$death_loc."</TD>
         </TR>";
}

echo "   <TR>
          <TD class='divider' colspan=3><HR></TD>
         </TR>
         <TR>
          <TH class='heading' colspan=3>Relationships</TH>
         </TR>";

//If a relationship doesn't exist, default to N/A
if(count($ft_relation_array) == 0){

   echo "<TR>
          <TD class='na' colspan=3>N/A</TD>
         </TR>";
}

//Loop through each of the relationships for this member
foreach($ft_relation_array as $partner_id => $relation_array){

   $ft_partner_array 	= get_member_data($partner_id);
   $partner_name     	= $ft_partner_array['first_name']." ".$ft_partner_array['middle_name']." ".$ft_partner_array['last_name']." ".$ft_partner_array['suffix'];
   $partner_maiden   	= ($ft_partner_array['maiden_name'] != null) ? " (n&eacute;e ".$ft_partner_array['maiden_name'].")" : '';
   $relation_begin		= format_date($relation_array['begin_year'],$relation_array['begin_month'],$relation_array['begin_day'],'MM/DD/YYYY');
	$relation_begin_loc 	= ($relation_array['begin_loc']) ? $relation_array['begin_loc'] : 'N/A'; 
   $relation_end     	= format_date($relation_array['end_year'],$relation_array['end_month'],$relation_array['end_day'],'MM/DD/YYYY');

   echo "<TR>
          <TD><a href='/?pg=$page&mid=$partner_id'>$partner_name$partner_maiden</a></TD>
          <TD><SPAN>Married:</SPAN>$relation_begin: $relation_begin_loc</TD>
          <TD><SPAN>Divorced: </SPAN>$relation_end</TD>
         </TR>";
}

echo "   <TR>
          <TD class='divider' colspan=3><HR></TD>
         </TR>
         <TR>
          <TH class='heading'>Offspring</TH>
          <TD colspan=2></TD>
         </TR>";

//If member has no children on file, display N/A
if(count($ft_children_array) == 0){

   echo "<TR>
          <TD class='na' colspan=3>N/A</TD>
         </TR>";
}

//Loop through each of the children and display them
foreach($ft_children_array as $child_id => $child_array){

   $child_name      = $child_array['first_name']." ".$child_array['middle_name']." ".$child_array['last_name']." ".$child_array['suffix'];
   $child_maiden    = ($child_array['maiden_name'] != null) ? " (n&eacute;e ".$child_array['maiden_name'].")" : '';
   $child_birth     = format_date($child_array['birth_year'],$child_array['birth_month'],$child_array['birth_day'],'MM/DD/YYYY');
   $child_birth_loc = ($child_array['birth_loc']) ? ": ".$child_array['birth_loc'] : '';
   $child_death     = format_date($child_array['death_year'],$child_array['death_month'],$child_array['death_day'],'MM/DD/YYYY');
   $child_death_loc = ($child_array['death_loc']) ? ": ".$child_array['death_loc'] : '';

   echo "<TR>
          <TD><a href='/?pg=$page&mid=$child_id'>$child_name$child_maiden</a></TD>
          <TD><SPAN>Born:</SPAN>$child_birth$child_birth_loc</TD>
          <TD><SPAN>Death:</SPAN>$child_death$child_death_loc</TD>
         </TR>";
}

/*--------------
 * About section
 *--------------*/
echo "   <TR>
          <TD class='divider' colspan=3><HR></TD>
         </TR>
         <TR>
          <TH class='heading'>About/History</TH>
          <TD colspan=2></TD>
         </TR>
         <TR>";

if(!$ft_members_array['bio']){

	echo "<TD class='na' colspan=3>N/A</TD>";
}
else{
	echo"<TD colspan=3>".$ft_members_array['bio']."</TD>";
}

	echo "</TR>
      </TABLE>
     </TD>
    </TR>
   </TABLE>
  </div>";

include('footer.php');
?>
