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

    echo "This that manager options page shit nigga."


?>

</body>
</html>
