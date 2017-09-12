
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';

include('header.php');

echo "<FORM method=post action='/?pg=about'>
      	<p>I will update the about page shortly.</p>
      </div>";
		
echo "</FORM>";

include('footer.php');
?>
