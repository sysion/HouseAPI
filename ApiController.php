<?php  

/*
 * ApiController.php
 *
 * Directs all queries from index.php to appropriate actions in HouseCrud.php
 * 
 * @param $req  -> string
 * @param $data -> array
 *
 */


require_once('HouseCrud.php');

class ApiController{
	private $hc;
	private $req;
	private $data;

	public function __construct($req, $data=[]){
		$this->hc = new HouseCrud();
		$this->req = $req;
		$this->data = $data;
	}

	public function router(){
		switch($this->req){
			case 'GET':
				if ($this->data['house'] == ""){
					return $this->hc->getAllHouses();
				}
				else{
					return $this->hc->getHouse($this->data['house']);
				}
				break;
			case 'POST':
				return $this->hc->createHouse($this->data);
				break;
			case 'PUT':
				return $this->hc->updateHouse($this->data);
				break;
			case 'DELETE':
				return $this->hc->deleteHouse($this->data['id']);
				break;
			default:
				return;
		}
		
	}
}


?>