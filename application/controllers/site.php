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

			$city = '';

			$latlng  = $this->geocodeit->geocode($address,$city,$zip);
			$pieces = explode(",", $latlng);
			$lat = $pieces[0];
			$lng = $pieces[1];

			$this->Clients_model->create_client($firstName, $lastName, $address, $state, $zip, $phone, $email, $source, $lat, $lng);

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
						$email = $x['Email'];
						$source = $x['Source'];
						$lat = $x['lat'];
						$lng = $x['lng'];

						$location = $this->Location_model->getClosetLocation($lat, $lng);

						$config['protocol'] = 'mail';
						$config['wordwrap'] = FALSE;
						$config['mailtype'] = 'html';
						$config['charset'] = 'utf-8';
						$config['crlf'] = "\r\n";
						$config['newline'] = "\r\n";

						$this->email->initialize($config);

						$fullname = $firstName . ' ' . $lastName;

						$data['firstname'] = $firstName;


						$this->email->from($email, $fullname);

						$this->email->to($email, $fullname);

						$this->email->subject('Welcome');

						$email = $this->load->view('email/template', $data, TRUE);

						$this->email->message($email);

						$this->email->send();

						echo 'email sent';

						$this->Clients_model->updateCount($email);

					}

				}


		}

		}

	}
	
	public function unsubscribe() {

		if (isset($_GET) || isset($_POST)) {

			$email = $this->input->get_post('Email', TRUE);
			$Key = $this->input->get_post('Key', TRUE);

			$this->Clients_model->create_client($email, $Key);
			
			$this->Clients_model->unsubscribeEmail($email, $Key);

		}
	
	}

	public function emailone() {
		$this->load->view('email/email-one');
	}

	public function emailtwo() {
		$this->load->view('email/email-two');
	}

	public function emailthree() {
		$this->load->view('email/email-three');
	}

	public function test() {
		$this->load->view('geocodetest');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/site.php */