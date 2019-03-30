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

echo "<b>Branch Name: </b>" . $_POST['branchName'] . "<p>";

$sql = "SELECT 	CUSTOMER.Customer_Name AS nameCustomer, 
				SUM(SALE.Sale_Amount) AS TOTAL_SALE_AMOUNT, 
				CONCAT(SUM(PRODUCT.Product_Price * SALE.Sale_Amount), ' TL') AS TOTAL_PRICE_OF_SALES 
		FROM CITY 
		INNER JOIN DISTRICT ON CITY.District_Id = DISTRICT.District_Id 
		INNER JOIN BRANCH ON CITY.City_Id = BRANCH.City_Id 
		INNER JOIN CUSTOMER ON BRANCH.Branch_Id= CUSTOMER.Branch_Id 
		INNER JOIN SALE ON CUSTOMER.Customer_Id = SALE.Customer_Id 
		INNER JOIN PRODUCT ON SALE.Product_Id = PRODUCT.Product_Id 
		WHERE BRANCH.Branch_Name = '" . $_POST['branchName'] . "' 
		GROUP BY CUSTOMER.Customer_Name
		ORDER BY TOTAL_PRICE_OF_SALES";

$result = $conn->query($sql);

echo "<b>3A)</b> The total amount number and price of sales done from each customer shown in the below table:<p>";

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td><b>CUSTOMER NAME</b></td><td><b>TOTAL SALE AMOUNT</b></td><td><b>TOTAL PRICE OF SALES</b></td></tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row["nameCustomer"]. "</td><td>" . $row["TOTAL_SALE_AMOUNT"]. "</td><td>" . $row["TOTAL_PRICE_OF_SALES"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "No customer found.";
}

$sql = "SELECT 	SALESMAN.Salesman_Name AS nameSalesman,
				SUM(SALE.Sale_Amount) AS TOTAL_SALE_AMOUNT, 
				CONCAT(SUM(PRODUCT.Product_Price * SALE.Sale_Amount), ' TL') AS TOTAL_PRICE_OF_SALES 
		FROM CITY 
		INNER JOIN DISTRICT ON CITY.District_Id = DISTRICT.District_Id 
		INNER JOIN BRANCH ON CITY.City_Id = BRANCH.City_Id 
		INNER JOIN SALESMAN ON BRANCH.Branch_Id= SALESMAN.Branch_Id
		INNER JOIN SALE ON SALESMAN.Salesman_Id = SALE.Salesman_Id 
		INNER JOIN PRODUCT ON SALE.Product_Id = PRODUCT.Product_Id 
		WHERE BRANCH.Branch_Name = '" . $_POST['branchName'] . "' 
		GROUP BY SALESMAN.Salesman_Name
		ORDER BY TOTAL_PRICE_OF_SALES";

$result = $conn->query($sql);

echo "<p><b>3B)</b> The total amount number and price of sales performed from each salesman shown in the below table:<p>";

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td><b>SALESMAN NAME</b></td><td><b>TOTAL SALE AMOUNT</b></td><td><b>TOTAL PRICE OF SALES</b></td></tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row["nameSalesman"]. "</td><td>" . $row["TOTAL_SALE_AMOUNT"]. "</td><td>" . $row["TOTAL_PRICE_OF_SALES"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "No salesman found.";
}

$conn->close();

?>
