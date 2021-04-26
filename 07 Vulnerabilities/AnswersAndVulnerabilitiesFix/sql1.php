<!DOCTYPE html>
<html>
<head>
  <title>SQL Injection</title>
  <link rel="shortcut icon" href="../Resources/hmbct.png" />
</head>
<body>

<div style="background-color:#c9c9c9;padding:15px;">
  <button type="button" name="homeButton" onclick="location.href='../homepage.html';">Home Page</button>
  <button type="button" name="mainButton" onclick="location.href='sqlmainpage.html';">Main Page</button>
</div>

<div align="center">
  <form action="sql1.php" method="post" >
    <p>John -> Doe</p>
    First name : <input type="text" name="firstname">
    <input type="submit" name="submit" value="Submit">
  </form>
</div>


<?php
///
// SHOW all errors:
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
// HIDE all errors:
 error_reporting(0);
 ini_set('display_errors', 0);
///
///
$servername = "localhost";
$username = "root";
$password = "";
$db = "1ccb8097d0e9ce9f154608be60224c7c";

// Create connection
$conn = mysqli_connect($servername,$username,$password,$db);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

if(isset($_POST["submit"])){
  $firstname = $_POST["firstname"];
  $sql = "SELECT lastname FROM users WHERE firstname='".mysqli_real_escape_string($conn, $firstname)."'";//String
  $result = mysqli_query($conn,$sql);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      echo $row["lastname"];
      echo "<br>";
    }
  } else {
    echo "0 results";
  }
}

?>
</body>
</html>
