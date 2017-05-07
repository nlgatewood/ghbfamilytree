<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : "";

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
			<link href='/css/lightbox/lightbox.css' rel='stylesheet' type='text/css'/>
		</HEAD>
		<BODY".(($body_event) ? " ".$body_event : "").">
		 <div id='page-wrapper'>

		  <div id='navbar-wrapper'>
			<img id='banner' src='/images/tree_of_life_banner.jpg'>
	     	<ul id='navbar'>
			 <li><a href='/'>Home</a></li>
	       <li><a href='/?pg=origin'>Family Origins</a></li>
	       <li><a href='/?pg=history'>Family History</a></li>
	       <li><a href='/?pg=tree'>Family Tree</a></li>
			 <li><a href='/?pg=about'>About</a></li>
  		    <li><a href='/?pg=contact'>Contact</a></li>
			</ul>
		  </div>";
?>
