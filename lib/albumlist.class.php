<?php

/*
 * Album list class
 * @author Nils Werner
 * @version 1.0
 *
 * This class is a list for album image URLs. It provides simple addItem- and getNextItem-operations.
 *
 */

class AlbumList {
	private $list = array();
	
	public function AlbumList() {
	}
	
	public function addItem($value) {
		array_push($this->list, $value);
	}
	
	public function getNextItem() {
		$return = array_shift($this->list);
		if($return === NULL)
			return FALSE;
		else
			return $return;
	}
}