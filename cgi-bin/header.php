<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : "";
$body_event = isset($body_event) ? $body_event : "";

echo "
	<!DOCTYPE html>
	<HTML lang='en'>
		<HEAD>
   		<meta charset='UTF-8'>
         <script language='JavaScript' src='/js/lib/jquery-1.11.1.min.js'></script>
         <script language='JavaScript' src='/js/lib/jquery-ui-1.10.3.custom.min.js'></script>
         <script language='JavaScript' src='/js/lib/jquery.cookie.js'></script>
         <script language='JavaScript' src='/js/lib/SigPlusWeb.js'></script>
         <script language='JavaScript' src='/js/lib/lightbox/lightbox.js'></script>
         <script language='JavaScript' src='/js/HeaderMenuBar.js'></script>
         <script language='JavaScript' src='/js/FamilyTree.js'></script>
			<link href='/css/page_layout.css' rel='stylesheet'>
			<link href='/css/family_tree.css' rel='stylesheet'>
			<link href='/css/lightbox/lightbox.css' rel='stylesheet'>
		</HEAD>
		<BODY".(($body_event) ? " ".$body_event : "").">

			<div id='navbar-wrapper'>
				<img id='banner' src='/images/tree_of_life_banner.jpg'>
				<ul id='navbar'>
					<li><a href='/'>Home</a></li>
					<li><a href='/?pg=family_origin'>Family Origins</a></li>
					<li><a href='/?pg=family_history'>Family History</a></li>
					<li><a href='/?pg=family_tree'>Family Search</a></li>
					<li><a href='/?pg=about'>About</a></li>
					<li><a href='/?pg=contact'>Contact</a></li>
				</ul>
		   </div>

		   <div id='page-wrapper'>";
?>
