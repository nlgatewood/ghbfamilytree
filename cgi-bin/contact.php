
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$fam = isset($_GET["fam"]) ? $_GET["fam"] : '';

include('header.php');

echo "<FORM method=post action='/?pg=contact'>
      <div class='panel'>
         <div class='panel-heading'>
            <h1 class='panel-title'>Welcome to the contact page!</h1>
         </div>
         <div class='panel-text'>
            <p style='text-align:left;'>I will update the Contact page shortly.</p>
         </div>
      </div>";

echo "</FORM>";

include('footer.php');
?>
