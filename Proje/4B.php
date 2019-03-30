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

$sql = "SELECT  BRANCH.Branch_Name AS nameBranch,
                MAX(PRODUCT.Product_Price * SALE.Sale_Amount) AS MAX_SALE,
                MIN(PRODUCT.Product_Price * SALE.Sale_Amount) AS MIN_SALE,
                SALESMAN.Salesman_Name AS nameSalesman
        FROM CITY 
        INNER JOIN BRANCH ON CITY.City_Id = BRANCH.City_Id 
        INNER JOIN SALESMAN ON BRANCH.Branch_Id= SALESMAN.Branch_Id
        INNER JOIN SALE ON SALESMAN.Salesman_Id = SALE.Salesman_Id 
        INNER JOIN PRODUCT ON SALE.Product_Id = PRODUCT.Product_Id 
        WHERE CITY.City_Name = '" . $_POST['cityName'] . "' 
        GROUP BY BRANCH.Branch_Id";

$result = $conn->query($sql);

?>  

<!DOCTYPE html>  
<html>  
    <head>  
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart()
        {  
            var data = google.visualization.arrayToDataTable([
                    ['Branch Name', 'Max Sale', 'Min Sale', 'Salesman Name'],  
                    <?php  
                    while($row = mysqli_fetch_array($result))  
                    {  
                       echo "['".$row["nameBranch"]."', ".$row["MAX_SALE"]."', ".$row["MIN_SALE"]."', ".$row["nameSalesman"]."],";   
                    }  
                    ?>  
               ]);  
            var options = {
              title: 'Title',
              bars: 'horizontal'
            };


            var chart = new google.charts.Bar(document.getElementById('barchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
      </script>  
    </head>  
    <body>  
      <div id="barchart_material" style="width: 900px; height: 500px;"></div>
    </body>  
</html>  

