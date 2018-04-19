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

<?php
	if(isset($currentUserType) && $currentUserType == "Manager"){
		?>
		<form method="post" action="managerOptions.php">
		<h1 align="right"><input type="submit" name="managerOptions" value="Manager Options" /></h1>
		</form>
		<?php
	}
	if(isset($currentFName)){
		echo "<h3>Hi, ".$currentFName."!</h3>";
	}	
?>

<center>
<form method="get">
	<table>
		<tr>
			<th><font size="5">Basic Search: </font></th>
			<th><input type="text" name="search" style="width: 200px; height: 40px; font-size:16pt"></th>
			<th><input type="submit" name="buttonPressed" value="Search" style="width: 150px; height: 40px; font-size:12pt"></th>
			<th><input type="submit" name="buttonPressed" id="test" value="Advanced" style="width: 150px; height: 40px; font-size:12pt"/><br/></th>
		</tr>
	<?php
		if(isset($_GET["buttonPressed"]) && $_GET["buttonPressed"] == "Advanced"){
		   	?>
			<tr>
				<th><font size="5">Author: </font></th>
				<th><input type="text" name="author" style="width: 200px; height: 40px; font-size:16pt"></th>
			</tr>
			<tr>
				<th><font size="5">Subject: </font></th>
				<th><input type="text" name="subject" style="width: 200px; height: 40px; font-size:16pt"></th>
			</tr>
			<tr>	
				<th><font size="5">Publisher: </font></th>
				<th><input type="text" name="publisher" style="width: 200px; height: 40px; font-size:16pt"></th>
			</tr>
			<tr>	
				<th><font size="5">Date Published: </font></th>
				<th><input type="date" name="publishDate" style="width: 200px; height: 40px; font-size:16pt"></th>
			</tr>
			<tr>
				<th><font size="5">Price: </font></th>
				<th><input type="number" name="priceLo" style="width: 98px; height: 40px; font-size:16pt">
				<input type="number" name="priceHi" style="width: 98px; height: 40px; font-size:16pt"></th>
			</tr>
			<?php
		}
	?>
	</table>
</form>

<?php	
	if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "Search"){
		$sql = "SELECT * FROM books, authors, keywords WHERE books.isbn = authors.authorid AND books.isbn = keywords.keyid";
		$sql = $sql." AND name LIKE '%{$_GET['search']}%'";
		if(isset($_GET['author'])){
			$sql = $sql." AND author_name LIKE '%{$_GET['author']}%'";
		}
		if(isset($_GET['subject'])){
			$sql = $sql." AND keyword LIKE '%{$_GET['subject']}%'";
		}
		if(isset($_GET['publisher'])){
			$sql = $sql." AND publisher LIKE '%{$_GET['publisher']}%'";
		}
		if(isset($_GET['publishDate'])){
			$sql = $sql." AND date_published LIKE '%{$_GET['publishDate']}%'";
		}
		if(isset($_GET['priceLo']) && $_GET['priceLo'] != ""){
			$sql = $sql." AND price >= ".(int)$_GET['priceLo'];
		}
		if(isset($_GET['priceHi']) && $_GET['priceHi'] != ""){
			$sql = $sql." AND price <= ".(int)$_GET['priceHi'];
		}
		$sql = $sql." ORDER BY name";
	}else{
		$sql = "SELECT * FROM books, authors WHERE books.isbn = authors.authorid ORDER BY RAND() LIMIT 5";

	}
	$results = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($results);
	echo "<table>";
	echo "<tr><th>Title</th><th>Author</th><th>Publisher</th><th>Price</th></tr>";
	while($row != NULL){
		echo "<tr>";
		echo "<td>".$row["name"]."</td>";
		echo "<td>".$row["author_name"]."</td>";
		echo "<td>".$row["publisher"]."</td>";
		echo "<td>$".$row["price"]."</td>";
		echo "</tr>";
		$row = mysqli_fetch_assoc($results);
	}
	echo "</table>";
	mysqli_close($conn);
?>
</center>
</body>
</html>