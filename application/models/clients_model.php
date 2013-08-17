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

	function create_client($firstName, $lastName, $address, $state, $zip, $phone, $email, $source, $lat, $lng) {

		$data = array(
			'FirstName' => $firstName,
			'LastName' => $lastName,
			'Address' => $address,
			'State' => $state,
			'Zip' => $zip,
			'Phone' => $phone,
			'Email' => $email,
			'Source' => $source,
			'lat' => $lat,
			'lng' => $lng,
			'Key'   => random_string('alnum', 45)
		);

		$this->db->select('*')
			->from('clients')
			->where('Email', $email);

		$query = $this->db->get();

		$row = $query->row_array();
		$num = $query->num_rows();

		if ($num < 1)
		{
			$this->db->insert('clients', $data);

			$this->update_locations_lat();

		} else {

		}


	}

	function update_locations_lat() {

		$this->db->select('*')
			->from('locations')
			->where('lat', NULL);

			$query = $this->db->get();

		foreach ($query->result() as $row)
		{
			$address =  $row->address;
			$city = $row->city;
			$zip =  $row->zip;
			$id = $row->id;

			$latlng  = $this->geocodeit->geocode($address,$city,$zip);
			$pieces = explode(",", $latlng);
			$lat = $pieces[0];
			$lng = $pieces[1];

			$data = array(
				'lat' => $lat,
				'lng' => $lng
			);

			$this->db->where('id', $id);
			$this->db->update('locations', $data);



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

	function send_email($firstName, $lastName, $address, $state, $zip, $phone, $email, $source, $lat, $lng) {

		$data = array(
			'FirstName' => $firstName,
			'LastName' => $lastName,
			'Address' => $address,
			'State' => $state,
			'Zip' => $zip,
			'Phone' => $phone,
			'Email' => $email,
			'Source' => $source,
			'lat' => $lat,
			'lng' => $lng
		);

		echo 'we have people to email';


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