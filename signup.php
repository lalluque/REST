<?php

    $servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "mfibd";
	
	try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// $dbh->select_db("mfibd");
		// connected successfully 
    } catch (PDOException $e) {
       // connection failed : $e->getMessage();
    }
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// Get data
		$name = isset($_POST['name']) ? $_POST['name'] : "";
		$email = isset($_POST['email']) ? $_POST['email'] : "";
		
		$stmt = $dbh->prepare("insert into user (name) values (:name)");
		$stmt->bindParam(':name', $name);
		$resultat = $stmt->execute(); // Insert data into data base
		
		if ($resultat) {
		    $json = array("status" => 1, "msg" => "Done User added!");
		} else {
		    $json = array("status" => 0, "msg" => "Error adding user!");
		}
	} else {
	    $json = array("status" => 0, "msg" => "Request method not accepted");
	}

	$dbh = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);

?>
