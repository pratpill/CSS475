<?php
$selectQuery = "SELECT * FROM MissingCase ORDER BY childID"; 
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

function test_input ($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<html>
<head>
<title>Missing Children Database Portal</title>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<style>
div {
	position: absolute;
	top:0;
	bottom: 0;
	left: 0;
	right: 0;
  	
	margin: auto;
}
</style>
</head>

<body>
<div>
<h1 style="align:center;">Missing Child Cases</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Value: <input type="text" name="val">
<select name="field">
  <option value="childID">Child ID</option>
  <option value="suspectID">Suspect ID</option>
</select><br>
<input type="submit">
</form>

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
      if ($key = "caseID") {
        echo "<td><a href=\"CSS475/query.php?id=".$value."\">".$value."</a></td>";

      } else {
        echo "<td>".$value."</td>";
      }
    }
    echo "</tr>";
  }
?>     
  </tbody>
</table>
</div>
</body>
</html>

