
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$fam = isset($_GET["fam"]) ? $_GET["fam"] : '';

include('header.php');

echo "<FORM method=post action='/'>";

echo" <div class='panel'>
      	<div class='panel-heading'>
         	<h1 class='panel-title'>Welcome to the Gatewood Home Page!</h1>
         </div>
         <div class='panel-text'>
        		<p style='text-align:left;'>The Gatewood Ancestry website is currently under construction.  I really hope to have this website up at 90% before the end of Summer 2017.  Most of my information comes from a family book of ancestry written by Gordon Jefferson Gatewood.  While it's a great resource, the book was published in 1981 and needs to be updated.  Many people listed in the book have since died or have children of their own.  
Also, the author never had the luxury of Google.  He spent years traveling across the country to different courhouses and other facilities gathering information.  There may have been details he missed simply because it wasn't readily available to him.  I'm hoping my research can fill in some of the gaps.  I am in awe of the work he did and the time he put into his research.</p>
         </div>
      </div>";

echo "</FORM>";

include('footer.php');
?>
