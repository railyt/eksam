<form method="POST" >
	<a class="link" href="http://localhost:5555/~railtoom/eksam/page/login.php">Logi sisse</a>
</form>
<?php
	//ühendan sessionniga
	require("../functions.php");
	
	require("../class/Helper.class.php");
	$Helper= new Helper();
	
	require("../class/Event.class.php");
	$Event= new Event($mysqli);
	
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
	
	
		$Food = $Helper->cleanInput($_POST["Food"]);
		
		$Event->saveEvent($Helper->cleanInput($_POST["Food"]), ($_POST["Day"]), ($_POST["Price"]));
		header("Location: add.php");
		exit();
	}
	if(isset($_GET["q"])){
		$q=$_GET["q"];
	}else{
		//ei otsi
		$q="";
	}
	$sort = "id";
	$order = "ASC";
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	$people=$Event->getAllPeople($q, $sort, $order);
	echo"<pre>";
	//var_dump($people[1]);
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

<h2>Söögid</h2>
<form>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">

</form>
<?php 
	$html="<table>";
		$html .="<tr>";
			
			$html .="<th>Toidunimi</th>";
			$html .="<th>Päev</th>";
			$html .="<th>Hind</th>";
	$html .="</tr>";
	
	foreach($people as $p){
		$html .="<tr>";
			
			$html .="<td>".$p->Food."</td>";
			$html .="<td>".$p->Day."</td>";
			$html .="<td>".$p->Price."</td>";
	$html .="</tr>";	
	}
	$html .="</table>";
	echo $html;
	
	
?>