<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $company = $phone = $email = $address = $business = $message = "";
$name_err = $company_err = $phone_err = $email_err = $address_err = $business_err = $message_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

	// Validate company
	$input_company=trim($_POST["company"]);
	if(empty($input_company)){
		$company_err="Please enter a company name";
	}
	elseif(!filter_var($input_company, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
		$company_err="Please enter a valid company name.";
	}
	else{
		$company=$input_company;
	}

	// Validate phone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter an phone number.";
    } else{
        $phone = $input_phone;
    }

	// Validate email
	$input_email=trim($_POST["email"]);
	if(empty($input_email)){
		$email_err="Please enter a email.";
	}
	elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
		$email_err="Please enter a valid email.";
	}
	else{
		$email=$input_email;
	}

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";
    } else{
        $address = $input_address;
    }

	// Validate business
    $input_business = trim($_POST["business"]);
    if(empty($input_business)){
        $business_err = "Please enter an business.";
    } else{
        $business = $input_business;
    }

	// Validate message
    $input_message = trim($_POST["message"]);
    if(empty($input_message)){
        $message_err = "Please enter an message.";
    } else{
        $message = $input_message;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (:name, :address, :salary)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":address", $param_address);
            $stmt->bindParam(":salary", $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control" value="<?php echo $name; ?>" placeholder="">
										<span class="help-block"><?php echo $name_err;?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($company_err)) ? 'has-error' : ''; ?>">
                                    <label for="company">Company Name</label>
                                    <input id="company" name="company" type="text" class="form-control" value="<?php echo $company; ?>" placeholder="">
                                    <span class="help-block"><?php echo $company_err;?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                                    <label for="phone">Phone Number</label>
                                    <input id="phone" name="phone" type="tel" class="form-control" value="<?php echo $phone; ?>" placeholder="">
                                    <span class="help-block"><?php echo $phone_err;?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                    <label for="email">Email address</label>
                                    <input id="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="">
                                    <span class="help-block"><?php echo $email_err;?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                                    <label for="city">Address</label>
                                    <input id="city" name="address" type="text" class="form-control" value="<?php echo $address; ?>" placeholder="">
                                    <span class="help-block"><?php echo $address_err;?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($business_err)) ? 'has-error' : ''; ?>">
                                    <label for="subject">Business Type</label>
                                    <input id="subject" name="business" type="text" class="form-control" value="<?php echo $business; ?>"  placeholder="">
                                    <span class="help-block"><?php echo $business_err;?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-area <?php echo (!empty($message_err)) ? 'has-error' : ''; ?>">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" type="text" class="form-control" rows="6" value="<?php echo $message; ?>"  placeholder=""></textarea>
                            <span class="help-block"><?php echo $message_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>