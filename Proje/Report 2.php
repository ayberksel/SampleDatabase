<!DOCTYPE html>
<html>
<body>
<form action="2.php" method="post">
<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "ayberk_seller";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SET NAMES utf8";
if($conn->query($sql) == TRUE){
} else{
	echo "Error in SQL: " . $conn->error;
}

$conn->close();
?>
<INPUT TYPE = "TEXT" NAME='customerName' VALUE ="Enter a customer name...">
<input type="submit" value="Search">
</form> 
</body>
</html>