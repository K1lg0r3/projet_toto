<?php

require dirname(dirname(__FILE__))."/inc/config.php";
require dirname(dirname(__FILE__))."/inc/functions.php";
require dirname(dirname(__FILE__))."/view/header.php";

if (session_destroy()) {
	header("location: http://kilgore.dev/index.php");
}
else {
	echo "Problem signing out";
}

require dirname(dirname(__FILE__))."/view/signin.php";
require dirname(dirname(__FILE__))."/view/footer.php";

?>