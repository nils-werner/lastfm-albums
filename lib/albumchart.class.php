<?php

require_once('lib/logger.class.php');
require_once('lib/imgrequest.class.php');
require_once('lib/userfeed.class.php');
require_once('lib/albumlist.class.php');
require_once('lib/albumfeed.class.php');
require_once('lib/imggenerator.class.php');
require_once('lib/output.class.php');

/*
 * Albumchart class
 * @author Nils Werner
 * @version 1.0
 *
 * This class wraps everything up
 *
 */
 
class AlbumChart {
	/*
	 * Contstructor
     */
	public function AlbumChart($uri) {
		
		$log = new Logger("./log.txt");
		
		$request = new ImgRequest($uri);

		if($request->isMalformed()) {
			$log->logGeneration($request, $hostid, true);
			$log->logString("   ERROR: " . $request->getMalformedString());
			die($request->getMalformedString() . ((SITE != '') ? "<br />Please see " . SITE . " for further help" : ""));
		}
		
		if($request->getCharttype() == "group") {
			$log->logGeneration($request, $hostid, true);
			$log->logString("   ERROR: Groupcharts disabled");
			die("Groupcharts are no longer supported!");
		}
		
		
		$userfeed = new UserFeed($request->getRawusername(), $request);
				
		$albumlist = new AlbumList();
		
		$i=0;
		while(($album = $userfeed->getNextItem()) && $i < $request->getCount()) {
			$albumfeed = new AlbumFeed($album);
			if(!$albumfeed->isValid()) {
				continue;
			}
			$albumlist->addItem($albumfeed->getImageUrl());
			unset($albumfeed);
			$i++;
		}
		
		$image = new ImgGenerator($albumlist, $request);

		$log->logGeneration($request);
		
		$output = new Output($image, $request);
		
		if($output->getFileExists()) {
			$log->logString("   WARNING: File Existed!");
		}
	}
}
