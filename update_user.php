<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $email = $phone = $designation = $department = $status = $password = $confirm_password = "";
$id = 0;
$name_err = $email_err = $phone_err = $designation_err = $department_err = $status_err = $password_err = $confirm_password_err = "";
// $name_err = $password_err = $confirm_password_err = "";
// echo 'check';exit;
// Processing form data when form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
// print_r($_SERVER["REQUEST_METHOD"]);exit;
// echo $_POST["email"];exit;
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];
    // echo $id;exit;
    // if (isset($_POST["email"]) && !empty($_POST["email"])) {

    //     // Validate email
    //     if (empty(trim($_POST["email"]))) {
    //         $email_err = "Please enter a email.";
    //     } else {
    // Prepare a select statement
    // $sql = "SELECT id FROM user_manage WHERE email = :email";

    // if ($stmt = $pdo->prepare($sql)) {
    //     // Bind variables to the prepared statement as parameters
    //     $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

    //     // Set parameters
    //     $param_email = trim($_POST["email"]);

    //     // Attempt to execute the prepared statement
    //     if ($stmt->execute()) {
    //         if ($stmt->rowCount() == 1) {
    //             $email_err = "This email is already taken.";
    //         } 
    //         // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         //     $email_err = "Please enter a valid email";
    //         // } 
    //         else {
    //             $email = trim($_POST["email"]);
    //         }
    //     } else {
    //         echo "Oops! Something went wrong. Please try again later.";
    //     }
    // }

    // // Close statement
    // unset($stmt);
    // }
    // unset($pdo);
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

    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $email_err = "Please enter a valid email";
    // } else {
    //     $email = trim($_POST["email"]);
    // }

    // Validate phone
    if (empty(trim($_POST["designation"]))) {
        $designation_err = "Please enter a designation.";
    } else {
        $designation = trim($_POST["designation"]);
    }

    // Validate phone
    if (empty(trim($_POST["department"]))) {
        $department_err = "Please enter a department.";
    } else {
        $department = trim($_POST["department"]);
    }

    if (isset($_POST["status"]) && !empty($_POST["status"])) {
        $status = $_POST["status"];
    } else {
        $status_err = "Please enter a status.";
    }

    // // Validate password
    // if (empty(trim($_POST["password"]))) {
    //     $password_err = "Please enter a password.";
    // } elseif (strlen(trim($_POST["password"])) < 6) {
    //     $password_err = "Password must have atleast 6 characters.";
    // } else {
    //     $password = trim($_POST["password"]);
    // }

    // // Validate confirm password
    // if (empty(trim($_POST["confirm_password"]))) {
    //     $confirm_password_err = "Please confirm password.";
    // } else {
    //     $confirm_password = trim($_POST["confirm_password"]);
    //     if (empty($password_err) && ($password != $confirm_password)) {
    //         $confirm_password_err = "Password did not match.";
    //     }
    // }
    try {

        // echo $id;exit;
        // Check input errors before inserting in database
        if (empty($name_err) && empty($phone_err)) {
            // if (isset($_POST['status'])) {
            //     $status = $_POST['status'];
            // }


            // Prepare an update statement
            $sql = "UPDATE user_manage SET `name` = :name, `phone` = :phone, `designation` = :designation, `department` = :department, `status` = :status WHERE id = :id";
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":id", $param_id);
                $stmt->bindParam(":name", $param_name);
                // $stmt->bindParam(":email", $param_email);
                $stmt->bindParam(":phone", $param_phone);
                $stmt->bindParam(":designation", $param_designation);
                $stmt->bindParam(":department", $param_department);
                $stmt->bindParam(":status", $param_status);
                // $stmt->bindParam(":password", $param_password);

                // old 
                // $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
                // $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                // $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
                // $stmt->bindParam(":designation", $param_designation, PDO::PARAM_STR);
                // $stmt->bindParam(":department", $param_department, PDO::PARAM_STR);
                // $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
                // $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                // Set parameters
                $param_id = $id;
                $param_name = $name;
                // $param_email = $email;
                $param_phone = $phone;
                $param_designation = $designation;
                $param_department = $department;
                $param_status = (int)$status;
                // echo $param_status;
                // exit;
                // $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    echo "Record updated successfuly";
                    // Redirect to login page
                    header("location: login.php");
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }

            // Close statement
            unset($stmt);
        }
    } catch (Exception $e) {
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }
    // Close connection
    unset($pdo);
    // }
} else {
    try {
        // echo $_GET["id"];exit;
        // Check existence of id parameter before processing further
        if (isset($_GET["id"]) && !empty($_GET["id"])) {

            // Get URL parameter
            $id = trim($_GET["id"]);

            $sql = "SELECT * from user_manage where id = :id";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":id", $param_id);

                $param_id = $id;
                // echo $param_id;exit;
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        /* Fetch result row as an associative array. Since the result set 
                        contains only one row, we don't need to use while loop */
                        $row = $stmt->Fetch(PDO::FETCH_ASSOC);

                        // Retrieve individual field value
                        $name = $row["name"];
                        // echo $name;exit;
                        $id = $row["id"];
                        $phone = $row["phone"];
                        $email = $row["email"];
                        $designation = $row["designation"];
                        $department = $row["department"];
                        $status = (int)$row["status"];
                    } else {
                        // URL doesn't contain valid id. Redirect to error page
                        echo "internal error";
                        //header("location: error.php");
                        exit();
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            unset($stmt);

            // Close connection
            unset($pdo);
        }
    } catch (Exception $e) {
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }
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
                <h2 class="text-center">User Edit</h2>
                <!-- <p class="text-center">Please fill this form to create an account.</p> -->
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

                    <!-- <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Email</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php // echo (!empty($email_err)) ? 'has-error' : ''; 
                                                    ?>">
                                <input type="text" name="email" class="form-control" value="<?php //echo $email; 
                                                                                            ?>">
                                <span class="help-block"><?php //echo $email_err; 
                                                            ?></span>
                            </div>
                        </div>
                    </div> -->

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
                                    <option value="">Select</option>
                                    <option value="1" <?php if ($status == '1') {
                                                            echo 'selected';
                                                        } ?>>Active</option>
                                    <option value="0" <?php if ($status == '0') {
                                                            echo 'selected';
                                                        } ?>>Inactive</option>
                                    <!-- <?php
                                            // $status_opt = array(
                                            //     "" => "Select",
                                            //     "1" => "Active",
                                            //     "0" => "Inactive"
                                            // );

                                            // // loop through the options to create the <option> tags
                                            // foreach ($status_opt as $key => $status) {
                                            //     echo "<option value=\"$key\">$status</option>";
                                            // }
                                            ?> -->
                                </select>
                                <span class="help-block"><?php echo $status_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Password</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php //echo (!empty($password_err)) ? 'has-error' : ''; 
                                                    ?>">
                                <input type="password" name="password" class="form-control" value="<?php //echo $password; 
                                                                                                    ?>">
                                <span class="help-block"><?php //echo $password_err; 
                                                            ?></span>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                            <label>Confirm Password</label>
                            <span class="text-danger ml-1">*</span>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group  <?php //echo (!empty($confirm_password_err)) ? 'has-error' : ''; 
                                                    ?>">
                                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                <span class="help-block"><?php //echo $confirm_password_err; 
                                                            ?></span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding"></div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <!-- <input type="reset" class="btn btn-default" value="Reset"> -->
                            </div>
                            <p>Already have an account?<a href="login.php"> Login here</a>.</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>

    </div>
</body>

</html>