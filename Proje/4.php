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
echo "<div style='text-align:center'><h3>Total Earnings of Each Branch in ". $_POST['cityName']."</h3></div>" ;

$sql = "SELECT  BRANCH.Branch_Name AS nameBranch,
                SUM(PRODUCT.Product_Price * SALE.Sale_Amount) AS TOTAL_EARNINGS
        FROM CITY 
        INNER JOIN DISTRICT ON CITY.District_Id = DISTRICT.District_Id 
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
         google.charts.load('current', {'packages':['corechart']});  
         google.charts.setOnLoadCallback(drawChart);  
         function drawChart()  
         {  
              var data = google.visualization.arrayToDataTable([  
                        ['Branch Name', 'Total Earnings'],  
                        <?php  
                        while($row = mysqli_fetch_array($result))  
                        {  
                             echo "['".$row["nameBranch"]."', ".$row["TOTAL_EARNINGS"]."],";  
                        }  
                        ?>  
                   ]);  
              var options = {  
                    is3D:true,  
                    //pieHole: 0.4
                   };  
              var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
              chart.draw(data, options);  
         }  
         </script>  
    </head>  
    <body>  
        <div align = "center">
         <div style="width:900px;">   
              <div id="piechart" style="width: 900px; height: 500px;"></div>  
         </div>  
    </body>  
</html>  

