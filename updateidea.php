<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
// Include config filed
require_once "config.php";
 
// Define variables and initialize with empty values
$title = $riskrating = $producttype = $instrument = $sector = $region = $country = $currency = $content = $tag = "";
$title_err = $riskrating_err = $producttype_err = $instrument_err = $sector_err = $region_err = $country_err = $currency_err = $content_err = $tag_err = "";
 
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

    // Validate tag
    $input_tag = trim($_POST["tag"]);
    if(empty($input_tag)){
        $tag_err = "Please enter a tag.";
    } else{
        $tag = $input_tag;
    }
    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($riskrating_err) && empty($producttype_err) && empty($instrument_err) && empty($sector_err) && empty($region_err) && empty($country_err) && empty($currency_err) && empty($content_err) && empty($tag_err)){
        // Prepare an update statement
        $sql = "UPDATE approvedideas SET title=?, riskrating=?, producttype=?, instrument=?, sector=?, region=?, country=?, currency=?, content=?, tag =? WHERE id=?";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssssssi", $title, $riskrating, $producttype, $instrument, $sector, $region, $country, $currency, $content, $tag, $id);
            
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
            $tag = $tag;
            $id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
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
        $sql = "SELECT * FROM approvedideas WHERE id = ?";
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
    <title>Update Investment</title>
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
                    <h2 class="mt-5">Update Idea</h2>
                    <p>Please edit the input values and submit to update the idea.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Risk Rating</label>
                            <input type="text" name="riskrating" class="form-control <?php echo (!empty($riskrating_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $riskrating; ?>">
                            <span class="invalid-feedback"><?php echo $riskrating_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Product Type</label>
                            <textarea name="producttype" class="form-control <?php echo (!empty($producttype_err)) ? 'is-invalid' : ''; ?>"><?php echo $producttype; ?></textarea>
                            <span class="invalid-feedback"><?php echo $producttype_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Instrument</label>
                            <input type="text" name="instrument" class="form-control <?php echo (!empty($instrument_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $instrument; ?>">
                            <span class="invalid-feedback"><?php echo $instrument_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Sector</label>
                            <input type="text" name="sector" class="form-control <?php echo (!empty($sector_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sector; ?>">
                            <span class="invalid-feedback"><?php echo $sector_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <input type="text" name="region" class="form-control <?php echo (!empty($region_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $region; ?>">
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
                        <div class="form-group">
                            <label>Tag</label>
                            <input type="text" name="tag" class="form-control <?php echo (!empty($tag_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tag; ?>">
                            <span class="invalid-feedback"><?php echo $tag_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Update">
                        <a href="approvedideas.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>