<?php

$search = $_POST['search'];
$column = $_POST['column'];

$servername = "localhost";
$username = "root";
$password = "";
$db = "rm";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error){
	die("Connection failed: ". $conn->connect_error);
}

$sql = "select * from clients where $column like '%$search%'";

$result = $conn->query($sql);

echo '<table border="2" cellspacing="4" cellpadding="6"> 
<tr> 
<td> <font face="Arial">Name</font> </td>
<td> <font face="Arial">Product Name</font> </td> 
<td> <font face="Arial">Product Type</font> </td> 
<td> <font face="Arial">Instrument</font> </td>
<td> <font face="Arial">Sector</font> </td>
<td> <font face="Arial">Region</font> </td>
<td> <font face="Arial">Country</font> </td>
<td> <font face="Arial">Potential Investment</font> </td> 
<td> <font face="Arial">Tag</font> </td>
</tr>';

if ($result->num_rows > 0){
 while($row = $result->fetch_assoc() ){
    $field1name = $row["name"];
    $field2name = $row["productname"];
    $field3name = $row["producttype"];
    $field4name = $row["instrument"];
    $field5name = $row["sector"];
    $field6name = $row["region"];
    $field7name = $row["country"];
    $field8name = $row["potentialinvestment"];
    $field9name = $row["tag"];

    echo '<tr> 
    <td>'.$field1name.'</td> 
    <td>'.$field2name.'</td> 
    <td>'.$field3name.'</td> 
    <td>'.$field4name.'</td>
    <td>'.$field5name.'</td> 
    <td>'.$field6name.'</td> 
    <td>'.$field7name.'</td> 
    <td>'.$field8name.'</td> 
    <td>'.$field9name.'</td>  
    </tr>';
	// echo $row["name"]."  ".$row["productname"]." ".$row["producttype"]."  ".$row["country"]."  ".$row["potentialinvestment"]." <br>";
  }
} else {
	echo "0 records";
}

$conn->close();

?>
<!DOCTYPE html>
<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Add icon library -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Search Results</title>
    <style>
      .button {
        background-color: #45a049;
        border: none;
        color: white;
        padding: 8px 14px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 20px;
        margin: 4px 0px;
        cursor: pointer;
      }
      .button:hover{
        background-color: #4CAF50;
      }
    </style>
  </head>
  <body>
    <a href="home.php" class="button">
    <i class="fa fa-home"></i> Home</a>
    <br>
    <br>
  </body>
</html>

<!-- <style>
body{
    padding: 0;
    margin: 0;
    background: var(--color-light);
    
    min-height: 100vh;
    color: var(--color-dark);
   }

 table{
    position: absolute;
    left: 32%;
    top: 26%;
    transform: translate(-50%, -50%);
    border-collapse: collapse;
    width: 60%;
    height: 300px;
    border: 1px solid #bdc3c7;
    box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2), -1px, -1px, 8px rgba(0, 0, 0, 0.2); 
    background-color: #f5f5f5;
   }

 tr{
    transition: all .2s ease-in;
    cursor: pointer;
  }

 th{
    background-color: #6d5c97;
    color: #fff;
    border-bottom: 1px solid #ddd;
  }

 th,
 td{
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    border: 1px solid rgb(190, 190, 190);
   }

 tr:hover{
    background-color: #fff;
    transform: scale(1.02);
    box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2), -1px, -1px, 8px rgba(0, 0, 0, 0.2); 
  }
</style>   -->