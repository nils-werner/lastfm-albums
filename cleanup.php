<?php 

	require_once("defines.php");
	
	if(KEY == '' || $_GET['key'] != KEY) {
		header("Location: /");
		die();
	}
	
	$subdirs = array(	'overall' => 21,
						'3month' => 21,
						'6month' => 21,
						'12month' => 21,
						'weekly' => 7,
						'group' =>7
					);
	$imagedir = "./images/";
	
	echo "<h2>" . $_SERVER['SERVER_NAME'] . "</h2>";
	echo "Cleanup on " . date("D M j G:i:s T Y");
	
	foreach($subdirs AS $subdir => $days) {
		echo "<h3>" . $subdir . "</h3><br />";
		$handle=opendir($imagedir . $subdir . "/");
		while ($file = readdir($handle)) {
			if($file != ".." && $file != "." && (filemtime($imagedir . $subdir . "/" . $file) < (time()-(60*60*24*$days)))) {
				if(isset($_GET['simulate']) || unlink($imagedir . $subdir . "/" . $file))
					echo "deleted: " . $imagedir . $subdir . "/" . $file . "<br />";
			}
		}
		closedir($handle);
	}

