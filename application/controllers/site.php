<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/site
	 *    - or -
	 *        http://example.com/index.php/site/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();

		$this->load->library('phpmailer');

	}

	/* This Does Nothing except prove the site can load */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	/* This is how new contacts get entered into the system. It's looking for
	these post variables */
	public function new_contact()
	{

		$query_string = "";

		if (isset($_GET) || isset($_POST)) {

			$firstName = $this->input->get_post('FirstName', TRUE);
			$lastName = $this->input->get_post('LastName', TRUE);
			$address = $this->input->get_post('Address', TRUE);
			$state = $this->input->get_post('State', TRUE);
			$zip = $this->input->get_post('Zip', TRUE);
			$phone = $this->input->get_post('Phone', TRUE);
			$email = $this->input->get_post('Email', TRUE);
			$source = $this->input->get_post('Source', TRUE);
			$estimateStyle = $this->input->get_post('estimateStyle', TRUE);
			$estimateSize = $this->input->get_post('estimateSize', TRUE);
			$estimatePanels = $this->input->get_post('estimatePanels', TRUE);
			$cost = $this->input->get_post('cost', TRUE);
			$city = '';

			$latlng = $this->geocodeit->geocode($address, $city, $zip);
			$pieces = explode(",", $latlng);
			$lat = $pieces[0];
			$lng = $pieces[1];

			/* This is is the function in the model that inserts records into the database */
			$this->Clients_model->create_client($firstName, $lastName, $address, $state, $zip, $phone, $email, $source, $lat, $lng, $estimateStyle, $estimateSize, $estimatePanels, $cost);

		}

	}

	/* This is the function that sends the emails. It get's triggered by a cron job and typically
	runs every 10 minutes. */
	public function email_contact()
	{



		date_default_timezone_set('America/Los_Angeles');

		$people = $this->Clients_model->email_client();

		if ($people == NULL) {
			/* If the above returns no results (for example the database is empty) we end up here. */
			echo 'no recipeints';
		} else {
			/* If there are people in the database then this is where we are. */

			foreach ($people as $key => $row) {

				/* For every person in the table, we'll loop through them here. */

				if (is_array($row)) {

					foreach ($row as $x) {

						$firstName = $x['FirstName'];
						$lastName = $x['LastName'];
						$address = str_replace('+', " ", $x['Address']);
						$state = $x['State'];
						$zip = $x['Zip'];
						$phone = $x['Phone'];
						$cust_email = $x['Email'];
						$key = $x['Key'];
						$source = $x['Source'];
						$emailLevel = $x['EmailLevel'];
						$lastSent = $x['lastSent'];
						$estimateStyle = str_replace('+', " ", $x['estimateStyle']);
						$estimateSize = str_replace('\\"', '"', $x['estimateSize']);
						$estimatePanels = $x['estimatePanels'];
						$price = $x['cost'];

						$lat = $x['lat'];
						$lng = $x['lng'];

						/* We'll now check the locations table to find the closest store location to them. */

						$location = $this->Location_model->getClosetLocation($lat, $lng, $zip);

						/* Now let's see how long it's been since we emailed this person. */


						$date1 = new DateTime("now");
						$date2 = new DateTime($lastSent);

						$interval = $date2->diff($date1);
						$timePassed = $interval->format('%R%a');

						if (($lastSent == '0000-00-00') || ($timePassed > 7) || ($lastSent == NULL)) {



							$mail = new PHPMailer;

							/* If they are a new recipient, or it's been more then 7 days, we send an email. */

							$fullname = $firstName . ' ' . $lastName;

							$data['firstname'] = $firstName;
							$data['lastname'] = $lastName;
							$data['cust_email'] = $cust_email;
							$data['key'] = $key;

							$data['style'] = $estimateStyle;
							$data['size'] = $estimateSize;
							$data['panels'] = $estimatePanels;
							$data['price'] = $price;

							echo '<p><strong>' . $fullname . '</strong></p>';

							if ($location == null) {
								$data['nolocation'] = '1';
								$data['email'] = 'contact@slidingdoorco.com';
							} else {
								$data['nolocation'] = '0';

								$foreachLoop = (is_object($location)) ? $location->result_array() : $location;

								$data['location_array'] = $location;

								foreach ($foreachLoop as $place) {

									$data['maplink'] = $place['map_link'];
									$data['location'] = $place['location'];
									$data['address'] = $place['address'];
									$data['city'] = $place['city'];
									$data['state'] = $place['state'];
									$data['zip'] = $place['zip'];
									$data['telephone'] = $place['telephone'];
									$data['email'] = $place['email'];
								}

							}


							/* Based on how many times they have been emailed we pick what email to send them. */

							switch ($emailLevel) {
								case 0:
									$subject = 'Thank You For Signing Up';
									$data['special'] = '0';
									$data['message'] = "<p>Thank you for designing your beautiful new closet doors with us. Your next step is sharing the specs of your custom order with the showroom below for more detailed pricing and options.</p>";

									break;
								case 1:
									$subject = 'Thank You From The Sliding Door Company';
									$data['special'] = '0';
									if ($location == null) {
										$data['message'] = '<p>Thank you for designing your beautiful new closet doors with us. Your next step is sharing the specs of your custom order with the showroom below for more detailed pricing and options.</p>';
									} else {
										$data['message'] = "<p>You're invited to our " . $place['city'] . "showroom for a free personalized
											consultation! You'll get one-on-one assistance from our trained experts and a
											first-hand look at your material options.</p>";
									}

									break;
								case 2:
									$subject = 'Here is something special from The Sliding Door Company!';
									$data['special'] = '1';
									if ($location == null) {
										$data['message'] = "<p>Schedule a consultation with our showroom headquarters before " . date('Y-m-d', strtotime("+30 days")) . " to take advantage of this one-time offer!</p>";
									} else {
										$data['message'] = "<p>You’re invited to our " . $place['city'] . " showroom for a free personalized
											consultation! You’ll get one-on-one assistance from our trained experts and a
											first-hand look at your material options.</p>";
									}

									break;
							}

							$body = $this->load->view('email/email-one', $data, TRUE);

							$this->phpmailer->AddAddress($cust_email);

							$this->phpmailer->IsMail();

							$this->phpmailer->From = 'contact@slidingdoorco.com';

							$this->phpmailer->FromName = 'Sliding Door Company';

							$this->phpmailer->IsHTML(true);

							$this->phpmailer->Subject = $subject;

							$this->phpmailer->Body = $body;

							$this->phpmailer->Send();

							$this->Clients_model->updateCount($cust_email);

							$this->Clients_model->updateDate($cust_email);

						}

					}

				}


			}

		}

	}

	public function email_store()
	{

		date_default_timezone_set('America/Los_Angeles');

		if (isset($_GET) || isset($_POST)) {

			$store_email = $this->input->get_post('store_email', TRUE);
			$location = $this->input->get_post('location', TRUE);
			$fullname = $this->input->get_post('fullname', TRUE);
			$zip = $this->input->get_post('zip', TRUE);
			$phone = $this->input->get_post('phone', TRUE);
			$cust_email = $this->input->get_post('cust_email', TRUE);
			$comments = $this->input->get_post('comments', TRUE);
			$date = $this->input->get_post('date', TRUE);
			$time = $this->input->get_post('time', TRUE);
			$style = $this->input->get_post('style', TRUE);
			$size = $this->input->get_post('size', TRUE);
			$panels = $this->input->get_post('panels', TRUE);
			$price = $this->input->get_post('price', TRUE);
			$discount_price = $this->input->get_post('discountprice', TRUE);
			$nolocation = $this->input->get_post('nolocation', TRUE);
		}

		$message = 'A Consultation Request has been received for the following customer: ';

		$message .= '<p>Full Name: ' . $fullname . '</p>';
		$message .= '<p>Zip: ' . $zip . '</p>';
		$message .= '<p>Phone: ' . $phone . '</p>';
		$message .= '<p>Customer Email: ' . $cust_email . '</p>';
		$message .= '<p>Comments: ' . $comments . '</p>';
		$message .= 'vRequested Date: ' . $date . '</p>';
		$message .= '<p>Requested Time: ' . $time . '</p>';
		$message .= '<p>Style: ' . $style . '</p>';
		$message .= '<p>Size: ' . $size . '</p>';
		$message .= '<p>Panels: ' . $panels . '</p>';
		$message .= '<p>Price: ' . $price . '</p>';
		$message .= '<p>Discount Price: ' . $discount_price . '</p>';

		$config['protocol'] = 'mail';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';

		$this->email->initialize($config);

		$this->email->from($cust_email, $fullname);

//		$store_email = 'jasshultz@gmail.com';

		$this->email->to($store_email, $location);

		$this->email->subject('Consultation Request');

		$this->email->message($message);

		$this->email->send();

		if ($nolocation == '1') {
			$data['thankyou'] = 'Thank you for requesting your telephone consultation. We’ll contact you to set up a date and time that best works for you.';

		} else {
			$data['thankyou'] = 'Thank you for requesting your showroom visit and consultation. We’ll contact you to set up a date and time that best works for you.';
		}

		$this->load->view('/landing/thankyou', $data);
	}

	/* This unsuscribe's people. It needs an email address and a unique key to work. */
	public function unsubscribe()
	{

		if (isset($_GET) || isset($_POST)) {

			$email = $this->input->get_post('email', TRUE);
			$Key = $this->input->get_post('key', TRUE);

			$this->Clients_model->unsubscribeEmail($email, $Key);

			$this->load->view('unsubscribed');

		}

	}

	/* This fires from the landing page. */
	public function consultation()
	{
		if (isset($_GET) || isset($_POST)) {

			$email = $this->input->get_post('email', TRUE);
			$Key = $this->input->get_post('key', TRUE);

			$customer = $this->Clients_model->getCustomer($email, $Key);

			foreach ($customer->result_array() as $x) {

				$firstName = $x['FirstName'];
				$lastName = $x['LastName'];
				$address = $x['Address'];
				$state = $x['State'];
				$zip = $x['Zip'];
				$phone = $x['Phone'];
				$cust_email = $x['Email'];
				$key = $x['Key'];
				$source = $x['Source'];
				$emailLevel = $x['EmailLevel'];
				$lastSent = $x['lastSent'];
				$estimateStyle = str_replace('+', " ", $x['estimateStyle']);
				$estimateSize = str_replace('\\"', "'", $x['estimateSize']);
				$estimatePanels = $x['estimatePanels'];
				$price = $x['cost'];

				$lat = $x['lat'];
				$lng = $x['lng'];
			}

			if ($emailLevel == 3) {
				$data['special'] = '1';
			} else {
				$data['special'] = '0';
			}

			$data['firstname'] = $firstName;
			$data['lastname'] = $lastName;
			$data['fullname'] = $firstName . ' ' . $lastName;
			$data['phone'] = $phone;
			$data['cust_email'] = $cust_email;
			$data['key'] = $key;
			$data['cust_zip'] = $zip;

			$data['style'] = $estimateStyle;
			$data['size'] = $estimateSize;
			$data['panels'] = $estimatePanels;
			$data['price'] = $price;

			$location = $this->Location_model->getClosetLocation($lat, $lng, $zip);

			if ($location == null) {
				$data['nolocation'] = '1';
				$data['store_email'] = 'contact@slidingdoorco.com';
				$data['location'] = 'Internet Only';

			} else {
				$data['nolocation'] = '0';

				$foreachLoop = (is_object($location)) ? $location->result_array() : $location;

				$data['location_array'] = $location;

				foreach ($foreachLoop as $place) {

					$data['maplink'] = $place['map_link'];
					$data['location'] = $place['location'];
					$data['address'] = $place['address'];
					$data['city'] = $place['city'];
					$data['state'] = $place['state'];
					$data['zip'] = $place['zip'];
					$data['telephone'] = $place['telephone'];
					$data['store_email'] = $place['email'];
				}

			}

			$this->load->view('landing/landing-view', $data);

		}

	}

	function send_email() {

		$subject = 'Test Email';

		$name = 'Engr Mudasir';

		$email = 'jasshultz@gmail.com';

		$body = "This si body text for test email to combine CodeIgniter and PHPmailer";

		$this->phpmailer->AddAddress($email);

		$this->phpmailer->IsMail();

		$this->phpmailer->From = 'info@computersneaker.com';

		$this->phpmailer->FromName = 'Computer Sneaker';

		$this->phpmailer->IsHTML(true);

		$this->phpmailer->Subject = $subject;

		$this->phpmailer->Body = $body;

		$this->phpmailer->Send();

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/site.php */