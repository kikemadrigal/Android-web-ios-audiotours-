<?php
header('Content-Type: application/json');
$request=array("message"=>array("https://images.dog.ceo/breeds/hound-afghan/n02088094_1003.jpg","https://images.dog.ceo/breeds/hound-afghan/n02088094_1007.jpg", "https://images.dog.ceo/breeds/hound-afghan/n02088094_1023.jpg"),
"status"=> "success");
      
  echo json_encode($request);
?>