<?php

class CalculatorController
{
   public function welcomeAction()
   {
       return array('message'=>'welcome');
   }

   public function calculateAction(){
       $data = $_POST['data'];
       if (!empty($data)) {
           $service= new CalculatorService();
           http_response_code(200);
           return $service->getMatrixPrice($data);
       }
       else{
           http_response_code(204);
           return array();
       }
   }
}