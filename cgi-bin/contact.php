
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$fam = isset($_GET["fam"]) ? $_GET["fam"] : '';

include('header.php');

echo "<FORM method=post action='/?pg=contact'>
      	<p>I will update the Contact page shortly.</p>";

echo "</FORM>";

include('footer.php');
?>
