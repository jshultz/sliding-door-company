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
					$cost = $this->input->get_post('cost', TRUE);
					$city = '';

					$latlng  = $this->geocodeit->geocode($address,$city,$zip);
					$pieces = explode(",", $latlng);
					$lat = $pieces[0];
					$lng = $pieces[1];

					$this->Clients_model->create_client($firstName, $lastName, $address, $state, $zip, $phone, $email, $source, $lat, $lng, $estimateStyle, $estimateSize, $estimatePanels, $cost);

				}



			}

			public function email_contact() {

				$people = $this->Clients_model->email_client();

				if ($people == NULL) {
					echo 'no recipeints';
				} else {

					echo '<pre>';
					var_dump($people);

					foreach ($people as $key => $row) {

						if (is_array($row)) {

							foreach ($row as $x) {
								echo '<pre>';
								var_dump($x);

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
								$price = $x['cost'];

								$lat = $x['lat'];
								$lng = $x['lng'];



								$location = $this->Location_model->getClosetLocation($lat, $lng, $zip);



								$date1 = new DateTime("now");
								$date2 = new DateTime($lastSent);

								$interval = $date2->diff($date1);
								$timePassed =  $interval->format('%R%a');

								echo $timePassed;



								echo '<p><em>' . $lastSent . '</em></p>';

								if (($lastSent == '0000-00-00') || ($timePassed > 7) || ($lastSent = NULL))
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
									$data['price'] = $price;

									echo '<p><strong>' . $fullname . '</strong></p>';

									$count = 1;

									if ($count == 1) {

										if ($location == null) {
											$data['nolocation'] = '1';
											$data['email'] = 'contact@slidingdoorco.com';

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

									} else {
										echo 'doh!';
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

									$this->email->message($email);


//									$this->email->send();
//
//									$this->Clients_model->updateCount($cust_email);
//
//									$this->Clients_model->updateDate($cust_email);

								} else {
									echo 'doh!';
								}



							}

						}


					}

				}

			}

			public function email_store() {

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

				$config['protocol'] = 'mail';
				$config['wordwrap'] = FALSE;
				$config['mailtype'] = 'html';
				$config['charset'] = 'utf-8';
				$config['crlf'] = "\r\n";
				$config['newline'] = "\r\n";

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

			public function unsubscribe() {

				if (isset($_GET) || isset($_POST)) {

					$email = $this->input->get_post('email', TRUE);
					$Key = $this->input->get_post('key', TRUE);

					$this->Clients_model->unsubscribeEmail($email, $Key);

					$this->load->view('unsubscribed');

				}

			}

			public function consultation() {
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
						$estimateStyle = $x['estimateStyle'];
						$estimateSize = $x['estimateSize'];
						$estimatePanels = $x['estimatePanels'];
						$price = $x['cost'];

						$lat = $x['lat'];
						$lng = $x['lng'];
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


						foreach ($location->result_array() as $place) {


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
		}

		/* End of file welcome.php */
		/* Location: ./application/controllers/site.php */