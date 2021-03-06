<?php
$serverName = "vergil.u.washington.edu";
$username = "root";
$password = "uwu";
$conn = new mysqli($serverName, $username, $password, "Missing Children", 8448);

$id_val = escape($_GET["id"]);
if($conn->query("SELECT * FROM MissingCase WHERE caseID = ".$id_val)->num_rows 
  < 1) {
	die("Bad Case ID, try again from the beginning");			
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $updateQuery = "INSERT INTO PublicationRequest (signature, signatureDate, printName, relationshipCode, requesterphoneNo) VALUES (";
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

  $updateSql = $updateQuery.$signed.", '".$date."', '".$name."', '".$relation."', ".$phone.");";
  if($conn->query($updateSql) === FALSE) {
    die($updateSql."\n".$conn->error);
  }

  $primKey = $conn->insert_id;
  $keySetSql = $setPubReqInMissingCaseQueryHead.$primKey.$setPubReqInMissingCaseQueryTail.$id_val;
  if($conn->query($keySetSql) === FALSE) {
    die($keySetSql."\n".$conn->error);
  }

  header("Location: query.php?id=".$id_val);
  die();

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

<div style="padding:30px;">
<h1>Make new publication request:</h1>
<p>Warning: Company policy dictates that we only hold one publication request open per case.</p>
<p>It is on the user of this web API to ensure that the currently linked publication request is not still open</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $id_val ?>" 
	method="post" style="align:center;">

  Sign Here: <input type="checkbox" name="signed">
  Sign Date: <input type="text" value="<?php  echo date("Y-m-d H:i:s"); ?>" name="date">
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
