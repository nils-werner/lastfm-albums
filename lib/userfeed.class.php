<?php

/*
 * User feed fetcher class
 * @author Nils Werner
 * @version 1.0
 *
 * This class fetches a Last.fm profile feed
 *
 */

class UserFeed {
	private $albums = array();
	
	public function UserFeed($username, $request) {
		$this->request = $request;
		$this->fetchFeed($username);
		
		if($request->getCharttype() != "group") {
			foreach($this->xml->topalbums->album as $value){
				$this->addItem((string) $value->image[1]);
			}
		}
		else {
			foreach($this->xml->weeklyalbumchart->album as $value){ 
				$this->addItem($value->mbid);
			}
		}
	}
	
	
	private function addItem($value) {
		if($value != "")
			array_push($this->albums, $value);
	}
	
	public function getNextItem() {
		$return = array_shift($this->albums);
		if($return === NULL)
			return FALSE;
		else
			return $return;
	}
	
	
	private function fetchFeed($username) {
		$this->xml = @simplexml_load_file($this->getUrl($this->request->getCharttype(), $username))
			or die("An error occured while trying to fetch album data for user/group " . $username . "!");
		return $xml;
	}
	
	private function getURL($charttype, $username) {
		switch($charttype) {
			case "weekly":
				$url="http://ws.audioscrobbler.com/2.0/?method=user.gettopalbums&user=" . $username . "&api_key=" . API_KEY . "&period=7day";
				break;
			case "group":
				$url="http://ws.audioscrobbler.com/2.0/?method=group.getweeklyalbumchart&group=" . $username . "&api_key=" . API_KEY . "";
				break;
			case "3month":
			case "6month":
			case "12month":
				$url="http://ws.audioscrobbler.com/2.0/?method=user.gettopalbums&user=" . $username . "&api_key=" . API_KEY . "&period=" . $charttype;
				break;
			default:
				$url="http://ws.audioscrobbler.com/2.0/?method=user.gettopalbums&user=" . $username . "&api_key=" . API_KEY . "";
		}
		return $url;
	}
}

