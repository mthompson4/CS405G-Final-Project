<?php

	$serverName = "127.0.0.1";
	$serverUserName = "admin";
	$serverPassword = "3j2l3j2klb3b2klb32l";
	$dbName = "bookstore";

	$conn = mysqli_connect($serverName, $serverUserName, $serverPassword, $dbName);

	if(!$conn){
		die("Connection Failed: ".mysqli_connect_error());
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

<div>
	<center><h1><font size="7">Bookstore Database</font></h1></center>
</div>

<h3 align='right'>
<form method="post" action="/mainPage.php">
<input type="submit" value="Home"/>
</form>
</h3>

<center>
	<form method="get">
	<input type="submit" name="buttonPressed" value="Show Users" style="width: 150px; height: 40px; font-size:12pt">
	<input type="submit" name="buttonPressed" value="Add Book" style="width: 150px; height: 40px; font-size:12pt">
	</form>
</center>

<?php
	if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "Show Users"){
		$sql = "SELECT * FROM users";
		$results = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($results);
		echo '<form method = "get">';
		echo "<table>";
		echo "<tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Age</th><th>Gender</th><th>User Type</th><th>Option</th></tr>";
		while($row != NULL){
			echo "<tr>";
			echo "<td>".$row["fname"]."</td>";
			echo "<td>".$row["mname"]."</td>";
			echo "<td>".$row["lname"]."</td>";
			echo "<td>".$row["email"]."</td>";
			echo "<td>".$row["password"]."</td>";
			echo "<td>".$row["age"]."</td>";
			echo "<td>".$row["gender"]."</td>";
			echo "<td>".$row["user_type"]."</td>";
			echo "<td>";
			echo "<select name = 'userChange".$row["userid"]."'>";
			?>
			
				<option value="">--</option>
				<option value="promote">Promote</option>
				<option value="demote">Demote</option>
				<option value="delete">Delete</option>
			</select>
			
			</td>
			<?php
			echo "</tr>";
			
			$row = mysqli_fetch_assoc($results);
		}
		?>
			</table>
			<input type="submit" name="buttonPressed" value="Confirm" style="width: 150px; height: 40px; font-size:12pt">
			</form>
		<?php
	}
	else if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "Confirm"){
		$sql = "SELECT * FROM users";
		$results = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($results);
		//echo '<form method = "get">';
		//echo "<table>";
		//echo "<tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Age</th><th>Gender</th><th>User Type</th><th>Option</th></tr>";
		while($row != NULL){
			if($_GET['userChange'.$row["userid"]] == "promote"){
				$sqlupdate = "UPDATE users SET user_type = 'Manager' WHERE userid = ".$row["userid"];
				mysqli_query($conn, $sqlupdate);
				echo "User ".$row["fname"]." has been promoted to Manager.<br/>";
			}
			else if($_GET['userChange'.$row["userid"]] == "demote"){
				$sqlupdate = "UPDATE users SET user_type = 'Customer' WHERE userid = ".$row["userid"];
				mysqli_query($conn, $sqlupdate);
				echo "User ".$row["fname"]." has been demoted to Customer.<br/>";
			}
			else if($_GET['userChange'.$row["userid"]] == "delete"){
				$sqlupdate = "DELETE FROM users WHERE userid = ".$row['userid'];
				mysqli_query($conn, $sqlupdate);
				echo "User ".$row["fname"]." has been removed from the database.<br/>";
			}
			/*echo "<tr>";
			echo "<td>".$row["fname"]."</td>";
			echo "<td>".$row["mname"]."</td>";
			echo "<td>".$row["lname"]."</td>";
			echo "<td>".$row["email"]."</td>";
			echo "<td>".$row["password"]."</td>";
			echo "<td>".$row["age"]."</td>";
			echo "<td>".$row["gender"]."</td>";
			echo "<td>".$row["user_type"]."</td>";
			echo "<td>";
			echo "<select name = 'userChange".$row["userid"]."'>";
			?>
			
				<option value="">--</option>
				<option value="promote">Promote</option>
				<option value="demote">Demote</option>
				<option value="delete">Delete</option>
			</select>
			
			</td>
			<?php
			echo "</tr>";
			echo "</table>";*/
			$row = mysqli_fetch_assoc($results);
		}
		?>
			<!--<input type="submit" name="buttonPressed" value="Confirm" style="width: 150px; height: 40px; font-size:12pt">
			</form>-->
		<?php
	}
	else if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "Add Book"){
		?>
		<div>
		<center><h1><font size="7">Add New Book</font></h1></center>
		</div>
		<form action="/managerOptions.php/?buttonPressed=Add" method="post">
		<center>
		<table>
		<tr><th><font size='5'>Title: </font></th><th><input type="text" name="newBookTitle" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Summary: </font></th><th><input type="text" name="newBookSummary" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Language: </font></th><th><input type="text" name="newBookLanguage" style="width: 200px; height: 25px"></th></tr>
		<tr><th><font size='5'>Publisher: </font></th><th><input type="text" name="newBookPublisher" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Date Published: </font></th><th><input type="date" name="newBookDate" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Price: </font></th><th><input type="number" name="newBookPrice" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Quantity: </font></th><th><input type="number" name="newBookQuantity" style="width: 200px; height: 25px" required></th></tr>
		</table><br/>
		<input type="submit" name = "buttonPressed" value="Add" style="width: 150px; height: 40px; font-size:12pt">
		</center>
		</form>
		<?php
	}
	else if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "Add"){
		//echo "hi";
		$insertingTitle = $_POST["newBookTitle"];
		$insertingSummary = $_POST["newBookSummary"];
		$insertingLanguage = $_POST["newBookLanguage"];
		$insertingPublisher = $_POST["newBookPublisher"];
		$insertingDate = $_POST["newBookDate"];
		$insertingPrice = $_POST["newBookPrice"];
		$insertingQuantity = $_POST["newBookQuantity"];
		
		$sql = "INSERT INTO books(name, summary, language, publisher, date_published, price, qty)
				VALUES('$insertingTitle', '$insertingSummary', '$insertingLanguage', '$insertingPublisher', '$insertingDate', '$insertingPrice', '$insertingQuantity')";
		mysqli_query($conn, $sql);
	}
	mysqli_close($conn);
?>

</body>
</html>