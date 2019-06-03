<!DOCTYPE html>

<html>

<head>
  <title>Missing Child Detailed Page</title>
</head>

<body>

<?php
function getConnToDb(){
    $serverName = "vergil.u.washington.edu";
    $username = "root";
    $password = "uwu";
    $conn = new mysqli($serverName, $username, $password, "Missing Children", 8448);
    if ($conn->connect_error) {
      die("Failed to connect to database: ".$conn->connect_error);
    }
    return $conn;
}
function closeConnection($conn)
{
    mysqli_close($conn);
}
function getInfo($caseID, $conn)
{
    $selectQuery = "SELECT * FROM (SELECT * FROM MissingCase WHERE caseID = ".$caseID.") c".
    " INNER JOIN (SELECT * FROM Search) s ON s.SearchID = c.searchID".
    " INNER JOIN (SELECT * FROM AmberAlert) a ON a.AlertID = c.amberAlertID".
    " INNER JOIN (SELECT * FROM Child INNER JOIN Address ON Child.Adddress = Address.AddressID) k ON k.ChildID = c.childID".
    " INNER JOIN (SELECT * FROM PrivateDetective) pd ON pd.pdID = c.pdID".
    " INNER JOIN (SELECT * FROM ParentContact) pc ON pc.ParentContactId = k.ParentContactId"
    ;
    $results = $conn->query($selectQuery);
    return $results;
}
function getVolunteerInfo($caseId, $conn)
{
    $selectQuery = "SELECT * FROM (SELECT * FROM MissingCase WHERE caseID = ".$caseID.") c".
    " INNER JOIN (SELECT * FROM SearchVolunteer) sv on c.searchID = sv.searchID".
    " INNER JOIN (SELECT * FROM Volunteer) v on v.ID = sv.volunteerID";
    $vol_results = $conn->query($selectQuery);
    return $vol_results;

}
$id_val = $_GET["id"];
echo("Child Id=".$id_val);
echo("Connecting to database");
$conn = getConnToDb();
echo("Connected to database");
echo("Get Child Info");
$results = getInfo($id_val, $conn);
$vol_results = getVolunteerInfo($id_val, $conn);
echo("close connection");
closeConnection($conn);
?>
<h1>Missing Child Detailed Page</h1>
<hr>
<h2>Child Details</h2>
<h3>Profile</h3>
 <?php
     if ($results->num_rows > 0)
     {
        $row = $results->fetch_row();
?>
<form>
    <p style="padding-right: 132px;">
        <b style="padding-right: 30px;">First Name:</b> 
	<input type="text" style="padding-right: 40px;" value=<?php echo($row[22]) ?> disabled />
        <b style="padding-left: 30px;">Last Name:</b> 
	<b style="padding-left: 25px;" ></b>
	<input type="text" style="padding-right: 40px;" value=<?php echo($row[23]) ?> disabled />
    </p>
    <p style="padding-right: 40px;">
        <b>Gender:</b> <input type="text" value=<?php echo($row[21]) ?> disabled />
        <b>Race:</b> <input type="text" value=<?php echo($row[20]) ?> disabled />
        <b>Last Seen:</b> <input type="text" value=<?php echo($row[16]) ?> disabled />
    </p>
    <p style="padding-right: 10px;"></p>
    <p style="padding-right: 40px;">
        <b>Address:</b> 
        <input type="text" size="5" value=<?php printf('%s',$row[40])?> disabled />
        <input type="text" size="20" value=
                <?php 
                     echo($row[41]);
                 ?> 
                disabled />
        <input type="text" size="18" value=<?php printf('%s',$row[38])?> disabled />
        <input type="text" size="18" value=<?php printf('%s',$row[39])?> disabled />
        <input type="text" size="5" value=<?php printf('%s',$row[37])?> disabled />
                  
    </p>
</form>
<h3>Parents</h3>
<form>
    <p style="padding-right: 132px;">
        <b style="padding-right: 30px;">First Name:</b>
	<input type="text" style="padding-right: 40px;" value=<?php echo($row[48]) ?> disabled />
        <b style="padding-left: 30px;">Last Name:</b> 
	<b style="padding-left: 25px;" ></b>
	<input type="text" style="padding-right: 40px;" value=<?php echo($row[49]) ?> disabled />
    </p>
    <p style="padding-right: 40px;">
        <b style="padding-right: 62px;">Phone:</b>
        <input type="text" size="27" value=<?php printf('%s',$row[51])?> disabled />
    </p>
</form>
<hr>
<h2>Progress</h2>
<h3>Alerts</h3>
<h3>Detectives</h3>
<form>
    <p style="padding-right: 132px;">
        <b style="padding-right: 30px;">First Name:</b>
	<input type="text" style="padding-right: 40px;" value=<?php echo($row[43]) ?> disabled />
        <b style="padding-left: 30px;">Last Name:</b> 
	<b style="padding-left: 25px;" ></b>
	<input type="text" style="padding-right: 40px;" value=<?php echo($row[44]) ?> disabled />
    </p>
    <p style="padding-right: 40px;">
</form>
<h3>Volunteers</h3>
<?php
        if ($vol_results->num_rows > 0) {
?>
<table>
<tr>
   <td> First Name </td>
   <td> Last  Name </td>
</tr>
<?php
           while ($vrow = $vol_results->fetch_assoc()) {

             echo "<tr>";

             foreach ($vrow as $key => $value) {

               if (($key == "FirstName") || ($key == "LastName"))  {

                 echo "<td> echo($value)</td>";
               }

   	     }
   
             echo "</tr>";
           }
?>
</table>
<?php
        }
        else
        {
          echo "No Volunteers";
        }
?>
<hr>
<h2>Raw Data</h2>
 <?php
            #echo ($row["ChildID"]);
            foreach ($row as $key => $value) {
                echo("<p>");
                echo($key.": ");
                echo($value." ");
                echo("</p>");
            }


        }
        else
        {
            echo("no results have returned");
        }
?>
</body>
</html>

