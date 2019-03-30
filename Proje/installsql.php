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

//Create tables
$sql = "SET NAMES utf8";
if($conn->query($sql) == TRUE){
} else{
	echo "Error in SQL: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS DISTRICT(District_Id INT,
					  District_Name VARCHAR(50),
					  PRIMARY KEY (District_Id)) ENGINE = INNODB
					  CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS CITY(City_Id INT,
			  City_Name VARCHAR(50),
			  District_Id INT,
			  PRIMARY KEY (City_Id),
			  FOREIGN KEY (District_Id)
			  	REFERENCES DISTRICT(District_Id)) ENGINE = INNODB
				CHARACTER SET utf8 COLLATE utf8_unicode_ci";			 
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql ="CREATE TABLE IF NOT EXISTS BRANCH(Branch_Id INT,
				Branch_Name VARCHAR(50),
				City_Id INT,
				PRIMARY KEY (Branch_Id),
				FOREIGN KEY (City_Id)
					REFERENCES CITY(City_Id)) ENGINE = INNODB
					CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql ="CREATE TABLE IF NOT EXISTS SALESMAN(Salesman_Id INT,
				  Salesman_Name VARCHAR(50),
				  Branch_Id INT,
				  PRIMARY KEY (Salesman_Id),
				  FOREIGN KEY (Branch_Id)
				  	REFERENCES BRANCH(Branch_Id)) ENGINE = INNODB
				  	CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql ="CREATE TABLE IF NOT EXISTS CUSTOMER(Customer_Id INT,
				  Customer_Name VARCHAR(50),
				  Branch_Id INT,
				  PRIMARY KEY (Customer_Id),
				  FOREIGN KEY (Branch_Id)
				  	REFERENCES BRANCH(Branch_Id)) ENGINE = INNODB
				  	CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql ="CREATE TABLE IF NOT EXISTS PRODUCT_CATEGORY(Category_Name VARCHAR(50),
						  PRIMARY KEY (Category_Name)) ENGINE = INNODB
						  CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql ="CREATE TABLE IF NOT EXISTS PRODUCT_SUBCATEGORY(Subcategory_Name VARCHAR(50),
							 Category_Name VARCHAR(50),
							 PRIMARY KEY (Subcategory_Name),
							 FOREIGN KEY (Category_Name)
							 	REFERENCES PRODUCT_CATEGORY(Category_Name)) ENGINE = INNODB
							 	CHARACTER SET utf8 COLLATE utf8_unicode_ci";
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql ="CREATE TABLE IF NOT EXISTS PRODUCT(Product_Id INT,
				 Product_Name VARCHAR(100),
				 Product_Price INT,
				 Subcategory_Name VARCHAR(50),
				 PRIMARY KEY (Product_Id),
				 FOREIGN KEY (Subcategory_Name)
				 	REFERENCES PRODUCT_SUBCATEGORY(Subcategory_Name)) ENGINE = INNODB
				 	CHARACTER SET utf8 COLLATE utf8_unicode_ci";		
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

$sql ="CREATE TABLE IF NOT EXISTS SALE(Sale_Id INT,
			  Product_Id INT,
			  Customer_Id INT,
			  Salesman_Id INT,
			  Sale_Amount INT,
			  Sale_Date DATE,
			  PRIMARY KEY (Sale_Id),
			  FOREIGN KEY (Product_Id)
			  	REFERENCES PRODUCT(Product_Id),
			  FOREIGN KEY (Customer_Id)
			  	REFERENCES CUSTOMER(Customer_Id),
			  FOREIGN KEY (Salesman_Id)
			  	REFERENCES SALESMAN(Salesman_Id)) ENGINE = INNODB
			  	CHARACTER SET utf8 COLLATE utf8_unicode_ci";		
if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}

//To prevent time error
ini_set('max_execution_time', 6000);

//Importing csv files
$row = 0;
$filename1 = "csv/district.csv";
$filename2 = "csv/city.csv";
$filename3 = "csv/branch.csv";
$filename4 = "csv/salesman.csv";
$filename5 = "csv/customer.csv";
$filename6 = "csv/product_category.csv";
$filename7 = "csv/product_subcategory.csv";
$filename8 = "csv/product.csv";
$filename9 = "csv/sale.csv";

//district.csv
if(!file_exists($filename1) || !is_readable($filename1))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename1, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO DISTRICT (District_Id, District_Name) VALUES 
			('$row[0]', '$row[1]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}

	fclose($handle);
}

//city.csv
if(!file_exists($filename2) || !is_readable($filename2))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename2, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO CITY (City_Id, City_Name, District_Id) VALUES 
			('$row[0]', '$row[1]', '$row[2]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

//branch.csv
if(!file_exists($filename3) || !is_readable($filename3))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename3, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO BRANCH (Branch_Id, Branch_Name, City_Id) VALUES 
			('$row[0]', '$row[1]', '$row[2]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

//salesman.csv
if(!file_exists($filename4) || !is_readable($filename4))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename4, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO SALESMAN (Salesman_Id, Salesman_Name, Branch_Id) VALUES 
			('$row[0]', '$row[1]', '$row[2]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

//customer.csv
if(!file_exists($filename5) || !is_readable($filename5))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename5, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO CUSTOMER (Customer_Id, Customer_Name, Branch_Id) VALUES 
			('$row[0]', '$row[1]', '$row[2]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

//product_category.csv
if(!file_exists($filename6) || !is_readable($filename6))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename6, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO PRODUCT_CATEGORY (Category_Name) VALUES 
			('$row[0]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

//product_subcategory.csv
if(!file_exists($filename7) || !is_readable($filename7))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename7, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO PRODUCT_SUBCATEGORY (Subcategory_Name, Category_Name) VALUES 
			('$row[0]', '$row[1]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

//product.csv
if(!file_exists($filename8) || !is_readable($filename8))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename8, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO PRODUCT (Product_Id, Product_Name, Product_Price, Subcategory_Name) VALUES 
			('$row[0]', '$row[1]', '$row[2]', '$row[3]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

//sale.csv
if(!file_exists($filename9) || !is_readable($filename9))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename9, 'r')) !== FALSE)
{
	
	while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
	{
		if(!$header)
			$header = $row;
		else{
			$sql = "INSERT INTO SALE (Sale_Id, Product_Id, Customer_Id, Salesman_Id, Sale_Amount, Sale_Date) VALUES 
			('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]');";
			if($conn->query($sql) == TRUE){
} else{
	echo "Error creating table: " . $conn->error;
}
		}
	}
	
	fclose($handle);
}

echo "Installation succesfully completed.";

$conn->close();

?>