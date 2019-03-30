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

echo "<b>Customer Name: </b>" . $_POST['customerName'] . "<p>";

$sql = "SELECT DISTRICT.District_Name AS nameDistrict, 
        CITY.City_Name AS nameCity, 
        BRANCH.Branch_Name AS nameBranch, 
        SALESMAN.Salesman_Name AS nameSalesman, 
        CONCAT((SALE.Sale_Amount * PRODUCT.Product_Price), ' TL') AS Total_Sale_Price_Without_VAT, 
        '%8' AS VAT, 
        CONCAT((SALE.Sale_Amount * (PRODUCT.Product_Price * 1.08)), ' TL') AS Total_Sale_Price_With_VAT, 
        SALE.Sale_Date AS dateSale
		FROM CITY 
		INNER JOIN DISTRICT ON CITY.District_Id = DISTRICT.District_Id 
		INNER JOIN BRANCH ON CITY.City_Id = BRANCH.City_Id 
		INNER JOIN SALESMAN ON BRANCH.Branch_Id = SALESMAN.Branch_Id 
		INNER JOIN CUSTOMER ON SALESMAN.Branch_Id = CUSTOMER.Branch_Id 
		INNER JOIN SALE ON SALESMAN.Salesman_Id = SALE.Salesman_Id 
		INNER JOIN PRODUCT ON SALE.Product_Id = PRODUCT.Product_Id 
		WHERE CUSTOMER.Customer_Name = '" . $_POST['customerName'] . "'
		ORDER BY dateSale";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td><b>DISTRICT NAME</b></td><td><b>CITY NAME</b></td><td><b>BRANCH NAME</b></td><td><b>SALESMAN NAME</b></td><td><b>TOTAL SALE PRICE WITHOUT VAT</b></td><td><b>VAT</b></td><td><b>TOTAL SALE PRICE WITH VAT</b></td><td><b>SALE DATE</b></td></tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row["nameDistrict"]. "</td><td>" . $row["nameCity"]. "</td><td>" . $row["nameBranch"]. "</td><td>" . $row["nameSalesman"]. "</td><td>" . $row["Total_Sale_Price_Without_VAT"]. "</td><td>" . $row["VAT"]. "</td><td>" . $row["Total_Sale_Price_With_VAT"]. "</td><td>" . $row["dateSale"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "No customer found.";
}
$conn->close();
?>
