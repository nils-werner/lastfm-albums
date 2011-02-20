<?php

/*
 * Album feedfetcher class
 * @author Nils Werner
 * @version 1.0
 *
 * This class accepts either Musicbrainz IDs or URLs to images.
 * When handed a mbid, the class fetches the information to that album from Last.fm.
 * When handed an URL, it will simply return it.
 *
 */

class AlbumFeed {
	private $blacklist = array(
				"http://static.last.fm/depth/catalogue/noimage/cover_large.gif",
				"http://static.last.fm/depth/catalogue/noimage/cover_med.gif",
				"http://static.last.fm/matt/noalbum_medium.gif",
				"http://static.last.fm/depth/catalogue/no_album_large.gif",
				"http://panther1.last.fm/depth/catalogue/noimage/cover_large.gif",
				"http://panther1.last.fm/depth/catalogue/noimage/cover_med.gif",
				"http://cdn.last.fm/depth/catalogue/noimage/cover_85px.gif",
				"http://cdn.last.fm/depth/catalogue/noimage/cover_med.gif",
				"http://cdn.last.fm/depth/catalogue/noimage/cover_large.gif",
				"http://cdn.last.fm/flatness/catalogue/noimage/2/default_album_small.png",
				"http://cdn.last.fm/flatness/catalogue/noimage/2/default_album_medium.png",
				"http://cdn.last.fm/flatness/catalogue/noimage/2/default_album_large.png",
                "");
	
	
	public function AlbumFeed($mbid) {
		if(substr_count($mbid, "http://") > 0) {
			$this->url = $mbid;
		}
		else {
			if($mbid == "") {
				$this->xml = FALSE;
				return;
			}
			$this->mbid = $mbid;
	
			$this->fetchFeed();
			$this->fetchImageURL();
		}
	}
	
	private function fetchFeed() {
		$url = "http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=" . API_KEY . "&mbid=" . $this->mbid;
		$this->xml = @simplexml_load_file($url);
	}
	
	public function fetchImageURL() {
		$array = $this->xml->xpath("album/image[@size='medium']");
		$this->url =  (string) $array[0];
	}
		
	public function getImageURL() {
		return $this->url;
	}
		
	public function getMbid() {
		return $this->mbid;
	}
	
	public function isValid() {
		if($this->xml === FALSE || in_array($this->url, $this->blacklist))
			return false;
		else
			return true;
	}
}
