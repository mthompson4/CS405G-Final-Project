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
<input type="submit" value="Home" style="width: 150px; height: 40px; font-size:12pt"/>
</form>
</h3>

<center>
	<form method="get">
	<input type="submit" name="buttonPressed" value="Show Users" style="width: 150px; height: 40px; font-size:12pt">
	<input type="submit" name="buttonPressed" value="Add Book" style="width: 150px; height: 40px; font-size:12pt">
	<input type="submit" name="buttonPressed" value="Edit Books" style="width: 150px; height: 40px; font-size:12pt">
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
		<tr><th><font size='5'>Authors: </font></th><th><input type="text" name="newBookAuthors" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Summary: </font></th><th><input type="text" name="newBookSummary" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Language: </font></th><th><input type="text" name="newBookLanguage" style="width: 200px; height: 25px"></th></tr>
		<tr><th><font size='5'>Publisher: </font></th><th><input type="text" name="newBookPublisher" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Date Published: </font></th><th><input type="date" name="newBookDate" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Price: </font></th><th><input type="number" name="newBookPrice" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Quantity: </font></th><th><input type="number" name="newBookQuantity" style="width: 200px; height: 25px" required></th></tr>	
		<tr><th><font size='5'>Keywords: </font></th><th><input type="text" name="newBookKeywords" style="width: 200px; height: 25px" required></th></tr>
		</table><br/>
		<input type="submit" name = "buttonPressed" value="Add" style="width: 150px; height: 40px; font-size:12pt">
		</center>
		</form>
		<?php
	}
	else if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "Add"){
		$insertingTitle = $_POST["newBookTitle"];
		$insertingAuthors = $_POST["newBookAuthors"];
		$insertingSummary = $_POST["newBookSummary"];
		$insertingLanguage = $_POST["newBookLanguage"];
		$insertingPublisher = $_POST["newBookPublisher"];
		$insertingDate = $_POST["newBookDate"];
		$insertingPrice = $_POST["newBookPrice"];
		$insertingQuantity = $_POST["newBookQuantity"];
		$insertingKeywords = $_POST['newBookKeywords'];
		
		$sql = "INSERT INTO books(name, summary, language, publisher, date_published, price, qty)
				VALUES('$insertingTitle', '$insertingSummary', '$insertingLanguage', '$insertingPublisher', '$insertingDate', '$insertingPrice', '$insertingQuantity')";
		mysqli_query($conn, $sql);
		$authorlist = explode(",", $insertingAuthors);
		$sqlgetnewisbn = "SELECT isbn FROM books WHERE name = '".$insertingTitle."'";
		$newisbncall = mysqli_query($conn, $sqlgetnewisbn);
		$row = mysqli_fetch_assoc($newisbncall);
		$newisbn = $row['isbn'];
		for($x = 0; $x < count($authorlist); $x++){
			$sqlAddNewAuthors = "INSERT INTO authors(authorid, author_name) VALUES(".$newisbn.", '".$authorlist[$x]."')";
			mysqli_query($conn, $sqlAddNewAuthors);
		}
		$keywordlist = explode(",", $insertingKeywords);
		for($x = 0; $x < count($keywordlist); $x++){
			$sqlAddNewKeywords = "INSERT INTO keywords(keyid, keyword) VALUES(".$newisbn.", '".$keywordlist[$x]."')";
			mysqli_query($conn, $sqlAddNewKeywords);
		}
		
	}
	else if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "Edit Books"){
		$sql = "SELECT * FROM books";
		$results = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($results);
		echo '<form method = "get">';
		echo "<center>";
		echo "<table bgcolor='#CCCCCC' style='border: 1px solid black; border-collapse: collapse;'>";
		echo "<tr style='border: 1px solid black; border-collapse: collapse;'><th>Title</th><th>ISBN</th><th>Authors</th><th>Summary</th><th>Language</th><th>Publisher</th><th>Publishing Date</th><th>Price</th><th>Quantity</th><th>Keywords</th><th>Edit</th><th>Delete</th></tr>";
		while($row != NULL){
			echo "<tr style='border: 1px solid black; border-collapse: collapse;'>";
			echo "<td>".$row["name"]."</td>";
			echo "<td>".$row["isbn"]."</td>";
			$sqlgetauthors = "SELECT author_name FROM authors WHERE authorid = ".$row['isbn'];
			$authorlist = mysqli_query($conn, $sqlgetauthors);
			$currentAuthor = mysqli_fetch_assoc($authorlist);
			$authors = "";
			while($currentAuthor != NULL){
				$authors = $authors.$currentAuthor['author_name']."</br>";
				$currentAuthor = mysqli_fetch_assoc($authorlist);
			}
			
			echo "<td>$authors</td>";
			echo "<td>".$row["summary"]."</td>";
			echo "<td>".$row["language"]."</td>";
			echo "<td>".$row["publisher"]."</td>";
			echo "<td>".$row["date_published"]."</td>";
			echo "<td>".$row["price"]."</td>";
			echo "<td>".$row["qty"]."</td>";
			$sqlgetkeywords = "SELECT keyword FROM keywords WHERE keyid = ".$row['isbn'];
			$keywordlist = mysqli_query($conn, $sqlgetkeywords);
			$currentKeyword = mysqli_fetch_assoc($keywordlist);
			$keys = "";
			while($currentKeyword != NULL){
				$keys = $keys.$currentKeyword['keyword']."</br>";
				$currentKeyword = mysqli_fetch_assoc($keywordlist);
			}
			
			echo "<td>$keys</td>";
			
			echo "<form method='get'>";
			echo "<td>";
			echo "<input type='submit' name='Edit".$row['isbn']."' value='Edit'>";
			echo "</td>";
			echo "<td>";
			echo "<input type='submit' name='Delete".$row['isbn']."' value='Delete'>";
			echo "</td>";
			echo "</form>";

			echo "</tr>";
			
			$row = mysqli_fetch_assoc($results);
		}
		?>
			</table>
			</center>
			</form>
		<?php
	}
	$sqlcheck = "SELECT * FROM books";
	$resultscheck = mysqli_query($conn, $sqlcheck);
	$row = mysqli_fetch_assoc($resultscheck);
	while($row != NULL){
		if(isset($_GET['Edit'.$row['isbn']]) && $_GET['Edit'.$row['isbn']] == "Edit"){
			?>
			<div>
		<center><h1><font size="7">Add New Book</font></h1></center>
		</div>
		<form action="/managerOptions.php/?buttonPressed=confirmChanges&ISBN=<?php echo htmlspecialchars($row['isbn']) ?>" method="post">
		<center>
		<table>
		<tr><th><font size='5'>Title: </font></th><th><input type="text" name="editedBookTitle" style="width: 200px; height: 25px" value = "<?php echo htmlspecialchars($row["name"])?>" required></th></tr>
		<?php
		
		$sqlauthors = "SELECT author_name FROM authors WHERE authorid = ".$row['isbn'];
		$authorresults = mysqli_query($conn, $sqlauthors);
		$authorRow = mysqli_fetch_assoc($authorresults);
		$authorString = "";
		$index = 1;
		while($authorRow != NULL){
			$authorString = $authorString.$authorRow['author_name'];
			if(mysqli_num_rows($authorresults) - $index != 0){
				$authorString = $authorString.", ";
			}
			$authorRow = mysqli_fetch_assoc($authorresults);
			$index++;
		}
		
		?>
		<tr><th><font size='5'>Authors: </font></th><th><input type="text" name="editedBookAuthors" style="width: 200px; height: 25px" value = "<?php echo $authorString ?>" required></th></tr>
		<tr><th><font size='5'>Summary: </font></th><th><input type="text" name="editedBookSummary" style="width: 200px; height: 25px" value = "<?php echo htmlspecialchars($row["summary"])?>" required></th></tr>
		<tr><th><font size='5'>Language: </font></th><th><input type="text" name="editedBookLanguage" style="width: 200px; height: 25px" value = "<?php echo htmlspecialchars($row["language"])?>"></th></tr>
		<tr><th><font size='5'>Publisher: </font></th><th><input type="text" name="editedBookPublisher" style="width: 200px; height: 25px" value = "<?php echo htmlspecialchars($row["publisher"])?>" required></th></tr>
		<tr><th><font size='5'>Date Published: </font></th><th><input type="date" name="editedBookDate" style="width: 200px; height: 25px" value = "<?php echo htmlspecialchars($row["date_published"])?>" required></th></tr>
		<tr><th><font size='5'>Price: </font></th><th><input type="number" name="editedBookPrice" style="width: 200px; height: 25px" value = "<?php echo htmlspecialchars($row["price"])?>" required></th></tr>
		<tr><th><font size='5'>Quantity: </font></th><th><input type="number" name="editedBookQuantity" style="width: 200px; height: 25px" value = "<?php echo htmlspecialchars($row["qty"])?>" required></th></tr>
		<?php
		
		$sqlkeywords = "SELECT keyword FROM keywords WHERE keyid = ".$row['isbn'];
		$keywordresults = mysqli_query($conn, $sqlkeywords);
		$keywordRow = mysqli_fetch_assoc($keywordresults);
		$keywordString = "";
		$index = 1;
		while($keywordRow != NULL){
			$keywordString = $keywordString.$keywordRow['keyword'];
			if(mysqli_num_rows($keywordresults) - $index != 0){
				$keywordString = $keywordString.", ";
			}
			$keywordRow = mysqli_fetch_assoc($keywordresults);
			$index++;
		}
		
		?>
		<tr><th><font size='5'>Keywords: </font></th><th><input type="text" name="editedBookKeywords" style="width: 200px; height: 25px" value = "<?php echo $keywordString ?>" required></th></tr>
		</table><br/>
		<input type="submit" name = "buttonPressed" value="Confirm Changes" style="width: 150px; height: 40px; font-size:12pt">
		</center>
		</form>	
				
			<?php
		}
		else if(isset($_GET['Delete'.$row['isbn']]) && $_GET['Delete'.$row['isbn']] == "Delete"){
				$sqlremove = "DELETE FROM books WHERE isbn = ".$row['isbn'];
				mysqli_query($conn, $sqlremove);
				echo mysqli_error($conn);
				echo "Book removed from database.";
		}
		
		$row = mysqli_fetch_assoc($resultscheck);
	}
	if(isset($_GET['buttonPressed']) && $_GET['buttonPressed'] == "confirmChanges"){
			if(isset($_GET['ISBN'])){
				$editingISBN = $_GET['ISBN'];
			}
			$sqledit = "UPDATE books SET name = '".$_POST['editedBookTitle']."', summary = '".$_POST['editedBookSummary']."', language = '".$_POST['editedBookLanguage']."', publisher = '".$_POST['editedBookPublisher']."', date_published = '".$_POST['editedBookDate']."', price = '".$_POST['editedBookPrice']."', qty = '".$_POST['editedBookQuantity']."' WHERE isbn = ".$editingISBN; 
			mysqli_query($conn, $sqledit);
			$keywordArray = explode(",", $_POST['editedBookKeywords']);
			$sqlDeleteCurrentKeywords = "DELETE FROM keywords WHERE keyid = ".$_GET['ISBN'];
			mysqli_query($conn, $sqlDeleteCurrentKeywords);
			for($x = 0; $x < count($keywordArray); $x++){
				$sqlAddNewKeywords = "INSERT INTO keywords(keyid, keyword) VALUES(".$_GET['ISBN'].", '".$keywordArray[$x]."')";
				mysqli_query($conn, $sqlAddNewKeywords);
			}
			$authorArray = explode(",", $_POST['editedBookAuthors']);
			$sqlDeleteCurrentAuthors = "DELETE FROM authors WHERE authorid = ".$_GET['ISBN'];
			mysqli_query($conn, $sqlDeleteCurrentAuthors);
			for($x = 0; $x < count($authorArray); $x++){
				$sqlAddNewAuthors = "INSERT INTO authors(authorid, author_name) VALUES(".$_GET['ISBN'].", '".$authorArray[$x]."')";
				mysqli_query($conn, $sqlAddNewAuthors);
			}
			//echo "$sqledit<br/>";
			echo "Book updated in database.";
	}
	mysqli_close($conn);
?>

</body>
</html>