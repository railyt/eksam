<?php 

	require("../functions.php");
	
    require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/User.class.php");
	$User = new User($mysqli);
	if(isset($_SESSION["userId"])){
		header("Location: add.php");
		exit();
	}
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);

	// MUUTUJAD
	$signupEmailError= "*";
	$signupEmail = "";
	$loginEmail = "";
	
	//PROOV Töötab 
	if(isset ($_POST["loginEmail"])) {
		if(empty ($_POST["loginEmail"])){
			$signupEmailError = "*";
		} else{
		$loginEmail = $_POST["loginEmail"];
		}
	}	
	
	//kas keegi vajutas nuppu ja see on üldse olemas
	if(isset ($_POST["signupEmail"])) {
		//kas on olemas
		//kas on tühi
		if(empty ($_POST["signupEmail"])){
			//on tühi
			$signupEmailError = "* Väli on kohustuslik!";
		} else{
		//email olemas ja õige
		$signupEmail = $_POST["signupEmail"];
		}
	}	
	
	//Kasutaja loomine
	$signupPasswordError= "*";
	if (isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {
			$signupPasswordError = "* Väli on kohustuslik!";
		} else {
			// parool ei olnud tühi
			if(strlen($_POST["signupPassword"]) < 8 ) {
				$signupPasswordError = "* Parool peab olema vähemalt 8 tähemärki pikk!";
			}
		}
	}

	if ( $signupEmailError == "*" AND
		$signupPasswordError == "*" &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) 
	){
		echo "Salvestan...<br>";
		/*echo "email ".$signupEmail. "<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
			$password = hash("sha512", $_POST["signupPassword"]);
		echo $password."<br>";
		signup($signupEmail, $password);*/
		
	}
	
	$notice ="";
	//kas kasutaja tahab sisse logida
	if( isset($_POST["loginEmail"]) &&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"]) 
	){
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
	}
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Logi sisse</title>
	</head>
	<body>	
		<h1>Logi sisse</h1>
		<p style="color:black;"><?=$notice;?></p>
		<form method="POST" >
			<input name="loginEmail" placeholder="Email" type="email" value="<?=$loginEmail;?>">
			<br><br>
			<input name="loginPassword" placeholder="Parool" type="password">
			<br><br>
			<input type="submit" value="Logi sisse">
		</form>
		
		<h1>Loo kasutaja</h1>
		<form method="POST">
		<input name="signupEmail" placeholder="Email" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError;?>
		<br><br>
		<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError;?>
		<br><br>
		<input type="submit" value="Loo kasutaja">
		</form>
	</body>
</html>
