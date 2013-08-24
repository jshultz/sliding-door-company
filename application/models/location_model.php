<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Location_model extends CI_Model {

		function __construct() {
		}

		public function calc_distance($point1, $point2)
		{
			$radius      = 3958;      // Earth's radius (miles)
			$deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)

			$distance = ($radius * pi() * sqrt(
					($point1['lat'] - $point2['lat'])
					* ($point1['lat'] - $point2['lat'])
					+ cos($point1['lat'] / $deg_per_rad)  // Convert these to
					  * cos($point2['lat'] / $deg_per_rad)  // radians for cos()
					  * ($point1['long'] - $point2['long'])
					  * ($point1['long'] - $point2['long'])
				) / 180);

			return $distance;  // Returned using the units used for $radius.
		}

		# Spherical Law of Cosines
		public function distance_slc($lat1, $lon1, $lat2, $lon2) {
			$earth_radius = 3960.00; # in miles
			$delta_lat = $lat2 - $lat1;
			$delta_lon = $lon2 - $lon1;
			$alpha    = $delta_lat/2;
			$beta     = $delta_lon/2;
			$a        = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
			$c        = asin(min(1, sqrt($a)));
			$distance = 2*$earth_radius * $c;
			$distance = round($distance, 4);

			return $distance;
		}

		function getAjaxClosestLocations($latlng, $originlat, $originlng, $tag) {

			$results = array();

			$pieces = explode(',', $latlng);

			$array = array(
				'tags' => $tag,
			);

			$this->db->select('*')->from('locations')->like($array);

			$location = $this->db->get();
			foreach ($location->result_array() as $address) {

				$distance = $this->distance_slc($originlat, $originlng, $address['lat'], $address['lng']);
				$test = $originlat . $originlng . $address['lat'] . $address['lng'];

				if ($distance < 50.0000) {
					$results[] = $address;
				}
			}

			echo json_encode(array('data' => $results));

//		echo json_encode($location->result_array());
		}

		function getAjaxLocationList()
		{
			$this->db->select( '*' )
				->from( 'locations' );

			$query = $this->db->get();

			$row = $query->row_array();
			$num = $query->num_rows();

			if ( $num < 1 ) {
				return NULL;
			}
			else {
				echo json_encode( $query->result_array() );

			}

		}

		function getAjaxLocation($idlocation)
		{
			$this->db->select( '*' )
				->from( 'locations' )
				->where( 'idlocation', $idlocation);

			$query = $this->db->get();

			$row = $query->row_array();
			$num = $query->num_rows();

			if ( $num < 1 ) {
				return NULL;
			}
			else {
				echo json_encode( $query->result_array() );

			}

		}

		function getClosetLocation($lat, $lng, $zip) {


			$this->db->select('*')
				->from('zipcodes');

			$query = $this->db->get();


			$ziprow = $query->row_array();

			foreach ($query->result() as $row)
			{
				$low = $row->low;
				$high = $row->high;

				if (($zip <= $high) && ($zip >= $low)) {



					if ($row->nostore == '1') {
						return null;
					} elseif ($row->usezip == '1') {

						$results = array();


						$this->db->select('*')->from('locations');

						$location = $this->db->get();
						foreach ($location->result_array() as $address) {

							$point1 = array(
								'lat' => $lat,
								'long' => $lng
							);

							$point2 = array(
								'lat' => $address['lat'],
								'long' => $address['lng']
							);

							$distance = $this->distance_slc($lat, $lng, $address['lat'], $address['lng']);
							$address['distance'] = $distance;

							//$distance = $this->calc_distance($point1, $point2);

							if ($distance < 100.0000) {
								$results[] = $address;


								$sortArray = array();

								foreach($results as $result){
									foreach($result as $key=>$value){
										if(!isset($sortArray[$key])){
											$sortArray[$key] = array();
										}
										$sortArray[$key][] = $value;
									}
								}

								$orderby = "distance"; //change this to whatever key you want from the array

								array_multisort($sortArray[$orderby],SORT_ASC,$results);


							}
						}

						return $results;

					} else {



						$this->db->select('*')
							->from('locations')
							->where('id', $row->storeid);
						$query = $this->db->get();

						return $query;


					}

				}

			}




			}

		function updateLocation($idlocation, $locationname, $locationstreet, $locationcity, $locationstate, $locationzip, $locationdescription, $lat, $lng, $tags, $uid)
		{
			if ($idlocation  == '') {
				$data = array(
					'idlocation'		=> uniqid(rand()),
					'location_name'			=> $locationname,
					'location_street'	=> $locationstreet,
					'location_city'     => $locationcity,
					'location_state'    => $locationstate,
					'location_zip'      => $locationzip,
					'lat'               => $lat,
					'lng'               => $lng,
					'tags'              => $tags,
					'description'       => $locationdescription,
					'userid'			=> $uid
				);
			} else {
				$data = array(
					'idlocation'		=> $idlocation,
					'location_name'		=> $locationname,
					'location_street'	=> $locationstreet,
					'location_city'     => $locationcity,
					'location_state'    => $locationstate,
					'location_zip'      => $locationzip,
					'lat'               => $lat,
					'lng'               => $lng,
					'tags'              => $tags,
					'description'       => $locationdescription,
					'userid'			=> $uid
				);
			}

			$this->db->select('*')
				->from('locations')
				->where('userid', $uid)
				->where('idlocation', $idlocation);

			$query = $this->db->get();

			$row = $query->row_array();
			$num = $query->num_rows();

			if ($num < 1)
			{
				$this->db->insert('locations', $data);

			} else {
				$this->db->where('idlocation', $idlocation);
				$this->db->update('locations', $data);
			}
		}

		function deleteLocation($id)
		{
			$this->db->where( 'idlocation', $id );
			$this->db->delete( 'locations' );
		}

	}