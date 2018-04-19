<html>
<head>
	<style>
		body{
			background-color: #990033
		}
	</style>
	<title>Registration</title>
</head>
<body>

<?php


	$button = $_POST["buttonPressed"];

	$username = $_POST["userEmail"];
	$password = $_POST["userPass"];

	//REGISTERING NEW USER
	if($button == "Register"){
		?>
		<div>
		<center><h1><font size="7">Register New User</font></h1></center>
		</div>
		<form action="mainPage.php/?buttonPressed=Register" method="post">
		<center>
		<table>
		<tr><th><font size='5'>Email: </font></th><th><input type="text" name="newUserEmail" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Password: </font></th><th><input type="password" name="newUserPassword" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>First Name: </font></th><th><input type="text" name="newUserFName" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Middle Name: </font></th><th><input type="text" name="newUserMName" style="width: 200px; height: 25px"></th></tr>
		<tr><th><font size='5'>Last Name: </font></th><th><input type="text" name="newUserLName" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Age: </font></th><th><input type="number" name="newUserAge" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Gender: </font></th><th><select name="newUserGender" style="width: 200px; height: 25px"><option value="Male">Male</option> <option value="Female">Female</option></select></th></tr>
		</table>
		<br/><input type="submit" name = "buttonPressed" value="Register" style="width: 150px; height: 40px; font-size:12pt">
		</center>
		</form>
		<?php
	}
	//LOGGING IN
	else if($button == "Login"){

		$serverName = "127.0.0.1";
		$serverUserName = "admin";
		$serverPassword = "3j2l3j2klb3b2klb32l";
		$dbName = "bookstore";

		$conn = mysqli_connect($serverName, $serverUserName, $serverPassword, $dbName);

		if(!$conn){
			die("Connection Failed: ".mysqli_connect_error());
		}

		$sql = 'SELECT email FROM users WHERE email="'.$username.'"';
		$results = mysqli_query($conn, $sql);
		//User not registered
		if(mysqli_num_rows($results) == 0){
			echo '<meta http-equiv="refresh" content = "2; url = index.html">';
			echo "There is no user registered with that email/password combination";
		}
		//User is registered
		else{
			//password doesn't match
			$sql = 'SELECT password FROM users WHERE email="'.$username.'" AND password="'.$password.'"';
			$results = mysqli_query($conn, $sql);
			if(mysqli_num_rows($results) == 0){
				echo '<meta http-equiv="refresh" content = "2; url = index.html">';
				echo "Incorrect password";
			}
			//passwords do match
			else{
				echo "Logging in...";
				echo '<meta http-equiv="refresh" content = "2; url = mainPage.php/?buttonPressed=Login&user='.base64_encode($username).'&pass='.base64_encode($password).'">';
			}
		}

		mysqli_close($conn);
	}


?>



</body>
</html>
