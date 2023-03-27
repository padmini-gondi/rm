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
<td> <font face="Arial">Product Type</font> </td> 
<td> <font face="Arial">Country</font> </td>
<td> <font face="Arial">Potential Investment</font> </td> 
</tr>';

if ($result->num_rows > 0){
 while($row = $result->fetch_assoc() ){
    $field1name = $row["name"];
    $field2name = $row["producttype"];
    $field3name = $row["country"];
    $field4name = $row["potentialinvestment"];

    echo '<tr> 
    <td>'.$field1name.'</td> 
    <td>'.$field2name.'</td> 
    <td>'.$field3name.'</td> 
    <td>'.$field4name.'</td> 
    </tr>';
	// echo $row["name"]."  ".$row["producttype"]."  ".$row["country"]."  ".$row["potentialinvestment"]." <br>";
  }
} else {
	echo "0 records";
}

$conn->close();

?>