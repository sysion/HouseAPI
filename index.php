<?php  

/*
 * index.php
 *
 * API entry point
 *
 */

require_once('ApiController.php');

$request = $_SERVER['REQUEST_METHOD'];

$data=[];
$req_type="GET";

if ($request == 'GET'){
	$data['house'] = "";

	if (isset($_GET['house'])){
		$data['house']=htmlspecialchars($_GET['house']);
	}
}
elseif ($request == 'POST'){
	if (isset($_POST['id'])){
		$data['id'] = $_POST['id'];
	}
	if (isset($_POST['code'])){
		$data['code'] = $_POST['code'];
	}
	if (isset($_POST['address'])){
		$data['address'] = $_POST['address'];
	}
	if (isset($_POST['agent'])){
		$data['agent'] = $_POST['agent'];
	}
	if (isset($_POST['url'])){
		$data['url'] = $_POST['url'];
	}
	
	if (isset($_POST['submit'])){
		$req_type='POST';
	}
	elseif (isset($_POST['delete'])){
		$req_type='DELETE';
	}
	elseif (isset($_POST['update'])){
		$req_type='PUT';
	}

}

$ac = new ApiController($req_type, $data);
$result = $ac->router();

if ($request == 'GET'){
	header('Content-Type:application/json');
	print_r($result);
}
elseif ($request == 'POST'){
	header('Content-Type: text/html; charset=UTF-8');
	echo $result;
}


?>