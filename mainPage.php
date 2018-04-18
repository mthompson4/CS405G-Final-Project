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

<form method="post">
    <input type="submit" name="test" id="test" value="RUN" /><br/>
</form>

<?php

function testfun()
{
   echo "Your test function on button click is working";
}

if(array_key_exists('test',$_POST)){
   testfun();
}

?>



<?php
	echo '<font size="5">Basic Search: </font><input type="text" name="searchBar" style="width: 200px; height: 25px" required>';
	
	echo '<form action="functioncalling.php"><input type="submit" name="insert" value="insert" onclick="insert()" /></form>';
	
	
	$serverName = "127.0.0.1";
	$serverUserName = "admin";
	$serverPassword = "3j2l3j2klb3b2klb32l";
	$dbName = "bookstore";
	
	$conn = mysqli_connect($serverName, $serverUserName, $serverPassword, $dbName);
	
	if(!$conn){
		die("Connection Failed: ".mysqli_connect_error());
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
		
		$sql = "INSERT INTO users(fname, mname, lname, email, password, age, gender, user_type)
				VALUES('$currentFName', '$currentMName', '$currentLName', '$currentEmail', '$currentPass', '$currentAge', '$currentGender', '$currentUserType')";
		
		mysqli_query($conn, $sql);
		
		mysqli_close($conn);
		
	}
	else{
		$currentUser = base64_decode(htmlspecialchars($_GET["user"]));
		$currentPass = base64_decode(htmlspecialchars($_GET["pass"]));
	}
	
	//echo "$currentUser".'</br>';
	//echo "$currentPass".'</br>';
	

?>

</body>
</html>