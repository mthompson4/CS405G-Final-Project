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
		
		$sql = 'SELECT * FROM users WHERE email="'.$currentEmail.'" AND password="'.$currentPass.'"';
		$results = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($results) > 0){
			
			$row = mysqli_fetch_assoc($results);
			$currentUser =		$row["userid"];
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
		<form method="get" action="/mainPage.php">
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
	?>
	<th>
	<form method="post" action="/mainPage.php">
	<input type="submit" value="Home"/>
	</form>
	</th>
	<?php
	echo "</tr></table></br>";

	if(isset($_GET['buttonPressed'])){
		if($_GET['buttonPressed'] == "Submit"){
			if(!isset($currentFName)){
				echo '<meta http-equiv="refresh" content = "0; url = /index.html">';
			}else{
				echo "Review submitted. Redirecting...";
				$sql = "SELECT isbn FROM books WHERE name = '".$_GET['title']."'";
				$results = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($results);
				
				$userSub = mysqli_real_escape_string($conn, $currentUser);
				$isbnSub = mysqli_real_escape_string($conn, $row['isbn']);
				$scoreSub = mysqli_real_escape_string($conn, $_POST['score']);
				$reviewSub = mysqli_real_escape_string($conn, $_POST['review']);
				$sql = "INSERT INTO reviews (user, book, score, review) VALUES ('$userSub', '$isbnSub', '$scoreSub', '$reviewSub')";
				mysqli_query($conn, $sql);
				echo '<meta http-equiv="refresh" content = "2; url = /bookPage.php/?title='.$_GET['title'].'">';
			}
		}
	}else if(isset($_GET['title'])){
		$sql = "SELECT * FROM books, authors WHERE isbn = authorid AND name = '".$_GET['title']."' ORDER BY author_name";
		$authorResults = mysqli_query($conn, $sql);
		$sql = "SELECT * FROM books, keywords WHERE isbn = keyid AND name = '".$_GET['title']."' ORDER BY keyword";
		$keywordResults = mysqli_query($conn, $sql);
		$sql = "SELECT * FROM books, reviews, users WHERE isbn = book AND user = userid AND name = '".$_GET['title']."' ORDER BY score DESC";
		$reviewResults = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($authorResults) == 0)
			echo '<meta http-equiv="refresh" content = "0; url = /mainPage.php">';
		
		$sql = "SELECT isbn FROM books WHERE name = '".$_GET['title']."'";
		$resultISBN = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($resultISBN);
		?>
			</br></br><table style="float:right"><tr><th>
			<form method="get" action="/orderBook.php">
			<button name="isbn" value="<?php echo $row['isbn'];?>" align="right">Order</button>
			</form>
			</th></tr></table>
		<?php

		echo "<h2>".$_GET['title']."</h2>";

		$authorOutput = "<h4>By ";
		$authors = [];
		for($row = mysqli_fetch_assoc($authorResults); $row != NULL; $row = mysqli_fetch_assoc($authorResults)){
			$authors[] = $row['author_name'];
		}
		$authorOutput = $authorOutput.$authors[0];// first author
		for($i = 1; $i < count($authors) - 1; $i++){// each additional author
			$authorOutput = $authorOutput.", ".$authors[$i];
		}
		if(count($authors) > 1){// last author
			$authorOutput = $authorOutput." and ".$authors[count($authors)-1];
		}
		$authorOutput = $authorOutput."</h4>";
		echo $authorOutput;
		$keywords = "<h4 align='right'>Keywords:";
		for($row = mysqli_fetch_assoc($keywordResults); $row != NULL; $row = mysqli_fetch_assoc($keywordResults)){
			$keywords = $keywords." ".$row['keyword'];
		}
		$keywords = $keywords."</h4>";
		echo $keywords;
		echo "<center>".$row['summary']."";
		echo "<table bgcolor='#CCCCCC' style='border: 1px solid black; border-collapse: collapse;'>";
		for($row = mysqli_fetch_assoc($reviewResults); $row != NULL; $row = mysqli_fetch_assoc($reviewResults)){
			echo "<tr style='border: 1px solid black; border-collapse: collapse;'>";
			echo "<th>".$row['fname']."</th>";
			echo "<th>".$row['score']."/5</th>";
			echo "<th>".$row['review']."</th>";
			echo "</tr>";
		}
		echo "</table></center>";
		?>
		<form method="post" action="?buttonPressed=Submit&title=<?php echo $_GET['title'];?>">
		<h4>Leave a review: </h4>
		<input  name="score" type="number" min="0" max="5"> /5</br>
		<textarea name="review" cols="50" rows="10" maxlength="500">Write your review here!</textarea></br>
		<input type="submit" name="buttonPressed" value="Submit" style="width: 150px; height: 40px; font-size:12pt">
		</form>
		<?php
	}else {
		echo '<meta http-equiv="refresh" content = "0; url = /mainPage.php">';
	}
	
?>



<?php
	mysqli_close($conn);
?>
</body>
</html>