<!DOCTYPE html>
<html>
 <head>
  <title>My Recommendations</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    input[type=submit] {
  background-color: #45a049;
  color: white;
  margin: 4px 0;
  padding: 9px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
 } 

 input[type=submit]:hover {
  background-color: #4CAF50;
 }
 th{
     background-color: #6d5c97;
     color: #fff;
     border-bottom: 1px solid #ddd;
   }
 </style>
 </head>
 <body>
  <br /><br />
  <div class="container">
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
     <div class="navbar-header">
      <a class="navbar-brand" href="#">My Recommendations</a>
     </div>
     <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
       <ul class="dropdown-menu"></ul>
      </li>
     </ul>
    </div>
   </nav>
   <br />
   <form method="post" action="">
    <div class="form-group">
     <label>Enter Title</label>
     <input type="text" name="subject" id="subject" class="form-control" autofocus required>
    </div>
    <div class="form-group">
     <input type="submit" name="post" id="post"  value="Search" />
    </div>
   </form>
   
   <?php
     echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        // echo "<th>ID</th>";
                                        echo "<th>Title</th>";
                                        echo "<th>Risk Rating</th>";
                                        echo "<th>Product Type</th>";
                                        echo "<th>Instrument</th>";
                                        echo "<th>Sector</th>";
                                        echo "<th>Region</th>";
                                        echo "<th>Country</th>";
                                        echo "<th>Currency</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
    ?>
   <?php
   include('../config.php');
   if(isset($_POST["subject"]) && !empty(trim($_POST["subject"]))){
    // Get URL parameter
    $subject =  trim($_POST["subject"]);

    $sql = "SELECT * FROM approvedideas WHERE title like '%$subject' ";
                             if($result = $mysqli->query($sql)){
                             if($result->num_rows > 0){
                                echo "<tbody>";
                                while($row = $result->fetch_assoc()){
                                    echo "<tr>";
                                        // echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['riskrating'] . "</td>";
                                        echo "<td>" . $row['producttype'] . "</td>";
                                        echo "<td>" . $row['instrument'] . "</td>";
                                        echo "<td>" . $row['sector'] . "</td>";
                                        echo "<td>" . $row['region'] . "</td>";
                                        echo "<td>" . $row['country'] . "</td>";
                                        echo "<td>" . $row['currency'] . "</td>";
                                        echo "<td>" . $row['content'] . "</td>";
                                        echo "<td>";
                                            
                                            echo '<a href="buyinvestment.php?id='. $row['id'] .'"><span class="material-symbols-sharp">Buy</span></a>';
                                            
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                              echo "</table>";
                             // Free result set
                             $result->free();
                             } else{
                              echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                              }
                              }
    // Close connection
    $mysqli->close();
}
?>
  </div>
 </body>
</html>
<script>
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-menu').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });
 }
 
 load_unseen_notification();
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  if($('#subject').val() != '' && $('#comment').val() != '')
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#comment_form')[0].reset();
     load_unseen_notification();
    }
   });
  }
  else
  {
   alert("Both Fields are Required");
  }
 });
 
 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
  load_unseen_notification('yes');
 });
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 
});
</script>