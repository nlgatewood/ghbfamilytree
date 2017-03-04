<?php

require('lib/ft_funcs.php');
require('lib/date_funcs.php');
require('lib/dbobj.php');

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$id = isset($_GET["id"]) ? $_GET["id"] : '999999';

//Get the information we'll need to create this page
$ft_members_array  = get_member_data($id);
$ft_parents_array  = get_member_parents($id);
$ft_siblings_array = get_member_siblings($id);
$ft_relation_array = get_member_relations($id);
$ft_children_array = get_member_children($id);

echo "<HTML>
		<HEAD>
		</HEAD>
		<BODY style='background-color:#C8C8C8;'>
		<FORM method=post action='/?pg=ft_frame'>";

/*--------------------------
 * Basic Information Section
 *--------------------------*/
$member_name 		 = $ft_members_array['first_name']." ".$ft_members_array['middle_name']." ".$ft_members_array['last_name']." ".$ft_members_array['suffix'];
$member_maiden 	 = ($ft_members_array['maiden_name'] != null) ? "(n&eacute;e ".$ft_members_array['maiden_name'].")" : '';
$member_nicknames  = ($ft_members_array['nicknames'] != null) ? "Nicknames: ".$ft_members_array['nicknames'] : '';
$member_birth 		 = ($ft_members_array['birth_date'] != null) ? $ft_members_array['birth_date'].": ".$ft_members_array['birth_loc'] : ' Unknown';
$member_death 		 = ($ft_members_array['death_date'] != null) ? $ft_members_array['death_date'].": ".$ft_members_array['death_loc'] : ' N/A';
$member_burial_loc = ($ft_members_array['burial_loc'] != null) ? $ft_members_array['burial_loc'] : '';
$member_gender 	 = null;

if($ft_members_array['gender'] == 'M'){

   $member_gender = 'Male';
}
elseif($ft_members_array['gender'] == 'F'){

   $member_gender = 'Female';
}
else{
   $member_gender = 'Unknown';
}

echo "<div class='ft-frame-content-wrapper' style='float:left; width:100%; height:100% border-width:1px; border-style:solid; border-right-style:hidden; border-left-style:hidden; border-top-style:hidden;'>
		<img src='/images/empty.png' style='float:left; width:150px; height=150px;'>

      <TABLE style='padding-bottom:10px;'>
		 <TR>
		  <TD colspan=2 style='font-size:24px; font-weight:bold;'>".$member_name."
		 	 <div style='font-weight:normal; display: inline;'>".$member_maiden."</div>
		  </TD>
		 <TR>
		  <TD colspan=2 height='30' valign='top'>
		   <div style='font-weight:normal; font-size: 14px; display: inline;'>".$member_nicknames."</div>
		  </TD>
       </TR>
       <TR>
        <TD>
          <TABLE>
			  <TR>
            <TH align='right'>Gender:</TH>
       		<TD>".$member_gender."</TD>
      	  </TR>
			  <TR>
		      <TH align='right'>Date of Birth:</TH>
		      <TD>".$member_birth."</TD>
		     </TR>
		     <TR>
		 		<TH align='right'>Date of Death:</TH>
		 		<TD>".$member_death."</TD>
			  </TR>
			  <TR valign='top' height='20'>
				<TH align='right'>Buried:</TH>
      	   <TD>".$member_burial_loc."</TD>
			  </TR>
			 </TABLE>
		  </TD>
		 </TR>
      </TABLE>
		</div>";

/*-----------------------------------
 * Relationship and Offspring Section
 *-----------------------------------*/
echo "<div class='ft-frame-content-wrapper' style='float:left;width:100%; height:100% border-width:1px; border-style:solid; border-right-style:hidden; border-left-style:hidden; border-top-style:hidden;'>

		<TABLE style='font-size:14px;'>
       <TR>
		  <TH align=left colspan=3 style='text-decoration:underline; margin-top:20px;'>Parents</TH>
       </TR>";

//If member has no children on file, display N/A
if(count($ft_parents_array) == 0){

   echo "<TR><TD style='font-style:italic;'>N/A</TD></TR>";
}

//Loop through each of the children and display them
foreach($ft_parents_array as $parent_id => $parent_array){

   $parent_name       = $parent_array['first_name']." ".$parent_array['middle_name']." ".$parent_array['last_name']." ".$parent_array['suffix'];
   $parent_maiden     = ($parent_array['maiden_name'] != null) ? " (n&eacute;e ".$parent_array['maiden_name'].")" : '';
   $parent_birth      = format_date($parent_array['birth_year'],$parent_array['birth_month'],$parent_array['birth_day'],'MM/DD/YYYY');
   $parent_birth_loc  = ($parent_array['birth_loc']) ? ": ".$parent_array['birth_loc'] : '';
   $parent_death      = format_date($parent_array['death_year'],$parent_array['death_month'],$parent_array['death_day'],'MM/DD/YYYY');
   $parent_death_loc  = ($parent_array['death_loc']) ? ": ".$parent_array['death_loc'] : '';

   echo "<TR align='left'>
          <TD style='padding-right:25px; white-space:nowrap;'><a href='/?pg=ft_frame&id=".$parent_id."'>".$parent_name.$parent_maiden."</a></TD>
          <TD style='padding-right:25px; white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Born: </div> ".$parent_birth.$parent_birth_loc."</TD>
          <TD style='white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Death: </div> ".$parent_death.$parent_death_loc."</TD>
         </TR>";
}

//Print the siblings
echo "<TR><TD colspan=3 style='padding-top:20px;'></TD></TR>
                <TR>
                  <TH align=left colspan=3 style='text-decoration:underline;'>Siblings</TH>
                 </TR>";

//If a relationship doesn't exist, default to N/A
if(count($ft_siblings_array) == 0){

        echo "<TR><TD style='font-style:italic;'>N/A</TD></TR>";
}

//Loop through each of the relationships for this member
foreach($ft_siblings_array as $sibling_id => $sibling_array){

        $sibling_name     = $sibling_array['first_name']." ".$sibling_array['middle_name']." ".$sibling_array['last_name']." ".$sibling_array['suffix'];
        $sibling_maiden   = ($sibling_array['maiden_name'] != null) ? " (n&eacute;e ".$sibling_array['maiden_name'].")" : '';
	$birth_date	  = format_date($sibling_array['birth_year'],$sibling_array['birth_month'],$sibling_array['birth_day'],'MM/DD/YYYY');
	$birth_loc	  = ($sibling_array['birth_loc']) ? ": ".$sibling_array['birth_loc'] : '';
	$death_date	  = format_date($sibling_array['death_year'],$sibling_array['death_month'],$sibling_array['death_day'],'MM/DD/YYYY');
	$death_loc	  = ($sibling_array['death_loc']) ? ": ".$sibling_array['death_loc'] : '';

        echo "<TR align='left'>
        			<TD style='padding-right:25px; white-space:nowrap;'><a href='/?pg=ft_frame&id=".$sibling_id."'>".$sibling_name.$sibling_maiden."</a></TD>
               <TD style='padding-right:25px; white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Birth: </div>".$birth_date.$birth_loc."</TD>
               <TD style='white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Death: </div>".$death_date.$death_loc."</TD>
              </TR>";
}


echo "<TR><TD colspan=3 style='padding-top:20px;'></TD></TR>
		<TR>
		  <TH align=left colspan=3 style='text-decoration:underline;'>Relationships</TH>
		 </TR>";

//If a relationship doesn't exist, default to N/A
if(count($ft_relation_array) == 0){

	echo "<TR><TD style='font-style:italic;'>N/A</TD></TR>";
}

//Loop through each of the relationships for this member
foreach($ft_relation_array as $partner_id => $relation_array){

	$ft_partner_array = get_member_data($partner_id);
	$partner_name     = $ft_partner_array['first_name']." ".$ft_partner_array['middle_name']." ".$ft_partner_array['last_name']." ".$ft_partner_array['suffix'];
	$partner_maiden   = ($ft_partner_array['maiden_name'] != null) ? " (n&eacute;e ".$ft_partner_array['maiden_name'].")" : '';
	$relation_begin   = ($relation_array['begin_date'] != null) ? $relation_array['begin_date'].": ".$relation_array['begin_loc'] : ' N/A';
	$relation_end     = ($relation_array['end_date'] != null) ? $relation_array['end_date']  : ' N/A';

	echo "<TR align='left'>
          <TD style='padding-right:25px; white-space:nowrap;'><a href='/?pg=ft_frame&id=".$partner_id."'>".$partner_name.$partner_maiden."</a></TD>
			 <TD style='padding-right:25px; white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Married: </div>".$relation_begin."</TD>
			 <TD style='white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Divorced: </div>".$relation_end."</TD>
			</TR>";
}

echo "<TR><TD colspan=3 style='padding-top:20px;'></TD></TR>
		<TR><TH align=left colspan=3 style='text-decoration:underline; margin-top:20px;'>Offspring</TH></TR>";

//If member has no children on file, display N/A
if(count($ft_children_array) == 0){

	echo "<TR><TD style='font-style:italic;'>N/A</TD></TR>";
}

//Loop through each of the children and display them
foreach($ft_children_array as $child_id => $child_array){

	$child_name        = $child_array['first_name']." ".$child_array['middle_name']." ".$child_array['last_name']." ".$child_array['suffix'];
	$child_maiden 	   = ($child_array['maiden_name'] != null) ? " (n&eacute;e ".$ft_partner_array['maiden_name'].")" : '';
        $child_birth       = format_date($child_array['birth_year'],$child_array['birth_month'],$child_array['birth_day'],'MM/DD/YYYY');
        $child_birth_loc   = ($child_array['birth_loc']) ? ": ".$child_array['birth_loc'] : '';
        $child_death       = format_date($child_array['death_year'],$child_array['death_month'],$child_array['death_day'],'MM/DD/YYYY');
        $child_death_loc   = ($child_array['death_loc']) ? ": ".$child_array['death_loc'] : '';


   echo "<TR align='left'>
			 <TD style='padding-right:25px; white-space:nowrap;'><a href='/?pg=ft_frame&id=".$child_id."'>".$child_name.$child_maiden."</a></TD>
          <TD style='padding-right:25px; white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Born: </div> ".$child_birth.$child_birth_loc."</TD>
			 <TD style='white-space:nowrap;'><div style='display:inline; font-weight:bold; font-style:italic;'>Death: </div> ".$child_death.$child_death_loc."</TD>
   		</TR>";
}

echo "</TABLE>
	  </div>";

/*--------------
 * About section
 *--------------*/
echo "<div style='float:left; width:100%; height:100%; margin-top:5px;'>
		 <div style='text-decoration:underline; font-weight:bold; display:inline;'>About/History</div>
		 <div style='margin-top:5px;'>".$ft_members_array['bio']."</div>
      </div>";
echo "</FORM>
		</BODY>
      </HTML>";
?>
