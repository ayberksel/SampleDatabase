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

echo "<b>District Name: </b>" . $_POST['districtName'] . "<p>";

$sql = "SELECT 	BRANCH.Branch_Name,
		CITY.City_Name,
        DISTRICT.District_Name,
		SALESMAN.Salesman_Name,
		CONCAT(SUM(PRODUCT.Product_Price * SALE.Sale_Amount), ' TL') AS TOTAL_INCOME,
        SUM(SALE.Sale_Amount) AS ITEMS_SOLD
		FROM CITY 
		INNER JOIN DISTRICT ON CITY.District_Id = DISTRICT.District_Id 
		INNER JOIN BRANCH ON CITY.City_Id = BRANCH.City_Id 
		INNER JOIN SALESMAN ON BRANCH.Branch_Id= SALESMAN.Branch_Id
		INNER JOIN SALE ON SALESMAN.Salesman_Id = SALE.Salesman_Id 
		INNER JOIN PRODUCT ON SALE.Product_Id = PRODUCT.Product_Id 
		WHERE DISTRICT.District_Name = '" . $_POST['districtName'] . "' 
        GROUP BY BRANCH.Branch_Id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td><b>BRANCH NAME</b></td><td><b>CITY NAME</b></td><td><b>DISTRICT NAME</b></td><td><b>SALESMAN NAME</b></td><td><b>TOTAL INCOME</b></td><td><b>ITEMS SOLD</b></td></tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row["Branch_Name"]. "</td><td>" . $row["City_Name"]. "</td><td>" . $row["District_Name"]. "</td><td>" . $row["Salesman_Name"]. "</td><td>" . $row["TOTAL_INCOME"]. "</td><td>" . $row["ITEMS_SOLD"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
