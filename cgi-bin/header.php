<?php

	$page = isset($_GET["pg"]) ? $_GET["pg"] : "";
	//$fam = isset($_GET["fam"]) ? $_GET["fam"] : "";
	//$fam_html = "";
	//$fam_desc = "";

	//Determine the Family Description for the link
	//if($fam == ""){

	//	$fam_html = "";
	//	$fam_desc = "Select a Family...";
	//}else{
	//	$fam_html = "?fam=$fam";
	//	$fam_desc = ucfirst($fam);
	//}

	echo "<HTML>
			<HEAD>
    			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
            	<script language='JavaScript' src='/js/lib/jquery-1.11.1.min.js'></script>
               <script language='JavaScript' src='/js/lib/jquery-ui-1.10.3.custom.min.js'></script>
               <script language='JavaScript' src='/js/lib/jquery.cookie.js'></script>
               <script language='JavaScript' src='/js/lib/SigPlusWeb.js'></script>
               <script language='JavaScript' src='/js/lib/lightbox/lightbox.js'></script>
               <script language='JavaScript' src='/js/HeaderMenuBar.js'></script>
               <script language='JavaScript' src='/js/FamilyTree.js'></script>
				<link href='/css/page_layout.css' rel='stylesheet' type='text/css'/>
				<link href='/css/family_tree.css' rel='stylesheet' type='text/css'/>
				<link href='/css/nav_menu.css' rel='stylesheet' type='text/css'/>
				<link href='/css/lightbox/lightbox.css' rel='stylesheet' type='text/css'/>
			</HEAD>
			<BODY style='background-color:222223';>
			 <CENTER>";

	echo "<img class='banner' src='/images/tree_of_life_banner.jpg'>
	      <ul class='navbar'>";

	echo "<li><a class='navbar-link' href='/'>Home</a></li>
	      <li><a class='navbar-link' href='/?pg=origin'>Family Origins</a></li>
	      <li><a class='navbar-link' href='/?pg=history'>Family History</a></li>
	      <li><a class='navbar-link' href='/?pg=tree'>Family Tree</a></li>";

	/*
   echo "<li><a href='javascript:void(0)' onclick='showDropdownMenu()' class='navbar-link dropbtn'>Family Trees 
             <img id='fam-menu-arrow' src='/images/down_arrow_12x12.png'></a>
             <div id='myDropdown' class='dropdown-content'>
             	<a href='/?pg=family_tree&fam=tj'>Thomas Jefferson to Atwell Bowcock</a>
               <a href='/?pg=family_tree&fam=jw'>John Wallace Tree</a>
               <a href='/?pg=family_tree&fam=ca'>Commilus Atwell Tree</a>
               <a href='/?pg=family_tree&fam=cl'>Cornealus Linzy Tree</a>
             </div></li>";
	*/

	echo "	   <li><a class='navbar-link' href='/?pg=about'>About</a></li>
  		   <li><a class='navbar-link' href='/?pg=contact'>Contact</a></li>
		  </ul>";
?>
