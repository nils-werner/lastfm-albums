<?php

/*
 * Image generator class
 * @author Nils Werner
 * @version 1.0
 *
 * This class generates a album chart image from an albumlist.
 *
 */

class ImgGenerator {
	private $images = 0;
	
	public function ImgGenerator($albumlist, $request) {
		$this->albumlist = $albumlist;
		
		$this->cols = $request->getCols();
		$this->rows = $request->getRows();
		$this->pixels = $request->getPixels();
		$this->spacing = $request->getSpacing();
		$this->bgcolor = $request->getBgColor();
		
		$this->createImage();
		while($this->images <= $request->getCount()) {
			$this->addImage("./lib/blank.png");
		}
		$this->images=0;
		
		while($album = $albumlist->getNextItem()) {
			$this->addImage($album);
		}
		
	}
	
	private function addImage($albumurl) {
		list($width, $height, $type) = getimagesize($albumurl);
		
		$albumimage = imagecreatetruecolor($this->pixels, $this->pixels);
		
		if($type == 1)
			$lastfmimage = imagecreatefromgif($albumurl);
		if($type == 2)
			$lastfmimage = imagecreatefromjpeg($albumurl);
		if($type == 3)
			$lastfmimage = imagecreatefrompng($albumurl);
			
		if($lastfmimage) {
			$ypos = ($this->images%$this->cols)*$this->pixels+($this->images%$this->cols)*$this->spacing;
			$xpos = intval($this->images/$this->cols)*$this->pixels+intval($this->images/$this->cols)*$this->spacing;
			
			imagecopyresampled($albumimage, $lastfmimage, 0, 0, 0, 0, $this->pixels, $this->pixels, $width, $height);
			imagedestroy($lastfmimage);
			imagecopymerge($this->image, $albumimage, $ypos, $xpos, 0, 0, $this->pixels, $this->pixels, 100);
			imagedestroy($albumimage);
			
			$this->images++;
		}
	}
	
	private function createImage() {
		$this->image = @imagecreatetruecolor(($this->cols*$this->pixels)+($this->cols-1)*$this->spacing, ($this->rows*$this->pixels)+($this->rows-1)*$this->spacing)
		or die("Cannot Initialize new GD image stream");

		$bgcoloralloc = imagecolorallocate($this->image , $this->bgcolor[0], $this->bgcolor[1], $this->bgcolor[2]);
		imagefill($this->image, 0, 0, $bgcoloralloc);
	}
	
	public function getImageHandle() {
		return $this->image;
	}
}