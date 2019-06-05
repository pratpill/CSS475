<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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