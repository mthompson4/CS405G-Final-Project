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
				echo "User ".$row["fname"]." has been promoted to Manager.";
			}
			else if($_GET['userChange'.$row["userid"]] == "demote"){
				$sqlupdate = "UPDATE users SET user_type = 'Customer' WHERE userid = ".$row["userid"];
				mysqli_query($conn, $sqlupdate);
				echo "User ".$row["fname"]." has been demoted to Customer.";
			}
			else if($_GET['userChange'.$row["userid"]] == "delete"){
				$sqlupdate = "DELETE FROM users WHERE userid = ".$row['userid'];
				mysqli_query($conn, $sqlupdate);
				echo "User ".$row["fname"]." has been removed from the database.";
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
	
	mysqli_close($conn);
?>

</body>
</html>