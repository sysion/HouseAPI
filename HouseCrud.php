<?php 


/*
 * HouseCrud.php
 *
 * Handles Create, Read, Update and Delete actions of API
 *
 * @param $db -> json database file
 *
 */

require_once('House.php');

class HouseCrud{
	private $db;

	public function __construct(){
		$this->db = file_get_contents('houses-data.json');
	}

	public function createHouse($house){
		$data = json_decode($this->db, true);
		$num_added = 0;

		//get last key in data
		$data_len = count($data);		// array index is zero base hence this gives next index value
		$data_len = intval($data_len);	// convert string number to actual number

		$house['id'] = $data_len;

		foreach($data as $key=>$value){
			//if ($value['id'] == $house['id'] || $value['code'] == $house['code']){
			if ($value['id'] == $house['id']){
				return "<h3>House ID already exists in database</h3>";
				break;
			}
		}

		// don't add new entry if any field is missing
		if (($house['code'] != "") && ($house['address'] != "") && ($house['agent'] != "") && ($house['url'] != "")){
			//$hs = new House($data_len, $house['code'], $house['address'], $house['agent'], $house['url']);
			//$hs['id'] = $data_len;
			//$data[$data_len] = $hs;	// output is empty object {} added to database $data!!! why is this???

			//$data[$data_len] = $house;	//ok
			array_push($data, $house);	//ok
			file_put_contents('houses-data.json', json_encode($data, JSON_UNESCAPED_SLASHES));
			$num_added = 1;

			if ($num_added = 0){
				return "<h3>zero rows added.</h3>";
			}
			elseif ($num_added = 1){
				return "<h3>one row added.</h3>";
			}
		}
		else{
			return "<h3>Incomplete record, entry not saved !!!</h3>";
		}
	}

	public function getAllHouses(){
		return $this->db;
	}

	public function getHouse($house_id){
		$data = json_decode($this->db,true);	// creates associative array

		foreach ($data as $key=>$value){
			if ($value['id'] == $house_id){
				//echo "value = {$value[id]}, house_id = {$house_id}";
				return json_encode($value);
				break;
			}
		}
		//return [{"not found": "Requested data not present in database"}];	// try to return json formatted output
		return "";
	}

	public function updateHouse($house_id){}

	public function deleteHouse($house_id){}
}


?>