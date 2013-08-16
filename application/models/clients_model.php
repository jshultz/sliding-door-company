<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/20/13
 * Time: 9:26 AM
 */

class Clients_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function create_client($firstName, $lastName, $address, $state, $zip, $phone, $email, $source) {

		$data = array(
			'FirstName' => $firstName,
			'LastName' => $lastName,
			'Address' => $address,
			'State' => $state,
			'Zip' => $zip,
			'Phone' => $phone,
			'Email' => $email,
			'Source' => $source,
			'Key'   => random_string('alnum', 45)
		);

		log_message('info', 'hello');

		$this->db->select('*')
			->from('clients')
			->where('Email', $email);

		$query = $this->db->get();

		$row = $query->row_array();
		$num = $query->num_rows();

		if ($num < 1)
		{
			$this->db->insert('clients', $data);

		} else {

		}


	}

	function email_client() {

		$this->db->select('*')
			->from('clients')
			->where('Unsubscribed', '0')
			->where('EmailLevel <', '2');

		$query = $this->db->get();

		$row = $query->row_array();
		$num = $query->num_rows();

		if ($num < 1)
		{
			return null;

		} else {
			return $query;
		}

	}

	function send_email($firstName, $lastName, $address, $state, $zip, $phone, $email, $source) {

		$data = array(
			'FirstName' => $firstName,
			'LastName' => $lastName,
			'Address' => $address,
			'State' => $state,
			'Zip' => $zip,
			'Phone' => $phone,
			'Email' => $email,
			'Source' => $source,
		);

		echo 'we have people to email';

		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';

		$this->email->initialize($config);

		$fullname = $firstName . ' ' . $lastName;

		$this->email->from($email, $fullname);

		$this->email->to($email, $fullname);

		$email_message = "Customer Contact created for: " . $firstName . ' ' . $lastName . '<br/>';
		$email_message .= "Email Address (if provided): " . $email . '<br/>';
		$email_message .= "Address (if provided): " . $address . '<br/>';
		$email_message .= 'State' . $state . ' ' . $zip . '<br/>';
		$email_message .= "Telephone (if provided): " . $phone . '<br/>';
		$email_message .= "Source: " . $source;


		$this->email->subject('Welcome');

		$this->email->message($email_message);

		$this->email->send();

		echo 'email sent';

		$this->updateCount($email);
	}

	function updateCount($email) {
		$this->db->select('*')
			->from('clients')
			->where('Email', $email);

		$query = $this->db->get();

		$row = $query->row_array();
		$num = $query->num_rows();

		if ($num < 1)
		{
			echo 'Something went wrong';

		} else {
			foreach ($query->result() as $row)
			{
				echo '<pre>';
				echo $row->EmailLevel;
				$level = $row->EmailLevel + 1;

				$data = array(
					'EmailLevel' => $level
				);

				$this->db->where('Email', $email);
				$this->db->update('clients', $data);

			}
		}
	}

	function unsubscribeEmail($email, $Key) {
		$this->db->select('*')
			->from('clients')
			->where('Email', $email)
			->where('Key', $Key);

		$query = $this->db->get();

		$row = $query->row_array();
		$num = $query->num_rows();

		if ($num < 1)
		{
			echo 'Something went wrong';

		} else {
			foreach ($query->result() as $row)
			{
				$this->db->where('Email', $email);
				$this->db->where('Key', $Key);
				$this->db->delete('clients');

			}
		}
	}


}