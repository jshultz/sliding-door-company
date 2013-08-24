<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/site
	 *	- or -  
	 * 		http://example.com/index.php/site/index
	 *	- or -
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
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function new_contact(){

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
			$city = '';

			$latlng  = $this->geocodeit->geocode($address,$city,$zip);
			$pieces = explode(",", $latlng);
			$lat = $pieces[0];
			$lng = $pieces[1];

			$this->Clients_model->create_client($firstName, $lastName, $address, $state, $zip, $phone, $email, $source, $lat, $lng, $estimateStyle, $estimateSize, $estimatePanels);

		}

		// Testing Code - REMOVE in Production

		if ($_POST) {
			$kv = array();
			foreach ($_POST as $key => $value) {
				$kv[] = "$key=$value";
				echo $key . ' ' . $value;
				$value = $key . ' ' . $value;
				log_message('info', $key);

			}
			$query_string = join("&", $kv);
			echo '<pre>Post Array:' . $query_string . '</pre>';
		}
		else {
			$kv = array();
			foreach ($_GET as $key => $value) {
				$kv[] = "$key=$value";
				echo $key . ' ' . $value;
			}
			$query_string = join("&", $kv);
			echo '<pre>Get Array:' . $query_string . '</pre>';

		}

		// END Testing Code

	}

	public function email_contact() {

		$people = $this->Clients_model->email_client();

		if ($people == NULL) {
			echo 'no recipeints';
		} else {

			foreach ($people as $key => $row) {

				if (is_array($row)) {

					foreach ($row as $x) {
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
						$estimateStyle = $x['estimateStyle'];
						$estimateSize = $x['estimateSize'];
						$estimatePanels = $x['estimatePanels'];

						$lat = $x['lat'];
						$lng = $x['lng'];

						$location = $this->Location_model->getClosetLocation($lat, $lng, $zip);


						$date1 = new DateTime("now");
						$date2 = new DateTime($lastSent);


						$interval = date_diff($date2, $date1);
						$timePassed =  $interval->format('%R%a');



						if (($lastSent == '0000-00-00') || ($timePassed > 7))
						{

							$config['protocol'] = 'mail';
							$config['wordwrap'] = FALSE;
							$config['mailtype'] = 'html';
							$config['charset'] = 'utf-8';
							$config['crlf'] = "\r\n";
							$config['newline'] = "\r\n";

							$this->email->initialize($config);

							$fullname = $firstName . ' ' . $lastName;

							$data['firstname'] = $firstName;
							$data['lastname'] = $lastName;
							$data['cust_email'] = $cust_email;
							$data['key'] = $key;

							$data['style'] = $estimateStyle;
							$data['size'] = $estimateSize;
							$data['panels'] = $estimatePanels;
							$data['price'] = '';

							$count = 1;

							if ($count == 1) {

								if ($location == null) {
									$data['nolocation'] = '1';

								} else {
									$data['nolocation'] = '0';

									foreach ($location->result_array() as $place) {


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

							}


							$this->email->from($cust_email, $fullname);

							$this->email->to($cust_email, $fullname);



							switch ($emailLevel) {
								case 0:
									$this->email->subject('Thank You For Signing Up');
									$data['special'] = '0';
									$data['message'] = "<p>Thank you for designing your beautiful new closet doors with us. Your next step is sharing the specs of your custom order with the showroom below for more detailed pricing and options.</p>";

									break;
								case 1:
									$this->email->subject('Thank You From The Sliding Door Company');
									$data['special'] = '0';
									if ($location == null) {
										$data['message'] = '<p>Thank you for designing your beautiful new closet doors with us. Your next step is sharing the specs of your custom order with the showroom below for more detailed pricing and options.</p>';
									} else {
										$data['message'] = "<p>You're invited to our " . $place['city']  . "showroom for a free personalized
													consultation! You'll get one-on-one assistance from our trained experts and a
													first-hand look at your material options.</p>";
									}

									break;
								case 2:
									$this->email->subject('Here is something special from The Sliding Door Company!');
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



							$email = $this->load->view('email/email-one', $data, TRUE);


							echo $email;
							exit;
							$this->email->message($email);


							$this->email->send();

							$this->Clients_model->updateCount($cust_email);

							$this->Clients_model->updateDate($cust_email);

						}



					}

				}


		}

		}

	}
	
	public function unsubscribe() {

		if (isset($_GET) || isset($_POST)) {

			$email = $this->input->get_post('email', TRUE);
			$Key = $this->input->get_post('key', TRUE);

			$this->Clients_model->unsubscribeEmail($email, $Key);

			$this->load->view('unsubscribed');

		}
	
	}

	public function consultation() {
		$this->load->view('landing/landing-view');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/site.php */