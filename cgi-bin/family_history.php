
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
//$fam = isset($_GET["fam"]) ? $_GET["fam"] : '';

include('header.php');

echo "<FORM method=post action='/'>";

echo" <div class='panel'>
      	<div class='panel-heading'>
         	<h1 class='panel-title'>Welcome to the Gatewood Timeline Page!</h1>
         </div>
      	<div class='panel-text'>
      		<p style='text-align:left;'>The Gatewood Timeline page is currently under construction.</p>
      	</div>
      </div>";

echo "</FORM>";

include('footer.php');
?>
