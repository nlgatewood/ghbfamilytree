
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';

include('header.php');

echo "<FORM method=post action='/'>";

echo"<div class='page-text'>

		<h1>404: Page Not Found</h1>

     </div>";

echo "</FORM>";

include('footer.php');
?>
