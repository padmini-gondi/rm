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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
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
                <a href="./investments.php" class="active">
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
                <h1>Welcome RM</h1>
            </div>
            <!-- <div class="search">
             <input type="text" placeholder="Search...">
             <button class="favorite styled" type="button"> Submit
             </button>
            </div> -->
            <br>

            <div class="Investments">
                <h1>Investments</h1>
                <br>

                <?php
                             // Include config file
                             require_once "config.php";
                    
                             // Attempt select query execution
                             $sql = "SELECT * FROM investments";
                             if($result = $mysqli->query($sql)){
                             if($result->num_rows > 0){
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
                                        echo "<th>Update</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
                                        // echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['riskrating'] . "</td>";
                                        echo "<td>" . $row['producttype'] . "</td>";
                                        echo "<td>" . $row['instrument'] . "</td>";
                                        echo "<td>" . $row['sector'] . "</td>";
                                        echo "<td>" . $row['region'] . "</td>";
                                        echo "<td>" . $row['country'] . "</td>";
                                        echo "<td>" . $row['currency'] . "</td>";
                                        echo "<td>" . $row['content'] . "</td>";
                                        echo "<td>";
                                            
                                            echo '<a href="updateinvestment.php?id='. $row['id'] .'"><span class="material-symbols-sharp">edit</span></a>';
                                            
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

                
               <!-- <h2> <span class="material-symbols-sharp">monitoring</span> Shares</h2>
                <br>
                <li>Invest in company stocks with potential for high returns. You can earn returns on your investment in two ways: through the appreciation of the stock price, which they can sell for a profit, and through dividend payments, which are a portion of the company's profits paid out to shareholders. Shares can be traded on stock exchanges or investment funds. This is an opportunity for capital appreciation and can be a valuable addition to a diversified investment portfolio.</li>
                <br>
                <li>Title: Shares</li>
                <li> Risk rating: 5 Suitable for very aggressive investors </li>
                <li> Product type: Shares</li>
                <li> Instruments: IBM, AWS, SAP, Oracle, Infosys, Government </li>
                <li> Major Sector: Finance </li>
                <li> Minor Sector: Finance, Health Care, IT Sector, Pharmaceutical </li>
                <li> Region: Asia, America, Europe </li>
                <li> Country: India, USA, Uk</li>
                <li> Currency: INR, USD, GBP</li>

                <ul style="list-style-type: circle">
                    <li>Contents:</li>
                    <li>High risk</li>
                    <li>High returns</li>
                    <li>Minimum investment: $500</li>
                </ul> -->
           </div>

        </section>

        <section class="right">
            <div style="padding: 10px;"; height: 10px;></div>

            <div class="investments">
                <div class="header">
                    <h2>Services</h2>
                    <a href="./services.php">More <span class="material-symbols-sharp">chevron_right</span></a>
                </div>

                <div class="investment">
                    <span class="material-symbols-sharp">handshake</span>
                    <!-- <img src="./images/uniliver.png"> -->
                    <h4>Health Insurance</h4>
                    <div>
                        <p>Protect yourself and your loved ones!!!</p>
                    </div>
                </div>

                <div class="investment">
                    <span class="material-symbols-sharp">request_quote</span>
                    <!-- <img src="./images/tesla.png"> -->
                    <h4>Fixed Deposits</h4>
                    <div>
                        <p>Earn a fixed rate of interest with your deposits</p>
                    </div>
                </div>

                <div class="investment">
                    <span class="material-symbols-sharp">verified_user</span>
                    <!-- <img src="./images/monster.png"> -->
                    <h4>NRI Services</h4>
                    <div>
                        <p>Get personalized services to manage your finances and investments.</p>
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
     position: absolute;
     left: 45%;
     top: 57%;
     transform: translate(-50%, -50%);
     border-collapse: collapse;
     width: 55%;
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

</style>