<?php

	$serverName = "127.0.0.1";
	$serverUserName = "admin";
	$serverPassword = "3j2l3j2klb3b2klb32l";
	$dbName = "bookstore";

	$conn = mysqli_connect($serverName, $serverUserName, $serverPassword, $dbName);

	if(!$conn){
		die("Connection Failed: ".mysqli_connect_error());
	}

	
	if(!isset($_COOKIE["user"])){
		echo '<meta http-equiv="refresh" content = "2; url = index.html">';
		echo 'die';
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

<div>
	<center><h1><font size="7">Bookstore Database</font></h1></center>
</div>

<h3 align='right'>
<form method="post" action="/mainPage.php">
<input type="submit" value="Home"/>
</form>
</h3>
<?php
	if(!isset($_GET['isbn']) || !isset($currentUser)){
		echo '<meta http-equiv="refresh" content = "0; url = /index.html">';
	}
	if(!isset($_GET['buttonPressed'])){
?>
		<form action="/orderBook.php/?buttonPressed=Order&isbn=<?php echo $_GET['isbn'];?>" method="post">
		<center>
		<table>
		<tr><th><font size='5'>Name on Credit Card: </font></th><th><input type="text" name="ccname" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Credit Card Number: </font></th><th><input type="text" name="ccnum" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Credit Card Type: </font></th><th><input type="text" name="cctype" style="width: 200px; height: 25px"></th></tr>
		<tr><th><font size='5'>Exp. Date: </font></th><th><input type="date" name="ccdate" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>CVV: </font></th><th><input type="text" name="cvv" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Shipping Street Address: </font></th><th><input type="text" name="ssa" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Shipping City: </font></th><th><input type="text" name="sc" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Shipping State: </font></th><th><input type="text" name="ss" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Shipping Zip: </font></th><th><input type="text" name="sz" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Billing Street Address: </font></th><th><input type="text" name="bsa" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Billing City: </font></th><th><input type="text" name="bc" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Billing State: </font></th><th><input type="text" name="bs" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Billing Zip: </font></th><th><input type="text" name="bz" style="width: 200px; height: 25px" required></th></tr>
		<tr><th><font size='5'>Quantity: </font></th><th><input type="number" name="qty" style="width: 200px; height: 25px" required></th></tr>
		</table><br/>
		<input type="submit" name = "buttonPressed" value="Order" style="width: 150px; height: 40px; font-size:12pt">
		</center>
		</form>
		
		<center><h2></br>Order History</h2><table bgcolor='#CCCCCC' style='border: 1px solid black; border-collapse: collapse;'>
		<tr>
			<th>Book Name</th>
			<th>Date Ordered</th>
			<th>Quantity</th>
			<th>Cost</th>
			<th>Status</th>
		</tr>
		<?php
			$sql = "SELECT name, date_ordered, orders.qty, cost, order_status FROM orders, books WHERE book_ordered = isbn AND buyer = '".$currentUser."' ORDER BY order_num DESC";
			$results = mysqli_query($conn, $sql);
			for($row = mysqli_fetch_assoc($results); $row != NULL; $row = mysqli_fetch_assoc($results)){
				echo '<tr style="border: 1px solid black; border-collapse: collapse;">';
					echo '<td>';
						echo $row['name'];
					echo '</td>';
					echo '<td>';
						echo $row['date_ordered'];
					echo '</td>';
					echo '<td>';
						echo $row['qty'];
					echo '</td>';
					echo '<td>';
						echo $row['cost'];
					echo '</td>';
					echo '<td>';
						echo $row['order_status'];
					echo '</td>';
				echo '</tr>';
			}
		?>
		</table>
		</center>
<?php
	}else if($_GET['buttonPressed'] == "Order"){
		$insert_ccname = mysqli_real_escape_string($conn, $_POST["ccname"]);
		$insert_ccnum = mysqli_real_escape_string($conn, $_POST["ccnum"]);
		$insert_cctype = mysqli_real_escape_string($conn, $_POST["cctype"]);
		$insert_ccdate = mysqli_real_escape_string($conn, $_POST["ccdate"]);
		$insert_cvv = mysqli_real_escape_string($conn, $_POST["cvv"]);
		$insert_ssa = mysqli_real_escape_string($conn, $_POST["ssa"]);
		$insert_sc = mysqli_real_escape_string($conn, $_POST["sc"]);
		$insert_ss = mysqli_real_escape_string($conn, $_POST["ss"]);
		$insert_sz = mysqli_real_escape_string($conn, $_POST["sz"]);
		$insert_bsa = mysqli_real_escape_string($conn, $_POST["bsa"]);
		$insert_bc = mysqli_real_escape_string($conn, $_POST["bc"]);
		$insert_bs = mysqli_real_escape_string($conn, $_POST["bs"]);
		$insert_bz = mysqli_real_escape_string($conn, $_POST["bz"]);
		$insert_isbn = mysqli_real_escape_string($conn, $_GET["isbn"]);
		$insert_date = mysqli_real_escape_string($conn, date("Y-m-d H:i:s"));
		$insert_qty = mysqli_real_escape_string($conn, $_POST["qty"]);
		
		$sql = "SELECT price FROM books WHERE isbn = ".$_GET['isbn'];
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$insert_price = mysqli_real_escape_string($conn, (int)$row['price'] * (int)$_POST['qty']);
		
		$sql = "INSERT INTO orders(buyer, book_ordered, date_ordered, qty, cost, order_status, cc_type, cc_num, cc_expdate, cc_cvv, cc_name, ba_street, ba_city, ba_state, ba_zip, sa_street, sa_city, sa_state, sa_zip)
				VALUES('$currentUser', '$insert_isbn', '$insert_date', $insert_qty, $insert_price, 'Processing', '$insert_cctype', '$insert_ccnum', '$insert_ccdate', '$insert_cvv', '$insert_ccname', '$insert_bsa', '$insert_bc', '$insert_bs', '$insert_bz', '$insert_ssa', '$insert_sc', '$insert_ss', '$insert_sz')";
		mysqli_query($conn, $sql);
		echo mysqli_error($conn);
		echo "Book ordered. Redirecting...";
		echo '<meta http-equiv="refresh" content = "2; url = /mainPage.php">';
	}
	mysqli_close($conn);
?>

</body>
</html>