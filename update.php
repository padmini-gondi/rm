<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $producttype = $country = $potentialinvestment = "";
$name_err = $productype_err = $country_err = $potentialinvestment_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } else{
        $name = $input_name;
    }
    
    // Validate product type
    $input_producttype = trim($_POST["producttype"]);
    if(empty($input_producttype)){
        $producttype_err = "Please enter an product type.";     
    } else{
        $producttype = $input_producttype;
    }
    
    // Validate country
    $input_country = trim($_POST["country"]);
    if(empty($input_country)){
        $country_err = "Please enter the country.";     
    } else{
        $country = $input_country;
    }

    // Validate potentialinvestment
    $input_potentialinvestment = trim($_POST["potentialinvestment"]);
    if(empty($input_potentialinvestment)){
        $potentialinvestments_err = "Please enter the potentialinvestment.";     
    } else{
        $potentialinvestment = $input_potentialinvestment;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($producttype_err) && empty($country_err) && empty($potentialinvestment_err)){
        // Prepare an update statement
        $sql = "UPDATE clients SET name=?, producttype=?, country=?, potentialinvestment=? WHERE id=?";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssi", $name, $producttype, $country, $potentialinvestment, $id);
            
            // Set parameters
            $name = $name;
            $producttype = $producttype;
            $country = $country;
            $potentialinvestment = $potentialinvestment;
            $id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: home.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM clients WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $producttype = $row["producttype"];
                    $country = $row["country"];
                    $potentialinvestment = $row["potentialinvestment"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
        
        // Close connection
        $mysqli->close();
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Client</h2>
                    <p>Please edit the input values and submit to update the clients record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Product Type</label>
                            <textarea name="producttype" class="form-control <?php echo (!empty($producttype_err)) ? 'is-invalid' : ''; ?>"><?php echo $producttype; ?></textarea>
                            <span class="invalid-feedback"><?php echo $producttype_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $country; ?>">
                            <span class="invalid-feedback"><?php echo $country_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Potential Investment</label>
                            <input type="text" name="potentialinvestment" class="form-control <?php echo (!empty($potentialinvestment_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $potentialinvestment; ?>">
                            <span class="invalid-feedback"><?php echo $potentialinvestment_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Update">
                        <a href="home.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>