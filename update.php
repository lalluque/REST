<?php

    $servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "mfibd";
	
	$json = array();
	
	try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// $dbh->select_db("mfibd");
		// connected successfully 
    } catch (PDOException $e) {
       // connection failed : $e->getMessage();
    }
	
	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
		$id = 0;
		$name = null;
		
		if (isset($_SERVER['HTTP_ID'])) {
			$id = $_SERVER['HTTP_ID'];
			
			if (isset($_SERVER['HTTP_NAME'])) {
				$name = $_SERVER['HTTP_NAME'];
			}
		}
		
		//we update if id exists
		if ($id != 0 && $name != null) {
			$stmt = $dbh->prepare("update user set name = ? where idUser = ?");
			$stmt->bindParam(1, $name);
			$stmt->bindParam(2, $id);
			
			$resultat = $stmt->execute();
			$nbupdate = $stmt->rowCount();
			
			//no problem
			if ($resultat) {
				//if update
				if ($nbupdate > 0) {
				    $json = array("status" => 1, "msg" => "user $name updated");	
				} else{
				     $json = array("status" => 0, "msg" => "user $id does not exist");
				}			    
			} else {
				$json = array("status" => 0, "msg" => "error updating user");
			}
			
		} else {
			$json = array("status" => 0, "msg" => "user id = $id not define or name is null in param");
		}
	}
	
	header("Content-type: application/json");
	echo json_encode($json);

?>
