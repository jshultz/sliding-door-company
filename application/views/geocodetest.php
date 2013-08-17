<?php

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
			$address = makegmapa($address);;
		} else {
			return "NO ADDRESS GIVEN";
		}

		if (isset($zipcode)) {
			$zipcode = makegmapa($zipcode);
		} else {
			$zipcode = "";
		}

		if (isset($city)) {
			$city = makegmapa($city);
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
//Use your geocoding function here
	$streetname = "Karlsplatz 13"; //Define the streetname, allowed chars: A-Z,a-z,ä,ö,ü,ß,-,/
	$zipcode = "1040"; //Define your zipcode (optional - leave blank) Remember More details will give you a more accurate result
	$city = "Wien"; //Define your city (optinal - leave blank) Remember More details will give you a more accurate result
	$latlng = geocode($streetname,$zipcode,$city); //Using the Geocodingfunction and save the result in a variable
	echo $latlng; //echo the result

?>