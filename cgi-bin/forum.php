
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';
$fam = isset($_GET["fam"]) ? $_GET["fam"] : '';

include('header.php');

echo "<FORM method=post action='/?pg=forum'>";

echo "<div id='forum-wrapper'>
			<iframe src='/phpBB3/index.php' id='forum-frame'></iframe>
		</div>";


echo "</FORM>";

include('footer.php');
?>
