<?php include('header.php'); ?>
<style>
    .form-group {
        margin: 10px;
        padding: 5px;
    }

    .center-item {
        text-align: center;
    }

    .center-item .center-align {
        display: block;
        margin: 0 auto;
    }

    .card-header {
        background-color: #fff;
    }
</style>
<?php

//inisialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

//include config file
require_once "config.php";

//define variables and initialize with empty values
$user = $new_password = $confirm_password = "";
$user_err = $new_password_err = $confirm_password_err = $success = $error = "";

$sql = "SELECT `id`, `name`,`email` FROM user_manage where `name`!='Administrator'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate new password
    if (empty(trim($_POST["user"]))) {
        $user_err = "Please select user.";
    }  else {
        $user = trim($_POST["user"]);
    }

    //validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    //validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the new password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    //check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err) && empty($user_err)) {
        //prepare an update statement
        $sql = "UPDATE user_manage set password=:password where id=:user";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":user", $param_user, PDO::PARAM_INT);

            //Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_user = $user;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $success = "Password Updated Successfuly";
            } else {
                $error = "Oops! Something went wrong. Please try again later.";
            }
        }
        //close statement
        unset($stmt);
    }
    //close connection
    unset($pdo);
}
?>
<div class="container mx-auto mt-5">
    <div class="row ">
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2"></div>
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">Reset Password</div>
                    <?php if($success) {?>
                            <p id="message" class="alert-success p-2"><?php echo $success; ?></p>
                        <?php } if($error) { ?>
                            <p id="message" class="alert-danger p-2"><?php echo $error; ?></p>
                        <?php } ?>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group <?php echo (!empty($user_err)) ? 'has-error' : ''; ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>User</label>
                                </div>
                                <div class="col-md-8">
                                <select name="user" class="form-control form-select">
                                    <option value="">Select</option>
                                    <?php 
                                    foreach ($result as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row["name"] . ' ('.$row['email'].')' . "</option>";
                                    }
                                    ?>
                                    </select>
                                    <span class="help-block text-danger"><?php echo $user_err; ?></span>
                                </div>
                            </div>
                        </div>    
                    <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>New Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                                    <span class="help-block text-danger"><?php echo $new_password_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Confirm Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="confirm_password" class="form-control">
                                    <span class="help-block text-danger"><?php echo $confirm_password_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="center-item">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary center-align" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2"></div>
    </div>
</div>
<?php include('footer.php'); ?>