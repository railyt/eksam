<?php
	//ühendan sessionniga
	//require("functions.php");
	
	if(!isset($_SESSION["userId"])){
		header("Location: data.php");
		exit();
	}
	if (isset($_GET["logout"])) {
		SESSION_destroy();
		header("Location: data.php");
		exit();
	}

		if ( isset($_POST["Food"]) && 
		 isset($_POST["Day"]) && 
		 isset($_POST["Price"]) &&
		 !empty($_POST["Food"]) &&
		 !empty($_POST["Day"]) &&
		 !empty($_POST["Price"]) 
	) { 
	
	
		$Day = cleanInput($_POST["Day"]);
		
		saveEvent(cleanInput($_POST["Food"]), ($_POST["Day"]), ($_POST["Price"]));
		header("Location: data.php");
		exit();
	}
	$people=getAllPeople();
	echo"<pre>";
	var_dump($people[1]);
	echo"</pre>";
	

	$FoodError= "*";
	if (isset ($_POST["Food"])) {
		if (empty ($_POST["Food"])) {
			$FoodError = "* Väli on kohustuslik!";
		} else {
			$Food = $_POST["Food"];
		}
	}
	
	$DayError= "*";
	if (isset ($_POST["Day"])) {
		if (empty ($_POST["Day"])) {
			$DayError = "* Väli on kohustuslik!";
		} else {
			$Day = $_POST["Day"];
		}
	}
	
	$PriceError= "*";
	if (isset ($_POST["Price"])) {
		if (empty ($_POST["Price"])) {
			$PriceError = "* Väli on kohustuslik!";
		} else {
			$Price = $_POST["Price"];
		}
	}
	
	if(isset ($_POST["Price"])) {
		if(empty ($_POST["Price"])){
			$PriceError = "*";
		} else{
		$Price = $_POST["Price"];
		}
	}
	
	if(isset ($_POST["Day"])) {
		if(empty ($_POST["Day"])){
			$DayError = "*";
		} else{
		$Day = $_POST["Day"];
		}
	}
	
	if(isset ($_POST["Food"])) {
		if(empty ($_POST["Food"])){
			$FoodError = "*";
		} else{
		$Food = $_POST["Food"];
		}
	}
	
?>
<h1>Lisa toidud</h1>

<?php echo$_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<br><br>
	<a href="?logout=1">logi välja</a>
</p>

<h2>Lisa toit</h2>
<form method="POST" >
	<label>Toidunimi</label><br>
	<input name="Food" type="text"><?php echo $FoodError;?>
	<br><br>
	<label>Päev</label><br>
	<input name="Day" type="date"><?php echo $DayError;?>
	<br><br>
	<label>Hind</label><br>
	<input name="Price" type="float"><?php echo $PriceError;?>
	<br><br>
	<input type="submit" value="Salvesta">
</form>

<h2>Söögid</h2>
<?php 
	$html="<table>";
		$html .="<tr>";
			$html .="<th>ID</th>";
			$html .="<th>Toidunimi</th>";
			$html .="<th>Päev</th>";
			$html .="<th>Hind</th>";
	$html .="</tr>";
	//iga liikmekohta masssiiivis
	foreach($people as $p){
		$html .="<tr>";
			$html .="<td>".$p->id."</td>";
			$html .="<td>".$p->Food."</td>";
			$html .="<td>".$p->Day."</td>";
			$html .="<td>".$p->Price."</td>";
			$html .= "<td><a href='edit.php?id=".$p->id."'>edit.php</a></td>";
	$html .="</tr>";	
	}
	$html .="</table>";
	echo $html;
	
	
?>