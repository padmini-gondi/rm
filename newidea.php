<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$title = $riskrating = $producttype = $instrument = $sector = $region = $country = $currency = $content = "";
$title_err = $riskrating_err = $producttype_err = $instrument_err = $sector_err = $region_err = $country_err = $currency_err = $content_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
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
        $sql = "INSERT INTO ideas (title, riskrating, producttype, instrument, sector, region, country, currency, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
 
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
                // Records updated successfully. Redirect to landing page
                header("location: idea.php");
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
} 
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Idea</title>
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
                    <h2 class="mt-5">Create New Ideas</h2>
                    <p>Please fill the input values and submit to create a new idea.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Create">
                        <a href="idea.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>