<?php

	function getActuallyDate(){
		date_default_timezone_set('Europe/Paris');
		return date("H:i:s d-m-Y");
	}

	function dateDiffBetweenNumber($dateStart, $dateEnd){
		return abs(strtotime($dateEnd) - strtotime($dateStart));
	}

	function dateDiffBetween($dateStart, $dateEnd){
		$difference = abs(strtotime($dateEnd) - strtotime($dateStart));

		if($difference < 60){
			return abs($difference)."s";
		}
		else if($difference >= 60 && $difference < 3600){
			return abs(round($difference / 60))."m";
		}
		else if($difference >= 3600 && $difference < 86400){
			return abs(round($difference / 3600))."h";
		}
		else if($difference >= 86400 && $difference < 604800){
			return abs(round($difference / 86400))."j";
		}
		else if($difference >= 604800) {
			return abs(round($difference / 604800))."S";
		}
	}
	
	function dateDiffActually($dateStart){
		return dateDiffBetween($dateStart, getActuallyDate());
	}

	function inLength($text, $maxLength){
		return strlen($text) <= $maxLength;
	}

	function isEmpty($variable){
		if(isset($variable) || strlen($variable) > 0){
			return false;
		}

		return true;
	}

	function addParameterToUrl(string $url, string $param, string $value){
		$getParameterNumber = count(array_keys($_GET));

		if(!isset($_GET[$param])){
			if($getParameterNumber > 0){
				$url .= "&".$param."=".$value;
			}
			else{
				$url .= "?".$param."=".$value;
			}
		}
		else{
			$getParam = $_GET;
			$getParam[$param] = $value;
			$url = $_SERVER['PHP_SELF'] . '?' . http_build_query($getParam);
		}

	    return $url;
	}

?>