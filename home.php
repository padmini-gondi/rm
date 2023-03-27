<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<!DOCTYPE html> 
<htmI lang="en">
<head> 
    <meta charset= "UTF-8">
    <title>Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">

     
    
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
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
                <!-- <div class="profile-photo">
                    <img src="./images/profile.jpg">
                </div> -->
                <span class="material-symbols-sharp">person_filled</span>
                <h5>Padmini Gondi</h5>
                <!-- <p>Welcome back, <?=$_SESSION['email']?>!</p> -->
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
                <a href="./home.php" class="active">
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
                    <h4>Ideas</h4>
                </a>
                <a href="./ticket.html">
                    <span class="material-symbols-sharp">mark_email_unread</span>
                    <h4>Create a Ticket</h4>
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
            <br>
            <div class="search">
                <form action="search.php" method="post">
                    Search <input type="text" name="search"><br>
    
                    Column: <select name="column">
                    <option></option>
                    <option value="name">Name</option>
                    <option value="producttype">Product Type</option>
                    <option value="country">Country</option>
                    <option value="potentialinvestment"> Potential Investment</option>
                    </select><br>
                    <input type ="submit">
                    </form>
            </div> 
            <br>
            <div class="recent-transactions">
                <div class="header">
                    <h2> <span class="material-symbols-sharp">people</span> Clients</h2>
                </div>
                
                
                <div class="wrapper">
                  <div class="container-fluid">
                     <div class="row">
                         <div class="col-md-12">
                             <!-- <div class="mt-5 mb-3 clearfix">
                                  <h2 class="pull-left">Employees Details</h2>
                                  <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
                             </div> -->
                             <?php
                             // Include config file
                             require_once "config.php";
                    
                             // Attempt select query execution
                             $sql = "SELECT * FROM clients";
                             if($result = $mysqli->query($sql)){
                             if($result->num_rows > 0){
                              echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Product Type</th>";
                                        echo "<th>Country</th>";
                                        echo "<th>Potential Investment</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['producttype'] . "</td>";
                                        echo "<td>" . $row['country'] . "</td>";
                                        echo "<td>" . $row['potentialinvestment'] . "</td>";
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
                              echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
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

                <!-- <div class="Investments">
                <p> 
                   <ul style="list-style-type: circle">
                      <li>Name: Client 1</li>
                      <li>Product type: Investments</li>
                      <li>Country: India</li>
                      <li>Potential investment: $1000</li>
                   </ul>
                </p>
                <br>

                <p> 
                    <ul style="list-style-type: circle">
                       <li>Name: Client 2</li>
                       <li>Product type: Services</li>
                       <li>Country: UK</li>
                       </li>
                       <li>Potential investment: $1500</li>
                    </ul>
               </p>
               <br>

                <p> 
                    <ul style="list-style-type: circle">
                       <li>Name: Client 3</li>
                       <li>Product type: Services</li>
                       <li>Country: USA</li>
                       <li>Potential investment: $500</li>
                    </ul>
                </p>
                <br>
                <p> 
                    <ul style="list-style-type: circle">
                       <li>Name: Client 4</li>
                       <li>Product type: Investment & Services</li>
                       <li>Country: USA</li>
                       <li>Potential investment: $1500</li>
                    </ul>
                </p>
             </div>   -->
        </section>

        

    </main>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="./main.js"></script> -->

</body>
</htmI>
