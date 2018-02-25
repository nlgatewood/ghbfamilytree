<?php

include("cgi-bin/lib/config.php");
	
$config_obj = new config();
$CONFIG = $config_obj->get_config_file();

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';

//Go to the page that was selected
if($page == "home" || $page == ""){

	include("./cgi-bin/home.php");

}elseif($page == "family_origin"){

	include("./cgi-bin/family_origin.php");
}
elseif($page == "family_history"){

	include("./cgi-bin/family_history.php");
}
elseif($page == "family_tree"){

	include("./cgi-bin/family_tree.php");
}
elseif($page == "profile"){

	include("./cgi-bin/profile.php");
}
elseif($page == "forum"){

   include("./cgi-bin/forum.php");
}
elseif($page == "about"){

	include("./cgi-bin/about.php");
}
elseif($page == "profile_edit"){

	include("./cgi-bin/profile_edit.php");
}
elseif($page == "upload_profile_image"){

	include("./cgi-bin/upload_profile_image.php");
}
else{
	include("./cgi-bin/not_found.php");
}

?>
