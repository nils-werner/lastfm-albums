<?php

require_once("defines.php");

if(API_KEY == '' || SECRET == '' || KEY == '')
	die("Vital configuration-settings are missing!");

require_once("lib/albumchart.class.php");

$chart = new AlbumChart($_SERVER['REQUEST_URI']);
