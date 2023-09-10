<?php
	
	function getActuallyDate(){
		return date("h:i:s j-m-Y");
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
		else if($difference >= 86400 && $difference < 2635200){
			return abs(round($difference / 86400))."j";
		}else{
			return "error";
		}
	}

	function dateDiffActually($dateStart){
		return dateDiffBetween($dateStart, getActuallyDate());
	}

?>