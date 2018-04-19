<?php

	if(isset($_GET["buttonPressed"]) && $_GET["buttonPressed"] == "Log Out"){
		unset($_COOKIE['user']);
		unset($_COOKIE['pass']);
	}
	$serverName = 		"127.0.0.1";
	$serverUserName = 	"admin";
	$serverPassword = 	"3j2l3j2klb3b2klb32l";
	$dbName = 			"bookstore";
	
	$conn = mysqli_connect($serverName, $serverUserName, $serverPassword, $dbName);
	
	if(!$conn){
		die("Connection Failed: ".mysqli_connect_error());
	}


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

<table style="float:right"><tr>
<?php
	if(isset($currentFName)){
		echo "<th><h3 align = 'right'>Hi, ".$currentFName."!</h3></th>";
	}	
	if(isset($currentUserType)){
		if($currentUserType == "Manager"){
			?>
			<th>
			<form method="post" action="/managerOptions.php">
			<input type="submit" name="managerOptions" value="Manager Options" />
			</form>
			</th>
			<?php
		}
		?>
		<th>
		<form method="get">
		<input type="submit" name="buttonPressed" value="Log Out"/>
		</form>
		</th>
		<?php
	}else{
		?>
		<th>
		<form method="post" action="/index.html">
		<input type="submit" name="buttonPressed" value="Log In"/>
		</form>
		</th>
		<?php
	}
	echo "</tr></table></br></br></br>";
?>




<?php
	mysqli_close($conn);
?>
</body>
</html>