<!DOCTYPE html>
<html>
<body>
<form action="4.php" method="post">
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

$sql = "SELECT City_Name FROM CITY";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<select name='cityName'>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["City_Name"]. "'>" . $row["City_Name"]. "</option>";
    }
	echo "</select>";
} else {
    echo "0 results";
}
$conn->close();
?>
<input type="submit" value="Submit">
</form> 
</body>
</html>