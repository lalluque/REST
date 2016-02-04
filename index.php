<?php

    $json = array("brand" => "yamaha", "model" => "R6", "puissance" => 600);
	
	header("Content-type: application/json");
	
	echo json_encode($json);
?>
