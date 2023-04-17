<!DOCTYPE html>
<html>
 <head>
  <title>Recommend to Client</title>
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

   .button {
        background-color: #6d5c97;
        border: none;
        border-radius: 4px;
        color: white;
        padding: 8px 14px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 0px;
        cursor: pointer;
      }
 </style>
 </head>
 <body>
  <br /><br />
  <div class="container">
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
     <div class="navbar-header">
      <a class="navbar-brand" href="#">Send Recommendation to Client</a>
   </nav>
   <div class="">
     <a href="../approvedideas.php" class="button">
      <i class ='fa fa-chevron-left'></i> Approved Ideas</a>
    </div>
   <br />
   <form method="post" id="comment_form">
    <div class="form-group">
     <label>Enter Subject</label>
     <input type="text" name="subject" id="subject" class="form-control" required>
    </div>
    <div class="form-group">
     <label>Enter Comment</label>
     <textarea name="comment" id="comment" class="form-control" rows="5" required></textarea>
    </div>
    <div class="form-group">
     <input type="submit" name="post" id="post" value="Post" />
    </div>
   </form>
   
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