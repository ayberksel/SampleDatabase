<!DOCTYPE html>
<html>
<body>
<form action="installsql.php" method="get">

<?php
$servername = "localhost";
$username = "root";
$password = "mysql";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "DROP DATABASE IF EXISTS ayberk_seller;";
if($conn->query($sql) == TRUE){
} else{
	echo "Error in SQL: " . $conn->error;
}

$sql = "CREATE DATABASE ayberk_seller;";
if($conn->query($sql) == TRUE){
} else{
	echo "Error in SQL: " . $conn->error;
}

$sql = "USE ayberk_seller;";
if($conn->query($sql) == TRUE){
} else{
	echo "Error in SQL: " . $conn->error;
}

$conn->close();
?>
<br><br>
	Note: After clicking the "INSTALL" button, the tables and all of the data will be created from scratch.
<br><br>
<input type="submit" value="INSTALL">
</form>
</body>
</html>