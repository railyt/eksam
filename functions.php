<?php 

	require("../../config.php");
	
	//see fail peab olema seotud kõigiga kus tahame sessiooni kasutada, saab kasutada nüüd $_session muutujat
	session_start();
	$database = "if16_raily_4";
	
	
	function signup($email, $password) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUE (?,?)");
		echo $mysqli->error;

		$stmt->bind_param("ss",$email, $password);
		if ($stmt->execute() ) {
			echo "õnnestus";
		}	else { "ERROR".$stmt->error;
		}
	}
	
	function login($email, $password) {
		$notice="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ?"  );
		echo $mysqli->error;
		//asendan küsimärgi
		$stmt->bind_param("s",$email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//ainult select puhul
		if($stmt->fetch()){
			//oli olemas,rida käes
			$hash=hash("sha512", $password);
			if($hash==$passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				header("Location: data.php");
				exit();
			} else {
				$notice = "Parool vale";
			}
		} else {
			//ei olnud ühtegi rida
			$notice = "Sellise emailiga $email kasutajat ei ole olemas";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $notice;
	}
	
	function saveEvent($Food, $Day, $Price) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO Menu (Food, Day, Price) VALUE (?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("sii", $Food, $Day, $Price);
		
		if ( $stmt->execute() ) {
			echo "õnnestus <br>";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function getAllPeople(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt=$mysqli->prepare("SELECT id, Food, Day, Price FROM Menu WHERE deleted IS NULL");
		$stmt->bind_result($id, $Food, $Day, $Price);
		$stmt->execute();
		$results=array();
		while($stmt->fetch()) {
			$human=new StdClass();
			$human->id=$id;
			$human->Food=$Food;
			$human->Day=$Day;
			$human->Price=$Price;
			$human->Genre=$Genre;
			$human->Comment=$Comment;
			$human->Rating=$Rating;
			
			
			
			array_push($results, $human);
		}
		return $results;
		}
	
	function cleanInput($input) {
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}
?>