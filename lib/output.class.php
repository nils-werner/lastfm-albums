<?php

/*
 * Output helper class
 * @author Nils Werner
 * @version 1.0
 *
 * This class saves and outputs a previously with ImgGenerator generated image
 *
 */

class Output {
	private $quality = 90;
	private $fileExists = false;
	
	public function Output($image, $request) {
		$this->request = $request;
		
		$this->saveImageToDisk($image);
		$this->sendImage($image);
	}
	
	private function saveImageToDisk($image) {
		if(substr_count($this->request->getRawusername(), '+'))
			$username = $this->request->getRawusername();
		else
			$username = $this->request->getUsername();
			
		$filename = $this->getDirectory($this->request->getCharttype()) . $username . "_" . $this->request->getSize() . "." . $this->request->getExtension();
		
		if(file_exists($filename)) {
			$this->fileExists = true;
		}
		
		imagejpeg($image->getImageHandle(), $filename, $this->quality);
		@chmod($filename, 0777);
	}
	
	private function sendImage($image) {
		header ("Content-type: image/" . $this->request->getExtension());
		header ("X-New: true");
		imagejpeg($image->getImageHandle(), NULL, $this->quality);
	}

	
	private function getDirectory($charttype) {
		switch($charttype) {
			case "group":
				$imagedir = "./images/group/";
				break;
			case "3month":
			case "6month":
			case "12month":
			case "weekly":
				$imagedir = "./images/" . $charttype . "/";
				break;
			default:
				$imagedir = "./images/overall/";
		}
		
		return $imagedir;
	}
	
	public function getFileExists() {
		return $this->fileExists;
	}
}