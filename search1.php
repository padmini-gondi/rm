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
    <title>Search Results</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
            background-color: #6d5c97;
        }
        table tr td:last-child{
            width: 70px;
        }
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <nav>
        <div class="container">
            <img src="./images/logo.png" class="logo">
         <div class="profile-area">
                <div class="profile">
                <span class="material-symbols-sharp">person_filled</span>
                <h5>Welcome back, <?=$_SESSION['name']?>!</h5>
            </div>
        </div>
      </div>
    </nav>

    <main>
        <aside>
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
                <a href="./idea.php">
                    <span class="material-symbols-sharp">emoji_objects</span>
                    <h4>New Ideas</h4>
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
                <br>
                <br>
                <h1>Welcome RM</h1>
            </div>
            <br><div class="recent-transactions">
                <div class="header">
                    <h2> <span class="material-symbols-sharp">person_search</span> Searched Results</h2>
                </div>
                <a href="home.php" class="button"> 
                <i class="fa fa-chevron-left"></i> Back</a>
                
                <div class="wrapper">
                  <div class="container-fluid">
                     <div class="row">
                         <div class="col-md-12">
                             <?php
                             // Include config file
                             require_once "config.php";

                             $search = $_POST['search'];
                             $column = $_POST['column'];
                    
                             // Attempt select query execution
                             $sql = "select * from clients where $column like '%$search%'";
                            //  execute sql and store result
                             if($result = $mysqli->query($sql)){
                             if($result->num_rows > 0){
                              echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Name</th>";
                                        echo "<th>Product Name</th>";
                                        echo "<th>Product Type</th>";
                                        echo "<th>Instrument</th>";
                                        echo "<th>Sector</th>";
                                        echo "<th>Region</th>";
                                        echo "<th>Country</th>";
                                        echo "<th>Potential Investment</th>";
                                        echo "<th>Investment Preference</th>";
                                        echo "<th>Tag</th>";
                                        echo "<th>Update</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['productname'] . "</td>";
                                        echo "<td>" . $row['producttype'] . "</td>";
                                        echo "<td>" . $row['instrument'] . "</td>";
                                        echo "<td>" . $row['sector'] . "</td>";
                                        echo "<td>" . $row['region'] . "</td>";
                                        echo "<td>" . $row['country'] . "</td>";
                                        echo "<td>" . $row['potentialinvestment'] . "</td>";
                                        echo "<td>" . $row['preference'] . "</td>";
                                        echo "<td>" . $row['tag'] . "</td>";
                                        echo "<td>";
                                            
                                            echo '<a href="update.php?id='. $row['id'] .'"><span class="material-symbols-sharp">edit</span></a>';
                                            
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                              echo "</table>";
                             // Free result set
                             $result->free();
                             } else{
                                echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>No records were found.</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "</table>";
                              }
                              } else{
                              echo "Oops! Something went wrong. Please try again later.";
                              }
                    
                               // Close connection
                              $mysqli->close();
                               ?>
                         </div>
                     </div>        
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
    left: 45%;
    top: 38%;
    transform: translate(-50%, -50%); */
    border-collapse: collapse;
    /* width: 60%;
    height: 300px; */
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