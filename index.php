<?php
$serverName = "localhost";
$username = "root";
$password = "uwu";
$conn = new mysqli($serverName, $username, $password);

if ($conn->connect_error) {
	die("Failed to connect to database: ".$conn->connect_error);
}
?>
<html>
<head>
<title>PHP in HTML Example</title>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
</head>
<body>
<h1>Short code <?=?></h1>
</body>
</html>
