<?php
$selectQuery = "SELECT * FROM MissingCase"; 
$tableColumns = array("Case ID", "Potential Amber Alert", "Abduction", "Is in NCIC DB", "Report Type", "Search ID", "Amber Alert ID", "Child ID", "Media Release Request ID", "Private Detective ID", "Suspect ID");

$serverName = "vergil.u.washington.edu";
$username = "root";
$password = "uwu";
$conn = new mysqli($serverName, $username, $password, "Missing Children", 8448);

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

