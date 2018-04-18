<?php
	$serverName = 		"127.0.0.1";
	$serverUserName = 	"admin";
	$serverPassword = 	"3j2l3j2klb3b2klb32l";
	$dbName = 			"bookstore";
	
	$conn = mysqli_connect($serverName, $serverUserName, $serverPassword, $dbName);
	
	if(!$conn){
		die("Connection Failed: ".mysqli_connect_error());
	}

	if(isset($_GET["buttonPressed"]) && $_GET["buttonPressed"] == "Register"){
		$currentEmail = 	$_POST["newUserEmail"];
		$currentPass = 		$_POST["newUserPassword"];
		$currentFName = 	$_POST["newUserFName"];
		$currentMName = 	$_POST["newUserMName"];
		$currentLName = 	$_POST["newUserLName"];
		$currentAge = 		$_POST["newUserAge"];
		$currentGender = 	$_POST["newUserGender"];
		$currentUserType = "Customer";
		
		setcookie("user", $currentEmail);
		setcookie("pass", $currentPass);
		
		$sql = "INSERT INTO users(fname, mname, lname, email, password, age, gender, user_type)
				VALUES('$currentFName', '$currentMName', '$currentLName', '$currentEmail', '$currentPass', '$currentAge', '$currentGender', '$currentUserType')";
		
		mysqli_query($conn, $sql);
		
		mysqli_close($conn);
		
	}else if(isset($_GET["buttonPressed"]) && $_GET["buttonPressed"] == "Login"){
		$currentEmail = base64_decode(htmlspecialchars($_GET["user"]));
		$currentPass = base64_decode(htmlspecialchars($_GET["pass"]));
		
		setcookie("user", $currentEmail);
		setcookie("pass", $currentPass);
		
		$sql = 'SELECT fname, mname, lname, age, gender, user_type FROM users WHERE email="'.$currentEmail.'" AND password="'.$currentPass.'"';
		
		$results = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($results) > 0){
			
			$row = mysqli_fetch_assoc($results);
			$currentFName = 	$row["fname"];
			$currentMName = 	$row["mname"];
			$currentLName = 	$row["lname"];
			$currentAge = 		$row["age"];
			$currentGender = 	$row["gender"];
			$currentUserType = 	$row["user_type"];
		
		}
	}else{
		if(!isset($_COOKIE["user"])){
			//no cookie
		}else{
			//cookie
			$currentEmail = $_COOKIE["user"];
			$currentPass = 	$_COOKIE["pass"];
			
			$sql = 'SELECT fname, mname, lname, age, gender, user_type FROM users WHERE email="'.$currentEmail.'" AND password="'.$currentPass.'"';
			$results = mysqli_query($conn, $sql);
			
			if(mysqli_num_rows($results) > 0){
				
				$row = mysqli_fetch_assoc($results);
				$currentFName = 	$row["fname"];
				$currentMName = 	$row["mname"];
				$currentLName = 	$row["lname"];
				$currentAge = 		$row["age"];
				$currentGender = 	$row["gender"];
				$currentUserType = 	$row["user_type"];
			
			}
		}
		if(isset($_GET["buttonPressed"]) && $_GET["buttonPressed"] == "Search"){
			$searchTerm = $_GET["search"];
			echo $searchTerm;
		}
	}
	
?>

<html>
<head>
	<style>
		body{
			background-color: #990033
		}
	</style>
	<title>Bookstore</title>
</head>
<body>

<div><center><h1><font size="7">Bookstore Database</font></h1></center></div>

<form method="get">
	<font size="5">Basic Search: </font>
	<input type="text" name="search" style="width: 200px; height: 40px">	
	<input type="submit" name="buttonPressed" value="Search" style="width: 150px; height: 40px; font-size:12pt">
	<input type="submit" name="buttonPressed" id="test" value="Advanced" style="width: 150px; height: 40px; font-size:12pt"/><br/>
	<?php
		function advSearch(){
			?>
			<font size="5">Author: </font>
			<input type="text" name="author" style="width: 200px; height: 40px">	
			<font size="5">Subject: </font>
			<input type="text" name="subject" style="width: 200px; height: 40px">	
			<font size="5">Date Published: </font>
			<input type="text" name="search" style="width: 200px; height: 40px">	
			<font size="5">Price: </font>
			<input type="number" name="search" style="width: 200px; height: 40px">	
			<?php
		}

		if(isset($_GET["buttonPressed"]) && $_GET["buttonPressed"] == "Advanced"){
		   advSearch();
		}
	?>
</form>
<?php	
	function showManagerOptionButton(){
		?>
		<form method="post" action="managerOptions.php">
		<h1><input type="submit" name="managerOptions" value="Manager Options" /></h1><br/>
		</form>
		<?php
	}
	
	if(isset($currentUserType) && $currentUserType == "Manager"){
		showManagerOptionButton();
	}
	if(isset($currentFName)){
		echo "<h1>Hi, ".$currentFName."!</h1>";
	}
	//echo "$currentUser".'</br>';
	//echo "$currentPass".'</br>';
	

?>

</body>
</html>