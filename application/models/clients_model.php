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

	function create_client($firstName, $lastName, $address, $state, $zip, $phone, $email, $source, $lat, $lng, $estimateStyle, $estimateSize, $estimatePanels, $cost) {

		$dataClient = array(
			'FirstName' => $firstName,
			'LastName' => $lastName,
			'Address' => $address,
			'State' => $state,
			'Zip' => $zip,
			'Phone' => $phone,
			'Email' => $email,
            'lat' => $lat,
            'lng' => $lng
		);

		$this->db->select('*')
			->from('clients')
			->where('Email', $email);

		$query = $this->db->get();

		$row = $query->row_array();
		$num = $query->num_rows();

		if ($num < 1)
		{
			$this->db->insert('clients', $dataClient);

            $dataQuote = array(
                'clientid' => $this->db->insert_id(),
                'Source' => $source,
                'estimateStyle' => $estimateStyle,
                'estimateSize' => $estimateSize,
                'estimatePanels' => $estimatePanels,
                'cost'  => $cost,
                'Key'   => random_string('alnum', 45)
            );

            $this->db->insert('quotes', $dataQuote);

            return true;

		} else {

            foreach ($query->result() as $row)
            {
                $clientid = $row->idclients;
            }

            $dataQuote = array(
                'clientid' => $clientid,
                'Source' => $source,
                'estimateStyle' => $estimateStyle,
                'estimateSize' => $estimateSize,
                'estimatePanels' => $estimatePanels,
                'cost'  => $cost,
                'Key'   => random_string('alnum', 45)
            );

            $this->db->insert('quotes', $dataQuote);

            return true;
		}


	}

	function email_client() {

		$this->db->select('*')
			->from('clients')
            ->join('quotes','quotes.clientid = clients.idclients')
			->where('quotes.Unsubscribed', '0')
			->where('quotes.EmailLevel <', '3');

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

	function getCustomer($email, $key) {

		$this->db->select('*')
			->from('clients')
			->where('email', $email)
			->where('key', $key);

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

	function updateCount($quoteid) {
		$this->db->select('*')
			->from('quotes')
			->where('idquotes', $quoteid);

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
                $today = date("Y-m-d");

				$data = array(
					'EmailLevel' => $level,
                    'lastSent' => $today
				);

				$this->db->where('idquotes', $quoteid);
				$this->db->update('quotes', $data);

			}
		}
	}

	function updateDate($quoteid) {
		$this->db->select('*')
			->from('quotes')
			->where('idquotes', $quoteid);

		$query = $this->db->get();

		$row = $query->row_array();
		$num = $query->num_rows();

		if ($num < 1)
		{
			echo 'Something went wrong';

		} else {
			foreach ($query->result() as $row)
			{
				$lastDate = $row->lastSent;

				$today = date("Y-m-d");


				$data = array(
					'lastSent' => $today
				);

				$this->db->where('idquotes', $quoteid);
				$this->db->update('quotes', $data);

			}
		}
	}

    function updatePrice($email) {
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
			->from('quotes')
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
				$data = array(
					'Unsubscribed' => '1'
				);

				$this->db->where('Key', $Key);
				$this->db->update('quotes', $data);

			}
		}
	}


}