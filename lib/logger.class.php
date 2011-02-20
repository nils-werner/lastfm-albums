<?php

/*
 * Logger class
 * @author Nils Werner
 * @version 1.0
 *
 * This class logs events for the lastfm album image generator
 *
 */
 
class Logger {
	/*
	 * Contstructor
     */
     public function Logger($filename) {
     	$this->filename = $filename;
     }
     
     public function logGeneration($request, $override = false) {
     	$string = "[" . $request->getTime() . "] Generating " . $request->getUri() . ": " . $request->getExecutionTime() . " Seconds";
     	if(DEBUG_LOG == true || $override == true) {
     		$this->logString($string);
 		}
	}
	
     public function logRedirect($request, $hostid, $override = false) {
     	$string = "[" . $request->getTime() . "] Redirecting to id " . $hostid . ": " . $request->getUri() . ": " . $request->getExecutionTime() . " Seconds";
		if(DEBUG_LOG == true || $override == true) {
     		$this->logString($string);
 		}
	}
	
	public function logString($string) {
		if(DEBUG_LOG == true || ERROR_LOG == true) {
			@file_put_contents($this->filename, $string . "\n", FILE_APPEND);
		}
	}
     
       
}