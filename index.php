<?php

require_once("defines.php");

if(SITE != '') {
	header ("Location: " . SITE);
	die();
}

?>
No parameters given.
