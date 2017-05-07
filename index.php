<?php

include("cgi-bin/lib/config.php");
	
$config_obj = new config();
$CONFIG = $config_obj->get_config_file();

$page = isset($_GET["pg"]) ? $_GET["pg"] : '';

if($page == "origin"){

	include("./cgi-bin/family_origin.php");
}
elseif($page == "history"){

	include("./cgi-bin/family_history.php");
}
elseif($page == "tree"){

	include("./cgi-bin/family_tree.php");
}
elseif($page == "ft_frame"){

	include("./cgi-bin/ft_frame.php");
}
elseif($page == "about"){

	include("./cgi-bin/about.php");
}
elseif($page == "contact"){

	include("./cgi-bin/contact.php");

}elseif($page == "family_tree_edit"){

	include("./cgi-bin/family_tree_edit.php");
}else{
	include("./cgi-bin/home.php");
}

?>
