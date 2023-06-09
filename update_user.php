<?php include('header.php'); ?>

<style type="text/css">
    .row {
        margin: 10px;
    }
</style>
<?php
session_start();
// Include config file
require_once "config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
// Define variables and initialize with empty values
$id = $name = $email = $phone = $designation = $department = $status = "";
$name_err = $email_err = $phone_err = $designation_err = $department_err = $status_err = $error = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];
    // Validate email if dulicate
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT * FROM user_manage WHERE id = :id";
        // Set parameters
        $param_id = trim($_POST["id"]);
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->Fetch(PDO::FETCH_ASSOC);

                    if (trim($_POST["email"]) != $row['email']) {
                        $sql = "SELECT * FROM user_manage WHERE email = '" . $_POST["email"] . "'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                        $stmt->execute();
                        if ($stmt->rowCount() == 0) {
                            $param_email = trim($_POST["email"]);
                            $email = trim($_POST["email"]);
                        } else {
                            $email_err = "This email is already taken.";
                        }
                    }
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

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }

    // Validate designation
    if (empty(trim($_POST["designation"]))) {
        $designation_err = "Please enter a designation.";
    } else {
        $designation = trim($_POST["designation"]);
    }

    // Validate department
    if (empty(trim($_POST["department"]))) {
        $department_err = "Please enter a department.";
    } else {
        $department = trim($_POST["department"]);
    }

    // Validate status
    if (isset($_POST["status"]) && !empty($_POST["status"])) {
        $status = $_POST["status"];
    } else {
        $status_err = "Please enter a status.";
    }
    try {
        // Check input errors before inserting in database
        if (empty($name_err) && empty($phone_err) && empty($email_err)) {
            // Prepare an update statement
            $sql = "UPDATE user_manage SET 
                    `name` = :name, 
                    `phone` = :phone, 
                    `email` = :email, 
                    `designation` = :designation, 
                    `department` = :department, 
                    `status` = :status 
                    WHERE id = :id";
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
                $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
                $stmt->bindParam(":designation", $param_designation, PDO::PARAM_STR);
                $stmt->bindParam(":department", $param_department, PDO::PARAM_STR);
                $stmt->bindParam(":status", $param_status, PDO::PARAM_INT);

                // Set parameters
                $param_id = $id;
                $param_name = $name;
                $param_phone = $phone;
                $param_email = $email;
                $param_designation = $designation;
                $param_department = $department;
                $param_status = (int)$status;
                
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Record updated successfuly";
                    // Redirect to login page
                    header("location: user.php");
                } else {
                    $error  = "Something went wrong. Please try again later.";
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
    
} else {
    try {
        // Check existence of id parameter before processing further
        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            // Get URL parameter
            $id = trim($_GET["id"]);

            $sql = "SELECT * from user_manage where id = :id";
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":id", $param_id);
                $param_id = $id;
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        /* Fetch result row as an associative array. Since the result set 
                        contains only one row, we don't need to use while loop */
                        $row = $stmt->Fetch(PDO::FETCH_ASSOC);

                        // Retrieve individual field value
                        $name = $row["name"];
                        $id = $row["id"];
                        $phone = $row["phone"];
                        $email = $row["email"];
                        $designation = $row["designation"];
                        $department = $row["department"];
                        $status = (int)$row["status"];
                    } else {
                        // URL doesn't contain valid id. Redirect to error page
                        $error = "internal error";
                        //header("location: error.php");
                        exit();
                    }
                } else {
                    $error = "Oops! Something went wrong. Please try again later.";
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
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">Edit User</div>
                    <?php if($error) {?>
                        <p id="message" class="alert-danger p-2"><?php echo $error; ?></p>
                    <?php }  ?>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                                <label>Name</label>
                                <span class="text-danger ml-1">*</span>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="form-group  <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                                    <span class="help-block text-danger"><?php echo $name_err; ?></span>
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
                                    <span class="help-block text-danger"><?php echo $phone_err; ?></span>
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
                                    <span class="help-block text-danger"><?php echo $email_err; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding">
                                <label>Designation</label>
                                <span class="text-danger ml-1">*</span>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="form-group  <?php echo (!empty($designation_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="designation" class="form-control" value="<?php echo $designation; ?>">
                                    <span class="help-block text-danger"><?php echo $designation_err; ?></span>
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
                                    <span class="help-block text-danger"><?php echo $department_err; ?></span>
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
                                    <select name="status" class="form-control form-select">
                                        <option value="">Select</option>
                                        <option value="1" <?php if ($status == '1') {
                                                                echo 'selected';
                                                            } ?>>Active</option>
                                        <option value="0" <?php if ($status == '0') {
                                                                echo 'selected';
                                                            } ?>>Inactive</option>
                                    </select>
                                    <span class="help-block text-danger"><?php echo $status_err; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group center-item">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
<?php include('footer.php'); ?>