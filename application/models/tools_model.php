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
                'clientid' =>  $row->idclients,
                'Source' => $row->Source,
                'EmailLevel' =>  $row->EmailLevel,
                'lastSent' => $row->lastSent,
                'Created' => $row->Created,
                'Unsubscribed' => $row->Unsubscribed,
                'estimateStyle' => $row->estimateStyle,
                'estimateSize' => $row->estimateSize,
                'estimatePanels' => $row->estimatePanels,
                'cost' => $row->cost
            );

            $results = $this->db->insert('quotes', $data);

            echo $results;

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