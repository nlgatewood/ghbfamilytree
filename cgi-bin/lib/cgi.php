<?php

	class Cgi {
	
		/*---------------------------------------------------------
       * CONSTRUCTOR
       *---------------------------------------------------------*/
		function __construct() {
		
		}		

		/*---------------------------------------------------------
       * html_header()
		 *---------------------------------------------------------*/
		function html_header($args = NULL) {

			$event_function = "";
			for($i=0; $i<count($args); $i+=2){

				if($args[$i] == 'onload'){

					$event_function .= $args[$i]."='".$args[$i+1]."'";
				}
			}

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
         		</HEAD>";

         echo "<BODY $event_function>
               <div id='page-wrapper'>";

         echo"<div id='navbar-wrapper'>
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

		}
	}
?>
