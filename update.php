<?php

session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $productname = $producttype = $instrument = $sector = $region = $country = $potentialinvestment = $tag = "";
$name_err = $productname_err = $productype_err = $instrument_err = $sector_err = $region_err = $country_err = $potentialinvestment_err = $tag_err = "";
 
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

    // Validate product name
    $input_productname = trim($_POST["productname"]);
    if(empty($input_productname)){
        $productname_err = "Please enter an product name.";     
    } else{
        $productname = $input_productname;
    }
    
    // Validate product type
    $input_producttype = trim($_POST["producttype"]);
    if(empty($input_producttype)){
        $producttype_err = "Please enter an product type.";     
    } else{
        $producttype = $input_producttype;
    }

    // Validate instrument
    $input_instrument = trim($_POST["instrument"]);
    if(empty($input_instrument)){
        $instrument_err = "Please enter an instrument.";     
    } else{
        $instrument = $input_instrument;
    }

    // Validate sector
    $input_sector = trim($_POST["sector"]);
    if(empty($input_sector)){
        $sector_err = "Please enter an sector.";     
    } else{
        $sector = $input_sector;
    }

    // Validate region
    $input_region = trim($_POST["region"]);
    if(empty($input_region)){
        $region_err = "Please enter the region.";     
    } else{
        $region = $input_region;
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

    // Validate tag
    $input_tag = trim($_POST["tag"]);
    if(empty($input_tag)){
        $tag_err = "Please enter the tag.";     
    } else{
        $tag = $input_tag;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($productname_err) && empty($producttype_err) && empty($instrument_err) && empty($sector_err) && empty($region_err) && empty($country_err) && empty($potentialinvestment_err) && empty($tag_err)){
        // Prepare an update statement
        $sql = "UPDATE clients SET name=?, productname=?, producttype=?, instrument=?, sector=?, region=?, country=?, potentialinvestment=?, tag=? WHERE id=?";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssssi", $name, $productname, $producttype, $instrument, $sector, $region, $country, $potentialinvestment, $tag, $id);
            
            // Set parameters
            $name = $name;
            $productname = $productname;
            $producttype = $producttype;
            $instrument = $instrument;
            $sector = $sector;
            $region = $region;
            $country = $country;
            $potentialinvestment = $potentialinvestment;
            $tag = $tag;
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
                    $productname = $row["productname"];
                    $producttype = $row["producttype"];
                    $instrument = $row["instrument"];
                    $sector = $row["sector"];
                    $region = $row["region"];
                    $country = $row["country"];
                    $potentialinvestment = $row["potentialinvestment"];
                    $tag = $row["tag"];
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
        input[type=submit] {
          background-color: #45a049;
          color: white;
          margin: 4px 0;
          padding: 7px 12px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        } 

        input[type=submit]:hover {
         background-color: #4CAF50;
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
                            <label>Product Name</label>
                            <textarea name="productname" class="form-control <?php echo (!empty($productname_err)) ? 'is-invalid' : ''; ?>"><?php echo $productname; ?></textarea>
                            <span class="invalid-feedback"><?php echo $productname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Product Type</label>
                            <textarea name="producttype" class="form-control <?php echo (!empty($producttype_err)) ? 'is-invalid' : ''; ?>"><?php echo $producttype; ?></textarea>
                            <span class="invalid-feedback"><?php echo $producttype_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Instrument</label>
                            <textarea name="instrument" class="form-control <?php echo (!empty($instrument_err)) ? 'is-invalid' : ''; ?>"><?php echo $instrument; ?></textarea>
                            <span class="invalid-feedback"><?php echo $instrument_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Sector</label>
                            <textarea name="sector" class="form-control <?php echo (!empty($sector_err)) ? 'is-invalid' : ''; ?>"><?php echo $sector; ?></textarea>
                            <span class="invalid-feedback"><?php echo $sector_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <textarea name="region" class="form-control <?php echo (!empty($region_err)) ? 'is-invalid' : ''; ?>"><?php echo $region; ?></textarea>
                            <span class="invalid-feedback"><?php echo $region_err;?></span>
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
                        <div class="form-group">
                            <label>Tag</label>
                            <textarea name="tag" class="form-control <?php echo (!empty($tag_err)) ? 'is-invalid' : ''; ?>"><?php echo $tag; ?></textarea>
                            <span class="invalid-feedback"><?php echo $tag_err;?></span>
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