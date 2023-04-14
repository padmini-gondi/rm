<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$title = $riskrating = $producttype = $instrument = $sector = $region = $country = $currency = $content = "";
$title_err = $riskrating_err = $producttype_err = $instrument_err = $sector_err = $region_err = $country_err = $currency_err = $content_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a title.";
    } else{
        $title = $input_title;
    }

    // Validate riskrating
    $input_riskrating = trim($_POST["riskrating"]);
    if(empty($input_riskrating)){
        $riskrating_err = "Please enter a risk rating.";
    } else{
        $riskrating = $input_riskrating;
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
        $region_err = "Please enter an region.";     
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

    // Validate currency
    $input_currency = trim($_POST["currency"]);
    if(empty($input_currency)){
        $currency_err = "Please enter the currency.";     
    } else{
        $currency = $input_currency;
    }

    // Validate content
    $input_content = trim($_POST["content"]);
    if(empty($input_content)){
        $content_err = "Please enter an content.";     
    } else{
        $content = $input_content;
    }
    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($riskrating_err) && empty($producttype_err) && empty($instrument_err) && empty($sector_err) && empty($region_err) && empty($country_err) && empty($currency_err) && empty($content_err)){
        // Prepare an update statement
        $sql = "INSERT INTO approvedideas SET title=?, riskrating=?, producttype=?, instrument=?, sector=?, region=?, country=?, currency=?, content=?";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssss", $title, $riskrating, $producttype, $instrument, $sector, $region, $country, $currency, $content);
            
            // Set parameters
            $title = $title;
            $riskrating = $riskrating;
            $producttype = $producttype;
            $instrument = $instrument;
            $sector = $sector;
            $region = $region;
            $country = $country;
            $currency = $currency;
            $content = $content;
            $id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                    // Get URL parameter
                    $id =  trim($_GET["id"]);
                    
                    $sql2 = "DELETE FROM ideas Where id = ? ";
                    if($stmt = $mysqli->prepare($sql2)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("i", $param_id);
                        
                        // Set parameters
                        $param_id = trim($_POST["id"]);
                        
                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            // Records deleted successfully. Redirect to landing page
                            header("location: approvedideas.php");
                            exit();
                        }
                    }    
                }
                // Records updated successfully. Redirect to landing page
                header("location: approvedideas.php");
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
        $sql = "SELECT * FROM ideas WHERE id = ?";
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
                    $title = $row["title"];
                    $riskrating = $row["riskrating"];
                    $producttype = $row["producttype"]; 
                    $instrument = $row["instrument"]; 
                    $sector = $row["sector"]; 
                    $region = $row["region"];   
                    $country = $row["country"];
                    $currency = $row["currency"];
                    $content = $row["content"];
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
    <title>Approve Idea</title>
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
                    <h2 class="mt-5">Approve Idea</h2>
                    <p>Please edit the input values and submit to approve the idea.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Risk Rating</label>
                            <textarea name="riskrating" class="form-control <?php echo (!empty($riskrating_err)) ? 'is-invalid' : ''; ?>"><?php echo $riskrating; ?></textarea>
                            <span class="invalid-feedback"><?php echo $riskrating_err;?></span>
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
                            <label>Currency</label>
                            <input type="text" name="currency" class="form-control <?php echo (!empty($currency_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $currency; ?>">
                            <span class="invalid-feedback"><?php echo $currency_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $content; ?>">
                            <span class="invalid-feedback"><?php echo $content_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Approve">
                        <a href="idea.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>