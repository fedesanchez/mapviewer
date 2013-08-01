<?php
  
  include("../classes/maps.class.php");
    
  $maps=new Maps();
  
  //$lista=$maps->getMapList();
  //$maps->createResponse($lista,"200")
  
  $method = $_SERVER['REQUEST_METHOD'];
  $request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));  
  
  if (count($request)>1){
  	$method=$request[0];
  	$newRequest=array($request[1]);
  	unset($request);
  	$request=$newRequest;
  }



  if($method == 'PUT') {  
      parse_str(file_get_contents('php://input'), $_POST);  
      array_unshift($_POST, $request[0]);
  }
    

	switch ($method) {
  		case 'PUT':
    		$maps->put($_POST);  
    		break;
  		case 'POST':
    		$maps->post($_POST);  
    		break;
  		case 'GET':
    		$maps->get($request);  
    		break;  		
  		case 'DELETE':
    		$maps->delete($request);  
    		break;  		
  		default:
    		$maps->error($request);  
    		break;
	}











?>