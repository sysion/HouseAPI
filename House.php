<?php

/*
 *
 * Example House Object in json format
 *
 * "id":0,
 * "code":"house-01",
 * "address":"Plot 124, Awosika Avenue, Ikoy, Lagos",
 * "agent":"Peju Adams",
 * "url":"https://127.0.0.1:12345/api/houses/house-01.jpg"
 *
 * @param $id integer
 * @param $code string
 * @param $address string
 * @param $agent string
 * @param $url string
 *
 */

class House{
	private $id;
	private $code;
	private $address;
	private $agent;
	private $url;

	public function __construct($id, $code, $address, $agent, $url){
		//$this->id = uniqid();		// autogenerate unique id
		$this->id = $id;
		$this->code = $code;
		$this->address = $address;
		$this->agent = $agent;
		$this->url = $url;
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getCode(){
		return $this->code;
	}

	public function setCode($code){
		$this->code = $code;
	}

	public function getAddress(){
		return $this->address;
	}

	public function setAddress($address){
		$this->address = $address;
	}

	public function getAgent(){
		return $this->agent;
	}

	public function setAgent($agent){
		$this->agent = $agent;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setUrl($url){
		$this->url = $url;
	}

}


?>