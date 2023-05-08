<?php include('header.php'); ?>
<link rel="stylesheet" href="css/style.css" type="text/css">
<style type="text/css">
    .row {
        margin: 10px;
    }
    .card-title {
        font-size: xx-large;
    }
</style>
<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$id = $name = $email = $phone = $designation = $department = $status = $password = $confirm_password = "";

$name_err = $email_err = $phone_err = $designation_err = $department_err = $status_err = $password_err = $confirm_password_err = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

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

    if (isset($_POST["status"]) && !empty($_POST["status"])) {
        $status = $_POST["status"];
    } else {
        $status_err = "Please enter a status.";
    }
    try {
        // Check input errors before inserting in database
        if (empty($name_err) && empty($phone_err)) {
            // Prepare an update statement
            $sql = "UPDATE user_manage SET `name` = :name, `phone` = :phone, `designation` = :designation, `department` = :department, `status` = :status WHERE id = :id";
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":id", $param_id);
                $stmt->bindParam(":name", $param_name);
                $stmt->bindParam(":phone", $param_phone);
                $stmt->bindParam(":designation", $param_designation);
                $stmt->bindParam(":department", $param_department);
                $stmt->bindParam(":status", $param_status);

                // Set parameters
                $param_id = $id;
                $param_name = $name;
                $param_phone = $phone;
                $param_designation = $designation;
                $param_department = $department;
                $param_status = (int)$status;
                // echo $param_status;
                // exit;
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    echo "Record updated successfuly";
                    // Redirect to login page
                    header("location: user.php");
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
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">Edit User</div>
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
                                    <span class="help-block"><?php echo $name_err; ?></span>
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
                                    <select name="status" class="form-control form-select">
                                        <option value="">Select</option>
                                        <option value="1" <?php if ($status == '1') {
                                                                echo 'selected';
                                                            } ?>>Active</option>
                                        <option value="0" <?php if ($status == '0') {
                                                                echo 'selected';
                                                            } ?>>Inactive</option>
                                    </select>
                                    <span class="help-block"><?php echo $status_err; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <!-- <div class="col-lg-4 col-md-4 col-sm-4 form-control-label label-padding"></div> -->
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group center-item">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                        <!-- <p class="mt-2">Already have an account?<a href="login.php"> Login here</a>.</p> -->
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