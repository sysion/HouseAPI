<?php 


/*
 * HouseCrud.php
 *
 * Handles Create, Read, Update and Delete actions of API
 *
 *
 */

require_once('House.php');

class HouseCrud{
	private $db;

	public function __construct(){
		$this->db = file_get_contents('houses-data.json');
	}

	public function createHouse($house){
		$data = json_decode($this->db, true);		// creates associative array
		$num_added = 0;

		//get last key in data
		$data_len = count($data);		// array index is zero base hence this gives next index value
		$data_len = intval($data_len);	// convert string number to actual number

		$house['id'] = $data_len;

		foreach($data as $key=>$value){
			if ($value['id'] == $house['id']){
				return "<h3>House ID already exists in database</h3>";
				break;
			}
		}

		return $this->saveHouse($house, $data, "added");
	}

	public function getAllHouses(){
		return $this->db;
	}

	public function getHouse($house_id){
		$data = json_decode($this->db,true);	// creates associative array

		if (! ctype_digit($house_id)){
			return "";
		}

		foreach ($data as $key=>$value){
			if ($value['id'] == $house_id){
				return json_encode($value);
				break;
			}
		}

		return "";
	}

	public function updateHouse($house){
		$hs = null;

		if ($house['id'] && count($house) == 1){
			$hs = json_decode($this->getHouse($house['id']));
			if ($hs != null){

				$header = file_get_contents('update_form_header.html');
				$footer = file_get_contents('update_form_footer.html');
				

				$form = "<form name='update-house' action='http://localhost:8899/index.php' method='post'>
							<table> 
								<tr><h3>House Details</h3></tr>
								<tr><td><label>id</label><input name='id' readonly value='".$hs->id."'/></td></tr>
								<tr><td><label>code</label><input name='code' value='".$hs->code."'/></td></tr>
								<tr><td><label>address</label><input name='address' value='".$hs->address."'/></td></tr>
								<tr><td><label>agent</label><input name='agent' value='".$hs->agent."'/></td></tr>
								<tr><td><label>url</label><input name='url' value='".$hs->url."'/></td></tr>
								<tr><td><button name='update' type='submit'>update</button></td></tr>
							</table>
						</form>";

				return $header.$form.$footer;
			}
			else{
				return "<h3>Cannot update non-existent record.</h3>";
			}
		}
		elseif (($house['id'] != "") && ($house['code'] != "") && ($house['address'] != "") && ($house['agent'] != "") && ($house['url'] != "")){

			$house['id'] = intval($house['id']);
			$this->deleteHouse($house['id']);	// delete existing record
			$this->db = file_get_contents('houses-data.json');	// reload database
			$data = json_decode($this->db, true);		// creates associative array
			return $this->saveHouse($house, $data, "updated");	// save updated record
		}	
		
	}

	public function deleteHouse($house_id){
		$data = json_decode($this->db);		// creates object array instead of associative array
		$num_del = 0;
		$obj_key = null;

		foreach($data as $key=>$obj){
			if ($obj->id == $house_id){
				unset($data[$key]);	// unset() removes key from array but does not re-index the array 
				$num_del = 1;

				file_put_contents('houses-data.json', json_encode(array_values($data), JSON_UNESCAPED_SLASHES));
				break;
			}
		}

		if ($num_del == 1){
			return "<h3>one row deleted.</h3>";
		}

		return "<h3>zero rows deleted.</h3>";			
	}

	private function saveHouse($house, $db, $action){
		// don't add new entry if any field is missing
		if (($house['id'] != "") && ($house['code'] != "") && ($house['address'] != "") && ($house['agent'] != "") && ($house['url'] != "")){
			array_push($db, $house);	//ok
			file_put_contents('houses-data.json', json_encode($db, JSON_UNESCAPED_SLASHES));
			$num_added = 1;

			if ($num_added = 0){
				return "<h3>zero rows {$action}.</h3>";
			}
			elseif ($num_added = 1){
				return "<h3>one row {$action}.</h3>";
			}
		}
		else{
			return "<h3>Incomplete record, entry not {$action} !!!</h3>";
		}
	}



}


?>