<?php

/*
 * Image request URI helper class
 * @author Nils Werner
 * @version 1.0
 *
 * This class takes a typical request URI and analyzes its parts.
 *
 */

class ImgRequest {
	private $malformed = FALSE, $defaultsize = FALSE;
	
	public function ImgRequest($uri) {
		$types = array(
						"weekly",
						"group",
						"3month",
						"6month",
						"12month"
						);
		$this->startTime = microtime(true);
		$this->uri = $uri;
		/* Explode path into segments */
		$paths = explode("/",$uri);
		$paths = array_values(array_diff($paths, array("")));


		/* Just username was provided */		
		if(count($paths) == 1) {
			$this->charttype = "overall";
			$this->size = "10x2";
			$this->defaultsize = TRUE;
			$this->rawusername = $paths[0];
		}
		
		/* Size or type followed by username */
		if(count($paths) == 2) {
			if(in_array($paths[0], $types)) {
				$this->charttype = $paths[0];
				$this->size = "10x2";
				$this->defaultsize = true;
				$this->rawusername = $paths[1];
			}
			elseif(preg_match("/^\d+x\d+$/", $paths[0])) {
				$this->charttype = "overall";
				$this->size = $paths[0];
				$this->rawusername = $paths[1];
			}
			else {
				$this->malformed = TRUE;
				$this->malformedString = "URL malformed (type and username or size and username given)!";
			}
		}
								
		/* Type, Size and Username (in that order) */
		if(count($paths) == 3) {
			if(in_array($paths[0], $types) && preg_match("/^\d+x\d+$/", $paths[1])) {
				$this->charttype = $paths[0];
				$this->size = $paths[1];
				$this->rawusername = $paths[2];
			}
			else {
				$this->malformed = TRUE;
				$this->malformedString = "URL malformed (type, size and username given)!";
			}
		}
		
		if(count($paths) > 3) {
			$this->malformed = TRUE;
			$this->malformedString = "URL malformed (4 or more arguments given)!";
		}
		
		$this->rawusername = str_replace(array(".jpeg",".jpg",".gif",".png"), "", $this->rawusername);
		
		$this->extension = "jpeg";
		
		$this->username = urldecode($this->rawusername);
		
		$sizes = explode("x",$this->size);
		$cols = intval($sizes[0]);
		$rows = intval($sizes[1]);
		
		if(!$this->isAllowed()) {
			$this->malformed = TRUE;
			$this->malformedString = "User not allowed here";
		}
		
		if($cols * $rows < 0 || $cols < 1 || $rows < 1) {
			$rows = 2;
			$cols = 10;
		}
	
		if($cols * $rows > 30 && !$this->isSuperuser()) {
			$this->malformed = TRUE;
			$this->malformedString = "URL malformed (size exceeds 30 albums)!";
		}
			
		//$this->size = $cols . "x" . $rows;
		
		if(isset($_GET['pixels']))
			$pixels = min(200,intval($_GET['pixels']));
		else
			$pixels = 50;
	
		if(isset($_GET['spacing']))
			$spacing = min(20,intval($_GET['spacing']));
		else
			$spacing = 0;
		
		if(isset($_GET['bgcolor']))
			$bgcolor = sscanf($_GET['bgcolor'], '%2x%2x%2x');
			
		$this->pixels = $pixels;
		$this->spacing = $spacing;
		$this->bgcolor = $bgcolor;
		
		$this->rows = $rows;
		$this->cols = $cols;
		$this->count = $rows*$cols;
	}
	
	public function getUsername() {
		return $this->username;
	}
	
	public function getRawusername() {
		return $this->rawusername;
	}
	
	public function isSuperuser() {
		if(is_null(SUPERUSER)) return false;
		
		return in_array($this->username, SUPERUSERS);		
	}
	
	public function isBanned() {
		if(is_null(BLACKLIST)) return false;
		
		return in_array($this->username, BLACKLIST);	
	}
	
	public function isAllowed() {
		if(is_null(WHITELIST)) return !$this->isBanned();
		
		return in_array($this->username, WHITELIST);	
	}
	
	public function getExtension() {
		return $this->extension;
	}
	
	public function getCharttype() {
		return $this->charttype;
	}
	
	public function getSize() {
		if($this->defaultsize == FALSE)
			return $this->size;
		else
			return "";
	}
	
	public function getRawsize() {
		return $this->size;
	}
	
	public function getRows() {
		return $this->rows;
	}
	
	public function getCols() {
		return $this->cols;
	}
	
	public function getCount() {
		return $this->count;
	}
	
	public function getPixels() {
		return $this->pixels;
	}
	
	public function getSpacing() {
		return $this->spacing;
	}
	
	public function getBgColor() {
		return $this->bgcolor;
	}
	
	public function getExecutionTime() {
		return microtime(true) - $this->startTime;
	}
	
	public function getTime() {
		return date("r");
	}
	
	public function isMalformed() {
		return $this->malformed;
	}
	
	public function getMalformedString() {
		if($this->malformed)
			return $this->malformedString;
		else
			return false;
	}
	
	public function getUri() {
		return $this->uri;
	}
	
	
}

?>
