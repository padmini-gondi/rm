<?php
session_start();

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'rm';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ( !isset($_POST['email'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

if ($stmt = $con->prepare('SELECT id, name, password FROM users WHERE email = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if ($_POST['password'] === $password) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['id'] = $id;
            
            // if(isset($_SESSION['email']) && $_SESSION['email'] == 'padmini@gmail.com') {
            //     header('Location: home.php');
            //  }elseif(isset($_SESSION['email']) && $_SESSION['email'] == 'vasanth@gmail.com'){
            //     header('Location: Admin/Admin.php');
            //  }elseif(isset($_SESSION['email']) && $_SESSION['email'] == 'rajan@gmail.com'){
            //     header('Location: Client/Dashboard.php');
            //  }else{
            //     header('Location: login.php'); 
            //  }
            header('Location: home.php');
        }else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
            // header('Location: login.php');
            
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
    }


	$stmt->close();
}
?>



<html>
<head>
    <style>
        .button {
           background-color: #4CAF50;
           border: 1px solid #ccc;
           border-radius: 4px;
           box-sizing: border-box;
           color: white;
           padding: 1rem;
           text-align: center;
           text-decoration: none;
           display: inline-block;
           font-size: 16px;
           margin: 4px 2px;
           cursor: pointer;
        }
   </style>
 <meta charset="UTF-8">
    
    <link rel="stylesheet" href="Login.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,300,0,0" />
    <title>Login Page</title>
</head>
<body>
Click here to <a href="login.php" class="button">Login</a>   
</body>
</html>