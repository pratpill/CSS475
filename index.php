<?php
$selectQuery = ""; // TODO: this
$tableColumns = array(); //TODO: this

$serverName = "localhost";
$username = "root";
$password = "uwu";
$conn = new mysqli($serverName, $username, $password, "Missing Children");

if ($conn->connect_error) {
        die("Failed to connect to database: ".$conn->connect_error);
}

$results = $conn->query($selectQuery);

mysqli_close($conn);
?>
<html>
<head>
<title>PHP in HTML Example</title>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
</head>
<body>
<h1>Data in table (TODO: name table)</h1>
<table class="table">
  <thead>
    <tr>
<?php
foreach ($tableColumns as &$column) {
	echo "<th>".$column."</th>";
}
?> 
    </tr>
  </thead>
  <tbody>
<?php
while ($row = $results->fetch_assoc()) {
echo "<tr>";
foreach ($row as $key => $value) {
	echo "<td>".$key."</td>";
}
echo "</tr>";
}
?>     
  </tbody>
</table>
</body>
</html>

