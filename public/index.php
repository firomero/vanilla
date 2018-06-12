<?php
require_once("../src/Calculator/CalculatorService.php");
require_once("../src/Calculator/CalculatorController.php");
$controller  = new CalculatorController();
$routes = ['welcome', 'calculate'];
$uri = explode('/', $_SERVER['REQUEST_URI']);
$action = $uri[1];
try{
    if (in_array($action,$routes)) {
        $method = $action."Action";
        if (method_exists($controller,$method )) {
            echo json_encode($controller->$method());
        }
        else{
            http_response_code(405);
            echo json_encode(array('message'=>'Method not allowed'));
        }
    }
    else{
        http_response_code(404);
        echo json_encode(array('message'=>'Source not found'));
    }
}
catch (Exception $exception){
    http_response_code(500);
    echo json_encode(array('message'=>$exception->getMessage()));
}