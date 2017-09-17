
<?php

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';

include('header.php');

echo "<FORM method=post action='/'>";

echo"<div class='page-text'>

<h1>Welcome to the Gatewood Family Tree Project!</h1>

<a href='images/family_collage.jpg' data-lightbox='image-1' data-title='My caption'>
<img src='images/family_collage.jpg' style='width:700px; height:auto; margin-top:30px; margin-bottom:30px;'></a>

<p>This Gatewood Ancestry website is currently under construction.  I really hope to have this website up at 90% before the end of Summer 2017.  Most of my information comes from a family book of ancestry written by Gordon Jefferson Gatewood.  While it's a great resource, the book was published in 1981 and needs to be updated.  Many people listed in the book have since died or have children of their own.  
Also, the author never had the luxury of Google.  He spent years traveling across the country to different courhouses and other facilities gathering information.  There may have been details he missed simply because it wasn't readily available to him.  I'm hoping my research can fill in some of the gaps.  I am in awe of the work he did and the time he put into his research.</p>
     </div>";

echo "</FORM>";

include('footer.php');
?>
