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