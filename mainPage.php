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

<div>
	<center><h1><font size="7">Bookstore Database</font></h1></center>
</div>

<?php
	
	$serverName = "127.0.0.1";
	$serverUserName = "admin";
	$serverPassword = "3j2l3j2klb3b2klb32l";
	$dbName = "bookstore";
	
	$conn = mysqli_connect($serverName, $serverUserName, $serverPassword, $dbName);
	
	if(!$conn){
		die("Connection Failed: ".mysqli_connect_error());
	}
	
	function showManagerOptionButton(){
		echo '<form method="post">';
		echo '<h1><input type="submit" name="managerOptions" value="Manager Options" /></h1><br/>';
		echo '</form>';
	}
	
	if($_GET["buttonPressed"] == "Register"){
		$currentEmail = $_POST["newUserEmail"];
		$currentPass = $_POST["newUserPassword"];
		$currentFName = $_POST["newUserFName"];
		$currentMName = $_POST["newUserMName"];
		$currentLName = $_POST["newUserLName"];
		$currentAge = $_POST["newUserAge"];
		$currentGender = $_POST["newUserGender"];
		$currentUserType = "Customer";
		
		echo "<h1>Hi, $currentFName!</h1>";
		
		$sql = "INSERT INTO users(fname, mname, lname, email, password, age, gender, user_type)
				VALUES('$currentFName', '$currentMName', '$currentLName', '$currentEmail', '$currentPass', '$currentAge', '$currentGender', '$currentUserType')";
		
		mysqli_query($conn, $sql);
		
		mysqli_close($conn);
		
	}
	else{
		$currentEmail = base64_decode(htmlspecialchars($_GET["user"]));
		$currentPass = base64_decode(htmlspecialchars($_GET["pass"]));
		
		$sql = 'SELECT fname, mname, lname, age, gender, user_type FROM users WHERE email="'.$currentEmail.'" AND password="'.$currentPass.'"';
		
		$results = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($results) > 0){
			
			$row = mysqli_fetch_assoc($results);
			$currentFName = $row["fname"];
			$currentMName = $row["mname"];
			$currentLName = $row["lname"];
			$currentAge = $row["age"];
			$currentGender = $row["gender"];
			$currentUserType = $row["user_type"];
		
		}
		
		echo "<h1>Hi, $currentFName!</h1>";
		
	}
	
	if($currentUserType == "Manager"){
		showManagerOptionButton();
	}
	
	//echo "$currentUser".'</br>';
	//echo "$currentPass".'</br>';
	

?>

</body>
</html>