<?php
 	//edit.php
	require("functions.php");
	require("editFunctions.php");
 	
	if(isset($_GET["delete"])){
		deletePerson($_GET["id"]);
		header("Location: data.php");
		exit();
	}
 	//kas kasutaja uuendab andmeid
 	if(isset($_POST["update"])){
 		
 		updatePerson(cleanInput($_POST["id"]), cleanInput($_POST["Food"]),
		cleanInput($_POST["Day"]), cleanInput($_POST["Price"]));
 		
 		header("Location: edit.php?id=".$_POST["id"]."&success=true");
         exit();	
 		
 	}
 	//saadan kaasa id
 	$p = getSinglePerosonData($_GET["id"]);
 	var_dump($p);
	
 ?>
 <br><br>
 <a href="data.php"> tagasi </a>
 
 <h2>Muuda kirjet</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
	
  	<label for="Food" >Toidunimi</label><br>
 	<input id="Food" name="Food" type="text" value="<?php echo $p->Food;?>" ><br><br>
	<label for="Day" >Päev</label><br>
	<input id="Day" name="Day" type="text" value="<?php echo $p->Day;?>" ><br><br>
	<label for="Price" >Hind</label><br>
 	<input id="Price" name="Price" type="float" value="<?php echo $p->Price;?>" ><br><br>
	<input type="submit" name="update" value="Salvesta">
</form>  
	<a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>