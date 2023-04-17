<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
?>

<!DOCTYPE html> 
<htmI lang="en">
<head> 
    <meta charset= "UTF-8">
    <title>New Ideas</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Add icon library -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="idea.css">
</head>
<body>
    <nav>
        <div class="container">
            <img src="./images/logo.png" class="logo">
         <div class="profile-area">
            <div class="profile">
                <!-- <div class="profile-photo">
                    <img src="./images/profile.jpg">
                </div> -->
                <span class="material-symbols-sharp">person_filled</span>
                <h5>Welcome back, <?=$_SESSION['name']?>!</h5>
                <!-- <span class="material-symbols-sharp">expand_more</span> -->
            </div>
            <!-- <button id="menu-btn">
                <span class="material-symbols-sharp">menu</span>
            </button> -->
        </div>
      </div>
    </nav>

    <main>
        <aside>
            <button id="close-btn">
                <span class="material-symbols-sharp">close</span>
            </button>

            <div class="sidebar">
                <a href="./home.php">
                    <span class="material-symbols-sharp">home</span>
                    <h4>Home</h4>
                </a>
                <a href="./investments.php">
                    <span class="material-symbols-sharp">monetization_on</span>
                    <h4>Investments</h4>
                </a>
                <a href="./services.php">
                    <span class="material-symbols-sharp">shield</span>
                    <h4>Services</h4>
                </a>
                <a href="./idea.php"  class="active">
                    <span class="material-symbols-sharp">emoji_objects</span>
                    <h4>Ideas</h4>
                </a>
                <a href="./approvedideas.php">
                    <span class="material-symbols-sharp">checklist</span>
                    <h4>Approved Ideas</h4>
                </a>
                <a href="./logout.php">
                    <span class="material-symbols-sharp">logout</span>
                    <h4>Logout</h4>
                </a>
            </div>

        </aside>

        <section class="middle">
            <div class="header">
                <h1>Welcome RM</h1>
            </div>
            <!-- <div class="search">
             <input type="text" placeholder="Search...">
             <button class="favorite styled" type="button"> Submit
             </button>
            </div> -->
             <br>
             <form class="form-inline" action="searchideas.php" method="post">
                    <h4>Search: </h4><input type="text" name="search" placeholder ="Enter here..." required><br>
    
                    <h4> Column: </h4> 
                    <select id="coloum" name="column" autofocus required>
                    <option></option>
                    <option value="title">Title</option>
                    <option value="riskrating">Risk Rating</option>
                    <option value="producttype">Product Type</option>
                    <option value="instrument">Instrument</option>
                    <option value="sector">Sector</option>
                    <option value="region">Region</option>
                    <option value="country">Country</option>
                    <option value="currency">Currency</option>
                    </select><br>
                    <input type ="submit" value="Search">    
              </form>

                <br> 
            <div class="Investments">

                <!-- <h3> <a href="./newidea.php">Add a New Idea</a></h3> -->
                <!-- <a href="newidea.php" class="button"> -->
                <!-- <i class="fa fa-plus"></i> Add a New Idea</a> -->
                <h1>New Ideas</h1>
                <br>
                <?php
                             // Include config file
                             require_once "config.php";
                    
                             // Attempt select query execution
                             $sql = "SELECT * FROM ideas";
                             if($result = $mysqli->query($sql)){
                             if($result->num_rows > 0){
                              echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Title</th>";
                                        echo "<th>Risk Rating</th>";
                                        echo "<th>Product Type</th>";
                                        echo "<th>Instrument</th>";
                                        echo "<th>Sector</th>";
                                        echo "<th>Region</th>";
                                        echo "<th>Country</th>";
                                        echo "<th>Currency</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Approve Idea</th>";
                                        echo "<th>Deny Idea</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
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
                                            echo '<a href="approveidea.php?id='. $row['id'] .'"><span class="material-symbols-sharp">check_circle</span></a>';
                                        echo "</td>";
                                        echo "<td>";
                                            echo '<a href="denyidea.php?id='. $row['id'] .'"><span class="material-symbols-sharp">cancel</span></a>'; 
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
                              } else{
                              echo "Oops! Something went wrong. Please try again later.";
                              }
                    
                               // Close connection
                              $mysqli->close();
                 
                ?>
           </div>

        </section>

        <section class="right">
           <div>
                <div class="header">
                 <a href="newidea.php" class="button">
                 <i class="fa fa-plus"></i> Add a New Idea</a>   
                 <!-- <a href="investments.php" class="button">
                 <i class="fa fa-chevron-left"></i> Investments</a>
                 <div style="padding: 10px;"; width: 10px;></div> 
                 <a href="services.php" class="button">
                 <i class="fa fa-chevron-left"></i> Services</a>
                 <a href="./notification/index.php" class="button">
                 <i class="fa fa-thumbs-o-up"></i> Recommend</a> -->
               </div>
               <!-- <div>
                 <a href="investments.php" class="button">
                 <i class="fa fa-chevron-left"></i> Investments</a>
               </div>
               <div>
                 <a href="services.php" class="button">
                 <i class="fa fa-chevron-left"></i> Services</a>
               </div>
               <div> -->
                 <a href="./notification/index.php" class="button">
                 <i class="fa fa-thumbs-o-up"></i> Recommend</a>
               </div>
            </div>
        </section>
    </main>
</body>
</htmI>

<style>

  body{
     padding: 0;
     margin: 0;
     background: var(--color-light);
     font-family: poppins, sans-serif;
     min-height: 100vh;
     color: var(--color-dark);
    }

  table{
     /* position: absolute;
     left: 51%;
     top: 68%;
     transform: translate(-50%, -50%); */
     border-collapse: collapse;
     /* width: 70%;
     height: auto; */
     padding: 10px;
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
   input[type=text] {
  width: 20%;
  height: 10px;
  padding: 15px 5px;
  margin: 4px 0;
  box-sizing: border-box;
  border: 3px solid #ccc;
  border-radius: 4px;   
  -webkit-transition: 0.5s;
  transition: 0.5s;
  outline: none;
 }
 select {
  width: 20%;
  height: 35px;
  margin: 4px 0;
  padding: 0px 5px;
  box-sizing: border-box;
  border: 3px solid #ccc;
  border-radius: 4px;
  background-color: #fff; 
 }  
 input[type=submit] {
  background-color: #45a049;
  color: white;
  margin: 4px 0;
  padding: 9px 16px;
  font-size: 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
 } 

 input[type=submit]:hover {
  background-color: #4CAF50;
 }

 .form-inline {  
  display: flex;
  flex-flow: row wrap;
  align-items: center;
 }
 .form-inline input, select {
  margin: 5px 10px 5px 5px;
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
      .button:hover{
        background-color: #7360a2;
      }

</style>