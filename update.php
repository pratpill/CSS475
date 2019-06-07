<?php
$serverName = "vergil.u.washington.edu";
$username = "root";
$password = "uwu";
$conn = new mysqli($serverName, $username, $password, "Missing Children", 8448);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_val = escape($_POST["id"]);
    if($conn->query("SELECT * FROM MissingCase WHERE caseID = ".$id_val)->num_rows 
			< 1) {
			die("Bad Case ID, try again from the beginning");			
    }

} else {
    $id_val = escape($_GET["id"]);
    if($conn->query("SELECT * FROM MissingCase WHERE caseID = ".$id_val)->num_rows 
			< 1) {
			die("Bad Case ID, try again from the beginning");			
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $updateQuery = "INSERT INTO PublicationRequest(signature, signatureDate, printName, relationshipCode, requesterphoneNo) VALUES (";
  $getPubReqPrimKeyQueryHead = "SELECT requestID FROM PublicationRequest WHERE signatureDate = ";
  $setPubReqInMissingCaseQueryHead = "UPDATE MissingCase SET requestID = ";
  $setPubReqInMissingCaseQueryTail = " WHERE caseId = ";
  $signed = $_POST["signed"] ? "1" : "0";
  $date = htmlspecialchars($_POST["date"]);
  $name = escape($_POST["name"]);
  $relation = escape($_POST["relation"]);
  $phone = escape($_POST["phone"]);

  // TODO: validate here.

  if ($conn->connect_error) {
    die("Failed to connect to database: ".$conn->connect_error);
  }

  $results = $conn->query($updateQuery.$signed.", ".$date.", ".$name.", ".$relation.", ".$phone);
  $primKey = $conn->query($getPubReqPrimKeyQueryHead.$date." AND printName = ".$name." AND relationshipCode = ".
			$relation." AND requesterphoneNo = ".$phone).fetch_row()[0];
  $conn->query($setPubReqInMissingCaseQueryHead.$id_val.$setPubReqInMissingCaseQueryTail.$primKey);

  mysqli_close($conn);
}

function escape ($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<html>
<head>
  <title>Missing Children Database Portal</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>

  <style>
    
  </style>
</head>

<div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="align:center;">
  Sign Here: <input type="checkbox" name="signed">
  Sign Date: <input type="text" placeholder="<?php  echo date("Y-m-d H:i:s"); ?>" name="date">
  Print Name: <input type="text" name="name">
  Relationship: <select name="relation">
	<option value="Father">Father</option>
	<option value="Mother">Mother</option>
	<option value="Grandfather">Grandfather</option>
	<option value="Grandmother">Grandmother</option>
  </select>
  Phone Number: <input type="text" name="phone">
  <input type="submit">
</form>

</div>
</html>
