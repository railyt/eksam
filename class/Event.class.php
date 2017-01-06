<?php 
class Event{
	private $connection;
	//käivitataks siis kui on = new User(see jõuab siia)
	
	function __construct($mysqli){
		//this viitab sellele klassile ja selle klassi muutujale
		$this->connection=$mysqli;
	}
	/*KÕIK FUNKTSIOONID */

	function saveEvent($Food, $Day, $Price) {
		$stmt = $this->connection->prepare("INSERT INTO Menu (Food, Day, Price) VALUE (?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssd", $Food, $Day, $Price);
		
		if ( $stmt->execute() ) {
			echo "õnnestus <br>";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function getAllPeople($q, $sort, $order){
		
		$allowedSort = ["id", "Food", "Day", "Price"];
		
		// sort ei kuulu lubatud tulpade sisse 
		if(!in_array($sort, $allowedSort)){
			$sort = "id";
		}
		
		$orderBy = "ASC";
		
		if($order == "DESC") {
			$orderBy = "DESC";
		}
		//echo "Sorteerin: ".$sort." ".$orderBy." ";
		
		if($q!=""){
			//otsin
			echo"otsin: ".$q;
			$stmt = $this->connection->prepare("
				SELECT id, Food, Day, Price
				FROM Menu
				WHERE deleted IS NULL
				AND ( Food LIKE ? OR Day LIKE ? OR Price LIKE ?)
				ORDER BY $sort $orderBy
				");
			$searchWord="%".$q."%";
			$stmt->bind_param("sss", $searchWord, $searchWord, $searchWord);
		}else {
			//ei otsi
			$stmt = $this->connection->prepare("
				SELECT id, Food, Day, Price
				FROM Menu
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
				");
		}
		
		
		$stmt->bind_result($id, $Food, $Day, $Price);
		$stmt->execute();
		$results=array();
		//tsüklissisu toimib seni kaua, mitu rida SQL lausega tuleb
		while($stmt->fetch()) {
			$human=new StdClass();
			$human->id=$id;
			$human->Food=$Food;
			$human->Day=$Day;
			$human->Price=$Price;
			array_push($results, $human);
		}
		return $results;
	}
	
	
	function getSinglePerosonData($edit_id){
 		$stmt = $this->connection->prepare("SELECT Food, Day, Price FROM Menu
		WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result($Food, $Day, $Price);
 		$stmt->execute();
 		//tekitan objekti
 		$p = new Stdclass();
 		//saime ühe rea andmeid
 		if($stmt->fetch()){
 			// saan siin alles kasutada bind_result muutujaid
 			$p->Food = $Food;
 			$p->Day = $Day;
			$p->Price = $Price;
 		}else{
 			// ei saanud rida andmeid kätte
 			// sellist id'd ei ole olemas
 			// see rida võib olla kustutatud
 			header("Location: data.php");
 			exit();
 		}
 		$stmt->close();
 		$this->connection->close();
 		return $p;
 	}
	
	
	function updatePerson($id, $Food, $Day, $Price){
 		$stmt = $this->connection->prepare("UPDATE Menu SET Food=?, Day=?, Price=? WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("ssii",$Food, $Day, $Price, $id);
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		$stmt->close();
 		$this->connection->close();
 	}
	
	
	function deletePerson($id){
 		$stmt = $this->connection->prepare("UPDATE Menu SET deleted=NOW()
 		WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("i",$id);
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		$stmt->close();
 		$this->connection->close();
 	}
	
	
	
}
?>