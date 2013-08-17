<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 8/16/13
 * Time: 7:22 PM
 */

class Geocodeit {

	function makegmapa($text){ //preparing the variables
		$text = trim($text);
		$text = str_replace(" ", "+", $text);
		$text = str_replace("ü","ue",$text);
		$text = str_replace("Ü","Ue",$text);
		$text = str_replace("ö","oe",$text);
		$text = str_replace("Ö","Oe",$text);
		$text = str_replace("ä","ae",$text);
		$text = str_replace("Ä","Ae",$text);
		$text = str_replace("ß","ss",$text);
		$clean = preg_replace("#[^A-Za-z0-9\+\-\/]#", "", "$text");

		return $clean;
	}
	function geocode($address,$zipcode,$city) { //main function
		if (isset($address)) {
			$address = $this->makegmapa($address);
		} else {
			return "NO ADDRESS GIVEN";
		}

		if (isset($zipcode)) {
			$zipcode = $this->makegmapa($zipcode);
		} else {
			$zipcode = "";
		}

		if (isset($city)) {
			$city = $this->makegmapa($city);
		} else {
			$city = "";
		}

		$search = "$address+$city+$zipcode";
		$url="http://maps.googleapis.com/maps/api/geocode/json?address=$search&sensor=false";
		$json = file_get_contents($url);
		$array = json_decode($json,true);
		$status = $array['status'];

		if ($status == true) {
			$lat = $array['results']['0']['geometry']['location']['lat'];
			$lng = $array['results']['0']['geometry']['location']['lng'];

			$latlng = "$lat,$lng";

			return $latlng;
		} else {
			return "Couldn't convert address";
		}

	}

} 