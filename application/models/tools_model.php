<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/20/13
 * Time: 9:26 AM
 */

class Tools_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}


    function move_quotes() {

        $this->db->select('*')
            ->from('clients');

        $query = $this->db->get();

        foreach ($query->result() as $row)
        {
            
            $data = array(
	            'Key' => $row->Key
            );
	        var_dump($row);

	        if ($row->Key != NULL) {

		        $this->db->where('clientid', $row->idclients);
		        $this->db->where('key', NULL);
		        $this->db->update('quotes', $data);
	        }

        }
    }


    function update_locations_lat() {

        $this->db->select('*')
            ->from('locations')
            ->where('lat', NULL)
            ->or_where('lat', '');

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

}