<?php
 
 	require_once("../../config.php");
 	
 	function getSinglePerosonData($edit_id){
     
         $database = "if16_raily_4";
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("SELECT Food, Day, Price FROM Menu WHERE id=? AND deleted IS NULL");
 
 		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result($Food, $Day, $Price);
 		$stmt->execute();
 		
 		$p = new Stdclass();
 		
 		if($stmt->fetch()){
 			$p->Food = $Food;
 			$p->Day = $Day;
			$p->Price = $Price;
 		}else{
 			header("Location: data.php");
 			exit();
 		}
		
 		$stmt->close();
 		$mysqli->close();
 		
 		return $p;
 		
 	}
 
 	function updatePerson($id, $Food, $Day){
     	
         $database = "if16_raily_4";
 
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("UPDATE Menu SET Food=?, Day=?, Price=? WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("siii",$Food, $Day, $Price, $id);
 		
 		if($stmt->execute()){
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 	}
	
 	function deletePerson($id){
     	
        $database = "if16_raily_4";
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("
		UPDATE Menu SET deleted=NOW()
 		WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("i",$id);
 		
 		if($stmt->execute()){
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
	
 	
 ?>