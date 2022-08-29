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

		/*/ don't add new entry if any field is missing
		if (($house['id'] != "") && ($house['code'] != "") && ($house['address'] != "") && ($house['agent'] != "") && ($house['url'] != "")){
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
		}*/

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
				//echo "value = {$value[id]}, house_id = {$house_id}";
				return json_encode($value);
				break;
			}
		}
		//return [{"not found": "Requested data not present in database"}];	// try to return json formatted output
		return "";
	}

	public function updateHouse($house){
		$hs = null;

		if ($house['id'] && count($house) == 1){
			$hs = json_decode($this->getHouse($house['id']));
			if ($hs != null){
				//print_r($hs);

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

				return $form;
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
				//array_splice(input, offset, num_elem) can also be used to remove key from array without affecting its indexing
				$num_del = 1;

				/* 
				 if an index in the middle is removed in this array of objects, json_encode
				 will encode the resulting array into an OBJECT because of the gap in the
				 array indexing. JSON can't encode arrays with gaps/holes back into arrays.
				 To solve this problem, re-index the array using array_values() then try to
				 encode it again.*/
				//file_put_contents('houses-data.json', json_encode($data, JSON_UNESCAPED_SLASHES)); // results in object instead of array
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