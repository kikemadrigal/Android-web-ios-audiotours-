<?php


header('Content-Type: application/json');

$data = array("id" => 1, "name" => "ejemplo1", "email" => "email1");
echo json_encode($data);  

?>