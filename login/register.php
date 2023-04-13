<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $email = $phone = $designation = $department =  $password = $confirm_password = "";
// $status = 0;
$name_err = $email_err = $phone_err = $designation_err = $department_err = $status_err = $password_err = $confirm_password_err = "";
// $name_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM user_manage WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }
    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter a phone.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email";
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($phone_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
            // echo "You selected $gender";
        }
        // Prepare an insert statement
        $sql = "INSERT INTO user_manage (`name`, `password`, email, phone, designation, department, `status`) VALUES (:name, :password, :email, :phone, :designation, :department, :status)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
            $stmt->bindParam(":designation", $param_designation, PDO::PARAM_STR);
            $stmt->bindParam(":department", $param_department, PDO::PARAM_STR);
            $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_phone = $phone;
            $param_designation = $designation;
            $param_department = $department;
            $param_status = (int)$status;
            // echo $param_status;
            // exit;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "Sign up successtuly";
                // Redirect to login page
                header("location: login.php");
            } else {
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
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            /* width: 990px; */
            padding: 20px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 mx-auto">
                <h2>User Add</h2>
                <p>Please fill this form to create an account.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Name</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                                <span class="help-block"><?php echo $name_err; ?></span>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Email</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                                <span class="help-block"><?php echo $email_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Phone</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                                <span class="help-block"><?php echo $phone_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Designation</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($designation_err)) ? 'has-error' : ''; ?>">
                                <input type="text" name="designation" class="form-control" value="<?php echo $designation; ?>">
                                <span class="help-block"><?php echo $designation_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Department</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($department_err)) ? 'has-error' : ''; ?>">
                                <input type="text" name="department" class="form-control" value="<?php echo $department; ?>">
                                <span class="help-block"><?php echo $department_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Status</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                                <select name="status" class="form-control">
                                    <?php
                                    $status_opt = array(
                                        "" => "Select",
                                        "1" => "Active",
                                        "0" => "Inactive"
                                    );

                                    // loop through the options to create the <option> tags
                                    foreach ($status_opt as $key => $status) {
                                        echo "<option value=\"$key\">$status</option>";
                                    }
                                    ?>
                                </select>
                                <span class="help-block"><?php echo $status_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Password</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Confirm Password</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                <span class="help-block"><?php echo $confirm_password_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <!-- <input type="reset" class="btn btn-default" value="Reset"> -->
                    </div>
                    <p>Already have an account?<a href="login.php"> Login here</a>.</p>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>

    </div>
</body>

</html>