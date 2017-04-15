
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';

include('header.php');

echo "<FORM method=post action='/?pg=about'>
      <div class='panel'>
         <div class='panel-heading'>
            <h1 class='page-title'>Welcome to the about page!</h1>
         </div>
         <div class='page-text'>
            <p style='text-align:left;'>I will update the about page shortly.</p>
         </div>
      </div>";
		
echo "</FORM>";

include('footer.php');
?>
