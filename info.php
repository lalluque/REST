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
	
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		// Get data
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		
		switch ($id) {
			case 0:
				//tous les users
				$stmt = $dbh->query("select * from user");
				$stmt->setFetchMode(PDO::FETCH_OBJ);
				
				$list_users = array();
				
				while ($elements = $stmt->fetch()) {
				    array_push($list_users, array("id" => $elements->idUser, "name" => $elements->name));
				}
				
				$json = array("status" => 1, "info" => $list_users);
				
			    break;
			default:
				//un user
			    $stmt = $dbh->prepare("select * from user where idUser = ?");
				$stmt->setFetchMode(PDO::FETCH_OBJ);
				$user = null;

				//array = liste de parametres ?
				$stmt->execute(array($id));
				
				while ($elements = $stmt->fetch()) {
					$user = array("id" => $elements->idUser, "name" => $elements->name);
				}
				
				if ($user != null) {
					$json = array("status" => 1, "info" => $user);
				} else {
					$json = array("status" => 0, "info" => "User does not exist");
				}
			    break;
		}		
	} else {
	    $json = array("status" => 0, "msg" => "No id user");
	}

	$dbh = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);

?>
